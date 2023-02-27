<?php
namespace App\Http\Controllers;

use App\Models\PaymentGateway;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use mysql_xdevapi\Exception;
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
use App\Http\Controllers\User\PaymentController;

class PaypalController extends Controller
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
        $paypal_conf = PaymentGateway::where('method_slug', 'paypal')->select('public_key', 'secret_key', 'method_mode')->first();
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
                $paypal_conf->public_key,
                $paypal_conf->secret_key)
        );

        $settings = array(
            'mode' => $paypal_conf->method_mode,
            'http.ConnectionTimeOut' => 60,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path() . '/logs/paypal.log',
            'log.LogLevel' => 'ERROR'
        );
        $this->_api_context->setConfig($settings);

    }

    public function paypalPayment()
    {
        try {
        $payment_data = Session::get('payment_data');

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $item = new Item();
        $item->setName('Purchase '. $payment_data['total_qty'] .' product from '. Config::get('siteSetting.site_name') )
            ->setCurrency($payment_data['currency'])
            ->setQuantity(1)
            ->setPrice($payment_data['total_price']);

        $itemList = new ItemList();
        $itemList->setItems(array($item));

        $amount = new Amount();
        $amount->setCurrency($payment_data['currency'])
            ->setTotal($payment_data['total_price']);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("#Order Id: ". $payment_data['order_id']);

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
                return Redirect::route('order.paymentGateway', Session::get('payment_data.order_id'));
            } else {
                Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::route('order.paymentGateway', Session::get('payment_data.order_id'));
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
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        Session::put('error', 'Unknown error occurred');
        return Redirect::route('order.paymentGateway', Session::get('payment_data.order_id'));

        }catch (\Exception $exception){
            Toastr::error('Some error occur, sorry for inconvenient');
            return back();
        }
    }

    public function paymentSuccess(Request $request)
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');

        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            Toastr::error('Payment failed');
            return Redirect::route('order.paymentGateway', Session::get('payment_data.order_id'));
        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            //after payment success update payment status
            $trnx_id = Session::get('paypal_payment_id');
            Session::put('payment_data.trnx_id', $trnx_id);
            Session::put('payment_data.payment_status', 'paid');
            Session::put('payment_data.status', 'success');
            $paymentController = new PaymentController();
            //redirect payment success method
            return $paymentController->paymentSuccess();
        }

        Toastr::error('Payment failed');
        return Redirect::route('order.paymentGateway', Session::get('payment_data.order_id'));
    }

    public function paymentCancel(){
        Toastr::error('Payment failed');
        return Redirect::route('order.paymentGateway', Session::get('payment_data.order_id'));
    }


}
