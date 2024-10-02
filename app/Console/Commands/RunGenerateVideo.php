<?php

namespace App\Console\Commands;

use App\Models\Clip;
use App\Models\User;
use App\Models\GenerateVideo;
use Illuminate\Console\Command;

class RunGenerateVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-video';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a talking head video for the first unprocessed clip.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
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
    }

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
}
