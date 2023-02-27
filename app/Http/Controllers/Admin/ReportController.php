<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderCancelReason;
use App\Models\OrderDetail;
use App\Models\OrderInvoice;
use App\Models\SiteSetting;
use App\Models\Transaction;

use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{

    public function orderReport(Request $request)
    {
        $offers = Offer::where('start_date', '<=', Carbon::now())->orderBy('position', 'asc')->where('status', 1)->select('id','title')->get();

        $orders = Order::with('order_details.product:id,title,slug,feature_image')
            ->orderBy('order_date', 'desc')
            ->where('payment_method', '!=', 'pending')
            ->join('users', 'orders.user_id', 'users.id');

        if ($request->offer && $request->offer != 'all') {
            $orders->where('offer_id', $request->offer);
        }

        if ($request->customer) {
            $keyword = $request->customer;
            $orders->where(function ($query) use ($keyword) {
                $query->orWhere('orders.shipping_name', 'like', '%' . $keyword . '%');
                $query->orWhere('orders.shipping_phone', 'like', '%' . $keyword . '%');
                $query->orWhere('orders.shipping_email', 'like', '%' . $keyword . '%');
                $query->orWhere('users.name', 'like', '%' . $keyword . '%');
                $query->orWhere('users.mobile', 'like', '%' . $keyword . '%');
                $query->orWhere('users.email', 'like', '%' . $keyword . '%');
                $query->orWhereHas('order_details.product', function($query)  use ($keyword) {
                    $query->where('title', 'like', '%' . $keyword . '%');
                });
            });
        }
        if ($request->from_date) {
            $from_date = Carbon::parse($request->from_date)->format('Y-m-d') . " 00:00:00";
            $orders = $orders->whereDate('order_date', '>=', $from_date);
        }
        if ($request->end_date) {
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d') . " 23:59:59";
            $orders = $orders->whereDate('order_date', '<=', $request->end_date);
        }
        if ($request->status && $request->status != 'all') {
            $orders = $orders->where('order_status', $request->status);
        }
        $perPage = 25;
        if($request->show){
            $perPage = $request->show;
        }
        $orders = $orders->selectRaw('orders.*, users.name as customer_name,username')->paginate($perPage);
        return view('admin.reports.orders')->with(compact('orders', 'offers'));
    }

}
