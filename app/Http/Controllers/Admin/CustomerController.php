<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Transaction;
use App\Traits\Sms;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class CustomerController extends Controller
{
    use Sms;
    public function customerList(Request $request, $status= ''){
        $customers  = User::with('orders:user_id');
        if($status){
            $customers->where('status', $status);
        }
        if(!$status && $request->status && $request->status != 'all'){
            $customers->where('status', $request->status);
        }if($request->name && $request->name != 'all'){
            $keyword = $request->name;
            $customers->where(function ($query) use ($keyword) {
                $query->orWhere('name', 'like', '%' . $keyword . '%');
                $query->orWhere('mobile', 'like', '%' . $keyword . '%');
                $query->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }if($request->location && $request->location != 'all'){
            $customers->where('city', $request->location);
        }
        $customers  = $customers->orderBy('id', 'desc')->paginate(15);
        $locations = City::orderBy('name', 'asc')->get();
        return view('admin.customer.customer')->with(compact('customers', 'locations'));
    }

    public function customerProfile($username){
        $customer  = User::with('orders')->where('username', $username)->first();
        return view('admin.customer.profile')->with(compact('customer'));
    }

    public function customerSecretLogin($id)
    {
        $user = User::findOrFail(decrypt($id));
        auth()->guard('web')->login($user, true);
        Toastr::success('Customer panel login success.');
        return redirect()->route('user.dashboard');

    }
    public function delete($id){
        $user = User::find($id);
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
