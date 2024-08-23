<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use App\Models\Clip;
use GuzzleHttp\Client;


class GenerateVideo extends Model
{
    use HasFactory;
    public function generateTalkingHead($imagePath, $mp3Path, $text, $clip)
    {

     /*   $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://api.d-id.com/talks', [
          'body' => '{
            "script": {
                "type": "text",
                "subtitles": "false",
                "text": "'.$text.'",
                 "source_url": "'.$imagePath.'",
                "provider": {
                    "type": "audio",
                    "audio_url": "'.$mp3Path.'",
                    "audio_type": "mp3",
                },
                }
            },
            "config": {
                "fluent": "false",
                "pad_audio": "0.0"
            }
        }',
          'headers' => [
            'accept' => 'application/json',
            'authorization' => 'Basic '.env('DID_API_KEY'),
            'content-type' => 'application/json',
          ],
        ]);
        
        echo $response->getBody();
*/
        // Prepare the payload
        $payload = [
            'script' => [
                'type' => 'audio',
                'audio' => $mp3Path, // Use the URL of the MP3 file
            ],
            'source_url' => $imagePath, // URL of the image to be used as the avatar
            'text' => $text, // The text to be displayed in the video

        ];

        // Make the request to D-ID's API using Guzzle
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->request('POST', 'https://api.d-id.com/talks', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic '. env('DID_API_KEY'),
                ],
                'json' => $payload,
            ]);

            if ($response->getStatusCode() == 200) {
                // Handle successful response
                $responseData = json_decode($response->getBody()->getContents(), true);
                $videoId = $responseData['id'];
                $clip->video_id = $videoId;
                $clip->status = 'Processing'; // Processing
                $clip->save();
            } else {
                // Handle errors
                return response()->json(['error' => 'Failed to generate video'], 500);
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Handle client errors
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\GuzzleHttp\Exception\ServerException $e) {
            // Handle server errors
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }
       
}

