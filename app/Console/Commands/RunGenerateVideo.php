<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GenerateAudio;
use App\Models\Clip;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\GenerateVideo;
use App\Models\User;



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
        $user = User::find($clip->character->user_id);

        if (!$clip){
            return;
        }

        //Generate the video
       
        $video = new GenerateVideo;
        //i want to get the path of the character image saved as a media file
        $imagePath = $clip->character->getFirstMediaUrl('avatar', 'preview');
        $mp3Path = $clip->audio_path;
        $text = $clip->script;
       
        $response = $video->generateTalkingHead($imagePath, $mp3Path, $text, $clip, $user);


         if ($response instanceof \Illuminate\Http\JsonResponse) {
            $content = $response->getContent();
            $data = json_decode($content, true);

            if(isset($data['error'])){
                $clip->status = 'failed';
                $clip->save();
                return;
            } else {
                $clip->video_id = $data['id'];
                $clip->status = 'processing';
                $clip->save();
            }
        }

    }
}
