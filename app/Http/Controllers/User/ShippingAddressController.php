<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\City;
use App\Models\Order;
use App\Models\State;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class ShippingAddressController extends Controller
{
        //get address book list
    public function addressBook()
    {
        $data['user'] = User::find(Auth::id());
        $data['states'] = State::where('country_id', config('siteSetting.country'))->where('status', 1)->get();
        $data['shipping_addresses'] = ShippingAddress::with(['get_state','get_city', 'get_area'])
            ->where('user_id', Auth::id())->get();
        return view('users.shipping.address-book')->with($data);
    }
    public function shippingAddressEdit($id){

        $data['shipping'] = ShippingAddress::where('id', $id)
            ->where('user_id', Auth::id())->first();
        $data['states'] = State::where('country_id', config('siteSetting.country'))->where('status', 1)->get();
        $data['cities'] = City::where('state_id', $data['shipping']->region)->where('status', 1)->get();
        $data['areas'] = Area::where('city_id', $data['shipping']->city)->where('status', 1)->get();
        return view('users.shipping.address-edit')->with($data);
    }
    public function shippingAddressUpdate(Request $request){
        $shipping = ShippingAddress::find($request->id);
        $shipping->user_id = Auth::id();
        $shipping->address_name = ($request->address_name) ? $request->address_name : $request->address_name;
        $shipping->name = ($request->shipping_name) ? $request->shipping_name : $request->name;
        $shipping->email = ($request->shipping_email) ? $request->shipping_email : $request->email;
        $shipping->phone = ($request->shipping_phone) ? $request->shipping_phone : $request->mobile;
        $shipping->region = ($request->shipping_region) ? $request->shipping_region : $request->region;
        $shipping->city = ($request->shipping_city) ? $request->shipping_city : $request->city;
        $shipping->area = ($request->shipping_area) ? $request->shipping_area : $request->area;
        $shipping->address = ($request->ship_address) ? $request->ship_address : $request->address;
        $update = $shipping->save();

        if($update){
            Toastr::success('Shipping address update successful.');
        }else{
            Toastr::error("Shipping address update failed.");
        }
        return redirect()->back();
    }

    public function shippingAddressDelete($id)
    {
        $shipping_addresse = ShippingAddress::where('id',$id)->where('user_id', Auth::id())->delete();
        if($shipping_addresse){
            $output = [
                'status' => true,
                'msg' => 'Shipping address deleted successful.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Shipping address  delete failed.'
            ];
        }
        return response()->json($output);
    }

        //change order shipping method
    public function changeShippingAddress(Request $request, $orderId){
        $data['order'] = Order::where('order_id', $orderId)->first();
        if($data['order']){
            if($request->isMethod('post')){
                $state = State::where('id', $request->shipping_region )->first()->name;
                $city = City::where('id', $request->shipping_city )->first()->name;
                $area = Area::where('id', $request->shipping_area )->first()->name;

                $data['order']->shipping_name = $request->shipping_name;
                $data['order']->shipping_phone = $request->shipping_phone;
                $data['order']->shipping_email = $request->shipping_email;
                $data['order']->shipping_region = $state;
                $data['order']->shipping_city = $city;
                $data['order']->shipping_area = $area;
                $data['order']->shipping_address = $request->shipping_address;
                $data['order']->save();
            }else{
                $data['states'] = State::where('country_id', config('siteSetting.country'))->where('status', 1)->get();
                $data['cities'] = City::join('states', 'cities.state_id', 'states.id')
                    ->where('states.name', $data['order']->shipping_region)->select('cities.*')->get();
                $data['areas'] = Area::join('cities', 'areas.city_id', 'cities.id')
                    ->where('cities.name', $data['order']->shipping_city)->select('areas.*')->get();
                return view('users.shipping.getShippingAddress')->with($data);
            }
        }
        Toastr::success('Shipping address update success.');
        return redirect()->back();
    }
}
