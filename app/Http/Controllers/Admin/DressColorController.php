<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDressColorRequest;
use App\Http\Requests\StoreDressColorRequest;
use App\Http\Requests\UpdateDressColorRequest;
use App\Models\DressColor;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DressColorController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('dress_color_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dressColors = DressColor::all();

        return view('admin.dressColors.index', compact('dressColors'));
    }

    public function create()
    {
        abort_if(Gate::denies('dress_color_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dressColors.create');
    }

    public function store(StoreDressColorRequest $request)
    {
        $dressColor = DressColor::create($request->all());

        return redirect()->route('admin.dress-colors.index');
    }

    public function edit(DressColor $dressColor)
    {
        abort_if(Gate::denies('dress_color_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dressColors.edit', compact('dressColor'));
    }

    public function update(UpdateDressColorRequest $request, DressColor $dressColor)
    {
        $dressColor->update($request->all());

        return redirect()->route('admin.dress-colors.index');
    }

    public function show(DressColor $dressColor)
    {
        abort_if(Gate::denies('dress_color_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dressColors.show', compact('dressColor'));
    }

    public function destroy(DressColor $dressColor)
    {
        abort_if(Gate::denies('dress_color_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dressColor->delete();

        return back();
    }

    public function massDestroy(MassDestroyDressColorRequest $request)
    {
        $dressColors = DressColor::find(request('ids'));

        foreach ($dressColors as $dressColor) {
            $dressColor->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
