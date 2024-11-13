<?php

namespace App\Observers;

use App\Models\Clip;
use App\Notifications\DataChangeEmailNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Credit;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NotEnoughCreditsEmailNotification;
use App\Models\Character;
use App\Models\GenerateCharacter;
use App\Models\GenerateAudio;

class CharacterIDActionObserver
{
    public function created(Character $model)
    {
        $data = ['action' => 'created', 'model_name' => 'Character'];
        // Retrieve this clip
        $character = Character::find($model->id);

        if (! $character) {
            return;
        }

        try {

            $audio_url = new GenerateAudio;
            $mp3Path = $audio_url->textToSpeech($character->script, $character->voice);

            // Create clip
            Clip::create([
                'character_id' => $character->id,
                'script' => $character->script,
                'voice' => $character->voice,
                'audio_path' => $mp3Path,
            ]);

          
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to save audio: '.$e], 500);
        }

        try {
            // Generate character avatar using an external service
            $new_character = new GenerateCharacter();
            $avatar = $new_character->generate($character->custom_prompt);
    
            // Retrieve avatar data from the generation response
            $avatarData = $avatar->getData();
            // Extract the prompt and image URL from the avatar data
            $prompt = $avatarData->prompt ?? null;
            $image = $avatarData->dalle_response->data[0]->url ?? null;
    
            // Handle error if the image is not generated
            if ($image === null) {
                // Delete the character if image generation fails
                return response()->json(['error' => 'Failed to generate character'], 500);
            }
        } catch (\Exception $e) {
            // Delete character and return error if image generation fails
            return response()->json(['error' => 'Failed to generate character'], 500);
        }
    
        // Save the generated image URL to the character's avatar and save it to S3
        try {
            $path = $character->addMediaFromUrl($image)
                ->toMediaCollection('avatar', 's3', 'photos')
                ->getUrl();
    
            $character->custom_prompt = $prompt;
            $character->avatar_url = $path;
            $character->save();


        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to save character avatar: '.$e], 500);
        }
    }


   
    /**
     * Retrieve the user associated with the clip's character.
     *
     * @param \App\Models\Clip $clip
     * @return \App\Models\User
     */
    protected function getCharacterUser(Character $character)
    {
        return User::find($character->user_id);
    }


    protected function getClipUser(Clip $clip)
    {
        return User::find(Character::find($clip->character_id)->user_id);
    }

     /**
     * Generate the talking head video for the given clip.
     *
     * @param \App\Models\Clip $clip
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function generateVideoForClip(Clip $clip, User $user)
    {
        $video = new GenerateVideo();

        // Get the required paths and text for video generation
        $imagePath = $clip->character->getFirstMediaUrl('avatar', 'preview');
        $mp3Path = $clip->audio_path;
        $text = $clip->script;

        // Generate the video
        return $video->generateTalkingHead($imagePath, $mp3Path, $text, $clip, $user);
    }

    /**
     * Handle the response from the video generation and update clip status.
     *
     * @param \Illuminate\Http\JsonResponse $response
     * @param \App\Models\Clip $clip
     * @return void
     */
    protected function handleVideoGenerationResponse($response, Clip $clip)
    {
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            $data = json_decode($response->getContent(), true);

            if (is_null($data)) {
                \Log::error('Failed to decode video generation response');
                return;
            }

            if (isset($data['error'])) {
                $this->markClipAsFailed($clip);
            } else {
                $this->markClipAsProcessing($clip, $data['id']);
            }
        }
    }

}
