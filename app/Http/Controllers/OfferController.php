<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\City;
use App\Models\HomepageSection;
use App\Models\Offer;
use App\Models\OfferProduct;
use App\Models\OfferType;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Page;
use App\Models\Product;
use App\Models\ShippingAddress;
use App\Models\State;
use App\Traits\Sms;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OfferController extends Controller
{
    use Sms;
    //display all offers
    public function offers(){
        $data['offers'] = Offer::orderBy('position', 'asc')->where('status', 1)->get();
        $data['page'] = Page::where('slug', \Request::segment(1))->where('status', 1)->first();
        $id = 0;
        if($data['page']){
            $id = $data['page']->id;
        }
        $data['banners'] = Banner::where('page_name', 'all')->orWhere('page_name', $id)->get();
        return view('frontend.offer.offers')->with($data);
    }

    //view offer details by offer slug
    public function offerDetails(Request $request, $slug){
        $data['offer'] = Offer::where('slug', $slug)->where('status', 1)->first();
        if($data['offer']) {
            //set offer id in session for offer identify
            Session::put('offer_id', $data['offer']->id);
            $data['offer_products'] = Product::join('offer_products', 'products.id', 'offer_products.product_id')
                ->where('offer_id', $data['offer']->id)
                ->selectRaw('offer_discount as discount, offer_products.discount_type,fake_sale,offer_quantity, offer_id, products.id,title,slug,selling_price,stock,feature_image')
                ->groupBy('offer_products.id')
                ->orderBy('offer_products.position', 'asc')
                ->where('offer_products.status', 'active')
                ->paginate(12);

            //direct offer purchase page
            if($data['offer']->offer_type == 'kanamachi'){
                Session::put('redirectLink', route('offer.buyOffer', $slug));
            }else{
                Session::forget('redirectLink');
            }
            //check ajax request
            if ($request->ajax()) {
                if( $data['offer']->offer_type == 'kanamachi') {
                    $view = view('frontend.offer.kanamachi-product', $data)->render();
                }else {
                    $view = view('frontend.offer.products', $data)->render();
                }
                return response()->json(['html'=>$view]);
            }
            if(!Session::has('offerView')){
                $data['offer']->increment('offer_views'); // news view count
                Session::put('offerView', 1);
            }
           
            return view('frontend.offer.offers-details')->with($data);
        }
        return view('404');
    }

    // get city by state
    public function getCity(Request $request, $id){
        $offer = Offer::find($request->offer_id);
        if($offer) {
            $total_amount = $offer->discount;
            //set shipping region id for shipping cost
            Session::put('ship_region_id', $id);

            $shipping_cost = $offer->shipping_cost;
            //check shipping method
            if ($offer->shipping_method == 'location') {
                if ($offer->ship_region_id != $id) {
                    $shipping_cost = $offer->other_region_cost;
                }
            }
            Session::put('shipping_cost', $shipping_cost);
            $cities = City::where('state_id', $id)->orderBy('name', 'asc')->where('status', 1)->get();
            $output = $allcity = '';
            if (count($cities) > 0) {
                $allcity .= '<option value="">Select city</option>';
                foreach ($cities as $city) {
                    $allcity .= '<option ' . (old("city") == $city->id ? "selected" : "") . ' value="' . $city->id . '">' . $city->name . '</option>';
                }
            }
            $grandTotal = ($total_amount + $shipping_cost);
            $output = array('status' => true, 'shipping_cost' => Config::get('siteSetting.currency_symble') . $shipping_cost, 'grandTotal' => $grandTotal, 'allcity' => $allcity);
            return response()->json($output);
        }else{
            $output = array('status' => false);
        }
    }

    public function shippingAddressInsert(Request $request){

        $request->validate([
            'shipping_name' => 'required',
            'shipping_phone' => 'required|min:11|numeric|regex:/(01)[0-9]/',
            'shipping_region' => 'required',
            'shipping_city' => 'required',
            'ship_address' => 'required',
        ]);

        $shipping = new ShippingAddress();
        $shipping->user_id = Auth::id();
        $shipping->name = ($request->shipping_name) ? $request->shipping_name : $request->name;
        $shipping->email = ($request->shipping_email) ? $request->shipping_email : $request->email;
        $shipping->phone = ($request->shipping_phone) ? $request->shipping_phone : $request->mobile;
        $shipping->region = ($request->shipping_region) ? $request->shipping_region : $request->region;
        $shipping->city = ($request->shipping_city) ? $request->shipping_city : $request->city;
        $shipping->area = ($request->shipping_area) ? $request->shipping_area : $request->area;
        $shipping->address = ($request->ship_address) ? $request->ship_address : $request->address;
        $store = $shipping->save();

        if($store){
            Toastr::success('Shipping address added successful.');
        }else{
            Toastr::error("Shipping address can\'t added.");
        }
        //insert shipping address & redirect payment method
        if($request->processBuy){
            Session::put('shipping_address', $shipping->id);
            return redirect()->route('offer.processToPay');
        }
        return redirect()->back();
    }

    // get shipping address by shipping id
    public function getShippingAddress(Request $request, $shipping_id)
    {
        $get_shipping = ShippingAddress::with(['get_state', 'get_city', 'get_area'])->where('user_id', Auth::id())->where('id', $shipping_id)->first();
        if ($get_shipping) {
            //set shipping address by region id
            Session::put('shipping_address', $get_shipping->id);
            $area = ($get_shipping->get_area) ? $get_shipping->get_area->name .',' : null;
            //get shipping details by region id
            $shipping_addess = '
                <div class="form-group" > <strong><i class="fa fa-user"></i></strong> ' . $get_shipping->name . ' </div>
                <div class="form-group" >  <strong><i class="fa fa-envelope"></i></strong> ' . $get_shipping->email . ' </div>
                <div class="form-group" > <strong><i class="fa fa-phone"></i></strong> ' . $get_shipping->phone . ' </div>
                <div class="form-group" > <strong><i class="fa fa-map-marker"></i></strong> ' .
                $get_shipping->address . ', ' . $area .
                $get_shipping->get_city->name . ', ' .
                $get_shipping->get_state->name .
                '</div>';

            $offer = Offer::find($request->offer_id);
            $total_amount = $offer->discount;

            $shipping_cost = $offer->shipping_cost;
            //check shipping method
            if($offer->shipping_method == 'location'){
                if ($offer->ship_region_id != $get_shipping->region) {
                    $shipping_cost = $offer->other_region_cost;
                }
            }
            Session::put('shipping_cost', $shipping_cost);
            $grandTotal = $total_amount;
            $output = array( 'status' => true, 'shipping_addess' => $shipping_addess, 'shipping_cost' => Config::get('siteSetting.currency_symble').$shipping_cost, 'grandTotal' => $grandTotal);
            return response()->json($output);
        }else{
            $output = array('status' => false);
        }
    }

  

    public function offer404(){
        return view('frontend.offer.offer404');
    }
    //pay shipping cost
    public function shippingCostPayment($orderId)
    {
        $order = Order::with('shipping_state')->where('payment_method', '!=', 'pending')->where('user_id', Auth::id())->where('order_id', $orderId)->first();
        try {
            if ($order) {
                $offer = Offer::where('id', $order->offer_id)->first();
                //check shipping method
                $shipping_cost = $offer->shipping_cost;
                if ($order->shipping_state) {
                    if ($offer->shipping_method == 'location') {
                        if ($offer->ship_region_id != $order->shipping_state->id) {
                            $shipping_cost = $offer->other_region_cost;
                        }
                    }
                }
                $order->offer_shipping = 1;
                $order->save();

                $data = [
                    'order_id' => $order->order_id,
                    'total_price' => $shipping_cost,
                    'total_qty' => $order->total_qty,
                    'currency' => $order->currency,
                    'payment_method' => 'nagad'
                ];

                Session::put('payment_data', $data);
                //return redirect()->route('offer.prizeSelect');
                //redirect PaypalController for payment process
                $nagad = new NagadPaymentController();
                return $nagad->nagadPayment();
            } else {
                Toastr::error('Payment failed.');
                return redirect()->back();
            }
        }catch (\Exception $exception){
            Toastr::error('Payment failed.');
            return redirect()->back();
        }
    }

    public function uniqueOrderId($offerNo)
    {
        $user_id = (Auth::check() ? Auth::id() : rand(000, 999));
        $offerNo = 'WK'.$offerNo.$user_id;
        $numberLen = 10 - strlen($offerNo);
        $order_id = $offerNo.strtoupper(substr(str_shuffle("0123456789"), -$numberLen));

        $check_path = DB::table('orders')->select('order_id')->where('order_id', 'like', $order_id.'%')->get();
        if (count($check_path)>0){
            //find slug until find not used.
            for ($i = 1; $i <= 99; $i++) {
                $new_order_id = $offerNo.strtoupper(substr(str_shuffle("0123456789"), -$numberLen));
                if (!$check_path->contains('order_id', $new_order_id)) {
                    return $new_order_id;
                }
            }
        }else{ return $order_id; }
    }
    //calculate product offer discount addtocart && buy now
    public static function discount($product_id, $offer_id='', $offerPage=''){
        $offer_id = ($offer_id) ? $offer_id : Session::get('offer_id');
        //check weather offer active or deactive
        $offer = Offer::where('id', $offer_id)->where('offer_type', '!=', 'kanamachi');
        //view discount only offer page (after running offer)
        if(!$offerPage){
            $offer->where('start_date', '<=', Carbon::now())->where('end_date', '>=', Carbon::now());
        }
        $offer = $offer->where('status', 1)->first();
        $output = null;
        //check offer discount product
        $product = OfferProduct::join('products', 'offer_products.product_id', 'products.id')
            ->selectRaw('selling_price, discount, offer_discount, offer_products.discount_type as offer_discount_type')
            ->where('offer_id', $offer_id)->where('product_id', $product_id)->first();

        if($offer && $product) {
            if ($product->offer_discount_type == '%') {
                $discount = $product->selling_price - ($product->offer_discount * $product->selling_price) / 100;
                $output = [
                    'discount_price' => $discount,
                    'discount' => $product->offer_discount,
                    'discount_type' => $product->offer_discount_type
                ];
            }elseif ($product->offer_discount_type == 'fixed') {
                $selling_price = $product->selling_price;
                $discount_price = $product->offer_discount;
                $discount = $product->offer_discount;
                $discount = round(((($selling_price - $discount) - $selling_price)/$selling_price) * 100);
                $output = [
                    'discount_price' => $discount_price,
                    'discount' => $discount,
                    'discount_type' => Config::get('siteSetting.currency_symble')
                ];
            } else {

                $selling_price = $product->selling_price;
                $discount_price = $product->selling_price - $product->offer_discount;
                $discount = $product->offer_discount;
                $discount = round(((($selling_price - $discount) - $selling_price)/$selling_price) * 100);
                $output = [
                    'discount_price' => $discount_price,
                    'discount' => $discount,
                    'discount_type' => Config::get('siteSetting.currency_symble')
                ];
            }
        }else {
            //product default discount
            $product = Product::where('discount', '!=', null)->where('id', $product_id)->first();
            if ($product){
                if ($product->discount_type == '%') {
                    $discount = $product->selling_price - ($product->discount * $product->selling_price) / 100;
                    $output = [
                        'discount_price' => round($discount, 0),
                        'discount' => $product->discount,
                        'discount_type' => '%'
                    ];
                } else {

                    $selling_price = $product->selling_price;
                    $discount_price = $product->selling_price - $product->discount;
                    $discount = $product->discount;
                    $discount = round(((($selling_price - $discount) - $selling_price)/$selling_price) * 100);
                    $output = [
                        'discount_price' => $discount_price,
                        'discount' => $discount,
                        'discount_type' => Config::get('siteSetting.currency_symble')
                    ];
                }
            }
        }
        return $output;

    }

}
