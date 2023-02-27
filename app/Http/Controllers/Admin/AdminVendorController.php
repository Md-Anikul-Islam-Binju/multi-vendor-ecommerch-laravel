<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Order;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Vendor;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class AdminVendorController extends Controller
{
    public function vendorList(Request $request, $status=''){
        $vendors  = Vendor::with(['allproducts:vendor_id','allorders:vendor_id']);
        if($status){
            $vendors->where('status', $status);
        }
        if(!$status && $request->status && $request->status != 'all'){
            $vendors->where('status', $request->status);
        }if($request->shop_name && $request->shop_name != 'all'){
            $vendors->where('shop_name', 'LIKE', '%'. $request->shop_name .'%');
        }if($request->location && $request->location != 'all'){
            $vendors->where('city', $request->location);
        }

        $vendors  = $vendors->orderBy('id', 'desc')->paginate(20);
        $locations = City::orderBy('name', 'asc')->get();
        return view('admin.vendor.vendor')->with(compact('vendors','locations'));
    }

    public function vendorProfile($slug){
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

    public function vendor_commission(){
        $commission = SiteSetting::where('type', 'vendor_commission')->get()->toArray();
        return view('admin.vendor.commission')->with(compact('commission'));
    }
    public function vendorCommissionUpdate(Request $request){
        SiteSetting::where('type', 'vendor_commission')->update(['value' => $request->seller_commission]);
        Toastr::success('Commission update success');
        return back();
    }

    public function sellerSecretLogin($id)
    {
        $seller = Vendor::findOrFail(decrypt($id));
        auth()->guard('vendor')->login($seller, true);
        Toastr::success('Seller panel login success');
        return redirect()->route('vendor.dashboard');
    }

    public function delete($id){
        $user = Vendor::find($id);
        if($user){
            $user->delete();
            $output = [
                'status' => true,
                'msg' => 'User deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'User cannot deleted.'
            ];
        }
        return response()->json($output);
    }
}
