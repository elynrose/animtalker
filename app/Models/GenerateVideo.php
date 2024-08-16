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

    public function generateTalkingHead($imagePath, $mp3Path)
    {
        // Prepare the payload
        $payload = [
            'script' => [
                'type' => 'audio',
                'audio' => $mp3Path, // Use the URL of the MP3 file
            ],
            'source_url' => $imagePath // URL of the image to be used as the avatar
        ];

        // Make the request to D-ID's API using Guzzle
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->request('POST', 'https://api.d-id.com/talks', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '. env('DID_API_KEY'),
            ],
            'json' => $payload,
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Handle client errors
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $errorMessage = json_decode($response->getBody()->getContents(), true)['error'];
            return response()->json(['error' => $errorMessage], $statusCode);
        } catch (\GuzzleHttp\Exception\ServerException $e) {
            // Handle server errors
            return response()->json(['error' => 'Failed to generate video'], 500);
        }

        if ($response->getStatusCode() == 200) {
            // Handle successful response
            $responseData = json_decode($response->getBody()->getContents(), true);
            $videoId = $responseData['id'];
            $clip = new Clip(); // Create a new instance of the Clip model
            $clip->video_id = $videoId;
            $clip->status = 'Processing'; // Processing
            $clip->save();
        } else {
            // Handle errors
            return response()->json(['error' => 'Failed to generate video'], 500);
        }

        if ($response->getStatusCode() == 200) {
            // Handle successful response
            $responseData = json_decode($response->getBody()->getContents(), true);
            $videoId = $responseData['id'];
            $clip = new Clip(); // Create a new instance of the Clip model
            $clip->video_id = $videoId;
            $clip->status = 'Processing'; // Processing
            $clip->save();
        } else {
            // Handle errors
            return response()->json(['error' => 'Failed to generate video'], 500);
        }
    }
}

