<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Offer;
use App\Models\Product;
use App\Models\ProductVariationDetails;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function cartAdd(Request $request)
    {
        $product = Product::find($request->product_id);
        if($product->voucher == 1){
            $output = array(
                'status' => 'error',
                'msg' => 'Vouchers cannot be added to the cart.'
            );
            return response()->json($output);
        }
        $qty = 1;

        /*if(Auth::guard('reseller')->check())
        {
            $selling_price = $product->reseller_price;
        }else{

            $selling_price = $product->selling_price;
        }*/
        $user_id = rand(1000000000, 9999999999);
        if(Auth::check()){
            $user_id = Auth::id();
        }else{
            if(Cookie::has('user_id') || Session::get('user_id')){
                $user_id = (Cookie::has('user_id') ? Cookie::get('user_id') :  Session::get('user_id'));
            }else{
                Session::put('user_id', $user_id );
                Cookie::queue('user_id', $user_id, time() + (86400));
            }
        }


        $cart_user = Cart::where('product_id', $product->id)->where('user_id', $user_id)->first();
        if($cart_user  && !$request->quantity){
            $qty = $cart_user->qty + 1;
        }else{
            $qty = ($request->quantity) ? $request->quantity : 1;
        }
        //check quantity
        if($qty > $product->stock) {
            $output = array(
                'status' => 'error',
                'msg' => 'Out of stock'
            );
            return $output;
        }

        $attributes = $request->except(['product_id', '_token', 'offer', 'quantity', 'buyDirect']);
        $variations = ProductVariationDetails::where('product_id', $request->product_id)->whereIn('attributeValue_name', array_values($attributes))->get();
        if(count($variations)>0){
            $variation_price = 0;
            foreach ($variations as $variation){
                if($variation->price > $variation_price){
                    $variation_price = $variation->price;
                }
            }
            //product variation price
            $selling_price = $variation_price;
        }
        //override variation price
        if(Auth::guard('reseller')->check())
        {
            $selling_price =  $product->reseller_price ;
        }else{
            $selling_price =  $product->selling_price ;
        }
        $attributes = json_encode($attributes);
        $discount = $calculate_discount = $offer_id = null;
        $getOffer =  Offer::join('offer_products', 'offers.id', 'offer_products.offer_id')->join('products', 'offer_products.product_id','products.id')
            ->where('offers.slug', $request->offer)
            ->where('offer_products.product_id', $product->id)
            ->where('offers.start_date', '<=',  Carbon::now())->where('offers.end_date', '>=', Carbon::now())->where('offers.status', '=', 1)->where('offers.offer_type', '!=', 'kanamachi')
            ->selectRaw('offer_products.offer_id, offer_products.offer_discount, offer_products.discount_type')->first();
        if($getOffer){
            $offer_id = $getOffer->offer_id;
            $discount = $getOffer->offer_discount;
            $discount_type = $getOffer->discount_type;
        }else{
            $discount = $product->discount;
            $discount_type = $product->discount_type;
        }
        $price = $selling_price;
        if($discount){
            $calculate_discount = HelperController::calculate_discount($selling_price, $discount, $discount_type );
            $price = $calculate_discount['price'];
        }

        if($cart_user){
            $data = ['qty' => (isset($request->quantity)) ? $request->quantity : $cart_user->qty+1, 'price' => $price];
            //check attributes set or not
            if($request->quantity){
                $data = array_merge(['attributes' => $attributes], $data);
            }
            $cart_user->update($data);
        }else{

            //$resellerPrice = Auth::guard('reseller')->check()?($product->reseller_price?$product->reseller_price:$product->selling_price):0;

            $data = [
                'user_id' => $user_id,
                'offer_id' => $offer_id,
                'product_id' => $request->product_id,
                'title' => $product->title,
                'slug' => $product->slug,
                'image' => $product->feature_image,
                'qty' => (isset($request->quantity)) ? $request->quantity : 1,
                'price' => (Auth::guard('reseller')->check()?$product->reseller_price:$price),
                'custom_price' => (Auth::guard('reseller')->check()?($product->reseller_price>1?$product->reseller_price:$product->selling_price):$price),
                'attributes' => $attributes,
            ];
            Cart::create($data);
        }

        $output = array(
            'status' => 'success',
            'title' => $product->title,
            'image' => $product->feature_image,
            'msg' => 'Product Added To Cart.'
        );
        return response()->json($output);
    }

    public function cartView()
    {

        Cookie::queue(Cookie::forget('direct_checkout_product_id'));
        Session::forget('direct_checkout_product_id');
        $user_id = 0;
        if(Auth::check()){
            $user_id = Auth::id();
        }else{
            $user_id = (Cookie::has('user_id') ? Cookie::get('user_id') :  Session::get('user_id'));
        }
        //get deactive & expired offer
        $getOffer =  Offer::where('end_date', '<', Carbon::now()->addMinute(10))
            ->orWhere('status', '!=', 1)
            ->pluck('id');
        $msg = null;
        if($getOffer){
            //delete cart data by offer id
            $delete = Cart::whereIn('offer_id', $getOffer)->delete();
            if($delete){
                $msg = 'Some cart item deleted because offer expired.';
                Toastr::error($msg);
            }
        }
        //delete voucher product from cart table
        Cart::join('products', 'carts.product_id', 'products.id')->where('products.voucher', 1)->delete();
        $cartItems = Cart::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        return view('frontend.carts.cart')->with(['cartItems' => $cartItems, 'error' => $msg]);
    }

    public function cartUpdate(Request $request)
    {
        $request->validate([
            'qty' => 'required:numeric|min:1'
        ]);

        if(Auth::check()){
            $user_id = Auth::id();
        }else{
            $user_id = (Cookie::has('user_id') ? Cookie::get('user_id') :  Session::get('user_id'));
        }
        $cart = Cart::with('get_product')->where('id', $request->id)->where('user_id', $user_id)->first();

        if($request->qty <= $cart->get_product->stock) {

            $cart->update(['qty' => $request->qty, 'custom_price' => $request->input('customerPrice')]);
            $cartItems = Cart::with('get_product:id,selling_price,shipping_cost,discount,discount_type')->where('user_id', $user_id);
            //check direct checkout
            if(Cookie::has('direct_checkout_product_id') || Session::has('direct_checkout_product_id')){
                $direct_checkout_product_id = (Cookie::has('direct_checkout_product_id') ? Cookie::get('direct_checkout_product_id') :  Session::get('direct_checkout_product_id'));
                $cartItems = $cartItems->where('product_id', $direct_checkout_product_id);
            }
            $cartItems = $cartItems->orderBy('id', 'desc')->get();

            if (Auth::guard('reseller')->check())
            {
                if($request->page == 'checkout'){
                    return view('frontend.checkout.order_summery')->with(compact('cartItems'));
                }else if ($request->page == 'cart_summary')
                {
                    return view('frontend.carts.cart_summary')->with(compact('cartItems'));
                }
                else{
                    return view('reseller.order_summery')->with(compact('cartItems'));
                }


            }else{
                if($request->page == 'checkout'){
                    return view('frontend.checkout.order_summery')->with(compact('cartItems'));
                }else{
                    return view('frontend.carts.cart_summary')->with(compact('cartItems'));
                }
            }



        }else{
            return response()->json(['status' => 'error', 'msg' => 'Out of stock']);
        }
    }

    public function itemRemove(Request $request, $id)
    {
        $user_id = 0;
        if(Auth::check()){
            $user_id = Auth::id();
        }else{
            $user_id = (Cookie::has('user_id') ? Cookie::get('user_id') :  Session::get('user_id'));
        }

        $cartItems = Cart::where('user_id', $user_id)->where('id', $id)->delete();
        if($cartItems){
            $cartItems = Cart::with('get_product')->where('user_id', $user_id)->get();
            if($request->page == 'checkout'){
                return view('frontend.checkout.order_summery')->with(compact('cartItems'));
            }
            return view('frontend.carts.cart_summary')->with(compact('cartItems'));
        }else{
            $output = array(
                'status' => 'error',
                'msg' => 'Cart item cannot delete.'
            );
        }
        return response()->json($output);
    }

    public function clearCart(){
        $user_id = 0;
        if(Auth::check()){
            $user_id = Auth::id();
        }else{
            $user_id = (Cookie::has('user_id') ? Cookie::get('user_id') :  Session::get('user_id'));
        }
        Cart::where('user_id', $user_id)->delete();
        //destroy coupon
        Session::forget('couponCode');
        Session::forget('couponAmount');
        return redirect()->back();
    }

    // apply coupon code in cart & checkout page
    public function couponApply(Request $request){
        $coupon = Coupon::where('coupon_code', $request->coupon_code)->first();
        //check coupon exist
        if(!$coupon){
            return response()->json(['status' => false, 'msg' => 'This coupon does not exists.']);
        }else{
            if($coupon->status != 1)
            {
                return response()->json(['status' => false, 'msg' => 'This coupon is not active.']);
            }
            if($coupon->times != null)
            {
                if($coupon->times == "0")
                {
                    return response()->json(['status' => false, 'msg' => 'Coupon usage limit has been reached.']);
                }
            }
            $today = Carbon::parse(now())->format('d-m-Y');
            $from = Carbon::parse($coupon->start_date)->format('d-m-Y');
            $to = Carbon::parse($coupon->expired_date)->format('d-m-Y');
            if($today < $from ){ return response()->json(['status' => false, 'msg' => 'This coupon is running from: '.$from]);}
            if( $to < $today ){ return response()->json(['status' => false, 'msg' => 'This coupon is expired.']);}
            $user_id = 0;
            if(Auth::check()){$user_id = Auth::id();
            }else{ $user_id = (Cookie::has('user_id') ? Cookie::get('user_id') :  Session::get('user_id'));}
            $cartItems = Cart::with('get_product:id,selling_price,discount,discount_type,shipping_method,ship_region_id,shipping_cost,other_region_cost')->where('user_id', $user_id);
            //check direct checkout
            if(Cookie::has('direct_checkout_product_id') || Session::get('direct_checkout_product_id')){
                $direct_checkout_product_id = (Cookie::has('direct_checkout_product_id') ? Cookie::get('direct_checkout_product_id') :  Session::get('direct_checkout_product_id'));
                $cartItems = $cartItems->where('product_id', $direct_checkout_product_id);
            }
            $cartItems = $cartItems->get();
            $total_shipping_cost = $total_amount = 0;
            foreach($cartItems as $item) {
                //calculate_discount price
                $price = $item->price;
                $total_amount += $price*$item->qty;
                //calculate shipping cost
                if(config('siteSetting.shipping_method') == 'product_wise_shipping'){
                    $shipping_cost = $item->get_product->shipping_cost;
                    //check shipping method
                    if ($item->get_product->shipping_method == 'location') {
                        if ($item->get_product->ship_region_id != Session::get('ship_region_id')) {
                            $shipping_cost = $item->get_product->other_region_cost;
                        }
                    }
                }else{
                    $shipping_cost =  \App\Http\Controllers\HelperController::shippingCharge(Session::get('ship_region_id'));
                }
                //check calculate type
                if(config('siteSetting.shipping_calculate') == 'per_product'){
                    $total_shipping_cost +=  $shipping_cost;
                }else{
                    if($shipping_cost > $total_shipping_cost) {
                        $total_shipping_cost = $shipping_cost;
                    }
                }
            }
            if($coupon->type == 0)
            {
                $couponAmount = round($total_amount * ($coupon->amount/100), 2);
                Session::put('couponType', '%');
                Session::put('couponAmount', round(($coupon->amount/100),2));
            }else{
                $couponAmount = $coupon->amount;
                Session::put('couponType', 'fixed');
                Session::put('couponAmount', $coupon->amount);
            }

            if(Session::get('couponCode') == $request->coupon_code){
                return response()->json(['status' => false, 'msg' => 'This coupon is already used.']);
            }
            //set coupon code
            Session::put('couponCode', $request->coupon_code);
            $grandTotal = round((($total_amount + $total_shipping_cost) - $couponAmount), 2);
            return response()->json(['status' => true, 'couponAmount' => $couponAmount, 'grandTotal' => $grandTotal, 'msg' => 'Coupon code successfully applied. You are available discount.']);
        }
    }

    public function buyDirect(Request $request)
    {
        $product = Product::selectRaw('id,title,selling_price,reseller_price,discount,discount_type,slug,stock,feature_image')->where('id', $request->product_id)->first();
        $qty = 0;
        $selling_price = $product->selling_price;
        if(Auth::check()){
            $user_id = Auth::id();
        }else{
            if(Cookie::has('user_id') || Session::get('user_id')){
                $user_id = (Cookie::has('user_id') ? Cookie::get('user_id') :  Session::get('user_id'));
            }else{
                $user_id = rand(1000000000, 9999999999);
                Session::put('user_id', $user_id);
                Cookie::queue('user_id', $user_id, time() + (86400));
            }
        }
        $cart_user = Cart::where('product_id', $product->id)->where('user_id', $user_id)->first();
        if($cart_user  && !$request->quantity){
            $qty = 1;
        }else{
            $qty = $request->quantity;
        }
        //check quantity
        if($qty > $product->stock) {
            Toastr::error('Out of stock');
            return redirect()->back();
        }

        $attributes = $request->except(['product_id', '_token', 'offer', 'quantity', 'buyDirect']);
        $variations = ProductVariationDetails::where('product_id', $request->product_id)->whereIn('attributeValue_name', array_values($attributes))->get();
        if(count($variations)>0){
            $variation_price = 0;
            foreach ($variations as $variation){
                if($variation->price > $variation_price){
                    $variation_price = $variation->price;
                }
            }
            $selling_price = $variation_price;
        }
        $attributes = json_encode($attributes);

        $discount = $calculate_discount = $offer_id = null;
        $selling_price =  $product->selling_price ;
        $getOffer =  Offer::join('offer_products', 'offers.id', 'offer_products.offer_id')->join('products', 'offer_products.product_id','products.id')
            ->where('offers.slug', request()->get('offer'))
            ->where('offer_products.product_id', $product->id)
            ->where('offers.start_date', '<=',  Carbon::now())->where('offers.end_date', '>=', Carbon::now())->where('offers.status', '=', 1)->where('offers.offer_type', '!=', 'kanamachi')
            ->selectRaw('offer_products.offer_id, offer_products.offer_discount, offer_products.discount_type')->first();
        //dd($getOffer);
        if($getOffer){
            $offer_id = $getOffer->offer_id;
            $discount = $getOffer->offer_discount;
            $discount_type = $getOffer->discount_type;
        }else{
            $discount = $product->discount;
            $discount_type = $product->discount_type;
        }
        $price = $selling_price;
        if($discount){
            $calculate_discount = HelperController::calculate_discount($selling_price, $discount, $discount_type );
            $price = $calculate_discount['price'];
        }
        if($cart_user){
            $data = ['qty' => (isset($request->quantity)) ? $request->quantity : 1, 'price' => $price];
            //check attributes set or not
            if($request->quantity){
                $data = array_merge(['attributes' => $attributes], $data);
            }
            $cart_user->update($data);
        }else{

            $data = [
                'user_id' => $user_id,
                'offer_id' => $offer_id,
                'product_id' => $request->product_id,
                'title' => $product->title,
                'slug' => $product->slug,
                'image' => $product->feature_image,
                'qty' => (isset($request->quantity)) ? $request->quantity : 1,
                'price' => (Auth::guard('reseller')->check()?$product->reseller_price:$price),
                'custom_price' => (Auth::guard('reseller')->check()?($product->reseller_price>1?$product->reseller_price:$product->selling_price):$price),
                'attributes' => $attributes,
            ];
            $cart_user = Cart::create($data);
        }
        //cookie set & retrieve;
        Cookie::queue('direct_checkout_product_id', $cart_user->product_id, time() + (86400));
        Session::put('direct_checkout_product_id' , $cart_user->product_id);
        return redirect()->route('checkout', 'process-to-buy');
    }


}
