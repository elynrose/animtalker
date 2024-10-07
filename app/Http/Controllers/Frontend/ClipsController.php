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
use Illuminate\Support\Facades\Http;
use App\Models\Credit;
use Storage;
use Auth;
use App\Models\SendToOpenai;


class ClipsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('clip_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clips = Clip::with(['character', 'media'])
            ->whereHas('character', function ($query) {
            $query->where('user_id', auth()->user()->id);
            })
            ->orderBy('id', 'desc')->get();

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
        $clip->status = 'new';
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

    public function savelink(Request $request)
    {
        $video_link = $request->video_path;
        $clip = Clip::find($request->clip_id);
        $fileName = 'video/' . uniqid() . '.mp4';
        $path = Storage::disk('s3')->putFileAs('video', $video_link, $fileName);

        if($path){
            $clip->saved = 1;
            $clip->video_path = $path;
            $clip->save();
            return json_encode(['success'=>'The file was saved', 'path'=>$path]);
        } else{
            return json_encode(['error'=>'The file was not saved, try again.']);
          //  return redirect()->route('frontend.clips.index')->withError('The file could not be saved.');

        }
        
       // $clip->addMedia(storage_path('tmp/uploads/' . basename($video_link)))->toMediaCollection('video');
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


    public function webhook(Request $request)
    {
        $clip = Clip::where('video_id', $request->input('video_id'))->first();
        $clip->status = $request->input('status');
        $clip->save();
    }

    //Create method for generateVideoStatus
    public function generateVideoStatus(Request $request)
    {
        $count = Clip::where('status','new')->count();
        $clip = Clip::where('id', $request->input('id'))->first();
        if($clip) {
            return response()->json(['status' => $clip->status, 'video_path' => $clip->video_path, 'in_line' => $count]);
        } else {
            return response()->json(['status' => 'not found']);
        }
    }


    //create an openai method to generate text with a given prompt
    public function openai(Request $request)
    { 
        $prompt = "Generate a 60 word only post and not include hashtags. Topic: ".$request->input('topic');
        $result = SendToOpenai::sendToOpenAI($prompt);
        return $result;
    }


    public function retry(Request $request)
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }
        $clip_id = $request->segment(3);
        //Get the first clip that has not been processed
        $clip = Clip::find($clip_id);
        if(!$clip){
            return;
        } else{
        //Update the status to new
        $clip->status = 'new';
        $clip->save();     
        return redirect()->route('frontend.clips.index'); 
        }
      
    }


   
}
