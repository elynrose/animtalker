<?php

namespace App\Console\Commands;

use App\Models\Clip;
use App\Mail\ClipCompleted;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
    protected $description = 'Retrieve the status of a video and update its record accordingly.';

    /**
     * Guzzle HTTP client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Create a new command instance.
     *
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct();

        $this->client = $client;  // Injecting the Guzzle client
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Retrieve the first clip that is still processing
        $clip = Clip::where('status', 'processing')->first();

        if (! $clip) {
            return; // Exit if no clip is being processed
        }

        // Fetch video status from external API
        $video = $this->fetchVideoStatus($clip->video_id);

        if ($this->isVideoCompleted($video)) {
            $this->markClipAsCompleted($clip, $video);
        } elseif ($this->isVideoFailed($video)) {
            $this->markClipAsFailed($clip);
        }

        return $video; // Return video data (useful for testing or debugging)
    }

    /**
     * Fetch the video status from the D-ID API.
     *
     * @param string $videoId
     * @return array
     */
    protected function fetchVideoStatus($videoId)
    {
        $response = $this->client->get("https://api.d-id.com/talks/{$videoId}", [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic ' . env('DID_API_KEY'),
                'content-type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Determine if the video is completed.
     *
     * @param array $video
     * @return bool
     */
    protected function isVideoCompleted(array $video)
    {
        return $video['status'] === 'done';
    }

    /**
     * Determine if the video processing failed.
     *
     * @param array $video
     * @return bool
     */
    protected function isVideoFailed(array $video)
    {
        return $video['status'] === 'error';
    }

    /**
     * Mark the clip as completed and notify the user.
     *
     * @param \App\Models\Clip $clip
     * @param array $video
     * @return void
     */
    protected function markClipAsCompleted(Clip $clip, array $video)
    {
        $duration = explode(':', $video['duration']);

        // Ensure $duration has two elements (minutes and seconds)
        if (count($duration) == 1) {
            // If only seconds are provided, assume minutes are 0
            array_unshift($duration, '0');
        }
        
        // Ensure minutes are two digits
        if ($duration[0] < 10) {
            $duration[0] = '0' . $duration[0];
        } elseif ($duration[0] > 99) {
            $duration[0] = substr($duration[0], -2);
        }
        
        // Ensure seconds are two digits
        if ($duration[1] < 10) {
            $duration[1] = '0' . $duration[1];
        } elseif ($duration[1] > 99) {
            $duration[1] = substr($duration[1], -2);
        }
        
        $totalDuration = $duration[0] . ':' . $duration[1];
        
        // Update clip details
        $clip->update([
            'duration' => $totalDuration,
            'minutes' => $duration[0],
            'seconds' => $duration[1],
            'status' => 'completed',
            'video_path' => $video['result_url'],
        ]);

        // Notify the user via email
        $this->notifyUser($clip);
    }

    /**
     * Mark the clip as failed.
     *
     * @param \App\Models\Clip $clip
     * @return void
     */
    protected function markClipAsFailed(Clip $clip)
    {
        $clip->update(['status' => 'failed']);
    }

    /**
     * Notify the user that the clip has been completed.
     *
     * @param \App\Models\Clip $clip
     * @return void
     */
    protected function notifyUser(Clip $clip)
    {
        $user = $clip->character->user;

        Mail::to($user->email)->send(new ClipCompleted($clip));
    }
}
