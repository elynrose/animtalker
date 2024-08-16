<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBodyTypeRequest;
use App\Http\Requests\StoreBodyTypeRequest;
use App\Http\Requests\UpdateBodyTypeRequest;
use App\Models\BodyType;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class BodyTypeController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('body_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bodyTypes = BodyType::with(['media'])->get();

        return view('frontend.bodyTypes.index', compact('bodyTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('body_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.bodyTypes.create');
    }

    public function store(StoreBodyTypeRequest $request)
    {
        $bodyType = BodyType::create($request->all());

        if ($request->input('icon', false)) {
            $bodyType->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $bodyType->id]);
        }

        return redirect()->route('frontend.body-types.index');
    }

    public function edit(BodyType $bodyType)
    {
        abort_if(Gate::denies('body_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.bodyTypes.edit', compact('bodyType'));
    }

    public function update(UpdateBodyTypeRequest $request, BodyType $bodyType)
    {
        $bodyType->update($request->all());

        if ($request->input('icon', false)) {
            if (! $bodyType->icon || $request->input('icon') !== $bodyType->icon->file_name) {
                if ($bodyType->icon) {
                    $bodyType->icon->delete();
                }
                $bodyType->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
            }
        } elseif ($bodyType->icon) {
            $bodyType->icon->delete();
        }

        return redirect()->route('frontend.body-types.index');
    }

    public function show(BodyType $bodyType)
    {
        abort_if(Gate::denies('body_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.bodyTypes.show', compact('bodyType'));
    }

    public function destroy(BodyType $bodyType)
    {
        abort_if(Gate::denies('body_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bodyType->delete();

        return back();
    }

    public function massDestroy(MassDestroyBodyTypeRequest $request)
    {
        $bodyTypes = BodyType::find(request('ids'));

        foreach ($bodyTypes as $bodyType) {
            $bodyType->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('body_type_create') && Gate::denies('body_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new BodyType();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
