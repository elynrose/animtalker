<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyNoseShapeRequest;
use App\Http\Requests\StoreNoseShapeRequest;
use App\Http\Requests\UpdateNoseShapeRequest;
use App\Models\NoseShape;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoseShapeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('nose_shape_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $noseShapes = NoseShape::all();

        return view('admin.noseShapes.index', compact('noseShapes'));
    }

    public function create()
    {
        abort_if(Gate::denies('nose_shape_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.noseShapes.create');
    }

    public function store(StoreNoseShapeRequest $request)
    {
        $noseShape = NoseShape::create($request->all());

        return redirect()->route('admin.nose-shapes.index');
    }

    public function edit(NoseShape $noseShape)
    {
        abort_if(Gate::denies('nose_shape_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.noseShapes.edit', compact('noseShape'));
    }

    public function update(UpdateNoseShapeRequest $request, NoseShape $noseShape)
    {
        $noseShape->update($request->all());

        return redirect()->route('admin.nose-shapes.index');
    }

    public function show(NoseShape $noseShape)
    {
        abort_if(Gate::denies('nose_shape_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.noseShapes.show', compact('noseShape'));
    }

    public function destroy(NoseShape $noseShape)
    {
        abort_if(Gate::denies('nose_shape_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $noseShape->delete();

        return back();
    }

    public function massDestroy(MassDestroyNoseShapeRequest $request)
    {
        $noseShapes = NoseShape::find(request('ids'));

        foreach ($noseShapes as $noseShape) {
            $noseShape->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
