<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class LocationController extends Controller
{

    public function country()
    {
        $data['countries'] = Country::all();
        return view('admin.location.country')->with($data);
    }

    public function country_store(Request $request)
    {
        $request->validate([
            'sortname' => 'required',
            'name' => 'required',
            'phonecode' => 'required',

        ]);

        $data = new Country();
        $data->name = trim($request->name);
        $data->slug = Str::slug($request->name);
        $data->sortname = $request->sortname;
        $data->phonecode = $request->phonecode;

        $store = $data->save();
        if($store){
            Toastr::success('State created successfully.');
        }else{
            Toastr::error('State cannot created.');
        }
        Session::put('autoSelectId', $request->country_id);
        return back();

    }

    public function country_edit($id)
    {

        $data['data'] = Country::find($id);
        echo view('admin.location.edit.country')->with($data);
    }

    public function country_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'sortname' => 'required',
            'phonecode' => 'required',
        ]);

        $data = Country::find($request->id);
        $data->name = $request->name;
        $data->sortname = $request->sortname;
        $data->phonecode = $request->phonecode;

        $store = $data->save();
        if($store){
            Toastr::success('State update successfully.');
        }else{
            Toastr::error('State cannot update.');
        }
        return back();
    }

    public function country_delete($id)
    {
        $delete = Country::where('id', $id)->delete();
        if($delete){
            $output = [
                'status' => true,
                'msg' => 'Item deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Item cannot deleted.'
            ];
        }
        return response()->json($output);
    }

    public function state()
    {
        $data['countries'] = Country::all();
        $data['states'] = State::orderBy('id', 'desc')->paginate(25);
        return view('admin.location.state')->with($data);
    }

    public function state_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country_id' => 'required',
        ]);

        $data = new State();
        $data->name = trim($request->name);
        $data->slug = Str::slug($request->name);
        $data->country_id = $request->country_id;

        $store = $data->save();
        if($store){
            Toastr::success('State created successfully.');
        }else{
            Toastr::error('State connot created.');
        }
        Session::put('autoSelectId', $request->country_id);
        return back();

    }

    public function state_edit($id)
    {
        $data['countries'] = Country::all();
        $data['data'] = State::find($id);
        echo view('admin.location.edit.state')->with($data);
    }

    public function state_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country_id' => 'required',
        ]);

        $data = State::find($request->id);
        $data->name = $request->name;
        $data->country_id = $request->country_id;

        $store = $data->save();
        if($store){
            Toastr::success('State update successfully.');
        }else{
            Toastr::error('State connot update.');
        }
        return back();
    }

    public function state_delete($id)
    {
        $delete = State::where('id', $id)->delete();
        if($delete){
            $output = [
                'status' => true,
                'msg' => 'Item deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Item cannot deleted.'
            ];
        }
        return response()->json($output);
    }

    public function city()
    {
        $data['states'] = State::orderBy('name', 'asc')->get();
        $data['cities'] = City::orderBy('id', 'desc')->paginate(25);
        return view('admin.location.city')->with($data);
    }

    public function city_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'state_id' => 'required',
        ]);
        $city_name = explode('*', $request->name);

        for ($i=0; $i <count($city_name) ; $i++) {
            if($city_name[$i]){
                $data = new City();
                $data->name =  preg_replace('/\s+/', ' ', trim($city_name[$i]));
                $data->slug = Str::slug($city_name[$i]);
                $data->state_id = $request->state_id;
//                $data->status = ($request->status) ? 1 : 0;
                $store = $data->save();
            }
        }
        if($store){
            Toastr::success('City created successfully.');
        }else{
            Toastr::error('City connot created.');
        }
        Session::put('autoSelectId', $request->state_id);
        return back();

    }

    public function city_edit($id)
    {
        $data['states'] = State::all();
        $data['data'] = City::find($id);
        echo view('admin.location.edit.city')->with($data);
    }

    public function city_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'state_id' => 'required',
        ]);

        $data = City::find($request->id);
        $data->name = $request->name;
        $data->state_id = $request->state_id;
        $data->status = ($request->status) ? 1 : 0;
        $store = $data->save();
        if($store){
            Toastr::success('city update successfully.');
        }else{
            Toastr::error('city connot update.');
        }
        return back();
    }

    public function city_delete($id)
    {
        $delete = City::where('id', $id)->delete();
        if($delete){
            $output = [
                'status' => true,
                'msg' => 'Item deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Item cannot deleted.'
            ];
        }
        return response()->json($output);
    }

    public function area()
    {
        $data['cities'] = City::all();
        $data['areas'] = Area::orderBy('id', 'desc')->paginate(25);
        return view('admin.location.area')->with($data);
    }

    public function area_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'city_id' => 'required',
        ]);

        $area_name = explode('*', $request->name);

        for ($i=0; $i <count($area_name) ; $i++) {
            if($area_name[$i]){
                $data = new Area();
                $data->name = preg_replace('/\s+/', ' ', trim($area_name[$i]));
                $data->slug = Str::slug($area_name[$i]);
                $data->city_id = $request->city_id;
                $data->status = ($request->status) ? 1 : 0;
                $store = $data->save();
            }
        }
        if($store){
            Toastr::success('Area created successfully.');
        }else{
            Toastr::error('Area connot created.');
        }
        Session::put('autoSelectId', $request->city_id);
        return back();

    }

    public function area_edit($id)
    {
        $data['cities'] = City::all();
        $data['data'] = Area::find($id);
        echo view('admin.location.edit.area')->with($data);
    }

    public function area_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'city_id' => 'required',
        ]);

        $data = Area::find($request->id);
        $data->name = $request->name;
        $data->city_id = $request->city_id;
        $data->status = ($request->status) ? 1 : 0;
        $store = $data->save();
        if($store){
            Toastr::success('Area update successfully.');
        }else{
            Toastr::error('Area connot update.');
        }
        return back();
    }

    public function area_delete($id)
    {
        $delete = Area::where('id', $id)->delete();
        if($delete){
            $output = [
                'status' => true,
                'msg' => 'Item deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Item cannot deleted.'
            ];
        }
        return response()->json($output);
    }
}
