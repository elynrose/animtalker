<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySkinToneRequest;
use App\Http\Requests\StoreSkinToneRequest;
use App\Http\Requests\UpdateSkinToneRequest;
use App\Models\SkinTone;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class SkinToneController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('skin_tone_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $skinTones = SkinTone::with(['media'])->get();

        return view('admin.skinTones.index', compact('skinTones'));
    }

    public function create()
    {
        abort_if(Gate::denies('skin_tone_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.skinTones.create');
    }

    public function store(StoreSkinToneRequest $request)
    {
        $skinTone = SkinTone::create($request->all());

        if ($request->input('icon', false)) {
            $skinTone->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $skinTone->id]);
        }

        return redirect()->route('admin.skin-tones.index');
    }

    public function edit(SkinTone $skinTone)
    {
        abort_if(Gate::denies('skin_tone_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.skinTones.edit', compact('skinTone'));
    }

    public function update(UpdateSkinToneRequest $request, SkinTone $skinTone)
    {
        $skinTone->update($request->all());

        if ($request->input('icon', false)) {
            if (! $skinTone->icon || $request->input('icon') !== $skinTone->icon->file_name) {
                if ($skinTone->icon) {
                    $skinTone->icon->delete();
                }
                $skinTone->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
            }
        } elseif ($skinTone->icon) {
            $skinTone->icon->delete();
        }

        return redirect()->route('admin.skin-tones.index');
    }

    public function show(SkinTone $skinTone)
    {
        abort_if(Gate::denies('skin_tone_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.skinTones.show', compact('skinTone'));
    }

    public function destroy(SkinTone $skinTone)
    {
        abort_if(Gate::denies('skin_tone_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $skinTone->delete();

        return back();
    }

    public function massDestroy(MassDestroySkinToneRequest $request)
    {
        $skinTones = SkinTone::find(request('ids'));

        foreach ($skinTones as $skinTone) {
            $skinTone->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('skin_tone_create') && Gate::denies('skin_tone_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new SkinTone();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
