<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Clip;
use App\Models\Credit;
use Illuminate\Support\Facades\Auth;

class GenerateVideo extends Model
{
    use HasFactory;

    /**
     * Generate a talking head video using the provided image and audio.
     *
     * @param string $imagePath Path to the source image.
     * @param string $mp3Path Path to the audio file.
     * @param string $text Unused parameter for potential text input.
     * @param Clip $clip Clip model instance associated with the video.
     * @return array|string The video response from the API or an error message.
     */
    public function generateTalkingHead($imagePath, $mp3Path, $text, $clip, $user)
    {
        $emotionName = null;

        // Check if clip and its associated character's emotion exist, set emotionName
        if ($clip && $clip->character && $clip->character->emotion) {
            $emotionName = $clip->character->emotion->name;
        }

        // Create a new Guzzle HTTP client
        $client = new Client();

        // Prepare the request payload for the D-ID API
        $payload = [
            "source_url" => $imagePath,
            "script" => [
                "type" => "audio",
                "audio_url" => $mp3Path,
            ],
            "config" => [
                "stitch" => true,
            ],
        ];

        // Send a POST request to the D-ID API to generate the talking head video
        try {
            $response = $client->request('POST', 'https://api.d-id.com/talks', [
                'body' => json_encode($payload),
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Basic ' . env('DID_API_KEY'),
                    'content-type' => 'application/json',
                ],
            ]);
        } catch (\Exception $e) {
            // Handle any errors that occur during the API request
            return response()->json(['error' => 'Failed to connect to video generation API'], 500);
        }

        // Decode the JSON response from the API
        $video = json_decode($response->getBody()->getContents(), true);

        // Check if the video ID is set in the response
        if (!isset($video['id'])) {
            return response()->json(['error' => 'Failed to generate video'], 500);
        }

        // Update the clip model with the new video ID and status
        $clip->video_id = $video['id'];
        $clip->status = 'processing';
        $clip->save();

                // Deduct credits
                $video_credit = Credit::where('email', Auth::user()->email)->first();
                $video_credit->points -= env('VIDEO_CREDIT_DEDUCTION', 3);
                $video_credit->save();

        // Return the video response
        return $video;
    }
}
