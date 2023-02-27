<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingCharge;
use App\Models\GeneralSetting;
use App\Models\State;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShippingChargeController extends Controller
{
    public function index(){
        $data['flat_shipping'] = ShippingCharge::where('shipping_method', 'flat_shipping')->first();
        $data['location_shipping'] = ShippingCharge::where('shipping_method', 'location_shipping')->first();
        $data['regions'] = State::where('country_id', config('siteSetting.country'))->orderBy('name', 'asc')->get();
        return view('admin.shipping.shippingcharge')->with($data);
    }

    public function activeShippingMethod(Request $request){
        $setting = GeneralSetting::first();
        $setting->shipping_method = $request->shipping_method;
        $setting->shipping_cost = $request->shipping_cost;
        $setting->shipping_calculate = $request->shipping_calculate;
        $setting->shipping_time = $request->shipping_time;
        $store = $setting->save();
       if($store){
            Session::put('shippingSettingTab', $request->shipping_method);
           Toastr::success('Shipping method active successful.');
       }else{
           Toastr::error('Shipping method active failed.!');
       }

       return back();
    }

//    public function store(Request $request){
//        $data = new ShippingCharge();
//        $data->shipping_method = $request->shippingSettingTab;
//        $data->category_id = $request->category_id ?? null;
//        $data->region_id = $request->region_id ?? null;
//        $data->basket_price = $request->basket_price ?? null;
//        $data->basket_qty = $request->basket_qty ?? null;
//        $data->shipping_cost = $request->shipping_cost;
//        $store = $data->save();
//        if($store){
//            Toastr::success('Shipping Charge Create Successful.');
//        }else{
//            Toastr::error('Shipping Charge Cannot Create.!');
//        }
//
//        return back();
//    }

    public function update(Request $request){
        //dd($request->all());
        Session::put('shippingSettingTab', $request->shippingSettingTab);
        //update flat rate
        if($request->shippingSettingTab == 'flat_shipping'){
            $data = [
                'id' => $request->id,
                'shipping_method' => $request->shippingSettingTab,
                'shipping_cost' => $request->shipping_cost
            ];
        }
        if($request->shippingSettingTab == 'location_shipping'){
            $data = [
                'id' => $request->id,
                'shipping_method' => $request->shippingSettingTab,
                'category_id' => $request->category_id ?? null,
                'region_id' => $request->region_id ?? null,
                'shipping_cost' => $request->shipping_cost,
                'other_region_cost' => $request->other_region_cost,
            ];
        }
        $update = ShippingCharge::upsert($data, ['id']);

        if($update){
            Toastr::success('Shipping charge update successful.');
        }else{
            Toastr::error('Shipping charge update failed.!');
        }

        return back();
    }



}
