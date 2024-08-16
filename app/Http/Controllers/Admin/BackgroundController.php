<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBackgroundRequest;
use App\Http\Requests\StoreBackgroundRequest;
use App\Http\Requests\UpdateBackgroundRequest;
use App\Models\Background;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class BackgroundController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('background_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $backgrounds = Background::with(['media'])->get();

        return view('admin.backgrounds.index', compact('backgrounds'));
    }

    public function create()
    {
        abort_if(Gate::denies('background_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.backgrounds.create');
    }

    public function store(StoreBackgroundRequest $request)
    {
        $background = Background::create($request->all());

        if ($request->input('icon', false)) {
            $background->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $background->id]);
        }

        return redirect()->route('admin.backgrounds.index');
    }

    public function edit(Background $background)
    {
        abort_if(Gate::denies('background_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.backgrounds.edit', compact('background'));
    }

    public function update(UpdateBackgroundRequest $request, Background $background)
    {
        $background->update($request->all());

        if ($request->input('icon', false)) {
            if (! $background->icon || $request->input('icon') !== $background->icon->file_name) {
                if ($background->icon) {
                    $background->icon->delete();
                }
                $background->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
            }
        } elseif ($background->icon) {
            $background->icon->delete();
        }

        return redirect()->route('admin.backgrounds.index');
    }

    public function show(Background $background)
    {
        abort_if(Gate::denies('background_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.backgrounds.show', compact('background'));
    }

    public function destroy(Background $background)
    {
        abort_if(Gate::denies('background_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $background->delete();

        return back();
    }

    public function massDestroy(MassDestroyBackgroundRequest $request)
    {
        $backgrounds = Background::find(request('ids'));

        foreach ($backgrounds as $background) {
            $background->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('background_create') && Gate::denies('background_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Background();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
