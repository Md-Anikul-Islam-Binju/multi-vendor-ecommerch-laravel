<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\RefundReason;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class RefundReasonController extends Controller
{

    public function refundConfig(){
        return view('admin.refund.returnConfigure');
    }

    //return lists
    public function index()
    {
        $return_reasons = RefundReason::all();

        return view('admin.refund.returnReason')->with(compact('return_reasons'));
    }

    //insert return reason
    public function store(Request $request)
    {
        $reason = new RefundReason();
        $reason->reason = $request->title;
        $reason->status = ($request->status) ? 1 : 0;
        $store = $reason->save();
        Toastr::success('Refund Reason Insert Success.');
        return back();
    }

    //edit reason
    public function edit($id)
    {
        $data = RefundReason::find($id);
        echo view('admin.refund.reasonEdit')->with(compact('data'));
    }
    //update data
    public function update(Request $request)
    {
        $reason = RefundReason::find($request->id);
        $reason->reason = $request->title;
        $reason->status = ($request->status) ? 1 : 0;
        $store = $reason->save();
        Toastr::success('Refund Reason update Success.');
        return back();

    }

    //delate reason
    public function delete($id)
    {
        $reason = RefundReason::where('id', $id)->delete();

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
