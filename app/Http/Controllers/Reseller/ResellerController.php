<?php
namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Order;
use App\Models\Product;
use App\Models\Reseller;
use App\Vendor;
use Illuminate\Http\Request;

class ResellerController extends Controller{

    public function resellerList(Request $request, $status=''){
        $resellers = Reseller::all();
        //$vendors  = Vendor::with(['allproducts:vendor_id','allorders:vendor_id']);
        if($status){
            $resellers->where('status', $status);
        }
        if(!$status && $request->status && $request->status != 'all'){
            $resellers->where('status', $request->status);
        }
//        if($request->shop_name && $request->shop_name != 'all'){
//            $resellers->where('shop_name', 'LIKE', '%'. $request->shop_name .'%');
//        }

//        if($request->location && $request->location != 'all'){
//            $resellers->where('city', $request->location);
//        }

        $resellers  = $resellers->orderBy('id', 'desc')->paginate(20);
        $locations = City::orderBy('name', 'asc')->get();
        return view('admin.reseller.resellers')->with(compact('resellers','locations'));
    }

    public function resellerProfile($slug){
        $data['vendor']  = Vendor::where('slug', $slug)->first();
        $data['products'] = Product::where('vendor_id', $data['vendor']->id)->paginate(15);
        $data['orders'] = Order::join('order_details', 'orders.order_id', 'order_details.order_id')
            ->join('users', 'orders.user_id', 'users.id')
            ->orderBy('order_details.id', 'desc')
            ->where('payment_method', '!=', 'pending')
            ->where('order_details.vendor_id', $data['vendor']->id)
            ->groupBy('order_details.order_id')
            ->selectRaw('order_details.*, count(qty) as quantity, sum(qty*price) as total_price, payment_method, tnx_id, payment_info, currency_sign, users.name as customer_name')->paginate(15);

        return view('admin.vendor.profile')->with($data);
    }
}
