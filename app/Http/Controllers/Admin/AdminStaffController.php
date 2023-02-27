<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Traits\Sms;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class AdminStaffController extends Controller
{
    use Sms;
    public function staffList(Request $request, $status= ''){
        $staffs  = Admin::where('role_id', 'staff');
        if($request->status && $request->status != 'all'){
            $staffs->where('status', $request->status);
        }if($request->name && $request->name != 'all') {
            $keyword = $request->name;
            $staffs->where(function ($query) use ($keyword) {
                $query->orWhere('name', 'like', '%' . $keyword . '%');
                $query->orWhere('mobile', 'like', '%' . $keyword . '%');
                $query->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }
        $data['staffs']  = $staffs->orderBy('id', 'desc')->paginate(15);
        $data['designations'] = [];
        return view('admin.staff.staff')->with($data);
    }

    public function staffProfile($username){
        $data['staff']  = Admin::where('username', $username)->first();
        return view('admin.staff.profile')->with($data);
    }

    public function staffSecretLogin($id)
    {
        $user = Admin::findOrFail(decrypt($id));
        auth()->guard('admin')->login($user, true);
        Toastr::success('Staff panel login success.');
        return redirect()->route('admin.dashboard');
    }
    public function delete($id){
        $user = Admin::find($id);
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
