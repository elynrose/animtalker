<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCreditRequest;
use App\Http\Requests\StoreCreditRequest;
use App\Http\Requests\UpdateCreditRequest;
use App\Models\Credit;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CreditsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('credit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $credits = Credit::where('email', auth()->user()->email)->get();

        return view('frontend.credits.index', compact('credits'));
    }

    public function create()
    {
        abort_if(Gate::denies('credit_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.credits.create');
    }

    public function store(StoreCreditRequest $request)
    {
        $credit = Credit::create($request->all());

        return redirect()->route('frontend.credits.index');
    }

    public function edit(Credit $credit)
    {
        abort_if(Gate::denies('credit_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.credits.edit', compact('credit'));
    }

    public function update(UpdateCreditRequest $request, Credit $credit)
    {
        $credit->update($request->all());

        return redirect()->route('frontend.credits.index');
    }

    public function show(Credit $credit)
    {
        abort_if(Gate::denies('credit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.credits.show', compact('credit'));
    }

    public function destroy(Credit $credit)
    {
        abort_if(Gate::denies('credit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $credit->delete();

        return back();
    }

    public function massDestroy(MassDestroyCreditRequest $request)
    {
        $credits = Credit::find(request('ids'));

        foreach ($credits as $credit) {
            $credit->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
