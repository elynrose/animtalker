<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEyeShapeRequest;
use App\Http\Requests\StoreEyeShapeRequest;
use App\Http\Requests\UpdateEyeShapeRequest;
use App\Models\EyeShape;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class EyeShapeController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('eye_shape_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eyeShapes = EyeShape::with(['media'])->get();

        return view('frontend.eyeShapes.index', compact('eyeShapes'));
    }

    public function create()
    {
        abort_if(Gate::denies('eye_shape_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.eyeShapes.create');
    }

    public function store(StoreEyeShapeRequest $request)
    {
        $eyeShape = EyeShape::create($request->all());

        if ($request->input('icon', false)) {
            $eyeShape->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $eyeShape->id]);
        }

        return redirect()->route('frontend.eye-shapes.index');
    }

    public function edit(EyeShape $eyeShape)
    {
        abort_if(Gate::denies('eye_shape_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.eyeShapes.edit', compact('eyeShape'));
    }

    public function update(UpdateEyeShapeRequest $request, EyeShape $eyeShape)
    {
        $eyeShape->update($request->all());

        if ($request->input('icon', false)) {
            if (! $eyeShape->icon || $request->input('icon') !== $eyeShape->icon->file_name) {
                if ($eyeShape->icon) {
                    $eyeShape->icon->delete();
                }
                $eyeShape->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
            }
        } elseif ($eyeShape->icon) {
            $eyeShape->icon->delete();
        }

        return redirect()->route('frontend.eye-shapes.index');
    }

    public function show(EyeShape $eyeShape)
    {
        abort_if(Gate::denies('eye_shape_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.eyeShapes.show', compact('eyeShape'));
    }

    public function destroy(EyeShape $eyeShape)
    {
        abort_if(Gate::denies('eye_shape_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eyeShape->delete();

        return back();
    }

    public function massDestroy(MassDestroyEyeShapeRequest $request)
    {
        $eyeShapes = EyeShape::find(request('ids'));

        foreach ($eyeShapes as $eyeShape) {
            $eyeShape->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('eye_shape_create') && Gate::denies('eye_shape_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new EyeShape();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
