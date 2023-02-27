<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\SiteSetting;
use App\Models\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{


    //admin view reseller withdraw request list
    public function resellerWithdrawRequest(Request $request){
        $withdraws = Transaction::join('resellers', 'transactions.reseller_id', 'resellers.id')
            ->with('paymethod_name')->where('type', 'withdraw')->select('transactions.*');
        //total withdraw amount
        $data['withdraw_status'] = $withdraws->get();
        //total balance
        $data['total_balance'] = Transaction::whereIn('type', ['order'])->where('status', 'paid')->sum('amount');

        if($request->name){
            $name = $request->name;
            $withdraws->where(function ($query) use ($name) {
                $query->orWhere('shop_name', 'LIKE', '%'. $name .'%');
                $query->orWhere('vendor_name', 'LIKE', '%'. $name .'%');
            });
        }
        if($request->from_date){
            $from_date = Carbon::parse($request->from_date)->format('Y-m-d')." 00:00:00";
            $withdraws->where('transactions.created_at', '>=', $from_date);
        }if($request->end_date){
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d')." 23:59:59";
            $withdraws->where('transactions.created_at', '<=', $request->end_date);
        }
        if($request->status && $request->status != 'all'){
            $withdraws->where('transactions.status',$request->status);
        }
        //all withdraw lists
        $data['allwithdraws'] =  $withdraws->orderBy('transactions.id', 'desc')->paginate(15);

        return view('admin.reseller.withdraw_request')->with($data);
    }

    //customer wallet withdraw configuration
    public function customerWithdrawConfigure(){
        $withdraw = SiteSetting::where('type', 'customer_withdraw_configure')->first();
        return view('admin.wallet.withdraw-configure')->with(compact('withdraw'));
    }

    //admin view seller withdraw request list
    public function sellerWithdrawRequest(Request $request){
        $withdraws = Transaction::join('vendors', 'transactions.seller_id', 'vendors.id')
            ->with('paymethod_name')->where('type', 'withdraw')->select('transactions.*');
        //total withdraw amount
        $data['withdraw_status'] = $withdraws->get();
        //total balance
        $data['total_balance'] = Transaction::whereIn('type', ['order'])->where('status', 'paid')->sum('amount');

        if($request->name){
            $name = $request->name;
            $withdraws->where(function ($query) use ($name) {
                $query->orWhere('shop_name', 'LIKE', '%'. $name .'%');
                $query->orWhere('vendor_name', 'LIKE', '%'. $name .'%');
            });
        }
        if($request->from_date){
            $from_date = Carbon::parse($request->from_date)->format('Y-m-d')." 00:00:00";
            $withdraws->where('transactions.created_at', '>=', $from_date);
        }if($request->end_date){
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d')." 23:59:59";
            $withdraws->where('transactions.created_at', '<=', $request->end_date);
        }
        if($request->status && $request->status != 'all'){
            $withdraws->where('transactions.status',$request->status);
        }
        //all withdraw lists
        $data['allwithdraws'] =  $withdraws->orderBy('transactions.id', 'desc')->paginate(15);

        return view('admin.vendor.withdraw_request')->with($data);
    }

    //admin view customer withdraw request list
    public function customerWithdrawRequest(Request $request){
        $withdraws = Transaction::join('users', 'transactions.customer_id', 'users.id')
            ->with('paymentGateway')->where('type', 'withdraw')->select('transactions.*');
        //all withdrawal
        $data['withdraw_status'] = $withdraws->get();

        if($request->name){
            $customer = $request->customer;
            $withdraws->where(function ($query) use ($customer) {
                $query->orWhere('name', 'LIKE', '%'. $customer .'%');
                $query->orWhere('mobile', 'LIKE', '%'. $customer .'%');
                $query->orWhere('email', 'LIKE', '%'. $customer .'%');
            });
        }
        if($request->from_date){
            $from_date = Carbon::parse($request->from_date)->format('Y-m-d')." 00:00:00";
            $withdraws->where('transactions.created_at', '>=', $from_date);
        }if($request->end_date){
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d')." 23:59:59";
            $withdraws->where('transactions.created_at', '<=', $request->end_date);
        }
        if($request->status && $request->status != 'all'){
            $withdraws->where('transactions.status',$request->status);
        }
        //all withdraw lists
        $data['allwithdraws'] =  $withdraws->orderBy('transactions.id', 'desc')->paginate(15);
        $data['availableBalance'] = User::where('wallet_balance', '>', 0)->sum('wallet_balance');
        $data['commission'] = Transaction::where('type', 'withdraw')->where('status', 'paid')->where('customer_id', '!=', null)->sum('commission');
        return view('admin.wallet.withdraw-request')->with($data);
    }

}
