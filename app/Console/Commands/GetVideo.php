<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use App\Models\Clip;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Mail\ClipCompleted;
use Illuminate\Support\Facades\Mail;
use App\Models\Credit;


class GetVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-video';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the completed video';

    /**
     * Maximum number of retries allowed.
     *
     * @var int
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $maxRetries = env('MAX_TRIES');

        // Get the first clip that is currently processing
        $clip = Clip::where('status', 'processing')->first();

        // If no clip is found, exit the command
        if (!$clip) {
            $this->info('No processing clips found.');
            return;
        }

        // Initialize the Guzzle HTTP client
        $client = new Client();

        // Number of attempts made to fetch the video status
        $attempts = 0;

        while ($attempts < $maxRetries) {
            try {
                // Make a GET request to fetch the video status from the D-ID API
                $response = $client->request('GET', 'https://api.d-id.com/talks/' . $clip->video_id, [
                    'headers' => [
                        'accept' => 'application/json',
                        'authorization' => 'Basic ' . env('DID_API_KEY'),
                        'content-type' => 'application/json',
                    ],
                ]);

                // Parse the JSON response from the API
                $video = json_decode($response->getBody()->getContents(), true);

                // Check the video status in the response
                if ($video['status'] === 'done') {
                    // Update the clip status and video path
                    $clip->status = 'completed';
                    $clip->video_path = $video['result_url'];
                    if($clip->save()){

                        $this->info('Clip status updated to completed');
                        //deduct credits for video generation
                        $credits = new Credit();
                        $credits->deductCredits('video');

                    } else {
                        $this->error('Failed to update clip status');
                    }

                    // Send an email notification to the user
                    $user = $clip->character->user;
                 //   Mail::to($user->email)->send(new ClipCompleted($clip));

                    $this->info('Video processing completed successfully for clip ID: ' . $clip->id);

                    //log this video details
                    Log::info($video);

                    return $video;

                } elseif ($video['status'] === 'failed') {
                    // Mark the clip as rejected if the video processing failed
                    $clip->status = 'rejected';
                    $clip->save();

                    $this->error('Video processing failed for clip ID: ' . $clip->id);
                    return $video;
                }

                // If the video is still processing, increment the attempts counter
                $attempts++;
                sleep(5); // Wait for 5 seconds before retrying

            } catch (\Exception $e) {
                // Log any exceptions encountered during the API request
                $this->error('An error occurred: ' . $e->getMessage());
                $attempts++;
                sleep(5); // Wait for 5 seconds before retrying
            }
        }

        // If maximum retries are reached, log an error and exit
        $this->error('Failed to retrieve video status after ' . $this->maxRetries . ' attempts.');
        $clip->status = 'failed';
        $clip->save();
    }
}
