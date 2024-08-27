<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GenerateAudio;
use App\Models\Clip;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\GenerateVideo;



class RunGenerateVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-video';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the video';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Get the first clip that has not been processed
        $clip = Clip::where('status', 'New')->first();

        if (!$clip){
            return;
        }

        //Generate the video
       
        $video = new GenerateVideo;
        //i want to get the path of the character image saved as a media file
        $imagePath = $clip->character->getFirstMediaUrl('avatar', 'preview');
        $mp3Path = $clip->audio_path;
        $text = $clip->script;
       
        $response = $video->generateTalkingHead($imagePath, $mp3Path, $text, $clip);

        if ($response) {
            //attach audio and video file to the request
            $clip->video_id = $response['id'];
            $clip->status = 'processing';
            $clip->save();
        }

    }
}
