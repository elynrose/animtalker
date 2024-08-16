<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPropRequest;
use App\Http\Requests\StorePropRequest;
use App\Http\Requests\UpdatePropRequest;
use App\Models\Prop;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PropsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('prop_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $props = Prop::all();

        return view('admin.props.index', compact('props'));
    }

    public function create()
    {
        abort_if(Gate::denies('prop_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.props.create');
    }

    public function store(StorePropRequest $request)
    {
        $prop = Prop::create($request->all());

        return redirect()->route('admin.props.index');
    }

    public function edit(Prop $prop)
    {
        abort_if(Gate::denies('prop_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.props.edit', compact('prop'));
    }

    public function update(UpdatePropRequest $request, Prop $prop)
    {
        $prop->update($request->all());

        return redirect()->route('admin.props.index');
    }

    public function show(Prop $prop)
    {
        abort_if(Gate::denies('prop_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.props.show', compact('prop'));
    }

    public function destroy(Prop $prop)
    {
        abort_if(Gate::denies('prop_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $prop->delete();

        return back();
    }

    public function massDestroy(MassDestroyPropRequest $request)
    {
        $props = Prop::find(request('ids'));

        foreach ($props as $prop) {
            $prop->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
