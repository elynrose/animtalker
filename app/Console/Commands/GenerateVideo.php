<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GenerateAudio;


class GenerateVideo extends Command
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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $clip = Clip::where('status', 'pending')->first();
        if ($clip) {
            $text = $clip->script; // Required: The text to convert to speech
            $voice = $clip->voice; // Optional: Define a default voice
            $audio  = new GenerateAudio;
            $result = $audio->textToSpeech($text, $voice);
        }



    }
}
