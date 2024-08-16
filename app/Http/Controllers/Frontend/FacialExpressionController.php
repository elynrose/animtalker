<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFacialExpressionRequest;
use App\Http\Requests\StoreFacialExpressionRequest;
use App\Http\Requests\UpdateFacialExpressionRequest;
use App\Models\FacialExpression;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class FacialExpressionController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('facial_expression_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $facialExpressions = FacialExpression::with(['media'])->get();

        return view('frontend.facialExpressions.index', compact('facialExpressions'));
    }

    public function create()
    {
        abort_if(Gate::denies('facial_expression_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.facialExpressions.create');
    }

    public function store(StoreFacialExpressionRequest $request)
    {
        $facialExpression = FacialExpression::create($request->all());

        if ($request->input('icon', false)) {
            $facialExpression->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $facialExpression->id]);
        }

        return redirect()->route('frontend.facial-expressions.index');
    }

    public function edit(FacialExpression $facialExpression)
    {
        abort_if(Gate::denies('facial_expression_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.facialExpressions.edit', compact('facialExpression'));
    }

    public function update(UpdateFacialExpressionRequest $request, FacialExpression $facialExpression)
    {
        $facialExpression->update($request->all());

        if ($request->input('icon', false)) {
            if (! $facialExpression->icon || $request->input('icon') !== $facialExpression->icon->file_name) {
                if ($facialExpression->icon) {
                    $facialExpression->icon->delete();
                }
                $facialExpression->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
            }
        } elseif ($facialExpression->icon) {
            $facialExpression->icon->delete();
        }

        return redirect()->route('frontend.facial-expressions.index');
    }

    public function show(FacialExpression $facialExpression)
    {
        abort_if(Gate::denies('facial_expression_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.facialExpressions.show', compact('facialExpression'));
    }

    public function destroy(FacialExpression $facialExpression)
    {
        abort_if(Gate::denies('facial_expression_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $facialExpression->delete();

        return back();
    }

    public function massDestroy(MassDestroyFacialExpressionRequest $request)
    {
        $facialExpressions = FacialExpression::find(request('ids'));

        foreach ($facialExpressions as $facialExpression) {
            $facialExpression->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('facial_expression_create') && Gate::denies('facial_expression_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new FacialExpression();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
