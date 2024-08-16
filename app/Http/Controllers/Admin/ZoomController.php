<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyZoomRequest;
use App\Http\Requests\StoreZoomRequest;
use App\Http\Requests\UpdateZoomRequest;
use App\Models\Zoom;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ZoomController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('zoom_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $zooms = Zoom::all();

        return view('admin.zooms.index', compact('zooms'));
    }

    public function create()
    {
        abort_if(Gate::denies('zoom_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.zooms.create');
    }

    public function store(StoreZoomRequest $request)
    {
        $zoom = Zoom::create($request->all());

        return redirect()->route('admin.zooms.index');
    }

    public function edit(Zoom $zoom)
    {
        abort_if(Gate::denies('zoom_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.zooms.edit', compact('zoom'));
    }

    public function update(UpdateZoomRequest $request, Zoom $zoom)
    {
        $zoom->update($request->all());

        return redirect()->route('admin.zooms.index');
    }

    public function show(Zoom $zoom)
    {
        abort_if(Gate::denies('zoom_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.zooms.show', compact('zoom'));
    }

    public function destroy(Zoom $zoom)
    {
        abort_if(Gate::denies('zoom_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $zoom->delete();

        return back();
    }

    public function massDestroy(MassDestroyZoomRequest $request)
    {
        $zooms = Zoom::find(request('ids'));

        foreach ($zooms as $zoom) {
            $zoom->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
