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
use App\Models\Character;


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
     * Execute the console command.
     */
    public function handle()
    {
        //Get the first pending clip
        $clip = Clip::where('status', 'processing')->first();

        if (!$clip){
            return;
        }

        
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://api.d-id.com/talks/'.$clip->video_id, [
       'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic '.env('DID_API_KEY'),
                'content-type' => 'application/json',
            ],
        ]);

        $video = json_decode($response->getBody()->getContents(), true);

        if ($video['status'] == 'done'){
            $video_duration = $video['duration'];
            $clip->duration = $video_duration;
           

           // $path = $character->addMediaFromUrl($video['result_url'])->toMediaCollection('avatar', 's3', 'videos')->getUrl();
            $clip->status = 'completed';
            $clip->video_path = $video['result_url'];
            $clip->save();

            //Send an email to the user
            $user = $clip->character->user_id;
         //   Mail::to($user->email)->send(new ClipCompleted($clip));
        } else if ($video['status'] == 'error'){
            $clip->status = 'failed';
            $clip->save();
        }

        //return $video as php array
        return $video;

    }


   
}