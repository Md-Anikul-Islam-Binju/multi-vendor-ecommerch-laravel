<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\User;
use App\Vendor;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
	public function dashboard(){
        $data= [];

        $data['newUser'] = User::where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->count();
        $data['allUser'] = User::count();
        $data['allSeller'] = Vendor::count();
        $data['pendingSeller'] = Vendor::where('status', 'pending')->count();

        $data['popularProducts'] = Product::orderBy('views', 'desc')->take(5)->get();
        $data['recentOrders'] = Order::where('payment_method', '!=', 'pending')->orderBy('id', 'desc')->take(5)->get();

        $data['allProducts'] = Product::count();
        $data['pendingProducts'] = Product::where('status', 'pending')->count();
        $data['outOfStock'] = Product::where('stock', '<=', 0)->count();
        $data['rejectProducts'] = Product::where('status', 'reject')->count();
        $data['allOrders'] = Order::where('payment_method', '!=', 'pending')->count();
        $data['pendingOrders'] = Order::where('payment_method', '!=', 'pending')->where('order_status', 'pending')->count();
        $data['completeOrders'] = Order::where('order_status', 'delivered')->count();
        $data['rejectOrders'] = Order::where('order_status', 'cancel')->count();
        $data['categories'] = Category::count();
        $data['brands'] = Brand::count();

        return view('admin.dashboard')->with($data);

    }

    public function profileEdit(){
	    return view('admin.setting.profile');
    }
    //profile update
    public function profileUpdate(Request $request){

        if(env('MODE') == 'demo'){
            Toastr::error('Demo mode on edit/delete not working');
            return back();
        }
	    $admin_id  = Auth::guard('admin')->id();
	    $request->validate([
	        'name' => 'required',
	        'username' => 'required',
	        'mobile' => 'required',
	        'email' => ['email','unique:admins,email,'.$admin_id],
        ]);

	    $profile = Admin::find($admin_id);
        $profile->name = $request->name;
        $profile->username = $request->username;
        $profile->mobile = $request->mobile;
        $profile->email = $request->email;

        if ($request->hasFile('phato')) {
            //delete image from folder
            $image_path = public_path('assets/images/users/'. $profile->photo);
            if(file_exists($image_path) && $profile->photo){
                unlink($image_path);
            }
            $image = $request->file('phato');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();

            $image_path = public_path('assets/images/users/' . $new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(250, 250);
            $image_resize->save($image_path);
            $profile->photo = $new_image_name;
        }
        $profile->save();
	    Toastr::success('Profile update success');
	    return back();
    }

    //change Password
    public function passwordChange(Request $request){
        return view('admin.setting.change-password');
    }
    //password update
    public function passwordUpdate(Request $request){
        if(env('MODE') == 'demo'){
            Toastr::error('Demo mode on edit/delete not working');
            return back();
        }
        $user_id  = Auth::guard('admin')->id();
        $check = Admin::find($user_id);
        if($check) {
            $this->validate($request, [
                'old_password' => 'required',
                'password' => 'required|confirmed:min:6'
            ]);

            $old_password = $check->password;
            if (Hash::check($request->old_password, $old_password)) {
                if (!Hash::check($request->password, $old_password)) {
                    $user = Admin::find($user_id);
                    $user->password = Hash::make($request->password);
                    $user->save();
                    Toastr::success('Password successfully change.', 'Success');
                    return redirect()->back();
                } else {
                    Toastr::error('New password cannot be the same as old password.', 'Error');
                    return redirect()->back();
                }
            } else {
                Toastr::error('Old password not match', 'Error');
                return redirect()->back();
            }
        }else{
            Toastr::error('Sorry your password can\'t change.', 'Error');
            return redirect()->back();
        }
    }
    //reset password all user
    public function resetPassword(Request $request){
        DB::table($request->table)->where('id', $request->id)->update(['password' => Hash::make($request->password)]);
        Toastr::success('Password reset successful.', 'Success');
        return redirect()->back();
    }
}
