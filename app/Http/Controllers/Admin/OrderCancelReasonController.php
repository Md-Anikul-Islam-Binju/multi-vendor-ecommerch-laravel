<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderCancelReason;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class OrderCancelReasonController extends Controller
{
    //order cancel reason lists
    public function orderCancelReason()
    {
        $reasons = OrderCancelReason::where('order_id', null)->get();
        return view('admin.order.cancel-reason')->with(compact('reasons'));
    }

    //insert return reason
    public function reasonStore(Request $request)
    {
        $reason = new OrderCancelReason();
        $reason->reason = $request->reason;
        $reason->status = ($request->status) ? 1 : 0;
        $reason->user_type = ($request->user_type) ? 1 : 'customer';
        $store = $reason->save();
        Toastr::success('Order Cancel Reason Insert Success.');
        return back();
    }

    //edit reason
    public function reasonEdit($id)
    {
        $data = OrderCancelReason::find($id);
        echo view('admin.order.cancel-reason-edit')->with(compact('data'));
    }
    //update data
    public function reasonUpdate(Request $request)
    {
        $reason = OrderCancelReason::find($request->id);
        $reason->reason = $request->reason;
        $reason->status = ($request->status) ? 1 : 0;
        $store = $reason->save();
        Toastr::success('Order Cancel Reason update Success.');
        return back();

    }

    //delate reason
    public function reasonDelete($id)
    {
        $reason = OrderCancelReason::where('id', $id)->delete();

        if($reason){
            $output = [
                'status' => true,
                'msg' => 'Reason deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Reason cannot deleted.'
            ];
        }
        return response()->json($output);
    }

}
