<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HelperController;
use App\Models\Area;
use App\Models\Cart;
use App\Models\City;
use App\Models\GeneralSetting;
use App\Models\Offer;
use App\Models\ShippingAddress;
use App\Models\ShippingMethod;
use App\Models\State;
use App\Traits\CreateSlug;
use App\Traits\Sms;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    use Sms;
    use CreateSlug;
    public function __construct()
    {
        //get deactive & expired offer
        $getOffer =  Offer::where('end_date', '<', Carbon::now()->addMinute(10))
            ->orWhere('status', '!=', 1)
            ->pluck('id');
        if ($getOffer) {
            //delete cart data by offer id
            $delete = Cart::whereIn('offer_id', $getOffer)->delete();
            if ($delete) {
                Toastr::error('Some cart item deleted because offer expired.');
            }
        }
    }
    //order checkout
    public function checkout(Request $request)
    {

        $user_id = 0;
        if (Auth::check()) {
            $user_id = Auth::id();
        } else {
            $user_id = (Cookie::has('user_id') ? Cookie::get('user_id') :  Session::get('user_id'));
        }
        $data = [];
        $cartItems = Cart::with('get_product:id,selling_price,shipping_cost,discount,discount_type')->where('user_id', $user_id);
        //if click direct checkout button forget product id
        if (isset($request->process)) {
            Cart::join('products', 'carts.product_id', 'products.id')->where('products.voucher', 1)->delete();
            Cookie::queue(Cookie::forget('direct_checkout_product_id'));
            Session::forget('direct_checkout_product_id');
        }
        //check direct checkout
        if (Cookie::has('direct_checkout_product_id') || Session::get('direct_checkout_product_id')) {
            $direct_checkout_product_id = (Cookie::has('direct_checkout_product_id') ? Cookie::get('direct_checkout_product_id') :  Session::get('direct_checkout_product_id'));
            $cartItems = $cartItems->where('product_id', $direct_checkout_product_id);
        }
        $data['cartItems'] =  $cartItems->orderBy('id', 'desc')->get();

        if (count($data['cartItems']) > 0) {
            $data['states'] = State::where('country_id', config('siteSetting.country'))->where('status', 1)->get();
            $data['get_shipping'] = ShippingAddress::with(['get_state', 'get_city', 'get_area'])->where('user_id', $user_id)->get();

            if (count($data['get_shipping']) > 0) {
                return redirect()->route('shippingReview');
            }

            if (Auth::guard('reseller')->check()) {
                return view('reseller.checkout')->with($data);
            } else {

                return view('frontend.checkout.checkout')->with($data);
            }
        } else {
            Toastr::error("Your shopping cart is empty. You don\'t have any product to checkout.");
            return redirect('/');
        }
    }


    public function reseller_checkout(Request $request)
    {
        echo "ok";
        exit;
    }



    // get city by state
    public function get_city(Request $request, $region_id)
    {
        $user_id = 0;
        if (Auth::check()) {
            $user_id = Auth::id();
        } else {
            $user_id = (Cookie::has('user_id') ? Cookie::get('user_id') :  Session::get('user_id'));
        }
        $data = [];

        $cartItems = Cart::with('get_product:id,selling_price,discount,discount_type,shipping_method,ship_region_id,shipping_cost,other_region_cost')
            ->where('user_id', $user_id);
        //check direct checkout
        if (Cookie::has('direct_checkout_product_id') || Session::get('direct_checkout_product_id')) {
            $direct_checkout_product_id = (Cookie::has('direct_checkout_product_id') ? Cookie::get('direct_checkout_product_id') :  Session::get('direct_checkout_product_id'));
            $cartItems = $cartItems->where('product_id', $direct_checkout_product_id);
        }
        $cartItems =  $cartItems->get();

        if ($region_id == 4){
            //dhaka division
            $cost = 80;
        }else{
            $cost = 120;
        }

        $total_shipping_cost = $total_amount = 0;


        foreach ($cartItems as $item) {
            //calculate_discount price
            $price = $item->price;
            $total_amount += $price * $item->qty;
            //calculate shipping cost
            if (config('siteSetting.shipping_method') == 'product_wise_shipping') {

                $productWeight = $item->get_product->weight;
                if ($productWeight > 1){
                    $actualWeight = 1;
                }else{
                    $actualWeight = ceil($productWeight);
                }
                $netWeight= $item->qty * $actualWeight;
                Toastr::error($netWeight);


                $shipping_cost = $item->get_product->shipping_cost;
                //check shipping method
                if ($item->get_product->shipping_method == 'location') {
                    if ($item->get_product->ship_region_id != $region_id) {
                        $shipping_cost = $item->get_product->other_region_cost;
                    }
                }
            } else {
                $shipping_cost =  \App\Http\Controllers\HelperController::shippingCharge($region_id);
            }
            //check calculate type
            if (config('siteSetting.shipping_calculate') == 'per_product') {
                $total_shipping_cost +=  $shipping_cost;
            }elseif (config('siteSetting.shipping_calculate') == 'weight_based'){
                $total_shipping_cost+= $netWeight * $cost;
                Toastr::error("weight based");
            }
            else {
                if ($shipping_cost > $total_shipping_cost) {
                    $total_shipping_cost = $shipping_cost;
                }
            }
        }
        //put shipping region id
        Session::put('ship_region_id', $region_id);
        $cities = City::where('state_id', $region_id)->where('status', 1)->get();
        $output = $allcity = '';
        if (count($cities) > 0) {
            $allcity .= '<option value="">Select city</option>';
            foreach ($cities as $city) {
                $allcity .= '<option ' . (old("city") == $city->id ? "selected" : "") . ' value="' . $city->id . '">' . $city->name . '</option>';
            }
        }
        $coupon_discount = (Session::get('couponType') == '%' ? $total_amount * Session::get('couponAmount') : Session::get('couponAmount'));
        $grandTotal = ($total_amount + $total_shipping_cost) - $coupon_discount;
        $output = array('status' => true, 'shipping_cost' => $total_shipping_cost, 'couponAmount' => $coupon_discount, 'grandTotal' => $grandTotal, 'allcity'  => $allcity);
        return response()->json($output);
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
                'mobile' => 'required|min:11|numeric|regex:/(01)[0-9]/' . ($request->account == 'register') ? '|unique:users' : '',
                //'region' => 'required',
                //'city' => 'required',
                'address' => 'required',
            ]);

            $username = $this->createSlug('users', $request->name, 'username');
            $username = trim($username, '-');
            $password = ($request['password']) ? $request['password'] : rand(100000, 999999);
            $user = new User;
            $user->name = $request->name;
            $user->username = $username;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->region = $request->region;
            //$user->city = $request->city;
            //$user->area = $request->area;
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

    //shipping review & choose one addresss
    public function shippingReview()
    {
        $user_id = 0;
        if (Auth::check()) {
            $user_id = Auth::id();
        } else {
            $user_id = (Cookie::has('user_id') ? Cookie::get('user_id') :  Session::get('user_id'));
        }
        $data = [];
        $cartItems = Cart::with('get_product:id,selling_price,shipping_cost,discount,discount_type')->where('user_id', $user_id);
        //check direct checkout
        if (Cookie::has('direct_checkout_product_id') || Session::get('direct_checkout_product_id')) {
            $direct_checkout_product_id = (Cookie::has('direct_checkout_product_id') ? Cookie::get('direct_checkout_product_id') :  Session::get('direct_checkout_product_id'));
            $cartItems = $cartItems->where('product_id', $direct_checkout_product_id);
        }
        $data['cartItems'] =  $cartItems->orderBy('id', 'desc')->get();

        if (count($data['cartItems']) > 0) {
            $data['states'] = State::where('country_id', config('siteSetting.country'))->where('status', 1)->get();
            $data['get_shipping'] = ShippingAddress::with(['get_state', 'get_city', 'get_area'])->where('user_id', $user_id)->get();

            if (count($data['get_shipping']) > 0) {
                $data['shipping_methods'] = ShippingMethod::where('status', 1)->orderBy('position', 'asc')->selectRaw('id, name, logo, duration')->get();
                return view('frontend.checkout.shipping_review')->with($data);
            } else {
                return back();
            }
        } else {
            Toastr::error("Your shopping cart is empty. You don\'t have any product to checkout.");
            return redirect('/');
        }
    }

    // get shipping address by shipping id
    public function getShippingAddress($shipping_id)
    {

        $get_shipping = ShippingAddress::with(['get_state', 'get_city', 'get_area'])->where('user_id', Auth::id())->where('id', $shipping_id)->first();
        if ($get_shipping) {
            $area = ($get_shipping->get_area) ? $get_shipping->get_area->name . ',' : null;
            //get shipping details by region id
            $shipping_address =  '
                <div class="form-group" > <strong><i class="fa fa-user"></i></strong> ' . $get_shipping->name . ' </div>
                <div class="form-group" >  <strong><i class="fa fa-envelope"></i></strong> ' . $get_shipping->email . ' </div>
                <div class="form-group" > <strong><i class="fa fa-phone"></i></strong> ' . $get_shipping->phone . ' </div>
                <div class="form-group" > <strong><i class="fa fa-map-marker"></i></strong> ' .
                $get_shipping->address . ', ' .
                $area .
                $get_shipping->get_city->name . ', ' .
                $get_shipping->get_state->name .
                '</div>';
            $user_id = 0;
            if (Auth::check()) {
                $user_id = Auth::id();
            } else {
                $user_id = (Cookie::has('user_id') ? Cookie::get('user_id') :  Session::get('user_id'));
            }
            $cartItems = Cart::with('get_product')->where('user_id', $user_id);
            //check direct checkout
            if (Cookie::has('direct_checkout_product_id') || Session::get('direct_checkout_product_id')) {
                $direct_checkout_product_id = (Cookie::has('direct_checkout_product_id') ? Cookie::get('direct_checkout_product_id') :  Session::get('direct_checkout_product_id'));
                $cartItems = $cartItems->where('product_id', $direct_checkout_product_id);
            }
            $cartItems = $cartItems->get();

            $total_shipping_cost = $total_amount = 0;$totalWeight=0;
            foreach ($cartItems as $item) {
                $price = $item->price;
                $total_amount += $price * $item->qty;
                //calculate shipping cost
                if (config('siteSetting.shipping_method') == 'product_wise_shipping') {
                    $shipping_cost = $item->get_product->shipping_cost;
                    //check shipping method
                    if ($item->get_product->shipping_method == 'location') {
                        if ($item->get_product->ship_region_id != $get_shipping->region) {
                            $shipping_cost = $item->get_product->other_region_cost;
                        }
                    }
                } else {
                    $shipping_cost =  \App\Http\Controllers\HelperController::shippingCharge($get_shipping->region);
                }
                //check calculate type
                if (config('siteSetting.shipping_calculate') == 'per_product') {
                    $total_shipping_cost +=  $shipping_cost;
                }

                elseif (config('siteSetting.shipping_calculate') == 'weight_based'){


                    $itemWeight = $item->get_product->weight;
                    if ($itemWeight==0 || $itemWeight <0){
                        $totalWeight+=1 * $item->qty;
                    }else{
                        $totalWeight+=$itemWeight * $item->qty;
                    }


                    $check = \App\Http\Controllers\HelperController::dhakaCityCheck($get_shipping->region);
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


                }else {
                    if ($shipping_cost > $total_shipping_cost) {
                        $total_shipping_cost = $shipping_cost;
                    }
                }
            }
            //put shipping region id
            Session::put('ship_region_id', $get_shipping->region);
            //calculate coupon discount
            $coupon_discount = round(Session::get('couponType') == '%' ? $total_amount * Session::get('couponAmount') : Session::get('couponAmount'), 2);
            $grandTotal = round(($total_amount + $total_shipping_cost) - $coupon_discount);
            $output = array('status' => true, 'shipping_address' => $shipping_address, 'shipping_cost' => $total_shipping_cost, 'couponAmount' => $coupon_discount, 'grandTotal' => $grandTotal);
        } else {
            $output = array('status' => false);
        }
        return response()->json($output);
    }
}
