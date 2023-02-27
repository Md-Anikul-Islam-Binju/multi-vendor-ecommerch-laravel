<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Traits\Sms;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;

use App\Models\Notification;

use App\Models\Reseller;
use App\Models\GeneralSetting as GS;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;


use App\Traits\CreateSlug;


 class AuthController extends Controller{

    use CreateSlug;
    use Sms;
     public function __construct()
     {
         $this->middleware('guest:admin', ['except' => ['logout']]);
     }

     public function showLoginForm()
     {
        return view('reseller.auth.login');
     }
     public function showRegisterForm()
     {
        return view('reseller.auth.register');
     }

     public function login(Request $request)
     {
         //return dd($request);

         $request->validate([
            'emailOrMobile' => 'required',
            'password' => 'required',
        ]);


        $emailOrMobile = trim($request->emailOrMobile);
        $password = trim($request->password);
        //remember credentials
        Cookie::queue('resellerEmailOrMobile', $emailOrMobile, time() + (86400));
        Cookie::queue('resellerPassword', $password, time() + (86400));

        $fieldType = filter_var($request->emailOrMobile, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

      if(Auth::guard('reseller')->attempt(array($fieldType => $emailOrMobile, 'password' => $password)))
      {
          if (Auth::guard('reseller')->user()->status != 'active') {
              Auth::guard('reseller')->logout();
              Toastr::error('Your seller request is pending review by our team before being activated.');
              return back()->with('error', 'Your seller request is pending review by our team before being activated.');
          }
          Toastr::success('Logged in success.');
          //return "success";
          return redirect()->route('reseller.dashboard'); 
      }
      else {
        Toastr::error( $fieldType. ' or password is invalid.');
        //return $fieldType. " failed ".$password;
          return back()->withInput($request->all());
      }
     }




    public function register(Request $request) {



        $gs = GS::first();
        if ($gs->registration == 0) {
          Toastr::error('alert', 'Registration is closed by Admin');
          return back();
        }

    

        $validatedRequest = $request->validate([
            'shop_name' => 'required',
            'vendor_name' => 'required',
            'mobile' => 'required|min:11|numeric|regex:/(01)[0-9]/|unique:resellers',
            'password' => 'required|confirmed|min:6'
        ]);

        if($request->email){
            $request->validate([
               'email' => ['required', 'string', 'email', 'max:255', 'unique:resellers'],
            ]);
        }

        $mobile = trim($request->mobile);
        $email = trim($request->email);
        $password = trim($request['password']);

        $username = explode(' ', trim($request->shop_name))[0];
        $vendor = new Reseller;
        $vendor->shop_name = $request->shop_name;
        $vendor->slug = $this->createSlug('resellers', $request->shop_name);
        $vendor->vendor_name = $request->vendor_name;
        $vendor->username = $this->createSlug('vendors', $username, 'username');
        $vendor->email = $email;
        $vendor->mobile = $mobile;
        $vendor->country = $request->country;
        $vendor->link_address = $request->link_address;

        $vendor->address = $request->address;
        $vendor->email_verification_token = $gs->email_verification == 0 ? rand(1000, 9999):NULL;
        $vendor->mobile_verification_token = $gs->sms_verification == 0 ? rand(1000, 9999):NULL;

        $vendor->status = 'active';
        $vendor->password = Hash::make($password);
        $success = $vendor->save();

        if($success) {

            $emailOrMobile = ($request->email ? $request->email : $request->mobile);

            Cookie::queue('vendorEmailOrMobile',$mobile, time() + (86400));
            Cookie::queue('vendorPassword', $password, time() + (86400));

            //insert notification in database
            Notification::create([
                'type' => 'vendor-register',
                'fromUser' => $vendor->id, 
                'toUser' => 0,
                'item_id' => $vendor->id,
                'notify' => 'register new seller',
            ]);
            Toastr::success('Registration in success.');
            return back()->with('success', $request->vendor_name. ', your information will be reviewed by Admin. We will let you know about the update (after review) through Phone\Email once it\'s been checked!');

        }else{
            Toastr::error('Registration failed try again.');
            return back()->withInput();
        }

        Toastr::error('Registration failed try again.');
        return back()->withInput();
    }


     

    public function logout()
    {
      Auth::guard('reseller')->logout();
      Toastr::success('Just Logged Out!');
      return redirect()->route('home');
    }
 }
