<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEmotionRequest;
use App\Http\Requests\StoreEmotionRequest;
use App\Http\Requests\UpdateEmotionRequest;
use App\Models\Emotion;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class EmotionController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('emotion_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $emotions = Emotion::with(['media'])->get();

        return view('admin.emotions.index', compact('emotions'));
    }

    public function create()
    {
        abort_if(Gate::denies('emotion_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.emotions.create');
    }

    public function store(StoreEmotionRequest $request)
    {
        $emotion = Emotion::create($request->all());

        if ($request->input('icon', false)) {
            $emotion->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $emotion->id]);
        }

        return redirect()->route('admin.emotions.index');
    }

    public function edit(Emotion $emotion)
    {
        abort_if(Gate::denies('emotion_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.emotions.edit', compact('emotion'));
    }

    public function update(UpdateEmotionRequest $request, Emotion $emotion)
    {
        $emotion->update($request->all());

        if ($request->input('icon', false)) {
            if (! $emotion->icon || $request->input('icon') !== $emotion->icon->file_name) {
                if ($emotion->icon) {
                    $emotion->icon->delete();
                }
                $emotion->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
            }
        } elseif ($emotion->icon) {
            $emotion->icon->delete();
        }

        return redirect()->route('admin.emotions.index');
    }

    public function show(Emotion $emotion)
    {
        abort_if(Gate::denies('emotion_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.emotions.show', compact('emotion'));
    }

    public function destroy(Emotion $emotion)
    {
        abort_if(Gate::denies('emotion_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $emotion->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmotionRequest $request)
    {
        $emotions = Emotion::find(request('ids'));

        foreach ($emotions as $emotion) {
            $emotion->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('emotion_create') && Gate::denies('emotion_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Emotion();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
