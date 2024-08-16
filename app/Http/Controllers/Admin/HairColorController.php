<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyHairColorRequest;
use App\Http\Requests\StoreHairColorRequest;
use App\Http\Requests\UpdateHairColorRequest;
use App\Models\HairColor;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class HairColorController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('hair_color_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hairColors = HairColor::with(['media'])->get();

        return view('admin.hairColors.index', compact('hairColors'));
    }

    public function create()
    {
        abort_if(Gate::denies('hair_color_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.hairColors.create');
    }

    public function store(StoreHairColorRequest $request)
    {
        $hairColor = HairColor::create($request->all());

        if ($request->input('icon', false)) {
            $hairColor->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $hairColor->id]);
        }

        return redirect()->route('admin.hair-colors.index');
    }

    public function edit(HairColor $hairColor)
    {
        abort_if(Gate::denies('hair_color_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.hairColors.edit', compact('hairColor'));
    }

    public function update(UpdateHairColorRequest $request, HairColor $hairColor)
    {
        $hairColor->update($request->all());

        if ($request->input('icon', false)) {
            if (! $hairColor->icon || $request->input('icon') !== $hairColor->icon->file_name) {
                if ($hairColor->icon) {
                    $hairColor->icon->delete();
                }
                $hairColor->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
            }
        } elseif ($hairColor->icon) {
            $hairColor->icon->delete();
        }

        return redirect()->route('admin.hair-colors.index');
    }

    public function show(HairColor $hairColor)
    {
        abort_if(Gate::denies('hair_color_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.hairColors.show', compact('hairColor'));
    }

    public function destroy(HairColor $hairColor)
    {
        abort_if(Gate::denies('hair_color_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hairColor->delete();

        return back();
    }

    public function massDestroy(MassDestroyHairColorRequest $request)
    {
        $hairColors = HairColor::find(request('ids'));

        foreach ($hairColors as $hairColor) {
            $hairColor->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('hair_color_create') && Gate::denies('hair_color_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new HairColor();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
