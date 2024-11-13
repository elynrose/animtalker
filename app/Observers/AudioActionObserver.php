<?php

namespace App\Observers;

use App\Models\Clip;
use App\Notifications\DataChangeEmailNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Credit;
use Exception;
use App\Models\GenerateAudio;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NotEnoughCreditsEmailNotification;
use App\Models\Character;
use App\Models\GenerateCharacter;

class AudioActionObserver
{
    public function updated(Clip $model)
    {
        $data = ['action' => 'created', 'model_name' => 'Clip', 'changed_field' => 'script'];

    if ($model->isDirty('script')) {
        // Retrieve this clip
        $clip = Clip::find($model->id);

        if (! $clip) {
            return;
        }

        // Retrieve the user related to the clip's character
        $user = $this->getClipUser($clip);

        $credits = Credit::where('email', $user->email)->first();

        // Check if the user has enough credits
        if ($credits->points < env('CREDIT_DEDUCTION', 5)) {
            try {
                // Notify the user via email
                Notification::send($user, new NotEnoughCreditsEmailNotification($data));
            } catch (Exception $e) {
                \Log::error('Error sending not enough credits email: ' . $e->getMessage());
            }

            return;
        }

        //generate audio from script and save to audio_path
        $audio = new GenerateAudio();
        $mp3 = $audio->generateAudio($clip->script, $clip->voice);

        // Update the clip with the audio path
        $clip->audio_path = $mp3;
        $clip->save();
        


    }
    }


    private function getClipUser(Clip $clip)
    {
        return User::find(Character::find($clip->character_id)->user_id);
    }

}
