<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDressStyleRequest;
use App\Http\Requests\StoreDressStyleRequest;
use App\Http\Requests\UpdateDressStyleRequest;
use App\Models\DressStyle;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class DressStyleController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('dress_style_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dressStyles = DressStyle::with(['media'])->get();

        return view('admin.dressStyles.index', compact('dressStyles'));
    }

    public function create()
    {
        abort_if(Gate::denies('dress_style_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dressStyles.create');
    }

    public function store(StoreDressStyleRequest $request)
    {
        $dressStyle = DressStyle::create($request->all());

        if ($request->input('icon', false)) {
            $dressStyle->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $dressStyle->id]);
        }

        return redirect()->route('admin.dress-styles.index');
    }

    public function edit(DressStyle $dressStyle)
    {
        abort_if(Gate::denies('dress_style_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dressStyles.edit', compact('dressStyle'));
    }

    public function update(UpdateDressStyleRequest $request, DressStyle $dressStyle)
    {
        $dressStyle->update($request->all());

        if ($request->input('icon', false)) {
            if (! $dressStyle->icon || $request->input('icon') !== $dressStyle->icon->file_name) {
                if ($dressStyle->icon) {
                    $dressStyle->icon->delete();
                }
                $dressStyle->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
            }
        } elseif ($dressStyle->icon) {
            $dressStyle->icon->delete();
        }

        return redirect()->route('admin.dress-styles.index');
    }

    public function show(DressStyle $dressStyle)
    {
        abort_if(Gate::denies('dress_style_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dressStyles.show', compact('dressStyle'));
    }

    public function destroy(DressStyle $dressStyle)
    {
        abort_if(Gate::denies('dress_style_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dressStyle->delete();

        return back();
    }

    public function massDestroy(MassDestroyDressStyleRequest $request)
    {
        $dressStyles = DressStyle::find(request('ids'));

        foreach ($dressStyles as $dressStyle) {
            $dressStyle->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('dress_style_create') && Gate::denies('dress_style_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new DressStyle();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
