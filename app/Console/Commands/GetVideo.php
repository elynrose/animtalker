<?php

namespace App\Console\Commands;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use App\Models\Clip;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;




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
            //Save the video on amazon s3 
            $videoPath = Storage::disk('s3')->put('videos', file_get_contents($video['result_url']), 'clips');

            //Get the s3 url
            $clip->video_path = Storage::disk('s3')->url($videoPath); 
            $clip->status = 'completed';
            $clip->save();

        } else if ($video['status'] == 'failed'){
            $clip->status = 'rejected';
            $clip->save();
        }

        //return $video as php array
        return $video;

    }


   
}
