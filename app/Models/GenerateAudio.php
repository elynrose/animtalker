<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;


class GenerateAudio extends Model
{

    public function textToSpeech($text, $voice)
    {
        // Prepare the payload for the API request
        $payload = [
            'input' => $text,
            'voice' => $voice,
            'model' => 'tts-1',
            'config' => [
                'encoding' => 'MP3', // You can use 'MP3', 'LINEAR16', or 'OGG_OPUS' based on your needs
                'sample_rate_hertz' => 24000,
                'language_code' => 'en-US',
            ],
        ];

        // Initialize the Guzzle client
        $client = new Client();

        // Make the request to OpenAI TTS API
        $response = $client->post('https://api.openai.com/v1/audio/speech', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_KEY'),
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
        ]);

        if ($response->getStatusCode() == 200) {
            $audioBinary = $response->getBody();
          
            //Save the file as a media attachment for clip->audio_file
            $fileName = 'audio/'. uniqid() . '.mp3';
            Storage::disk('public')->put($fileName, $audioBinary);
            $mp3Path = url('storage/' . $fileName);
            
            return $mp3Path;
    
        } else {
            return response()->json(['error' => 'Failed to generate audio'], 500);
        }
    }
}
