<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\PaymentGateway;
use App\Models\PaymentSetting;
use App\Models\Transaction;
use App\Vendor;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class TransactionController extends Controller
{
    //seller payment gateway setting
    public function paymentSetting(Request $request){
        $paymentgateways = PaymentGateway::with('paymentInfo')->orderBy('position', 'asc')
            ->where('method_for', 'payment')->where('status', 1)->get();
        return view('vendors.payment-setting')->with(compact('paymentgateways'));
    }

    //seller payment gateway update
    public function paymentSettingUpdate(Request $request){
        $seller_id = Auth::guard('vendor')->id();
        $request->validate([
            'payment_id' => 'required',
            'acc_name' => 'required',
            'acc_no' => 'required'
        ]);

        $paymentSetting =  PaymentSetting::where('seller_id', $seller_id)->where('payment_id', $request->payment_id)->where('id', $request->id)->first();

        if(!$paymentSetting) {
            $paymentSetting = new PaymentSetting();
        }
        $paymentSetting->payment_id = $request->payment_id;
        $paymentSetting->acc_name = $request->acc_name;
        $paymentSetting->acc_no = $request->acc_no;
        $paymentSetting->bank_name = ($request->bank_name) ? $request->bank_name : null;
        $paymentSetting->branch_name = ($request->branch_name) ? $request->branch_name : null;
        $paymentSetting->routing_no = ($request->routing_no) ? $request->routing_no : null;
        $paymentSetting->seller_id = $seller_id;
        $paymentSetting->status = 'pending';
        $paymentSetting->save();
        Toastr::success('Payment Setting Update Success.');
        return back();
    }

    // view vendor all transaction
    public function vendor_transactions(){
        $vendor_id = Auth::guard('vendor')->id();
        $data['transactions'] = Transaction::where('seller_id', $vendor_id)->orderBy('id', 'desc')->groupBy('item_id')->selectRaw('*, sum(amount) as grand_total')->paginate(15);
        $data['total'] = Transaction::whereIn('type', ['order'])->where('seller_id', $vendor_id)->where('status', 'paid')->sum('amount');
        $data['withdraw'] = Transaction::where('type', 'withdraw')->where('seller_id', $vendor_id)->where('status', '!=', 'cancel')->sum('amount');

        return view('vendors.transactions')->with($data);
    }
    //view admin all transaction
    public function admin_transactions(){

        $data['transactions'] = Transaction::orderBy('id', 'desc')->where('seller_id', '!=', null)->groupBy('item_id')->selectRaw('*, sum(amount) as grand_total')->paginate(15);
        $data['totalBalance'] = Vendor::where('balance', '>', 0)->sum('balance');
        $data['totalWithdraw'] = Transaction::where('type', 'withdraw')->where('seller_id', '!=', null)->where('status', '!=', 'cancel')->sum('amount');
        $data['pendingWithdraw'] = Transaction::where('type', 'withdraw')->where('seller_id', '!=', null)->where('status', 'pending')->sum('amount');

        return view('admin.vendor.transactions')->with($data);
    }



}
