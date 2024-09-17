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
        
    }


     /**
     * Generate the character prompt based on the selected attributes.
     *
     * @return string
     */
    public function generatePrompt($character, $isRealistic)
    {
        // Initialize the base of the prompt
        $prompt = "Create ";

        if ($isRealistic) {
            $prompt .= "a highly detailed, realistic ";
        } else {
            $prompt .= "a detailed 3D animated ";
        }

        // Append the age group and gender, if available
        if (!empty($character->age_group)) {
            $prompt .= $character->age_group->age . " ";
        }
        if (!empty($character->gender)) {
            $prompt .= strtolower($character->gender->type);
        } else {
            $prompt .= "character";
        }
        $prompt .= " with ";

        // Append the character's physical attributes
        $attributes = [];
        if (!empty($character->hair_lenght) && !empty($character->hair_color) && !empty($character->hair_style)) {
            $attributes[] = $character->hair_lenght->lenght . " " . $character->hair_color->color . " " . $character->hair_style->style . " hair";
        }
        if (!empty($character->eye_color) && !empty($character->eye_shape)) {
            $attributes[] = $character->eye_color->color . " " . strtolower($character->eye_shape->shape) . " eyes";
        }
        if (!empty($character->skin_tone)) {
            $attributes[] = $character->skin_tone->tone . " skin";
        }
        if (!empty($character->head_shape)) {
            $attributes[] = "a " . strtolower($character->head_shape->shape) . " head";
        }
        if (!empty($character->nose_shape)) {
            $attributes[] = "a " . strtolower($character->nose_shape->shape);
        }
        if (!empty($character->mouth_shape)) {
            $attributes[] =  "and ". strtolower($character->mouth_shape->shape);
        }

        // Join all attributes with commas
        if (!empty($attributes)) {
            $prompt .= implode(", ", $attributes) . ". ";
        }

        // Add facial expression and emotion, if available
        if (!empty($character->facial_expression)) {
            $prompt .= "The character has a " . strtolower($character->facial_expression->expression) . " face";
            if (!empty($character->emotion)) {
                $prompt .= ", expressing " . strtolower($character->emotion->name) . ". ";
            } else {
                $prompt .= ". ";
            }
        }

        // Append more details about the clothing and accessories, if available
        if (!empty($character->dress_style)) {
            $prompt .= "The character is dressed in a " . strtolower($character->dress_style->style) . " style";
        }

        // Include dress colors if available
        if (!empty($character->dress_colors) && count($character->dress_colors) > 0) {
            $colors = [];
            foreach ($character->dress_colors as $color) {
                $colors[] = strtolower($color->color);
            }
            $prompt .= ", featuring " . implode(", ", $colors) . " colors. ";
        } else {
            $prompt .= ". ";
        }

        // Add props if they exist
        if (!empty($character->props) && count($character->props) > 0) {
            $props = [];
            foreach ($character->props as $prop) {
                $props[] = strtolower($prop->name);
            }
            $prompt .= "The character is holding or adorned with " . implode(", ", $props) . ". ";
        }

        // Include posture and zoom details, if available
        if (!empty($character->posture)) {
            $prompt .= "The character is posed in a " . strtolower($character->posture->name) . " posture, ";
        }

        if (!empty($character->character_zoom)) {
            $prompt .= "with a " . strtolower($character->character_zoom->name) . " zoom for emphasis. ";
        }

        // Describe the art style and setting
        $prompt .= "The art style is akin to " . $character->art_style;

        if ($isRealistic) {
            $prompt .= " in a hyperrealistic, Fujifilm X-T3, 1/1250sec at f/2.8, ISO 160, 84mm style.";
        } else {
            $prompt .= " in a 3D animated style, with realistic textures and lighting effects.";
        }

        if (!empty($character->custom_prompt)) {
            $prompt .= " " . $character->custom_prompt . " ";
        }

        $prompt .= "--Background and Lighting-- ";
        $prompt .= "The character is set against a " . strtolower($character->scene->scene) . " background, ";
        $prompt .= "with the focus on the character and the background slightly blurred to emphasize the character's features. ";
        $prompt .= "The character is well-lit with rich and high detail. ";

        if ($isRealistic) {
            $prompt .= "The colors are vibrant, inspired by DSLR camera quality realistic lighting and color schemes.";
        } else {
            $prompt .= "The colors are vibrant, inspired by Disney's warm and inviting aesthetic.";
        }

        $prompt .= " The image ratio should be ";

        if ($character->aspect_ratio == '16:9') {
            $prompt .= "16:9";
        } elseif ($character->aspect_ratio == '9:16') {
            $prompt .= "9:16";
        }

        $prompt .= " aspect ratio, allowing the character to appear in the right perspective within the screen. ";
        $prompt .= "Let the character be the main focus of the image.";

        return $prompt;
    }
    

    

}
