<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Offer;
use App\Models\OfferProduct;
use App\Models\OfferType;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\State;
use App\Traits\CreateSlug;
use App\Vendor;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use phpDocumentor\Reflection\Utils;

class OfferController extends Controller
{
    use CreateSlug;
    public function index()
    {
        $data['sellers'] = Vendor::orderBy('shop_name', 'asc')->where('status', 'active')->get();
        $data['categories'] = Category::where('parent_id', '=', null)->orderBy('name', 'asc')->where('status', 1)->get();
        $data['brands'] = Brand::orderBy('name', 'asc')->get();
        $data['regions'] = State::orderBy('name', 'asc')->get();
        $data['offerTypes'] = OfferType::orderBy('position', 'asc')->where('status', 1)->get();
        $data['offers'] = Offer::withCount(['offer_products','offer_orders'])->orderBy('position', 'asc')->get();
        return view('admin.offer.index')->with($data);
    }
    //create new offer
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'start_date' => 'required',
            'discount' => 'required',
            'discount_type' => 'required',
        ]);

        $offer = new Offer();
        $offer->title = $request->title;
        $offer->slug = $this->createSlug('offers', $request->title);
        $offer->start_date = $request->start_date;
        $offer->end_date = $request->end_date;
        $offer->offer_type = $request->offer_type;
        $offer->discount = $request->discount;
        $offer->discount_type = $request->discount_type;
        $offer->background_color = $request->background_color;
        $offer->text_color = $request->text_color;
        $offer->prefix_id = strtoupper($request->prefix_id);
        if($request->allow_item == 'specific') {
            $offer->allow_item = $request->specific;
            $offer->seller_id = ($request->seller) ? implode(',', $request->seller) : null;
            $offer->brand_id = ($request->brand) ? implode(',', $request->brand) : null;
            $offer->category_id = ($request->category) ? implode(',', $request->category) : null;
            $offer->allow_location = ($request->allow_location) ? implode(',', $request->allow_location) : null;
        }
        $offer->shipping_method = ($request->shipping_method) ? $request->shipping_method : null;
        $offer->order_price_above = ($request->order_price_above) ? $request->order_price_above : null;
        $offer->order_qty_above = ($request->order_qty_above) ? $request->order_qty_above : null;
        $offer->free_shipping = ($request->free_shipping) ? 1 : null;
        $offer->shipping_cost = ($request->shipping_cost) ? $request->shipping_cost : null;
        $offer->discount_shipping_cost = ($request->discount_shipping_cost) ? $request->discount_shipping_cost : null;
        $offer->ship_region_id = ($request->ship_region_id) ? $request->ship_region_id : null;
        $offer->other_region_cost = ($request->other_region_cost) ? $request->other_region_cost : null;
        $offer->shipping_time = ($request->shipping_time) ? $request->shipping_time : null;
        $offer->notes = ($request->details) ? $request->details :null;
        $offer->link = $request->link;
        $offer->position = 0;
        $offer->status = 1;

        //if feature image set
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $new_image_name = $this->uniqueImagePath('offers', 'thumbnail', $image->getClientOriginalName());
            $image->move(public_path('upload/images/offer/thumbnail/'), $new_image_name);
            $offer->thumbnail = $new_image_name;
        }
        //if feature image set
        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $new_image_name = $this->uniqueImagePath('offers', 'banner', $image->getClientOriginalName());
            $image->move(public_path('upload/images/offer/banner/'), $new_image_name);
            $offer->banner = $new_image_name;
        }
        $store = $offer->save();
        if($store) {
            Toastr::success('Offer created successfully.');
        }else{
            Toastr::error('Offer can\'t created.');
        }
        return back();
    }
    //edit offer
    public function editOffer($id){
        $data['offer'] = Offer::find($id);

        if($data['offer']){
            $data['offerTypes'] = OfferType::orderBy('position', 'asc')->where('status', 1)->get();
            $data['sellers'] = Vendor::orderBy('shop_name', 'asc')->where('status', 'active')->get();
            $data['categories'] = Category::where('parent_id', '=', null)->orderBy('name', 'asc')->where('status', 1)->get();
            $data['brands'] = Brand::orderBy('name', 'asc')->get();
            $data['regions'] = State::orderBy('name', 'asc')->get();
            return view('admin.offer.editOffer')->with($data);
        }else{
            return 'Offer not found.';
        }
    }
    //update offer
    public function updateOffer(Request $request){

        //update offer
        $request->validate([
            'title' => 'required',
            'offer_type' => 'required',
            'start_date' => 'required',
            'discount' => 'required',
            'discount_type' => 'required',
        ]);

        $offer = Offer::find($request->id);
        $offer->title = $request->title;
        $offer->start_date = $request->start_date;
        $offer->end_date = $request->end_date;
        $offer->offer_type = $request->offer_type;
        $offer->discount = $request->discount;
        $offer->discount_type = $request->discount_type;
        $offer->background_color = $request->background_color;
        $offer->text_color = $request->text_color;
        $offer->prefix_id = strtoupper($request->prefix_id);

        if($request->allow_item == 'specific') {
            $offer->allow_item = $request->specific;
            $offer->seller_id = ($request->seller) ? implode(',', $request->seller) : null;
            $offer->brand_id = ($request->brand) ? implode(',', $request->brand) : null;
            $offer->category_id = ($request->category) ? implode(',', $request->category) : null;
            $offer->allow_location = ($request->allow_location) ? implode(',', $request->allow_location) : null;
        }
        $offer->shipping_method = ($request->shipping_method) ? $request->shipping_method : null;
        $offer->order_price_above = ($request->order_price_above) ? $request->order_price_above : null;
        $offer->order_qty_above = ($request->order_qty_above) ? $request->order_qty_above : null;
        $offer->free_shipping = ($request->free_shipping) ? 1 : null;
        $offer->shipping_cost = ($request->shipping_cost) ? $request->shipping_cost : null;
        $offer->discount_shipping_cost = ($request->discount_shipping_cost) ? $request->discount_shipping_cost : null;
        $offer->ship_region_id = ($request->ship_region_id) ? $request->ship_region_id : null;
        $offer->other_region_cost = ($request->other_region_cost) ? $request->other_region_cost : null;
        $offer->shipping_time = ($request->shipping_time) ? $request->shipping_time : null;
        $offer->notes = ($request->details) ? $request->details :null;
        $offer->link = $request->link;
        $offer->status = ($request->status) ? 1 : null;

        //if feature image set
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $new_image_name = $this->uniqueImagePath('offers', 'thumbnail', $image->getClientOriginalName());
            $image->move(public_path('upload/images/offer/thumbnail/'), $new_image_name);
            $offer->thumbnail = $new_image_name;
        }
        //if feature image set
        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $new_image_name = $this->uniqueImagePath('offers', 'banner', $image->getClientOriginalName());
            $image->move(public_path('upload/images/offer/banner/'), $new_image_name);
            $offer->banner = $new_image_name;
        }
        $store = $offer->save();
        if($store) {
            $offerProduct = OfferProduct::where('offer_id', $request->id)->first();
            if($offerProduct) {
                //update all offer products
                $data = [];
                if ($request->discount > 0) {
                    $data['offer_price'] = $request->discount;
                    $data['offer_discount'] = $request->discount;
                }
                //update discount type
                $data['discount_type'] = $request->discount_type;
                OfferProduct::where('offer_id', $request->id)->update($data);
            }
            Toastr::success('Offer update successful.');
        }else{
            Toastr::error('Offer update failed.');
        }
        return back();

    }
    //delete offer
    public function delete($id)
    {
        $offer = Offer::find($id);

        if($offer){
            //delete offer
            $offer->delete();
            //delete offer product
            OfferProduct::where('offer_id', $offer->id)->delete();
            $banner = public_path('upload/images/offer/banner/' . $offer->banner);
            $thumbnail = public_path('upload/images/offer/thumbnail/' . $offer->thumbnail);

            if(file_exists($thumbnail) && $offer->thumbnail){
                unlink($thumbnail);
            }if(file_exists($banner) && $offer->banner){
                unlink($banner);
            }
            $output = [
                'status' => true,
                'msg' => 'Offer deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Offer cannot deleted.'
            ];
        }
        return response()->json($output);
    }

    //added offer single product
    public function offerSingleProductStore(Request $request)
    {
        $offer = Offer::where('id', $request->offer_id)->first();
        if($offer){
            $offerProduct = OfferProduct::where('offer_id', $request->offer_id)->where('product_id', $request->product_id)->first();
            if(!$offerProduct) {
                $productPosition = OfferProduct::where('offer_id', $request->offer_id)->orderBy('id', 'desc')->select('position')->first();
                $offerProduct = new OfferProduct();
                $offerProduct->offer_id = $offer->id;
                $offerProduct->product_id = $request->product_id;
                $offerProduct->fake_sale = rand(00,99);
                $offerProduct->offer_price = ($offer->discount) ? $offer->discount : $request->offer_discount;
                $offerProduct->offer_quantity = ($request->quantity) ? $request->quantity : 0;
                $offerProduct->offer_discount = ($offer->discount) ? $offer->discount : $request->offer_discount;
                $offerProduct->discount_type = ($offer->discount_type) ? $offer->discount_type : $request->discount_type;
                $offerProduct->invisible = ($request->invisible) ? 1 : 0;
                $offerProduct->approved = 1;
                $offerProduct->position = ($productPosition) ? $productPosition->position + 1 : 1;
                $offerProduct->status = 'active';
                $offerProduct->save();
                $output = [
                    'status' => true,
                    'msg' => 'Product added success.'
                ];
            }else{
                $output = [
                    'status' => false,
                    'msg' => 'This product already added.'
                ];
            }
        }
        return response()->json($output);
    }

    //added offer multi product
    public function offerMultiProductStore(Request $request){

        $offer = Offer::where('id', $request->offer_id)->first();
        if($offer && $request->product_id){
            foreach ($request->product_id as $product_id => $value) {
                $offerProduct = OfferProduct::where('offer_id', $request->offer_id)->where('product_id', $product_id)->first();
                if(!$offerProduct){
                    $offerProduct = new OfferProduct();
                    $offerProduct->offer_id = $offer->id;
                    $offerProduct->product_id = $product_id;
                    $offerProduct->fake_sale = rand(0,50);
                    $offerProduct->offer_price = ($offer->discount) ? $offer->discount : $request->discount[$product_id];
                    $offerProduct->offer_quantity = ($request->quantity[$product_id]) ? $request->quantity[$product_id] : 0;
                    $offerProduct->offer_discount = ($offer->discount) ? $offer->discount : $request->discount[$product_id];
                    $offerProduct->discount_type = ($offer->discount_type) ? $offer->discount_type : $request->discount_type[$product_id];
                    $offerProduct->invisible = ($request->invisible && array_key_exists($product_id, $request->invisible)) ? 1 : 0;
                    $offerProduct->approved = 1;
                    $offerProduct->status = 'active';
                    $offerProduct->save();
                }
            }
        }else{
            Toastr::error('Product added failed.');
        }
        return back();
    }

    //all offer product lists
    public function offerProducts(Request $request, $offer_slug){
        $data['offer'] = Offer::where('slug', $offer_slug)->first();
        $offer_id = $data['offer']->id;

        if($data['offer']){
            $offer_products = OfferProduct::with(['offer_orders' => function ($query) use ($offer_id) {
                $query->where('offer_id', '=', $offer_id);
            }])->join('products', 'offer_products.product_id', 'products.id');
            if($request->title){
                $offer_products->where('products.title', 'LIKE', '%'. $request->title .'%');
            }
            if($request->status && $request->status != 'all'){
                if($request->status == 'sold-out'){
                    $offer_products->where('offer_quantity', 0);
                }elseif($request->status == 'visible') {
                    $offer_products->where('invisible', 0);
                }elseif($request->status == 'invisible') {
                    $offer_products->where('invisible', 1);
                }else {
                    $offer_products->where('offer_products.status', $request->status);
                }
            }if($request->brand && $request->brand != 'all'){
                    $offer_products->where('products.brand_id', $request->brand);
            }if($request->seller && $request->seller != 'all'){
                    $offer_products->where('products.vendor_id', $request->seller);
            }
            $perPage = 15;
            if($request->show){
                $perPage = $request->show;
            }

            $data['offer_products'] = $offer_products->where('offer_id', $data['offer']->id)
                ->orderBy('position', 'asc')
                ->selectRaw('offer_products.*, products.title,selling_price,products.slug,feature_image')
                ->paginate($perPage);

            $data['sellers'] = Vendor::orderBy('shop_name', 'asc')->where('status', 'active')->get();
            $data['categories'] = Category::where('parent_id', '=', null)->orderBy('name', 'asc')->where('status', 1)->get();
            $data['brands'] = Brand::orderBy('name', 'asc')->get();
            $data['regions'] = State::orderBy('name', 'asc')->get();
            return view('admin.offer.offer_products')->with($data);
        }
        Toastr::error('Offer not found.');
        return back();
    }
    //edit offer product
    public function offerProductEdit($id){
        $offerProduct = OfferProduct::find($id);
        $offer = Offer::find($offerProduct->offer_id);
        if($offerProduct){
            return view('admin.offer.editOfferProduct')->with(compact('offerProduct','offer'));
        }else{
            return 'Product not found.';
        }
    }
    //update offer product
    public function offerProductUpdate(Request $request)
    {
        $offerProduct = OfferProduct::find($request->id);
        if($offerProduct) {
            $offerProduct->offer_quantity = ($request->offer_quantity) ? $request->offer_quantity : null;
            if($request->offer_price){
                $offerProduct->offer_price = $request->offer_price;
                $offerProduct->offer_discount = $request->offer_price;
            }
            if($request->discount_type) {
                $offerProduct->discount_type = $request->discount_type;
            }
            $offerProduct->save();
            Toastr::success('Product update success.');
        }else{
            Toastr::error('Product update failed.');
        }
        return back();
    }
    //get all products by anyone field
    public function getAllProducts (Request $request){
        $data['offer'] = Offer::with('offer_products')->where('id', $request->offer_id)->first();
        $result = '';
        if($data['offer']) {
            $products = Product::where('status', 'active');
            if ($request->product) {
                $keyword = $request->product;
                $products->where(function ($query) use ($keyword) {
                    $query->orWhere('title', 'like', '%' . $keyword . '%');
                    $query->orWhere('meta_keywords', 'like', '%' . $keyword . '%');
                    $query->orWhere('summery', 'like', '%' . $keyword . '%');
                });
            }
            if ($request->brand && $request->brand != 'all') {
                $products->where('brand_id', $request->brand);
            }
            if ($request->seller && $request->seller != 'all') {
                $products->where('vendor_id', $request->seller);
            }
            if ($request->category && $request->category != 'all') {
                $products->where('category_id', $request->category);
            }
            $data['allproducts'] = $products->orderBy('title', 'asc')->paginate(25);
            return view('admin.offer.getProducts')->with($data);
        }
        echo $result;
    }
    //offer Product Delete
    public function offerProductRemove($id)
    {
        $offerProduct = OfferProduct::find($id);
        if($offerProduct){
            $offerProduct->delete();
            $output = [
                'status' => true,
                'msg' => 'Product remove successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Product cannot remove.'
            ];
        }
        return response()->json($output);
    }

    // add order info exm( shipping cost, comment)
    public function setProductPrice(Request $request){
        $offerProduct = OfferProduct::where('id', $request->id)->first();
        if($offerProduct){
            $offerProduct->seller_rate = $request->seller_rate;
            $offerProduct->save();
            $output = array( 'status' => true,  'message' => 'Price update successful.');
        }else{
            $output = array( 'status' => false, 'message' => 'Price update failed.');
        }
        return response()->json($output);
    }
    //offer order list
    public function offerOrder(Request $request, $offer_slug, $status=''){
        $data['offer'] = Offer::where('slug', $offer_slug)->first();
        $offer_id = $data['offer']->id;
        if($data['offer']){
            $data['orderCount'] = Order::where('payment_method', '!=', 'pending')->where('offer_id', $offer_id)->select('order_status')->get();
            $offer_orders = Order::join('users', 'orders.user_id', 'users.id')
                ->where('offer_id', $offer_id)
                ->where('payment_method', '!=', 'pending')
                ->where('order_status', '!=', 'cancel');

            if($request->order_id){
                $offer_orders->where('order_id', $request->order_id);
            }
            if($request->customer){
                $keyword = $request->customer;
                $offer_orders->where(function ($query) use ($keyword) {
                    $query->orWhere('orders.billing_name', 'like', '%' . $keyword . '%');
                    $query->orWhere('orders.billing_phone', 'like', '%' . $keyword . '%');
                    $query->orWhere('orders.billing_email', 'like', '%' . $keyword . '%');
                    $query->orWhere('users.name', 'like', '%' . $keyword . '%');
                    $query->orWhere('users.mobile', 'like', '%' . $keyword . '%');
                    $query->orWhere('users.email', 'like', '%' . $keyword . '%');
                });
            }
            if($status){
                $offer_orders->where('order_status', $status)->orderBy('order_date', 'asc');
            }else{
                $offer_orders->orderBy('order_date', 'desc');
            }
            if($request->from_date){
                $from_date = Carbon::parse($request->from_date)->format('Y-m-d')." 00:00:00";
                $offer_orders->where('order_date', '>=', $from_date);
            }if($request->end_date){
                $end_date = Carbon::parse($request->end_date)->format('Y-m-d')." 23:59:59";
                $offer_orders->where('order_date', '<=', $request->end_date);
            }
            if(!$status && $request->status && $request->status != 'all'){
                $offer_orders->where('order_status',$request->status);
            }

            $data['offerOrders'] = $offer_orders->selectRaw('orders.*,users.name,username, users.mobile, count(user_id) total_order, sum(total_qty) all_qty ')
                ->groupBy('user_id')
                ->paginate(15);

            $data['sellers'] = Vendor::orderBy('shop_name', 'asc')->where('status', 'active')->get();
            $data['categories'] = Category::where('parent_id', '=', null)->orderBy('name', 'asc')->where('status', 1)->get();
            $data['brands'] = Brand::orderBy('name', 'asc')->get();
            $data['regions'] = State::orderBy('name', 'asc')->get();
            return view('admin.offer.order.offerOrders')->with($data);
        }
        Toastr::error('Offer not found.');
        return back();
    }

    //show order details by username
    public function showOfferOrderDetails(Request $request, $offer_slug, $username){

        $data['offer'] = Offer::where('slug', $offer_slug)->first();
        $offer_id = $data['offer']->id;
        $data['offer_slug'] = $offer_slug;
        $data['username'] = $username;
        if($data['offer']){
            $orders = Order::with(['order_details.product:id,title,slug,feature_image'])
                ->join('users', 'orders.user_id', 'users.id')
                ->where('payment_method', '!=', 'pending');
                if(!$request->addExtraOrder){
                    $orders->where('users.username', $username)->where('offer_id', $offer_id);
                }
                //add extra other user order
                if($request->addExtraOrder) {

                    $order_id = explode(',', $request->order_id);
                    $orders->whereIn('order_id', $order_id);

                    if ($request->status && $request->status != 'all') {
                        $orders->where('order_status', $request->status);
                    }
                }

                $data['orders'] = $orders->selectRaw('orders.*,users.name,username, users.mobile')
                ->orderBy('order_date', 'asc')
                ->get();
            if($request->addExtraOrder){
                if($data['orders']) {
                    return view('admin.offer.order.addExtraOrder')->with($data);
                }
                return false;
            }
            $data['shipping_methods'] = ShippingMethod::where('status', 1)->orderBy('position', 'asc')->selectRaw('id, name, logo, duration')->get();
            return view('admin.offer.order.orderDetails')->with($data);
        }

        return false;
    }
    //get product by order
    public function offerOrderInvoice(Request $request, $offer_slug, $username){
        $data['offer'] = Offer::where('slug', $offer_slug)->first();
        $offer_id = $data['offer']->id;

        if($data['offer']) {
            $orders = Order::with(['order_details.product:id,title,slug,feature_image'])
                ->join('users', 'orders.user_id', 'users.id')
                ->where('payment_method', '!=', 'pending')
                ->where('offer_id', $offer_id)
                ->where('username', $username);
                //add extra other user order
                if($request->addExtraOrder) {
                    if ($request->order_id) {
                        $order_id = explode(',', $request->order_id);
                        $orders->orWhereIn('order_id', $order_id);
                    }
                    if ($request->status && $request->status != 'all') {
                        $orders->where('order_status', $request->status);
                    }
                }
                $data['orders'] = $orders->orderBy('order_date', 'asc')->selectRaw('orders.*,users.name,username, users.mobile')->get();
            return view('admin.offer.order.invoice')->with($data);
        }
        return back();
    }

    public function offerOrderProducts(Request $request, $offer_slug, $product_slug){
        $data['offer'] = Offer::where('slug', $offer_slug)->first();
        $data['product'] = Product::where('slug', $product_slug)->select('title', 'slug', 'id')->first();
        $offer_id = $data['offer']->id;

        if($data['offer']){
            $orderUsers = OrderDetail::join('orders', 'order_details.order_id', 'orders.order_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->where('orders.offer_id', $data['offer']->id)
            ->where('order_details.product_id', $data['product']->id);
            if($request->customer){
                $keyword = $request->customer;
                $orderUsers->where(function ($query) use ($keyword) {
                    $query->orWhere('orders.billing_name', 'like', '%' . $keyword . '%');
                    $query->orWhere('orders.billing_phone', 'like', '%' . $keyword . '%');
                    $query->orWhere('orders.billing_email', 'like', '%' . $keyword . '%');
                    $query->orWhere('users.name', 'like', '%' . $keyword . '%');
                    $query->orWhere('users.mobile', 'like', '%' . $keyword . '%');
                    $query->orWhere('users.email', 'like', '%' . $keyword . '%');
                });
            }if($request->city && $request->city != 'all'){
                $orderUsers->where('orders.shipping_city', $request->city);
            }if($request->status && $request->status != 'all'){
                $orderUsers->where('orders.order_status', $request->status);
            }
            $perPage = 15;
            if($request->show){
                $perPage = $request->show;
            }
            $data['orderUsers'] = $orderUsers->selectRaw('order_details.*,orders.order_date, orders.shipping_region, orders.shipping_city, orders.shipping_area, orders.shipping_address,orders.shipping_phone, orders.order_status, users.name')
                ->paginate($perPage);

            $data['cities'] = City::join('orders', 'cities.name', 'orders.shipping_city')
                ->join('order_details', 'orders.order_id', 'order_details.order_id')
                ->where('orders.offer_id', $data['offer']->id)
                ->where('order_details.product_id', $data['product']->id)
                ->orderBy('name', 'asc')
                ->selectRaw('cities.*, count(orders.shipping_city) total_order')
                ->groupBy('shipping_city')->get();

            return view('admin.offer.order.orderUsers')->with($data);
        }
        Toastr::error('Offer not found.');
        return back();
    }
}
