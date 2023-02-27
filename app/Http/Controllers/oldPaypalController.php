<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;


class oldPaypalController extends Controller
{

    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        /** PayPal api context **/
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);

    }

    public function paypalPayment(Request $request, $orderId)
    {

        $order = Order::with('order_details.product:id,title')->where('user_id', Auth::id())->where('order_id', $orderId)->first()->toArray();
        if($order){
            $sub_total = $order['total_price'] - $order['coupon_discount'];
            $total_price = $sub_total + $order['shipping_cost'] ;

        }else{
            Toastr::error('Payment failed.');
            return redirect()->back();
        }
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        foreach ($order['order_details'] as $order_item){

            $item = new Item();
            $item->setName($order_item['product']['title'])
                ->setCurrency($order['currency'])
                ->setQuantity($order_item['qty'])
                ->setPrice($order_item['price']);
            $item_array[] =  $item;
        }
        // set discount
        if($order['coupon_discount']) {
            $discount = new Item();
            $discount->setName('Discount')
                ->setCurrency($order['currency'])
                ->setQuantity(1)
                ->setPrice(-$order['coupon_discount']);
            $item_array[] = $discount;
        }
        $itemList = new ItemList();
        $itemList->setItems($item_array);

        $details = new Details();
        $details->setShipping($order['shipping_cost'])
            ->setTax(0)
            ->setSubtotal($sub_total);

        $amount = new Amount();
        $amount->setCurrency($order['currency'])
            ->setTotal($total_price)
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("#Order Id: ". $order['order_id'])
            ->setInvoiceNumber($order['order_id']);

        $redirectUrls  = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('paypalPaymentSuccess')) /** Specify return URL **/
        ->setCancelUrl(route('paypalPaymentCancel'));

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {

            if (Config::get('app.debug')) {
                Session::put('error', 'Connection timeout');
                return Redirect::route('user.orderHistory');
            } else {
                Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::route('user.orderHistory');
            }
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        Session::put('order_id', $order['order_id']);
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        Session::put('error', 'Unknown error occurred');
        return Redirect::route('user.orderHistory');

    }

    public function paymentSuccess(Request $request)
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');

        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            Toastr::error('Payment failed');
            return Redirect::route('user.orderHistory');
        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            //after payment success update payment status
            $order_id = Session::get('order_id');
            Session::forget('order_id'); // destroy order_id
            Order::where('user_id', Auth::id())->where('order_id', $order_id)->update(['payment_method' => 'payPal', 'payment_status' => 'complete']);

            return redirect()->route('user.orderDetails', $order_id);
        }

        Toastr::error('Payment failed');
        return Redirect::route('user.orderHistory');
    }


}
