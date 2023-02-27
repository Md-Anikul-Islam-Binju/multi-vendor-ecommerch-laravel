<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Order;
use App\Models\ReturnRequest;
use App\Models\ShippingCharge;
use App\Models\ShippingMethod;
use App\Models\State;
use App\Models\Transaction;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class ShippingMethodController extends Controller
{
    use CreateSlug;
    public function shipping_method()
    {
        $shipping_methods = ShippingMethod::orderBy('position', 'asc')->get();
        $locations = City::where('status', 1)->orderBy('name', 'asc')->get();
        return view('admin.shipping.shipping_method')->with(compact('shipping_methods', 'locations'));
    }
    //insert shipping
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cost' => 'required',
        ]);

        $data = new ShippingMethod();
        $data->location_id = ($request->location_id) ? json_encode($request->location_id) : '["all"]';
        $data->name = $request->name;
        $data->slug = $this->createSlug('shipping_methods', $request->name);
        $data->cost = $request->cost;
        $data->duration = $request->duration;
        $data->notes = $request->notes;
        $data->status = ($request->status ? 1 : 0);

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image_path = public_path('upload/images/shipping/' . $new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(90, 60);
            $image_resize->save($image_path);
            $data->logo = $new_image_name;
        }

        $store = $data->save();
        if($store){
            Toastr::success('Shipping Method Create Successful.');
        }else{
            Toastr::error('Shipping Method Cannot Create.!');
        }

        return back();
    }

    public function edit($id)
    {
        $data = ShippingMethod::find($id);
        $locations = City::where('status', 1)->orderBy('name', 'asc')->get();
        echo view('admin.shipping.edit.shipping_method')->with(compact('data', 'locations'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cost' => 'required',
        ]);

        $data = ShippingMethod::find($request->id);
        $data->location_id = ($request->location_id) ? json_encode($request->location_id) : '["all"]';
        $data->name = $request->name;
        $data->cost = $request->cost;
        $data->duration = $request->duration;
        $data->notes = $request->notes;
        $data->status = ($request->status ? 1 : 0);

        if ($request->hasFile('logo')) {
            //delete image from folder
            $image_path = public_path('upload/images/shipping/'. $data->logo);
            if(file_exists($image_path) && $data->logo){
                unlink($image_path);
            }
            $image = $request->file('logo');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image_path = public_path('upload/images/shipping/' . $new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(90, 60);
            $image_resize->save($image_path);
            $data->logo = $new_image_name;
        }

        $store = $data->save();
        if($store){
            Toastr::success('Shipping Method Create Successfully.');
        }else{
            Toastr::error('Shipping Method Cannot Create.!');
        }
        return back();
    }

    public function delete($id)
    {
        $shipping = ShippingMethod::find($id);

        if($shipping){
            $image_path = public_path('upload/images/shipping/'.$shipping->logo);
            if(file_exists($image_path) && $shipping->logo){
                unlink($image_path);
            }
            $shipping->delete();
            $output = [
                'status' => true,
                'msg' => 'Shipping deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Shipping cannot deleted.'
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
                $data['states'] = State::where('country_id', 18)->where('status', 1)->get();
                $data['cities'] = City::join('states', 'cities.state_id', 'states.id')
                    ->where('states.name', $data['order']->shipping_region)->select('cities.*')->get();
                $data['areas'] = Area::join('cities', 'areas.city_id', 'cities.id')
                    ->where('cities.name', $data['order']->shipping_city)->select('areas.*')->get();
                return view('admin.order.getShippingAddress')->with($data);
            }
        }
        Toastr::success('Shipping address update success.');
        return redirect()->back();
    }



    public function orderReturn(Request $request, Order $order){


            if($request->method() == 'POST'){

                try {
                    $request->validate([
                        'amount' => 'required'
                    ]);
                }catch (Exception $exception){
                    Toastr::error($exception->getMessage());
                }




                //try to find reseller
                $orderId = $order->id;

                //$order = Order::where('id', $orderId)->first();
                if ($order->user_type==2){
                    $resellerOrder = Order::with('reseller')->where('id', $orderId)->first();
                    $resellerOrder->reseller->decrement('wallet_balance', $request->input('amount'));
                    $resellerOrder->reseller->save();
                    Toastr::info($resellerOrder->reseller->shop_name."'s balance charged ".$request->input('amount'));
                }else{
                    $customerOrder = Order::with('customer')->where('id', $orderId)->first();
                    $customerOrder->customer->decrement('wallet_balance', $request->input('amount'));
                    $customerOrder->save();
                    Toastr::info($customerOrder->customer->username."'s balance charged ".$request->input('amount'));
                }

                $order->order_status = 'return';
                $order->save();
                Toastr::success("order Successfully return");


                Transaction::create([
                    'type' => 'returnCharge',
                    'notes' => 'Reduce balance for product return',
                    'payment_method' => 'wallet-balance',
                    'reseller_id' => $order->user_id,
                    'amount' => $request->input('amount'),
                    'status' => 'paid',
                    'created_by' => Auth::id()
                ]);
































//                $attributes = $request->validate(['order_id' => 'required', 'product' => 'required', 'reason' => 'nullable']);
//                $attributes['status'] = 0;
//                $attributes['products']=implode( ',', $request->input('product'));
//                if (ReturnRequest::create($attributes)){
//                    Toastr::success("success");
//                }
//                else{
//                    Toastr::error("failed");
//                }
                return back();
            }else{
                return view('admin.order.returnForm', compact('order'));
            }
    }
}
