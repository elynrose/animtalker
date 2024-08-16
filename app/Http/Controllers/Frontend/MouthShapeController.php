<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMouthShapeRequest;
use App\Http\Requests\StoreMouthShapeRequest;
use App\Http\Requests\UpdateMouthShapeRequest;
use App\Models\MouthShape;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MouthShapeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('mouth_shape_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mouthShapes = MouthShape::all();

        return view('frontend.mouthShapes.index', compact('mouthShapes'));
    }

    public function create()
    {
        abort_if(Gate::denies('mouth_shape_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.mouthShapes.create');
    }

    public function store(StoreMouthShapeRequest $request)
    {
        $mouthShape = MouthShape::create($request->all());

        return redirect()->route('frontend.mouth-shapes.index');
    }

    public function edit(MouthShape $mouthShape)
    {
        abort_if(Gate::denies('mouth_shape_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.mouthShapes.edit', compact('mouthShape'));
    }

    public function update(UpdateMouthShapeRequest $request, MouthShape $mouthShape)
    {
        $mouthShape->update($request->all());

        return redirect()->route('frontend.mouth-shapes.index');
    }

    public function show(MouthShape $mouthShape)
    {
        abort_if(Gate::denies('mouth_shape_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.mouthShapes.show', compact('mouthShape'));
    }

    public function destroy(MouthShape $mouthShape)
    {
        abort_if(Gate::denies('mouth_shape_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mouthShape->delete();

        return back();
    }

    public function massDestroy(MassDestroyMouthShapeRequest $request)
    {
        $mouthShapes = MouthShape::find(request('ids'));

        foreach ($mouthShapes as $mouthShape) {
            $mouthShape->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
