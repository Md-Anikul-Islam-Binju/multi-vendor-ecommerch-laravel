<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Order;
use App\Models\Reseller;
use App\Models\ShippingAddress;
use App\Models\State;
use App\Traits\CreateSlug;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;
class UserController extends Controller
{
    use CreateSlug;
    public function dashboard()
    {
        $user_id = Auth::id();
        $data['profile'] = User::find($user_id);
        $data['orders'] = Order::with(['order_details.product:id,title,slug,feature_image'])->where('user_id', $user_id)->orderBy('id', 'desc')->where('payment_method', '!=', 'pending')->take(10)->get();
        return view('users.dashboard')->with($data);  
    }
    //my account form 
    public function myAccount()
    {
        $data['user'] = User::find(Auth::id());
        $data['states'] = State::where('country_id', config('siteSetting.country'))->where('status', 1)->get();
        $data['cities'] = City::where('state_id', $data['user']->region )->where('status', 1)->get();
        $data['areas'] = Area::where('city_id', $data['user']->city )->where('status', 1)->get();
        return view('users.my-account')->with($data);
    }

    
    //update user profile
    public function profileUpdate(Request $request){
        if(env('MODE') == 'demo'){
            Toastr::error('Demo mode on edit/delete not working');
            return back();
        }
        $request->validate([
            'name' => 'required',
            'mobile' => ['required','unique:users,mobile,'.Auth::id()],
            'email' => ['required','email','max:255','unique:users,email,'.Auth::id()],
        ]);
        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->birthday= $request->birthday;
        $user->blood = $request->blood;
        $user->gender = $request->gender;
        $user->user_dsc = $request->user_dsc;
        $update =$user->save();
        if($update){
            Toastr::success('Your profile update successful.');
        }else{
            Toastr::error('Sorry profile can\'t update.');
        }
        return back();
    }
    //change profile image
    public function changeProfileImage(Request $request){
        $this->validate($request, [
            'profileImage' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);
        if (Auth::guard('reseller')->check())
        {
            $user = Reseller::find(Auth::guard('reseller')->id());
        }else{
            $user = User::find(Auth::id());

        }

        //profile image
        if ($request->hasFile('profileImage')) {
            //delete image from folder
            $getimage_path = public_path('upload/users/'. $user->photo);
            if(file_exists($getimage_path) && $user->photo){
                unlink($getimage_path);
            }
            $image = $request->file('profileImage');

            if (Auth::guard('reseller')->check()){

            $new_image_name = $this->uniqueImagePath('resellers', 'photo', $image->getClientOriginalName());
            }else{

            $new_image_name = $this->uniqueImagePath('users', 'photo', $image->getClientOriginalName());
            }

            $image_path = public_path('upload/users/' . $new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(150, 150);
            $image_resize->save($image_path);
            $user->photo = $new_image_name;
            $user->save();
            Toastr::success('Your profile image update success.');
            return back();
        }
        Toastr::error('Please select any image');
        return back();
    }
    //update payment address
    public function addressUpdate(Request $request){
        $request->validate([
            'region' => 'required',
            'city' => ['required'],
            'area' => ['required'],
            'address' => ['required'],
        ]);
        $user = User::find(Auth::id());
        $user->region = $request->region;
        $user->city = $request->city;
        $user->area = $request->area;
        $user->address= $request->address;
        $update = $user->save();
        if($update){
            Toastr::success('Your address update successful.');
        }else{
            Toastr::error('Sorry address can\'t update.');
        }
        return back();
    }
    //change password form
    public function changePasswordForm(Request $request){
        return view('users.password-change');
    }
    //change password
    public function changePassword(Request $request){
        if(env('MODE') == 'demo'){
            Toastr::error('Demo mode on edit/delete not working');
            return back();
        }
        $check = User::where('id', Auth::id())->first();
        if($check) {
            $this->validate($request, [
                'old_password' => 'required',
                'password' => 'required|confirmed:min:6'
            ]);

            $old_password = $check->password;
            if (Hash::check($request->old_password, $old_password)) {
                if (!Hash::check($request->password, $old_password)) {
                    $user = User::find(Auth::id());
                    $user->password = Hash::make($request->password);
                    $user->save();
                    Toastr::success('Password change successful.', 'Success');
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
            Toastr::error('Sorry your password cann\'t change.', 'Error');
            return redirect()->back();
        }
    }

}
