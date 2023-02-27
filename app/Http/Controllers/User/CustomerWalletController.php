<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\PaymentGateway;
use App\Models\SiteSetting;
use App\Models\Transaction;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomerWalletController extends Controller
{

    public function walletHistory(Request $request){
        $customer_id = Auth::id();
        $wallets = Transaction::with(['customer:id,name,username,mobile', 'paymentGateway'])
            ->where('customer_id', $customer_id)
            ->whereIn('type', ['wallet', 'withdraw']);
        if($request->withdraw && $request->withdraw != 'all'){
            $wallets->where('transactions.status', $request->withdraw);
        }
        $data['wallets'] =   $wallets->orderBy('id', 'desc')->get();
        $data['paymentGateways'] = PaymentGateway::where('method_for', 'payment')->where('status', 1)->get();
        $data['withdraw_configure'] = SiteSetting::where('type', 'customer_withdraw_configure')->first();
        return view('users.wallet.wallet')->with($data);
    }

    public function withdrawRequest(Request $request){
        $withdraw = SiteSetting::where('type', 'customer_withdraw_configure')->where('status', 1)->first();
        //check withdraw request active or deactive
        if(!$withdraw){
            return redirect()->back();
        }
        $request->validate([
            'payment_method' => ['required'],
            'amount' => ['required'],
            'account_no' => ['required'],
            'password' => ['required'],
        ]);
        // if occur error open model
        Session::put('submitType', 'withdraw_request');
        $customer_id = Auth::id();
        $amount = $request->amount;
        $user = User::where('id', $customer_id)->first();
        if($user && Hash::check($request->password, $user->password)) {
            //Minimum withdrawal amount
            $withdrawalConfig = SiteSetting::where('type', 'customer_withdraw_configure')->first();

            if($amount < $withdrawalConfig->value2){
                $msg = 'Minimum withdrawal amount '. Config::get('siteSetting.currency_symble') . $withdrawalConfig->value2;
                Toastr::error($msg);
            }
            elseif($request->amount > $user->wallet_balance){
                $msg = 'Insufficient Your Wallet Balance.';
                Toastr::error($msg);
            }
            else {

                //minus customer balance
                $user->wallet_balance = $user->wallet_balance - $request->amount;
                $user->save();
                //calculate commission
                $commission = ($withdrawalConfig->value > 0) ? round(($amount * $withdrawalConfig->value)/100, 2) : 0;
                //minus commission
                $amount = $amount - $commission;
                $invoice_id = 'W'.Auth::id() . strtoupper(substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), -6));
                //insert transaction
                $withdraw = new Transaction();
                $withdraw->type = 'withdraw';
                $withdraw->payment_method = $request->payment_method;
                $withdraw->customer_id = $customer_id;
                $withdraw->item_id = $invoice_id;
                $withdraw->amount = $amount;
                $withdraw->commission = $commission;
                $withdraw->account_no = $request->account_no;
                $withdraw->notes = $request->notes;
                $withdraw->status = 'pending';
                $withdraw->save();

                //insert notification in database
                Notification::create([
                    'type' => 'withdraw',
                    'fromUser' => $customer_id,
                    'toUser' => null,
                    'item_id' => $withdraw->id,
                    'notify' => 'withdraw request',
                ]);
                $msg = 'Withdrawal request successfully submitted.';
                Toastr::success($msg);
                return redirect()->back()->with('success', $msg);
            }
        }else{
            $msg = 'Sorry invalid password.!.';
            Toastr::error($msg);
        }
        return redirect()->back()->withInput()->with('error', $msg);

    }
}
