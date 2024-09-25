<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use App\Models\Character;

class GenerateCharacter extends Model
{
    use HasFactory;

     /**
     * Handle the character generation request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generate($id) {
        
        $character = Character::find($id);

        if($character->is_realistic){
            $isRealistic = true;
        } else {
            $isRealistic = false;
        }

        // Generate the prompt
        $prompt = $this->generatePrompt($character, $isRealistic);

        //dd($prompt);
        // Send the prompt to DALL-E API
        $response = $this->sendToDalle($prompt);

        // Return the API response
        return response()->json(['prompt' => $prompt, 'dalle_response' => $response]);
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

    // Initialize the prompt with the character type
    $prompt = "Create " . ($isRealistic ? "a highly detailed, realistic " : "a detailed 3D animated ");

    // Add age group and gender
    $prompt .= (!empty($character->age_group) ? $character->age_group->age . " " : "") .
               (!empty($character->gender) ? strtolower($character->gender->type) : "character") . " with ";

    // Gather character attributes
    $attributes = $this->formatCharacterAttributes($character);
    $prompt .= implode(", ", $attributes);

    // Append style details
    $prompt .= $this->styleDetails($character, $isRealistic);

    // Describe the background, lighting, and artistic details
    $prompt .= $this->backgroundAndArtDetails($character, $isRealistic);

    return $prompt;
}

private function formatCharacterAttributes($character)
{
    $attributes = [];

    if (!empty($character->hair_lenght)) {
        $attributes[] = "{$character->hair_lenght->lenght} {$character->hair_color->color} {$character->hair_style->style} hair";
    }
    if (!empty($character->eye_color)) {
        $attributes[] = "{$character->eye_color->color} " . strtolower($character->eye_shape->shape) . " eyes";
    }
    if (!empty($character->skin_tone)) {
        $attributes[] = "{$character->skin_tone->tone} skin";
    }
    if (!empty($character->head_shape)) {
        $attributes[] = "a " . strtolower($character->head_shape->shape) . " head";
    }

    return $attributes;
}

private function styleDetails($character, $isRealistic)
{
    $styleDetails = "";
    if (!empty($character->facial_expression)) {
        $styleDetails .= "The character has a " . strtolower($character->facial_expression->expression) . " face";
    }
    if (!empty($character->emotion)) {
        $styleDetails .= ", expressing " . strtolower($character->emotion->name);
    }
    $styleDetails .= ". ";

    if (!empty($character->dress_style)) {
        $styleDetails .= "The character is dressed in a " . strtolower($character->dress_style->style) . " style";
    }

    return $styleDetails;
}

private function backgroundAndArtDetails($character, $isRealistic)
{
    $details = "--Background and Lighting-- ";
    if (!empty($character->scene)) {
        $details .= "The character is set against a " . strtolower($character->scene->scene) . " background, ";
    }
    $details .= "with the character prominently placed in the foreground, facing the viewer. ";
    $details .= "The camera maintains a ".($character->zoom->name ?? "Eye level shot")." view, smoothly following the character's movements. ";
    $details .= "The character is well-lit with rich and high detail, ";
    $details .= "in a " . ($isRealistic ? "hyperrealistic" : "3D animated") . " style with realistic textures and lighting effects. ";
    $details .= "The colors are vibrant, inspired by " . ($isRealistic ? "DSLR camera quality" : "Disney's warm aesthetic") . ". ";
    $details .= "The image ratio should be " . ($character->aspect_ratio ?? "16:9") . " aspect ratio, ";
    $details .= "ensuring that the character remains the main focus of the image throughout the scene.";

    return $details;
}

    

}
