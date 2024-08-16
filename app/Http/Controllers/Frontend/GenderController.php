<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyGenderRequest;
use App\Http\Requests\StoreGenderRequest;
use App\Http\Requests\UpdateGenderRequest;
use App\Models\Gender;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class GenderController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('gender_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $genders = Gender::with(['media'])->get();

        return view('frontend.genders.index', compact('genders'));
    }

    public function create()
    {
        abort_if(Gate::denies('gender_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.genders.create');
    }

    public function store(StoreGenderRequest $request)
    {
        $gender = Gender::create($request->all());

        if ($request->input('icon', false)) {
            $gender->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $gender->id]);
        }

        return redirect()->route('frontend.genders.index');
    }

    public function edit(Gender $gender)
    {
        abort_if(Gate::denies('gender_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.genders.edit', compact('gender'));
    }

    public function update(UpdateGenderRequest $request, Gender $gender)
    {
        $gender->update($request->all());

        if ($request->input('icon', false)) {
            if (! $gender->icon || $request->input('icon') !== $gender->icon->file_name) {
                if ($gender->icon) {
                    $gender->icon->delete();
                }
                $gender->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
            }
        } elseif ($gender->icon) {
            $gender->icon->delete();
        }

        return redirect()->route('frontend.genders.index');
    }

    public function show(Gender $gender)
    {
        abort_if(Gate::denies('gender_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.genders.show', compact('gender'));
    }

    public function destroy(Gender $gender)
    {
        abort_if(Gate::denies('gender_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gender->delete();

        return back();
    }

    public function massDestroy(MassDestroyGenderRequest $request)
    {
        $genders = Gender::find(request('ids'));

        foreach ($genders as $gender) {
            $gender->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('gender_create') && Gate::denies('gender_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Gender();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
