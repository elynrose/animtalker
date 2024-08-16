<?php

namespace App\Http\Controllers\Admin;

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

class ClipsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('clip_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clips = Clip::with(['character', 'media'])->get();

        return view('admin.clips.index', compact('clips'));
    }

    public function create()
    {
        abort_if(Gate::denies('clip_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $characters = Character::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.clips.create', compact('characters'));
    }

    public function store(StoreClipRequest $request)
    {
        $clip = Clip::create($request->all());

        if ($request->input('audio_file', false)) {
            $clip->addMedia(storage_path('tmp/uploads/' . basename($request->input('audio_file'))))->toMediaCollection('audio_file');
        }

        if ($request->input('music_layer', false)) {
            $clip->addMedia(storage_path('tmp/uploads/' . basename($request->input('music_layer'))))->toMediaCollection('music_layer');
        }

        if ($request->input('video', false)) {
            $clip->addMedia(storage_path('tmp/uploads/' . basename($request->input('video'))))->toMediaCollection('video');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $clip->id]);
        }

        return redirect()->route('admin.clips.index');
    }

    public function edit(Clip $clip)
    {
        abort_if(Gate::denies('clip_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $characters = Character::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $clip->load('character');

        return view('admin.clips.edit', compact('characters', 'clip'));
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

        return redirect()->route('admin.clips.index');
    }

    public function show(Clip $clip)
    {
        abort_if(Gate::denies('clip_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clip->load('character');

        return view('admin.clips.show', compact('clip'));
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
