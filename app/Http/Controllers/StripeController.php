<?php

namespace App\Http\Controllers;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\User\PaymentController;

class StripeController extends Controller
{

    //stripe_payment
 	public function masterCardPayment()
    {
        $payment_data = Session::get('payment_data');

        if($payment_data){
            $stripe = PaymentGateway::where('method_slug', 'masterCard')->select('public_key', 'secret_key')->first();

            \Stripe\Stripe::setApiKey($stripe->secret_key);
            $payment_success = \Stripe\Charge::create ([
                    "amount" => round($payment_data['total_price'] * 100),
                    "currency" => $payment_data['currency'],
                    "source" => $payment_data['stripeToken'],
                    "description" => 'product purchase',
                    'statement_descriptor' => Auth::user()->name,
            ]);
            if($payment_success){
                Session::put('payment_data.trnx_id', $payment_success['balance_transaction']);
                Session::put('payment_data.status', 'success');
                Session::put('payment_data.payment_status', 'paid');
                $paymentController = new PaymentController();
                //redirect payment success method
                return $paymentController->paymentSuccess();
		    }else{
		    	Toastr::error('Sorry, your payment failed');
	            return back();
		    }
	    }else{
	    	Toastr::error('Sorry your cart is empty or product not found.!');
	    	return back();
	    }
    }
}
