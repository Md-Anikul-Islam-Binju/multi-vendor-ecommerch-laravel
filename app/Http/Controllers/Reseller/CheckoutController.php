<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\NagadPaymentController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\ShurjopayController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripeController;
use App\Models\Coupon;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentGateway;
use App\Models\Reseller;
use App\Models\ResellerCustomer;
use App\Models\ReturnRequest;
use App\Models\SiteSetting;
use App\Traits\CreateSlug;
use App\Traits\Sms;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\User;
use App\Models\Cart;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class CheckoutController extends Controller
{


    use CreateSlug;
    use Sms;
    public function orderHistory()
    {

        $orders = Order::with(['order_details.product:id,title,slug,feature_image', 'orderNotify' => function($query){
            $query->orderBy('id', 'DESC');
        }])->whereNull('is_voucher')
            ->where('user_id', Auth::guard('reseller')->id())
        ->where('user_type', 2);

        $data['orders'] = $orders->orderBy('id', 'desc')->get();

        return view('reseller.order-history')->with($data);
    }

    public function orderReturn(Order $order)
    {

        return view('reseller.returnReson', compact('order'));
    }

    public function orderReturnStore(Request $request, Order $order): RedirectResponse
    {
        $attributes = $request->validate(['order_id' => 'required', 'product' => 'required', 'reason' => 'nullable']);
        $attributes['products']=implode( ',', $request->input('product'));
        if (ReturnRequest::create($attributes)){
            Toastr::success("success");
        }
        else{
            Toastr::error("failed");
        }
        return back();
    }

    //show order details by order id
    public function orderDetails($orderId){
        $order = Order::with(['order_details.product:id,title,slug,feature_image,product_type,file,file_link','get_country', 'get_state', 'get_city', 'get_area'])
            ->where('user_id', Auth::guard('reseller')->id())
            ->where('user_type', 2)
            ->where('order_id', $orderId)->first();
        if($order){
            $refund = SiteSetting::where('type', 'refund_request')->where('status', 1)->first();
            return view('reseller.order-details')->with(compact('order', 'refund'));
        }
        return abort(404);
    }

    public function orderConfirm(Request $request, ResellerCustomer $resellerCustomer)
    {

        //$shipping_address = ShippingAddress::with(['get_country','get_state','get_city', 'get_area'])->find($request->confirm_shipping_address);
        if($resellerCustomer->id > 0) {

            $user_id = 0;
            if (Auth::check()) {
                $user_id = Auth::id();
            } else {
                $user_id = (Cookie::has('user_id') ? Cookie::get('user_id') :  Session::get('user_id'));
            }

            //get cart items
            $cartItems = Cart::where('user_id', $user_id)->groupBy('product_id')->orderBy('id', 'asc');
            //check direct checkout product
            if(Cookie::has('direct_checkout_product_id') || Session::get('direct_checkout_product_id')){
                $direct_checkout_product_id = (Cookie::has('direct_checkout_product_id') ? Cookie::get('direct_checkout_product_id') :  Session::get('direct_checkout_product_id'));
                $cartItems = $cartItems->where('product_id', $direct_checkout_product_id);
            }
            $cartItems = $cartItems->get();
            if(!count($cartItems)>0) {
                return redirect()->back();
            }
            //get offer prefix id
            $prefix = null;
            $offer_id = $cartItems->pluck('offer_id')->toArray();
            $offer_id = array_values(array_filter($offer_id));
            if($offer_id){
                $offer = Offer::where('id', $offer_id[0])->select('prefix_id')->first();
                if($offer){
                    $prefix = $offer->prefix_id;
                }
            }
            $prefix = ($prefix) ? $prefix : 'R';
            $prefix = $prefix.$user_id;
            $order_id = $this->uniqueOrderId('orders', 'order_id', $prefix);

            $total_qty = array_sum(array_column($cartItems->toArray(), 'qty'));
            //old price
            $total_price = array_sum(array_column($cartItems->toArray(), 'price'));
            $coupon_discount = null;
            if (Session::has('couponAmount')) {
                $coupon = Coupon::where('coupon_code', Session::get('couponCode'))->first();
                if( $coupon && $coupon->times != null)
                {
                    if($coupon->times > 0)
                    {
                        $coupon_discount = (Session::get('couponType') == '%') ? round($total_price * Session::get('couponAmount'), 2) : Session::get('couponAmount');
                        $coupon->decrement('times', 1);
                    }
                }
            }

            //insert order in order table
            $order = new Order();
            $order->order_id = $order_id;
            $order->user_id = Auth::guard('reseller')->id();
            $order->user_type = 2;
            $order->customer_total_price = array_sum(array_column($cartItems->toArray(), 'custom_price'));

            $order->total_qty = $total_qty;
            $order->total_price = $total_price;
            $order->coupon_code = ($coupon_discount ? Session::get('couponCode') : null);
            $order->coupon_discount = $coupon_discount;
            $order->shipping_method_id = ($request->shipping_method) ? $request->shipping_method : null;

            //return Auth::guard('reseller')->user();
            $order->billing_name = $resellerCustomer->name;
            $order->billing_phone = $resellerCustomer->mobile;
            $order->billing_email = $resellerCustomer->email;
            $order->billing_country = "Bangladesh";
            $order->billing_region = $resellerCustomer->get_state->name;
            $order->billing_city = $resellerCustomer->get_city->name;
            $order->billing_area = $resellerCustomer->get_area->name;
            $order->billing_address = $resellerCustomer->address;


            $order->shipping_name = $resellerCustomer->name;
            $order->shipping_phone = $resellerCustomer->mobile;
            $order->shipping_email = $resellerCustomer->email;
            $order->shipping_country = 'Bangladesh';
            $order->shipping_region = $resellerCustomer->get_state->name;
            $order->shipping_city = $resellerCustomer->get_city->name;
            $order->shipping_area = $resellerCustomer->get_area->name;
            $order->shipping_address = $resellerCustomer->address;
            $order->order_notes = $request->order_notes;
            $order->currency = Config::get('siteSetting.currency');
            $order->currency_sign = Config::get('siteSetting.currency_symble');
            $order->currency_value = Config::get('siteSetting.currency_symble');
            $order->order_date = now();
            $order->payment_status = 'pending';
            $order->order_status = 'pending';
            $order = $order->save();
            if ($order) {
                // insert product details in table
                $total_shipping_cost = $total_price = 0;$totalCustomerPrice = 0;
                $totalWeight = 0;
                foreach ($cartItems as $item) {
                    $price =  $item->price;

                    $total_price += $price*$item->qty;
                    $totalCustomerPrice += $item->custom_price * $item->qty;
                    //calculate shipping cost
                    if(config('siteSetting.shipping_method') == 'product_wise_shipping'){
                        $shipping_cost = $item->get_product->shipping_cost;
                        //check product_wise_shipping shipping method type
                        if($item->get_product->shipping_method == 'location'){
                            if ($item->get_product->ship_region_id != $resellerCustomer->region) {
                                $shipping_cost = $item->get_product->other_region_cost;
                            }
                        }
                    }else{
                        //other shipping method
                        $shipping_cost =  HelperController::shippingCharge($resellerCustomer->region);
                    }
                    //check shipping calculate type
                    if(config('siteSetting.shipping_calculate') == 'per_product'){
                        $total_shipping_cost +=  $shipping_cost;
                    }elseif (config('siteSetting.shipping_calculate') == 'weight_based'){

                        $itemWeight = $item->get_product->weight;
                        if ($itemWeight==0 || $itemWeight <0){
                            $totalWeight+=1 * $item->qty;
                        }else{
                            $totalWeight+=$itemWeight * $item->qty;
                        }

                        //var_dump($total_shipping_cost);
                    }
                    else{
                        if($shipping_cost > $total_shipping_cost) {
                            $total_shipping_cost = $shipping_cost;
                        }
                    }
                    $is_voucher = ($item->get_product->voucher == 1) ? 1 : null;
                    $orderDetails = new OrderDetail();
                    $orderDetails->order_id = $order_id;
                    $orderDetails->offer_id = ($item->offer_id) ? $item->offer_id : null;
                    $orderDetails->is_voucher = $is_voucher;
                    $orderDetails->vendor_id = $item->get_product->vendor_id;
                    $orderDetails->user_id = Auth::guard('reseller')->id();
                    $orderDetails->product_id = $item->product_id;
                    $orderDetails->qty = $item->qty;
                    $orderDetails->price = $price;
                    $orderDetails->customer_price =  $item->custom_price;
                    $orderDetails->shipping_charge = $shipping_cost;
                    $orderDetails->coupon_discount = ($coupon_discount ? ($coupon_discount / $total_price) * ($item->price*$item->qty) : null);
                    $orderDetails->attributes = $item->attributes;
                    $orderDetails->shipping_status = 'pending';
                    $orderDetails->save();
                    //make array offer id
                    $offer_id[] = $item->offer_id;
                    //make array cart id for cart item delete
                    $cart_id[] = $item->id;
                }







                $check = HelperController::dhakaCityCheck($resellerCustomer->region);
                Toastr::warning("total weight: $totalWeight");
                $roundWeight = ceil($totalWeight);
                if ($check){
                    if ($roundWeight>1){
                        $extra = $roundWeight - 1;
                        $extraCost = $extra * 30;
                        $total_shipping_cost = $extraCost + 80;
                    }else{
                        $total_shipping_cost += 80;
                    }

                }else{
                    if ($roundWeight>1){
                        $extra = $roundWeight - 1;
                        $extraCost = $extra * 30;
                        $total_shipping_cost+= $extraCost + 150;
                    }else{
                        $total_shipping_cost+= 150;
                    }
                }

                // $offer_id = array_values(array_unique(array_filter($offer_id)));
                // $offer_id = (count($offer_id ) > 0) ? json_encode($offer_id) : null;
                $offer_id = $item->offer_id;
                //update order
                Order::where('order_id', $order_id)->update(['total_price' => $total_price, 'customer_total_price' =>$totalCustomerPrice, 'shipping_cost' => $total_shipping_cost, 'offer_id' => $offer_id, 'is_voucher' => $is_voucher ]);
                //delete cart item
                Cart::whereIn('id', $cart_id)->delete();
            }
            Session::put('shipping_city', $resellerCustomer->get_city->id);
            Session::forget('couponCode');
            Session::forget('couponType');
            Session::forget('couponAmount');
            //redirect payment method page for payment
            return redirect()->route('resellerOrder.payment', encrypt($order_id));
        }else{
            Toastr::error('Please select shipping address.');
            return back();
        }
    }

    public function orderPaymentGateway($orderIds)
    {
        try {
            $orderId = Crypt::decrypt($orderIds);
        } catch (DecryptException $e) {
            $orderId = $orderIds;
        }

        $order = Order::with('order_details.product:id,title,slug,feature_image')
            ->where('order_id', $orderId)->first();
        //return var_dump($order);
        if($order){
            $paymentgateways = PaymentGateway::orderBy('position', 'asc')->where('method_for', '!=', 'payment')->where('status', 1)->get();
            return view('reseller.order-payment')->with(compact('order', 'paymentgateways'));
        }
        return abort(404);
    }



    public function paymentSuccess(){

        $payment_data = Session::get('payment_data');
        //clear session payment data
        //Session::forget('payment_data');
        if($payment_data && $payment_data['status'] == 'success') {
            $order = Order::with('order_details')->where('order_id', $payment_data['order_id'])->first();
            if ($order) {
                $user_id = $order->user_id;
                $order->payment_method = $payment_data['payment_method'];
                $order->tnx_id = (isset($payment_data['trnx_id'])) ? $payment_data['trnx_id'] : null;
                $order->order_date = now();
                $order->payment_status = (isset($payment_data['payment_status'])) ? $payment_data['payment_status'] : 'pending';
                $order->payment_info = (isset($payment_data['payment_info'])) ? $payment_data['payment_info'] : null;
                $order->save();
                //when one order multi payment work this
                //minus product stock qty
                foreach ($order->order_details as $order_detail){
                    if($order_detail->qty <= $order_detail->product->stock) {
                        $order_detail->product->decrement('stock', $order_detail->qty);
                    }
                }
                //send mobile notify
                $customer_mobile = ($order->billing_phone) ? $order->billing_phone : $order->shipping_phone;
                $msg = 'Dear customer, Your order has been successfully placed on ' . $_SERVER['SERVER_NAME'];
                $this->sendSms($customer_mobile, $msg);

                // $admin_mobile = Config::get('siteSetting.phone');
                // $admin_msg = 'You have received a new order on '.$_SERVER['SERVER_NAME'].'. Order details '.route('orderTracking').'?order_id='.$order->order_id;
                // $this->sendSms($admin_mobile, $admin_msg);
                //insert notification in database
                Notification::create([
                    'type' => 'order',
                    'fromUser' => Auth::id(),
                    'toUser' => null,
                    'item_id' => $payment_data['order_id'],
                    'notify' => 'Placed order',
                ]);
                return redirect()->route('reseller.paymentConfirm', $payment_data['order_id']);
            }
        }
        return redirect()->route('reseller.orderHistory');
    }

    public function paymentConfirm($orderId){
        $order = Order::with(['order_details.product:id,title,slug,feature_image','get_area','get_city','get_state'])
            ->where('order_id', $orderId)->first()->toArray();

        //send notification in email
        //Mail::to(Auth::user()->email)->send(new OrderMail($order));
        Toastr::success('Thanks Your order submitted successfully');
        return view('reseller.payemnt-confirmation')->with(compact('order'));
    }



    public function orderPayment(Request $request, $orderId){


        if (Auth::check()) {
            $user_id = Auth::id();

        } else {
            $user_id = (Cookie::has('user_id') ? Cookie::get('user_id') :  Session::get('user_id'));

        }



        $order = Order::with('order_details.product:id,title')->where('order_id', $orderId)->first();

        if($order){
            $total_price = $order->total_price + $order->shipping_cost - $order->coupon_discount;
            $data = [
                'order_id' => $order->order_id,
                'total_price' => $total_price,
                'total_qty' => $order->total_qty,
                'currency' => $order->currency,
                'payment_method' => $request->payment_method
            ];
            Session::put('payment_data', $data);
        }else{
            Toastr::error('Payment failed.');
            return redirect()->back();
        }

        if($request->payment_method == 'cash-on-delivery'){
            Session::put('payment_data.status', 'success');
            //redirect payment success method
            return $this->paymentSuccess();
        }elseif($request->payment_method == 'wallet-balance'){

            if (Auth::guard('reseller')->check())
                if(Auth::guard('reseller')->user()->wallet_balance >= $total_price) {

                    //minuse wallet balance;
                    //$user = User::find($order->user_id);
                    $user = Reseller::find($order->user_id);
                    $user->wallet_balance = $user->wallet_balance - $total_price;
                    $user->save();

                    Session::put('payment_data.status', 'success');
                    Session::put('payment_data.payment_status', 'paid');
                    //redirect payment success method
                    return $this->paymentSuccess();


                }else{
                    Toastr::error('Insufficient wallet balance.');
                    return redirect()->back();
                }
            else{
                if(Auth::user()->wallet_balance >= $total_price) {

                    //minuse wallet balance;
                    //$user = User::find($order->user_id);
                    $user = User::find($order->user_id);
                    $user->wallet_balance = $user->wallet_balance - $total_price;
                    $user->save();

                    Session::put('payment_data.status', 'success');
                    Session::put('payment_data.payment_status', 'paid');
                    //redirect payment success method
                    return $this->paymentSuccess();


                }else{
                    Toastr::error('Insufficient wallet balance.');
                    return redirect()->back();
                }
            }
        }elseif($request->payment_method == 'reward-points'){
            $reward_points = (Auth::user()->reward_points > 0 ) ? Auth::user()->reward_points/2 : 0.00;
            if($reward_points >= $total_price) {
                //minuse reward points balance;
                //$user = User::find($order->user_id);
                $user = Reseller::find($order->user_id);
                $user->reward_points = $user->reward_points - $total_price;
                $user->save();

                Session::put('payment_data.status', 'success');
                Session::put('payment_data.payment_status', 'paid');
                //redirect payment success method
                return $this->paymentSuccess();
            }else{
                Toastr::error('Insufficient wallet balance.');
                return redirect()->back();
            }
        }
        elseif($request->payment_method == 'sslcommerz'){
            //redirect SslCommerzPaymentController for payment process
            $sslcommerz = new SslCommerzPaymentController;
            return $sslcommerz->sslCommerzPayment();
        }elseif($request->payment_method == 'nagad'){
            //redirect PaypalController for payment process
            $nagad = new NagadPaymentController;
            return $nagad->nagadPayment();
        }elseif($request->payment_method == 'shurjopay'){
            //redirect shurjopayController for payment process
            $shurjopay = new ShurjopayController();
            return $shurjopay->shurjopayPayment();
        }elseif($request->payment_method == 'paypal'){
            //redirect PaypalController for payment process
            $paypal = new PaypalController;
            return $paypal->paypalPayment();
        }
        elseif($request->payment_method == 'masterCard'){
            //redirect StripeController for payment process
            Session::put('payment_data.stripeToken', $request->stripeToken);
            $stripe = new StripeController();
            return $stripe->masterCardPayment();
        }
        elseif($request->payment_method == 'manual'){
            $trnx_id = ($request->manual_method_name == 'cash') ? 'cash'.rand(000, 999) : $request->trnx_id;
            $checkTrnx = Order::where('tnx_id', $trnx_id)->first();
            if(!$checkTrnx){
                Session::put('payment_data.payment_method', $request->manual_method_name);
                Session::put('payment_data.status', 'success');
                Session::put('payment_data.trnx_id', $request->trnx_id);
                Session::put('payment_data.payment_info', $request->payment_info);
                //redirect payment success method
                return $this->paymentSuccess();
            }else{
                Toastr::error('This transaction is invalid.');
                return redirect()->back()->withInput()->with('error', 'This transaction is invalid.');
            }
        }else{
            Toastr::error('Please select payment method');
        }
        return back();
    }




    //registration user
    public function ShippingRegister(Request $request)
    {

        if (!Auth::check()) {
            $gs = GeneralSetting::first();
            if ($gs->registration == 0) {
                Session::flash('alert', 'Registration is closed by Admin');
                Toastr::error('Registration is closed by Admin');
                return back();
            }

            $request->validate([
                'name' => 'required',
                'mobile' => 'required|min:11|numeric|regex:/(01)[0-9]/' . ($request->account == 'register') ? '|unique:resellers' : '',
                'region' => 'required',
                'city' => 'required',
                'address' => 'required',
            ]);

            $username = $this->createSlug('resellers', $request->name, 'username');
            $username = trim($username, '-');
            $password = ($request['password']) ? $request['password'] : rand(100000, 999999);


            $user = new User;
            $user->name = $request->name;
            $user->username = $username;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->region = $request->region;
            $user->city = $request->city;
            $user->area = $request->area;
            $user->address = $request->address;
            $user->password = Hash::make($password);
            $user->email_verification_token = $gs->email_verification == 1 ? rand(1000, 9999) : NULL;
            $user->mobile_verification_token = $gs->sms_verification == 1 ? rand(1000, 9999) : NULL;
            $new_user = $user->save();
            if ($new_user) {
                $user_id = (Cookie::has('user_id') ? Cookie::get('user_id') :  Session::get('user_id'));
                Auth::attempt(['username' => $username, 'password' => $password,]);
                //send mobile notify
                if (Auth::user()->mobile) {
                    $customer_mobile = Auth::user()->mobile;
                    $msg = 'Hello ' . Auth::user()->name . ', Thank you for registering with ' . $_SERVER['SERVER_NAME'] . '.';
                    $this->sendSms($customer_mobile, $msg);
                }
                Cart::where('user_id', $user_id)->update(['user_id' => Auth::id()]);
                //check duplicate records
                $duplicateRecords = Cart::select('product_id')
                    ->where('user_id', Auth::id())
                    ->selectRaw('id, count("product_id") as occurences')
                    ->groupBy('product_id')
                    ->having('occurences', '>', 1)
                    ->get();
                //delete duplicate record
                foreach ($duplicateRecords as $record) {
                    $record->where('id', $record->id)->delete();
                }
            }
        }

        //if shipping_billing is checked then check validation
        if (!$request->shipping_address) {
            $request->validate([
                'shipping_name' => 'required',
                'shipping_phone' => 'required',
                'shipping_region' => 'required',
                'shipping_city' => 'required',
                'ship_address' => 'required',
            ]);
        }

        $shipping = new ShippingAddress();
        $shipping->user_id = Auth::id();
        $shipping->address_name = ($request->address_name) ? $request->address_name : $request->address_name;
        $shipping->name = ($request->shipping_name) ? $request->shipping_name : $request->name;
        $shipping->email = ($request->shipping_email) ? $request->shipping_email : $request->email;
        $shipping->phone = ($request->shipping_phone) ? $request->shipping_phone : $request->mobile;
        $shipping->region = ($request->shipping_region) ? $request->shipping_region : $request->region;
        $shipping->city = ($request->shipping_city) ? $request->shipping_city : $request->city;
        $shipping->area = ($request->shipping_area) ? $request->shipping_area : $request->area;
        $shipping->address = ($request->ship_address) ? $request->ship_address : $request->address;
        $store = $shipping->save();

        if ($store) {
            Toastr::success('Shipping address added successful.');
        } else {
            Toastr::error("Shipping address cann\'t added.");
        }
        return redirect()->back();
    }
}
