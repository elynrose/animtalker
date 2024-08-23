<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use App\Models\Clip;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;


class GenerateVideo extends Model
{
    use HasFactory;
    public function generateTalkingHead($imagePath, $mp3Path, $text, $clip)
    {
        // Prepare the payload
        $payload = [
            "script" => [
                "type" => "audio",
                "provider" => [
                    "type" => "audio",
                    "audio_path" => $mp3Path,
                ],
            ],
            "source_url" => $imagePath
        ];

        // Make the request to D-ID's API using Guzzle
        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->request("POST", "https://api.d-id.com/talks", [
                "headers" => [
                    'accept' => 'application/json',
                    "Content-Type" => "application/json",
                    "Authorization" => "Basic " . env("DID_API_KEY"),
                ],
                "json" => json_encode($payload),
            ]);

            if ($response->getStatusCode() == 200) {
                // Handle successful response
                $responseData = json_decode($response->getBody()->getContents(), true);
                if (is_array($responseData) && isset($responseData['id'])) {
                    $videoId = $responseData['id'];
                    $clip->video_id = $videoId;
                } else {
                    return response()->json(['error' => 'Invalid response from API'], 500);
                }
                $clip->status = 'Processing';
                $clip->save();
            } else {
                // Handle errors
                return response()->json(['error' => 'Failed to generate video'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}


