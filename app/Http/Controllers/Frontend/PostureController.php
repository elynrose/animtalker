<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPostureRequest;
use App\Http\Requests\StorePostureRequest;
use App\Http\Requests\UpdatePostureRequest;
use App\Models\Posture;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostureController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('posture_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $postures = Posture::all();

        return view('frontend.postures.index', compact('postures'));
    }

    public function create()
    {
        abort_if(Gate::denies('posture_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.postures.create');
    }

    public function store(StorePostureRequest $request)
    {
        $posture = Posture::create($request->all());

        return redirect()->route('frontend.postures.index');
    }

    public function edit(Posture $posture)
    {
        abort_if(Gate::denies('posture_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.postures.edit', compact('posture'));
    }

    public function update(UpdatePostureRequest $request, Posture $posture)
    {
        $posture->update($request->all());

        return redirect()->route('frontend.postures.index');
    }

    public function show(Posture $posture)
    {
        abort_if(Gate::denies('posture_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.postures.show', compact('posture'));
    }

    public function destroy(Posture $posture)
    {
        abort_if(Gate::denies('posture_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $posture->delete();

        return back();
    }

    public function massDestroy(MassDestroyPostureRequest $request)
    {
        $postures = Posture::find(request('ids'));

        foreach ($postures as $posture) {
            $posture->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
