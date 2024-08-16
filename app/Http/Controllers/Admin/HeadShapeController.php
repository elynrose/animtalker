<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyHeadShapeRequest;
use App\Http\Requests\StoreHeadShapeRequest;
use App\Http\Requests\UpdateHeadShapeRequest;
use App\Models\HeadShape;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HeadShapeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('head_shape_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $headShapes = HeadShape::all();

        return view('admin.headShapes.index', compact('headShapes'));
    }

    public function create()
    {
        abort_if(Gate::denies('head_shape_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.headShapes.create');
    }

    public function store(StoreHeadShapeRequest $request)
    {
        $headShape = HeadShape::create($request->all());

        return redirect()->route('admin.head-shapes.index');
    }

    public function edit(HeadShape $headShape)
    {
        abort_if(Gate::denies('head_shape_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.headShapes.edit', compact('headShape'));
    }

    public function update(UpdateHeadShapeRequest $request, HeadShape $headShape)
    {
        $headShape->update($request->all());

        return redirect()->route('admin.head-shapes.index');
    }

    public function show(HeadShape $headShape)
    {
        abort_if(Gate::denies('head_shape_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.headShapes.show', compact('headShape'));
    }

    public function destroy(HeadShape $headShape)
    {
        abort_if(Gate::denies('head_shape_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $headShape->delete();

        return back();
    }

    public function massDestroy(MassDestroyHeadShapeRequest $request)
    {
        $headShapes = HeadShape::find(request('ids'));

        foreach ($headShapes as $headShape) {
            $headShape->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
