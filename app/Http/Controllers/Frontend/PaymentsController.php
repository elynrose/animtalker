<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPaymentRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Payment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Credit;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class PaymentsController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function paid(Request $request)
    {

        abort_if(Gate::denies('payment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //check if the stripe transaction and email exist already
        $payment_old = Payment::where('stripe_transaction', $request->segment(2))->where('email', Auth::user()->email)->first();

        if($payment_old){
            return redirect()->route('frontend.credits.index');
        }
        if($request->segment(2) == null) {
            return redirect()->route('frontend.credits.index');
        } 

        //Validate the stripe transaction
        try {
            // Retrieve the session from Stripe
            $session = StripeSession::retrieve($request->segment(2));
    
            // Optionally, check if the session is paid, active, etc.
            if ($session->payment_status == 'paid') {

                $payment = new Payment;
                $payment->stripe_transaction = $request->segment(2);
                $payment->amount = 10;
                $payment->email = Auth::user()->email;
                
                if($payment->save()){
                    //Add credits to the user
                    $credits = Credit::where('email', Auth::user()->email)->first();
                    //If not found, create a new record
                    if(!$credits){
                        $credits = new Credit;
                        $credits->email = Auth::user()->email;
                        $credits->points = 10;
                        $credits->save();
                    } else {
                    $credits->points = $credits->points + 10;
                    $credits->save();
                    }
                }

            } else {
                return response()->json(['status' => 'failed', 'message' => 'Session is not paid.']);
            }
        } catch (\Exception $e) {
            // Handle errors, such as session not found
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
        

        session()->flash('success', 'Payment successful, we have added 10 credits to your account.');
        return redirect()->route('frontend.credits.index');

    }


    public function index()
    {
        abort_if(Gate::denies('payment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payments = Payment::where('email', Auth::user()->email)->get();
        
        return view('frontend.payments.index', compact('payments'));
    }

    public function create()
    {
        abort_if(Gate::denies('payment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.payments.create');
    }

    public function store(StorePaymentRequest $request)
    {
        $payment = Payment::create($request->all());

        return redirect()->route('frontend.payments.index');
    }

    public function edit(Payment $payment)
    {
        abort_if(Gate::denies('payment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.payments.edit', compact('payment'));
    }

    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $payment->update($request->all());

        return redirect()->route('frontend.payments.index');
    }

    public function show(Payment $payment)
    {
        abort_if(Gate::denies('payment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.payments.show', compact('payment'));
    }

    public function destroy(Payment $payment)
    {
        abort_if(Gate::denies('payment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payment->delete();

        return back();
    }

    public function massDestroy(MassDestroyPaymentRequest $request)
    {
        $payments = Payment::find(request('ids'));

        foreach ($payments as $payment) {
            $payment->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
