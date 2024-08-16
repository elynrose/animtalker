<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyHairLengthRequest;
use App\Http\Requests\StoreHairLengthRequest;
use App\Http\Requests\UpdateHairLengthRequest;
use App\Models\HairLength;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class HairLengthController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('hair_length_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hairLengths = HairLength::with(['media'])->get();

        return view('admin.hairLengths.index', compact('hairLengths'));
    }

    public function create()
    {
        abort_if(Gate::denies('hair_length_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.hairLengths.create');
    }

    public function store(StoreHairLengthRequest $request)
    {
        $hairLength = HairLength::create($request->all());

        if ($request->input('icon', false)) {
            $hairLength->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $hairLength->id]);
        }

        return redirect()->route('admin.hair-lengths.index');
    }

    public function edit(HairLength $hairLength)
    {
        abort_if(Gate::denies('hair_length_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.hairLengths.edit', compact('hairLength'));
    }

    public function update(UpdateHairLengthRequest $request, HairLength $hairLength)
    {
        $hairLength->update($request->all());

        if ($request->input('icon', false)) {
            if (! $hairLength->icon || $request->input('icon') !== $hairLength->icon->file_name) {
                if ($hairLength->icon) {
                    $hairLength->icon->delete();
                }
                $hairLength->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
            }
        } elseif ($hairLength->icon) {
            $hairLength->icon->delete();
        }

        return redirect()->route('admin.hair-lengths.index');
    }

    public function show(HairLength $hairLength)
    {
        abort_if(Gate::denies('hair_length_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.hairLengths.show', compact('hairLength'));
    }

    public function destroy(HairLength $hairLength)
    {
        abort_if(Gate::denies('hair_length_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hairLength->delete();

        return back();
    }

    public function massDestroy(MassDestroyHairLengthRequest $request)
    {
        $hairLengths = HairLength::find(request('ids'));

        foreach ($hairLengths as $hairLength) {
            $hairLength->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('hair_length_create') && Gate::denies('hair_length_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new HairLength();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
