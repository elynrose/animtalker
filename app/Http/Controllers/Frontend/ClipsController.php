<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyClipRequest;
use App\Http\Requests\StoreClipRequest;
use App\Http\Requests\UpdateClipRequest;
use App\Models\Character;
use App\Models\Clip;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use App\Models\GenerateAudio;
use App\Models\GenerateVideo;

class ClipsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('clip_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clips = Clip::with(['character', 'media'])->get();

        return view('frontend.clips.index', compact('clips'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('clip_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        if($request->segment(2) == null) {
            return redirect()->route('frontend.characters.index');
        }
        //get the character id from the request
        $character = Character::find($request->segment(2));


        return view('frontend.clips.create', compact('character'));
    }

    public function store(StoreClipRequest $request)
    {
        $text = $request->input('script'); // Required: The text to convert to speech
        $voice = $request->input('voice', 'alloy'); // Optional: Define a default voice

        $audio  = new GenerateAudio;
        $mp3Path = $audio->textToSpeech($text, $voice);

    //give me the full image path including the http://localhost:8000
        $imagePath = $request->input('image_path');
        $text = $request->input('script');

        $clip = new  Clip;
        $clip->character_id = $request->input('character_id');
        $clip->voice = $voice;
        $clip->audio_path = $mp3Path;
        $clip->script = $text;
        $clip->save();
        
        //Send reques to d:id api to generate video
        $video = new GenerateVideo;
        //dd($imagePath.' | '. $mp3Path.' | '.$text);
        $video_result = $video->generateTalkingHead($imagePath, $mp3Path, $text, $clip);

        if ($video_result instanceof \Illuminate\Http\JsonResponse) {
            return $video_result;
        }

        //attach audio and video file to the request

        $clip->video_id = $video_result['video_id'];
        $clip->video_path = $video_result['video_path'];
        $clip->status = 'Processing';
        $clip->save();
      
        if ($request->input('music_layer', false)) {
            $clip->addMedia(storage_path('tmp/uploads/' . basename($request->input('music_layer'))))->toMediaCollection('music_layer');
        }

        if ($request->input('video', false)) {
            $clip->addMedia(storage_path('tmp/uploads/' . basename($request->input('video'))))->toMediaCollection('video');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $clip->id]);
        }

        return redirect()->route('frontend.clips.index');
    }

    public function edit(Clip $clip)
    {
        abort_if(Gate::denies('clip_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $characters = Character::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $clip->load('character');

        return view('frontend.clips.edit', compact('characters', 'clip'));
    }

    public function update(UpdateClipRequest $request, Clip $clip)
    {
        $clip->update($request->all());

        if ($request->input('audio_file', false)) {
            if (! $clip->audio_file || $request->input('audio_file') !== $clip->audio_file->file_name) {
                if ($clip->audio_file) {
                    $clip->audio_file->delete();
                }
                $clip->addMedia(storage_path('tmp/uploads/' . basename($request->input('audio_file'))))->toMediaCollection('audio_file');
            }
        } elseif ($clip->audio_file) {
            $clip->audio_file->delete();
        }

        if ($request->input('music_layer', false)) {
            if (! $clip->music_layer || $request->input('music_layer') !== $clip->music_layer->file_name) {
                if ($clip->music_layer) {
                    $clip->music_layer->delete();
                }
                $clip->addMedia(storage_path('tmp/uploads/' . basename($request->input('music_layer'))))->toMediaCollection('music_layer');
            }
        } elseif ($clip->music_layer) {
            $clip->music_layer->delete();
        }

        if ($request->input('video', false)) {
            if (! $clip->video || $request->input('video') !== $clip->video->file_name) {
                if ($clip->video) {
                    $clip->video->delete();
                }
                $clip->addMedia(storage_path('tmp/uploads/' . basename($request->input('video'))))->toMediaCollection('video');
            }
        } elseif ($clip->video) {
            $clip->video->delete();
        }

        return redirect()->route('frontend.clips.index');
    }

    public function show(Clip $clip)
    {
        abort_if(Gate::denies('clip_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clip->load('character');

        return view('frontend.clips.show', compact('clip'));
    }

    public function destroy(Clip $clip)
    {
        abort_if(Gate::denies('clip_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clip->delete();

        return back();
    }

    public function massDestroy(MassDestroyClipRequest $request)
    {
        $clips = Clip::find(request('ids'));

        foreach ($clips as $clip) {
            $clip->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('clip_create') && Gate::denies('clip_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Clip();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
