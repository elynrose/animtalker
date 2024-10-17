<?php

namespace App\Observers;

use App\Models\Clip;
use App\Notifications\DataChangeEmailNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\GenerateVideo;
use App\Models\GenerateAudio;
use App\Models\SendToOpenai;
//Add guzzle client
use GuzzleHttp\Client;

class VideoIDActionObserver
{
    /**
     * Guzzle HTTP client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Create a new observer instance.
     *
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(Client $client)

    {
        $this->client = $client;
    }

    
    
    public function created(Clip $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'Clip'];
        
        // Retrieve the first unprocessed clip
        $clip = $this->getUnprocessedClip();

        if (! $clip) {
            return;
        }

        // Retrieve the user related to the clip's character
        $user = $this->getClipUser($clip);

        // Generate the video and update the clip status
        $response = $this->generateVideoForClip($clip, $user);

        // Handle the response from the video generation process
        $this->handleVideoGenerationResponse($response, $clip);
        
        
        //Get the user who created the clip
        $user = $model->character->user;

        }

    public function updated(Clip $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'Clip', 'changed_field' => 'video_id'];
        if ($model->isDirty('video_id')) {
            $video_id = $model->video_id;

              // Retrieve the first clip that is still processing
        $clip = Clip::where('video_id', $video_id)->first();

        if (! $clip) {
            return; // Exit if no clip is being processed
        }

        // Fetch video status from external API
        $video = $this->fetchVideoStatus($clip->video_id);

        if ($this->isVideoCompleted($video)) {
            $this->markClipAsCompleted($clip, $video);
        } elseif ($this->isVideoFailed($video)) {
            $this->markClipAsFailed($clip);
        }

        }

        // Notification::send($users, new DataChangeEmailNotification($data));

    }




//-------------Code fot the RunGenerateVideo.php file-----------------//



      /**
     * Get the first clip that has not been processed.
     *
     * @return \App\Models\Clip|null
     */
    protected function getUnprocessedClip()
    {
        return Clip::where('status', 'new')->first();
    }

    /**
     * Retrieve the user associated with the clip's character.
     *
     * @param \App\Models\Clip $clip
     * @return \App\Models\User
     */
    protected function getClipUser(Clip $clip)
    {
        return User::find($clip->character->user_id);
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

            if (isset($data['error'])) {
                $this->markClipAsFailed($clip);
            } else {
                $this->markClipAsProcessing($clip, $data['id']);
            }
        }
    }

    /**
     * Mark the clip as processing and save the video ID.
     *
     * @param \App\Models\Clip $clip
     * @param string $videoId
     * @return void
     */
    protected function markClipAsProcessing(Clip $clip, $videoId)
    {
        $clip->update([
            'video_id' => $videoId,
            'status' => 'processing',
        ]);
    }

    /**
     * Mark the clip as failed.
     *
     * @param \App\Models\Clip $clip
     * @return void
     */
    protected function markClipAsFailed(Clip $clip)
    {
        $clip->update(['status' => 'failed']);
    }





//-------------Code fot the GetVideo.php file-----------------//




      /**
     * Fetch the video status from the D-ID API.
     *
     * @param string $videoId
     * @return array
     */
    protected function fetchVideoStatus($videoId)
    {
        $response = $this->client->get("https://api.d-id.com/talks/{$videoId}", [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic ' . env('DID_API_KEY'),
                'content-type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Determine if the video is completed.
     *
     * @param array $video
     * @return bool
     */
    protected function isVideoCompleted(array $video)
    {
        return $video['status'] === 'done';
    }

    /**
     * Determine if the video processing failed.
     *
     * @param array $video
     * @return bool
     */
    protected function isVideoFailed(array $video)
    {
        return $video['status'] === 'error';
    }

    /**
     * Mark the clip as completed and notify the user.
     *
     * @param \App\Models\Clip $clip
     * @param array $video
     * @return void
     */
    protected function markClipAsCompleted(Clip $clip, array $video)
    {
        $duration = explode(':', $video['duration']);

        // Ensure $duration has two elements (minutes and seconds)
        if (count($duration) == 1) {
            // If only seconds are provided, assume minutes are 0
            array_unshift($duration, '0');
        }
        
        // Convert seconds to minutes if necessary
        $minutes = (int)$duration[0];
        $seconds = (float)$duration[1];
        
        if ($seconds >= 60) {
            $additionalMinutes = floor($seconds / 60);
            $seconds = $seconds % 60;
            $minutes += $additionalMinutes;
        }
        
        // Ensure minutes are two digits
        $minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);
        
        // Ensure seconds are two digits without fractional part
        $seconds = str_pad((int)$seconds, 2, '0', STR_PAD_LEFT);
        
        $totalDuration = $minutes . ':' . $seconds;

        // Update clip details
        $clip->update([
            'duration' => $video['duration'],
            'minutes' => $duration[0],
            'seconds' => $duration[1],
            'status' => 'completed',
            'video_path' => $video['result_url'],
        ]);

        // Notify the user via email
        $this->notifyUser($clip);
    }


}
