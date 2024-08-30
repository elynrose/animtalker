<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use App\Models\Clip;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class GenerateVideo extends Model
{
    use HasFactory;
    public function generateTalkingHead($imagePath, $mp3Path, $text, $clip)
    {
        $emotionName = null;

        if ($clip && $clip->character && $clip->character->emotion) {
            $emotionName = $clip->character->emotion->name;
        }

        
        $client = new \GuzzleHttp\Client();

    
        $response = $client->request('POST', 'https://api.d-id.com/talks', [
            'body' => json_encode([
                "source_url" => $imagePath,
                "script" => [
                    "type" => "audio",
                    "audio_url" => $mp3Path,
                ],

            "config" => [
               "stitch"=> true,
                "driver_expressions"=> [
                    "expressions"=> [
                        "expression"=> $emotionName,
                        "start_frame"=> 0,
                        "intensity"=> 5
                    ],
                ], 
            ],

            ]),
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic '.env('DID_API_KEY'),
                'content-type' => 'application/json',
            ],
        ]);

    
       /* if ($response->getStatusCode() != 200) {
            return response()->json(['error' => 'Failed to generate video'], 500);
        }
        */
    
        $video = json_decode($response->getBody()->getContents(), true);
        
        $clip->video_id = $video['id'];
        $clip->status = 'processing';
        $clip->save();
    
        return $video;
    }
}


