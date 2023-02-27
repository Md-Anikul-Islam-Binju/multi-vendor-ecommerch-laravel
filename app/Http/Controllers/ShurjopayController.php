<?php

namespace App\Http\Controllers;

use App\Http\Controllers\User\PaymentController;
use App\Models\Order;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use smasif\ShurjopayLaravelPackage\ShurjopayService;


class ShurjopayController extends Controller
{
    public function shurjopayPayment(){
        $payment_data = Session::get('payment_data');
        $order = Order::where('order_id', $payment_data['order_id'])->first();
        if(!Session::has('payment_data') && !$order){
            return redirect()->back();
        }
        $total_price = $order->total_price + $order->shipping_cost - $order->coupon_discount;
        $order_id = $payment_data['order_id'];
        $shurjopay_service = new ShurjopayService();
        $tx_id = $shurjopay_service->generateTxId($order_id);
        $success_route = route('shurjopayPaymentSuccess'); //This is your custom route where you want to back after completing the transaction.
        $trx_array=array(
            'customer_name'=> (Auth::user()->name) ? Auth::user()->name : $order->shipping_name,
            'customer_email'=> (Auth::user()->email) ? Auth::user()->email : $order->shipping_email,
            'customer_cell'=> (Auth::user()->mobile) ? Auth::user()->mobile : $order->shipping_phone,
            'customer_address'=> ($order->billing_address) ? $order->billing_address : $order->shipping_address,
            'total_amount'=> $total_price
        );
        $shurjopay_service->sendPayment($trx_array, $success_route);
    }

    public function paymentSuccess(Request $request)
    {
        try{
        $server_url = env('SHURJOPAY_SERVER_URL');
        $response_decrypted = file_get_contents($server_url . "/merchant/decrypt.php?data=" . $request->spdata);
        $data = simplexml_load_string($response_decrypted) or die("Error: Cannot create object");

            if ($data && $data->spCode == 000 && $data->bankTxStatus=="SUCCESS") {
                $orderid = explode('_', trim($data->txID))[1];
                //after payment success update payment status
                Session::forget('payment_data');
                $data = [
                    'order_id' => $orderid,
                    'trnx_id' => $data->txID,
                    'payment_status' => 'paid',
                    'payment_info' => $data->paymentOption . ' ,txId:' . $data->bankTxID,
                    'payment_method' => 'shurjopay',
                    'status' => 'success'
                ];
                Session::put('payment_data', $data);
                $make_array = (explode('K', $orderid));
                if (count($make_array) > 1) {
                    $offerPayment = new OfferController();
                    return $offerPayment->offerPrizeSelect();
                }
                $paymentController = new PaymentController();
                //redirect payment success method
                return $paymentController->paymentSuccess();
            } else {
                Toastr::error('Payment failed');
                $payment_data = Session::get('payment_data');
                if ($payment_data) {
                    $make_array = (explode('K', $payment_data['order_id']));
                    if(count($make_array)>1){
                        if(Session::has('redirectLink')){
                            return redirect(Session::get('redirectLink'));
                        }
                        return Redirect::route('offers');
                    }
                    return Redirect::route('order.paymentGateway', $payment_data['order_id']);
                }
                return redirect('/');
            }
        }catch (\Mockery\Exception $exception) {
            Toastr::error('Payment failed');
            return redirect('/');
        }
    }

}
