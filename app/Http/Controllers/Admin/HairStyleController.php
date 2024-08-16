<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyHairStyleRequest;
use App\Http\Requests\StoreHairStyleRequest;
use App\Http\Requests\UpdateHairStyleRequest;
use App\Models\HairStyle;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class HairStyleController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('hair_style_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hairStyles = HairStyle::with(['media'])->get();

        return view('admin.hairStyles.index', compact('hairStyles'));
    }

    public function create()
    {
        abort_if(Gate::denies('hair_style_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.hairStyles.create');
    }

    public function store(StoreHairStyleRequest $request)
    {
        $hairStyle = HairStyle::create($request->all());

        if ($request->input('icon', false)) {
            $hairStyle->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $hairStyle->id]);
        }

        return redirect()->route('admin.hair-styles.index');
    }

    public function edit(HairStyle $hairStyle)
    {
        abort_if(Gate::denies('hair_style_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.hairStyles.edit', compact('hairStyle'));
    }

    public function update(UpdateHairStyleRequest $request, HairStyle $hairStyle)
    {
        $hairStyle->update($request->all());

        if ($request->input('icon', false)) {
            if (! $hairStyle->icon || $request->input('icon') !== $hairStyle->icon->file_name) {
                if ($hairStyle->icon) {
                    $hairStyle->icon->delete();
                }
                $hairStyle->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
            }
        } elseif ($hairStyle->icon) {
            $hairStyle->icon->delete();
        }

        return redirect()->route('admin.hair-styles.index');
    }

    public function show(HairStyle $hairStyle)
    {
        abort_if(Gate::denies('hair_style_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.hairStyles.show', compact('hairStyle'));
    }

    public function destroy(HairStyle $hairStyle)
    {
        abort_if(Gate::denies('hair_style_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hairStyle->delete();

        return back();
    }

    public function massDestroy(MassDestroyHairStyleRequest $request)
    {
        $hairStyles = HairStyle::find(request('ids'));

        foreach ($hairStyles as $hairStyle) {
            $hairStyle->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('hair_style_create') && Gate::denies('hair_style_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new HairStyle();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
