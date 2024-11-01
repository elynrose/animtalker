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
// Add guzzle client
use GuzzleHttp\Client;
use App\Models\Credit;
use App\Notifications\NotEnoughCreditsEmailNotification;
use Exception;

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
        $data = ['action' => 'created', 'model_name' => 'Clip'];

        // Retrieve the first unprocessed clip
        $clip = $this->getUnprocessedClip($clip);

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

        // Generate the video and update the clip status
        $response = $this->generateVideoForClip($clip, $user);

        // Handle the response from the video generation process
        $this->handleVideoGenerationResponse($response, $clip);
    }

    public function updated(Clip $model)
    {
        $data = ['action' => 'updated', 'model_name' => 'Clip', 'changed_field' => 'video_id'];

        if ($model->isDirty('video_id')) {
            $video_id = $model->video_id;

            // Retrieve the first clip that is still processing
            $clip = Clip::where('video_id', $video_id)->first();

            if (!$clip) {
                return; // Exit if no clip is being processed
            }

            // Fetch video status from external API
            $video = $this->fetchVideoStatus($clip->video_id);

            if ($this->isVideoCompleted($video)) {
                $this->markClipAsCompleted($clip, $video);

                $user = $model->character->user;

                // Deduct credits
                $credit = Credit::where('email', $user->email)->first();
                $credit->points -= env('VIDEO_CREDIT_DEDUCTION', 5);
                $credit->save();

                try {
                    // Notify the user via email
                    Notification::send($user, new DataChangeEmailNotification($data));
                } catch (Exception $e) {
                    \Log::error('Error sending data change email: ' . $e->getMessage());
                }

            } elseif ($this->isVideoFailed($video)) {
                $this->markClipAsFailed($clip);
            }
        }
    }

    // Helper Methods

    /**
     * Get the first clip that has not been processed.
     *
     * @return \App\Models\Clip|null
     */
    protected function getUnprocessedClip($clip)
    {
        return Clip::where('status', 'new')->where('id', $clip->id)->get();
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

    /**
     * Fetch the video status from the D-ID API.
     *
     * @param string $videoId
     * @return array|null
     */
    protected function fetchVideoStatus($videoId)
    {
        try {
            $response = $this->client->get("https://api.d-id.com/talks/{$videoId}", [
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Basic ' . env('DID_API_KEY'),
                    'content-type' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            \Log::error('Error fetching video status: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Determine if the video is completed.
     *
     * @param array|null $video
     * @return bool
     */
    protected function isVideoCompleted($video)
    {
        return $video && $video['status'] === 'done';
    }

    /**
     * Determine if the video processing failed.
     *
     * @param array|null $video
     * @return bool
     */
    protected function isVideoFailed($video)
    {
        return $video && $video['status'] === 'error';
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
        $durationInSeconds = $video['duration_in_seconds'];

        // Use PHP's gmdate for proper formatting of duration
        $totalDuration = gmdate("i:s", $durationInSeconds);

        // Update clip details
        $clip->update([
            'duration' => $totalDuration,
            'status' => 'completed',
            'video_path' => $video['result_url'],
        ]);

        // Notify the user via email
        $this->notifyUser($clip);
    }

    /**
     * Notify the user that the clip processing is completed.
     *
     * @param \App\Models\Clip $clip
     * @return void
     */
    protected function notifyUser(Clip $clip)
    {
        $user = $clip->character->user;
        $data = ['action' => 'completed', 'model_name' => 'Clip'];
        try {
            Notification::send($user, new DataChangeEmailNotification($data));
        } catch (Exception $e) {
            \Log::error('Error sending completion email: ' . $e->getMessage());
        }
    }
}
