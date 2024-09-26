<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use App\Models\Credit;
use Illuminate\Support\Facades\Auth;

class SendToOpenai extends Model
{
    use HasFactory;

    public static function sendToOpenAI($prompt)
    {
        try {
            $client = new Client();
            $response = $client->post('https://api.openai.com/v1/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('OPENAI_KEY'),
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo-instruct',
                    'prompt' => $prompt,
                    'max_tokens' => 255,
                    'temperature' => 0.7,
                    'top_p' => 1,
                    'frequency_penalty' => 0,
                    'presence_penalty' => 0,
                ],
            ]);
            $data = json_decode($response->getBody(), true);
    
            if(isset($data['choices'][0]['text'])) {
                $credits = new Credit();
                $credits->deductCredits('prompt', Auth::user());        }
    
            return trim($data['choices'][0]['text']);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

}
