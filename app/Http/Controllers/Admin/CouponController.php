<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{

    public function index()
    {
        $get_coupons = Coupon::orderBy('id', 'desc')->get();
        return view('admin.coupon.coupon')->with(compact('get_coupons'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required',
            'type' => 'required',
            'amount' => 'required',
            'start_date' => 'required',
            'expired_date' => 'required',
            'notes' => 'max:225',
        ]);

        $data = new Coupon();
        $data->coupon_code = $request->coupon_code;
        $data->type = $request->type;
        $data->amount = $request->amount;
        $data->times = $request->times;
        $data->start_date = $request->start_date;
        $data->expired_date = $request->expired_date;
        $data->notes = $request->notes;
        $data->status = ($request->status ? 1 : 0);
        $data->created_by = Auth::id();
        $data->vendor_id = ($request->vendor_id ? $request->vendor_id : Auth::user()->vendor_id);
        $store = $data->save();
        if($store){
            Toastr::success('New Coupon Added Successfully.');
        }else{
            Toastr::error('Coupon Connot Added Successfully.');
        }
        return back();
    }


    public function edit($id)
    {
        $data = Coupon::find($id);
        echo view('admin.coupon.editform')->with(compact('data'));
    }

    public function update(Request $request)
    {
        Session::put('submitType', 'edit');
        $request->validate([
            'coupon_code' => ['required','unique:coupons,coupon_code,'.$request->id],
            'type' => 'required',
            'amount' => 'required',
            'start_date' => 'required',
            'expired_date' => 'required',
            'notes' => 'max:225',
        ]);

        $data = Coupon::find($request->id);
        $data->coupon_code = $request->coupon_code;
        $data->type = $request->type;
        $data->amount = $request->amount;
        $data->times = $request->times;
        $data->start_date = $request->start_date;
        $data->expired_date = $request->expired_date;
        $data->notes = $request->notes;
        $data->status = ($request->status ? 1 : 0);
        $data->updated_by = Auth::id();
        $update = $data->save();
        if($update){
            Toastr::success('Coupon Update Successfully.');
        }else{
            Toastr::error('Coupon Connot Update Successfully.');
        }
        return  redirect()->back();
    }


    public function delete($id)
    {
        $delete = Coupon::where('id', $id)->delete();
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
