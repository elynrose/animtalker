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
      

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://api.d-id.com/talks', [
          'body' => '{"script":{"type":"text","subtitles":"false","provider":{"type":"microsoft","voice_id":"en-US-JennyNeural"},"audio_url":"https://animshorts.s3.us-east-2.amazonaws.com/audio/66c8ea935a449.mp3"},"config":{"fluent":"false","pad_audio":"0.0"},"face":{"size":1024},"source_url":"https://animshorts.s3.us-east-2.amazonaws.com/28/img-gL15XuQqbAGG5XU1Qtb9clvE.png"}',
          'headers' => [
            'accept' => 'application/json',
            'authorization' => 'Basic '.env('DID_API_KEY'),
            'content-type' => 'application/json',
          ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        if (isset($data['error'])) {
            return response()->json(['error' => $data['error']], 500);
        }
dd($data);
        $clip->video_id = $data['id'];
        $clip->save();
        
    

    }
}


