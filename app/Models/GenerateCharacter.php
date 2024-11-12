<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use App\Models\Character;
use App\Models\SendToOpenai;
use Illuminate\Http\Request;


class GenerateCharacter extends Model
{
    use HasFactory;

     /**
     * Handle the character generation request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generate($custom_prompt) {
        $refined_prompt = $this->refine($custom_prompt);

        //Send to dalle 
        $response = $this->sendToDalle($refined_prompt);

        // Return the API response
        return response()->json(['prompt' => $refined_prompt, 'dalle_response' => $response]);
    }

       //create an openai method to generate text with a given prompt
       public function refine($custom_prompt)
       { 
           $prompt = "You are an advanced AI system specializing in converting simple, natural language descriptions into detailed, vivid prompts for generating pixarlike 3D animated characters and scenes in the style of modern animation movies. Your outputs should provide enough detail for a DALL-E-like API to create visually stunning 3d animations reminiscent of Pixar or Disney styles. You are expected to: Enhance Simplicity with Detail: Transform basic inputs into richly detailed descriptions, specifying character features, clothing textures, emotional expressions, surrounding environments, lighting, and artistic style. Contextual Clarity: Ensure each prompt vividly captures the essence of the character\'s personality, mood, and environment while maintaining clarity and coherence.
Modern Animation Style: Always ensure the prompt reflects high-quality, modern animation styles with realistic lighting, textures, and dynamic elements. The character posing for a shot. The shot should be an eye-level shot. The input prompt is :".$custom_prompt;
           $openai = new SendToOpenai;
           $result = $openai->sendToOpenAI($prompt);
           return $result;
       }
   

    /**
     * Send the generated prompt to the DALL-E API.
     *
     * @param  string  $prompt
     * @return array
     */
        private function sendToDalle($prompt)
        {
        try {
            // Set the OpenAI API key from the environment
            $apiKey = env('OPENAI_KEY');

            // Prepare the API request payload
            $response = Http::withHeaders([
                'Authorization' => "Bearer $apiKey",
            ])->post('https://api.openai.com/v1/images/generations', [
                'prompt' => $prompt,          // The description prompt
                'n' => 1,                     // Number of images to generate
                'size' => '1792x1024',  
                'model'=> 'dall-e-3',     // Image size (can be 256x256, 512x512, or 1024x1024)
            ]);

            // Decode and return the response from OpenAI
            return $response->json();
        } catch (\Exception $e) {
            // Handle the exception and return a JSON error response
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to generate image, please wait and try again.'], 500);
        }
        
    }


     /**
     * Generate the character prompt based on the selected attributes.
     *
     * @return string
     */
        public function generatePrompt($character, $isRealistic)
    {
        // Use a custom prompt if provided
        if (!empty($character->custom_prompt)) {
            return $character->custom_prompt;
        }
    }

}