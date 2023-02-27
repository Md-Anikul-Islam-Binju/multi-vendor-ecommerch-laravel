<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderInvoice;
use App\Models\ShippingMethod;
use App\Traits\Sms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
    use Sms;
    //get all order by user id
    public function orderHistory(Request $request, $status='')
    {
        $orderCount = Order::where('payment_method', '!=', 'pending')->select('order_status', 'offer_id')->get();

        $orders = Order::with(['orderCancelReason', 'orderNotify' => function($query){
            $query->orderBy('id', 'DESC');  }, 'orderNotify.staff', 'orderPartialPayments'])
            ->where('payment_method', '!=', 'pending')
            ->leftJoin('users', 'orders.user_id', 'users.id');
        if($request->order_id){
            $orders->where('order_id', $request->order_id);
        }if($request->payment){
            $orders->where('payment_method', $request->payment);
        }
        if($request->offer && $request->offer != 'offer' &&  $request->offer != 'regular'){
            $orders->where('offer_id', $request->offer);
        }else{
            if($request->offer && $request->offer == 'offer'){
                $orders->where('offer_id', '!=', null);
            }if($request->offer && $request->offer == 'regular'){
                $orders->where('offer_id', null);
            }
        }
        if($request->customer){
            $keyword = $request->customer;
                $orders->where(function ($query) use ($keyword) {
                $query->orWhere('orders.shipping_name', 'like', '%' . $keyword . '%');
                $query->orWhere('orders.shipping_phone', 'like', '%' . $keyword . '%');
                $query->orWhere('orders.shipping_email', 'like', '%' . $keyword . '%');
                $query->orWhere('users.name', 'like', '%' . $keyword . '%');
                $query->orWhere('users.mobile', 'like', '%' . $keyword . '%');
                $query->orWhere('users.email', 'like', '%' . $keyword . '%');
            });
        }
        if($status){
            $orders = $orders->where('order_status', $status);
        }
        if($request->from_date){
            $from_date = Carbon::parse($request->from_date)->format('Y-m-d')." 00:00:00";
            $orders = $orders->whereDate('order_date', '>=', $from_date);
        }if($request->end_date){
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d')." 23:59:59";
            $orders = $orders->whereDate('order_date', '<=', $request->end_date);
        }
        if(!$status && $request->status && $request->status != 'all'){
            $orders = $orders->where('order_status',$request->status);
        }

        $orders = $orders->orderBy('order_date', 'desc')->selectRaw('orders.*, users.name as customer_name,username')->paginate(15);

        $offers = Offer::orderBy('id', 'desc')->get();
        return view('admin.order.orders')->with(compact('orders', 'orderCount', 'offers'));
    }




    //show order details by order id
    public function showOrderDetails($orderId){

        $data['order'] = Order::with(['order_details.product:id,title,slug,feature_image,product_type','get_country', 'get_state', 'get_city', 'get_area'])
            ->where('order_id', $orderId)->first();
        if($data['order']){
            $data['shipping_methods'] = ShippingMethod::where('status', 1)->orderBy('position', 'asc')->selectRaw('id, name, logo, duration')->get();
            return view('admin.order.order-details')->with($data);
        }
        return false;
    }

    //show order details by order id
    public function orderInvoice($orderId){
        $order = Order::with(['order_details.product:id,title,slug,feature_image'])
            ->where('order_id', $orderId)->first();
        if($order){
            return view('admin.order.invoice')->with(compact('order'));
        }
        return view('404');
    }

    //set product attribute size , color etc
    public function orderAttributeUpdate(Request $request){
        $order = OrderDetail::where('order_id', $request->order_id)->where('product_id', $request->product_id)->first();
        if($order){
            $attributes = explode(',', $request->productAttributes);
            $attributes = json_encode($attributes);
            $order->attributes = $attributes;
            $order->save();
            $output = array( 'status' => true,  'message'  => 'Product Attribute added successful.');
        }else{
            $output = array( 'status' => false,  'message'  => 'Product Attribute added failed.!');
        }
        return response()->json($output);
    }

    // add order info exm( shipping cost, comment)
    public function addedOrderInfo(Request $request){
        $order = Order::where('order_id', $request->order_id)->first();
        $staff_name = Auth::guard('admin')->user()->name;
        if($order){
            if($request->field_data) {
                $field = $request->field;
                $order->$field = ($request->field_data) ? $order->$field .'<p> By '.$staff_name.' => '. $request->field_data .' ('. date('d M, Y') .')</p>' : null;
                $order->save();
            }
            $output = array( 'status' => true,  'message'  => str_replace( '_', ' ', $request->field).' added successful.');
        }else{
            $output = array( 'status' => false,  'message'  => str_replace( '_', ' ', $request->field).' added failed.');
        }
        return response()->json($output);
    }

    //order invoice Print By
    public function invoicePrintBy(Request $request, $order_id){
        $order = Order::where('order_id', $order_id)->first();
        if($order){
            $order->increment('invoicePrints');
            $staff_id = Auth::guard('admin')->id();
            //add  order invoice
            $orderInvoice = new OrderInvoice();
            $orderInvoice->invoice_id = $request->invoice_id;
            $orderInvoice->all_orders = $request->all_orders;
            $orderInvoice->notes = 'order: '. $order->order_status.', payment: '.$order->payment_status;
            $orderInvoice->user_id = $order->user_id;
            $orderInvoice->created_by = $staff_id;
            $orderInvoice->save();
        }
        return true;
    }


}
