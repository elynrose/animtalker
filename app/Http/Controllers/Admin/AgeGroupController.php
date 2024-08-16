<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAgeGroupRequest;
use App\Http\Requests\StoreAgeGroupRequest;
use App\Http\Requests\UpdateAgeGroupRequest;
use App\Models\AgeGroup;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AgeGroupController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('age_group_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ageGroups = AgeGroup::with(['media'])->get();

        return view('admin.ageGroups.index', compact('ageGroups'));
    }

    public function create()
    {
        abort_if(Gate::denies('age_group_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ageGroups.create');
    }

    public function store(StoreAgeGroupRequest $request)
    {
        $ageGroup = AgeGroup::create($request->all());

        if ($request->input('icon', false)) {
            $ageGroup->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $ageGroup->id]);
        }

        return redirect()->route('admin.age-groups.index');
    }

    public function edit(AgeGroup $ageGroup)
    {
        abort_if(Gate::denies('age_group_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ageGroups.edit', compact('ageGroup'));
    }

    public function update(UpdateAgeGroupRequest $request, AgeGroup $ageGroup)
    {
        $ageGroup->update($request->all());

        if ($request->input('icon', false)) {
            if (! $ageGroup->icon || $request->input('icon') !== $ageGroup->icon->file_name) {
                if ($ageGroup->icon) {
                    $ageGroup->icon->delete();
                }
                $ageGroup->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
            }
        } elseif ($ageGroup->icon) {
            $ageGroup->icon->delete();
        }

        return redirect()->route('admin.age-groups.index');
    }

    public function show(AgeGroup $ageGroup)
    {
        abort_if(Gate::denies('age_group_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ageGroups.show', compact('ageGroup'));
    }

    public function destroy(AgeGroup $ageGroup)
    {
        abort_if(Gate::denies('age_group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ageGroup->delete();

        return back();
    }

    public function massDestroy(MassDestroyAgeGroupRequest $request)
    {
        $ageGroups = AgeGroup::find(request('ids'));

        foreach ($ageGroups as $ageGroup) {
            $ageGroup->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('age_group_create') && Gate::denies('age_group_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new AgeGroup();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
