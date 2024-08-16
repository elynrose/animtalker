<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEyeColorRequest;
use App\Http\Requests\StoreEyeColorRequest;
use App\Http\Requests\UpdateEyeColorRequest;
use App\Models\EyeColor;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class EyeColorController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('eye_color_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eyeColors = EyeColor::with(['media'])->get();

        return view('frontend.eyeColors.index', compact('eyeColors'));
    }

    public function create()
    {
        abort_if(Gate::denies('eye_color_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.eyeColors.create');
    }

    public function store(StoreEyeColorRequest $request)
    {
        $eyeColor = EyeColor::create($request->all());

        if ($request->input('icon', false)) {
            $eyeColor->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $eyeColor->id]);
        }

        return redirect()->route('frontend.eye-colors.index');
    }

    public function edit(EyeColor $eyeColor)
    {
        abort_if(Gate::denies('eye_color_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.eyeColors.edit', compact('eyeColor'));
    }

    public function update(UpdateEyeColorRequest $request, EyeColor $eyeColor)
    {
        $eyeColor->update($request->all());

        if ($request->input('icon', false)) {
            if (! $eyeColor->icon || $request->input('icon') !== $eyeColor->icon->file_name) {
                if ($eyeColor->icon) {
                    $eyeColor->icon->delete();
                }
                $eyeColor->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
            }
        } elseif ($eyeColor->icon) {
            $eyeColor->icon->delete();
        }

        return redirect()->route('frontend.eye-colors.index');
    }

    public function show(EyeColor $eyeColor)
    {
        abort_if(Gate::denies('eye_color_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.eyeColors.show', compact('eyeColor'));
    }

    public function destroy(EyeColor $eyeColor)
    {
        abort_if(Gate::denies('eye_color_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eyeColor->delete();

        return back();
    }

    public function massDestroy(MassDestroyEyeColorRequest $request)
    {
        $eyeColors = EyeColor::find(request('ids'));

        foreach ($eyeColors as $eyeColor) {
            $eyeColor->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('eye_color_create') && Gate::denies('eye_color_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new EyeColor();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
