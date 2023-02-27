<?php
namespace App\Traits;


use Illuminate\Support\Facades\Auth;

trait Vendor
{
    public function vendor_id(){
        if(Auth::guard('vendor')->check()){
            return Auth::guard('vendor')->id();
        }elseif(Auth::guard('staff')->check()){
            return Auth::guard('staff')->user()->vendor_id;
        }else{
            return 0;
        }
    }

    public function user_id(){
        if(Auth::guard('vendor')->check()){
            return Auth::guard('vendor')->id();
        }elseif(Auth::guard('staff')->check()){
            return Auth::guard('staff')->id();
        }else{
            return 0;
        }

    }
}




