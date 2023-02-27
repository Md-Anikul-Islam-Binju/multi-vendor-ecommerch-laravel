<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordMail;
use App\Models\Reseller;
use App\Traits\Sms;
use App\User;
use App\Vendor;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    use Sms;
    use SendsPasswordResetEmails;

    public function passwordRecover(){
        return view('auth.passwords.email');

    }
    public function passwordRecoverNotify(Request $request){

        $input = $request->all();

        $this->validate($request, [
            'emailOrMobile' => 'required',
        ]);
        $emailOrMobile = trim($input['emailOrMobile']);

        $fieldType = filter_var($request->emailOrMobile, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        $user = User::where($fieldType,$emailOrMobile)->first();

        if(!$user){
            return redirect('password/reset')->withErrors(['emailOrMobile' => trans('User does not exist')]);
        }
        if($fieldType == 'email'){
            $user->email_verification_token = Str::random(32);
            $user->mobile_verification_token = null;
            $user->updated_at = Carbon::now()->addHours(1);
            $user->save();
            //send notification in email
            Mail::to($user->email)->send(new ForgotPasswordMail($user));
            if (count(Mail::failures()) > 0) {
                return redirect('password/reset')->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
            } else {
                return redirect('password/reset')->with('status', trans('Password reset link has been sent to your email address.'));
            }
        }
        else{
            $this->validate($request, [
                'emailOrMobile' => 'min:11|numeric|regex:/(01)[0-9]/',
            ]);
            $code = rand(1111,9999);
            $user->mobile_verification_token = $code;
            $user->email_verification_token = null;
            $user->updated_at = Carbon::now()->addHours(1);
            $user->save();

            if ($user) {
                $msg = Config::get('siteSetting.site_name'). ' Password reset verification code is: '.$code;
                 $response = $this->systemMessage($user->mobile,$msg);
                $url = 'password/reset?mobile='.$user->mobile;
                return redirect($url)->with('status', trans('Password reset verification code has been sent to your mobile number.'));
            } else {
                return redirect('password/reset')->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
            }
        }

        return redirect()->back()->withErrors(['emailOrMobile' => trans('User does not exist')]);
    }

    public function passwordRecoverVerify(Request $request){
        $user = null;

        if($request->email && $request->token){
            $request->validate([
                'email' => 'required|email',
            ]);
            $user = User::where('email', $request->email);
            $user->where('email_verification_token', $request->token);
            $user = $user->first();
            if($user){
                if($user->updated_at <= Carbon::now()){
                    return back()->with('error', 'Session token has expired.');
                }
                return view('auth.passwords.reset');
            }else{
                return redirect('password/reset')->withErrors(['emailOrMobile' => trans('Invalid email address or token.')]);
            }
        }
        elseif($request->mobile && $request->otp_code){
            $this->validate($request, [
                'mobile' => 'min:11|numeric|regex:/(01)[0-9]/',
            ]);
            $user = User::where('mobile', $request->mobile);
            $user->where('mobile_verification_token', $request->otp_code);
            $user = $user->first();
            if($user){
                if($user->updated_at <= Carbon::now()){
                    return back()->with('error', 'Session token has expired.');
                }
                return view('auth.passwords.reset');
            }else{
                return redirect()->back()->withErrors(['otp_code' => trans('Invalid verification code.')]);
            }
        }
        else{
            return redirect('password/reset')->with('error', 'Sorry Error occurred. Please try again.');
        }

    }

    public function passwordRecoverUpdate(Request $request)
    {
        //Validate input
       $request->validate([
           'password' => 'required|min:6|confirmed'
       ]);
        $user = null;
        if ($request->email && $request->token) {
            $request->validate([
                'email' => 'required|email',
            ]);
            $user = User::where('status', 1);
            $user->where('email', $request->email);
            $user->where('email_verification_token', $request->token);
            $user = $user->first();
            if($user){
                $user->password = Hash::make($request->password);
                $user->email_verification_token = null;
                $user->save();
                Toastr::success('Password change success.');
                return redirect('login');
            }
        }elseif($request->mobile && $request->otp_code) {
            $this->validate($request, [
                'mobile' => 'min:11|numeric|regex:/(01)[0-9]/',
            ]);
            $user = User::where('mobile', $request->mobile);
            $user->where('mobile_verification_token', $request->otp_code);
            $user = $user->first();
            if($user){
                $user->password = Hash::make($request->password);
                $user->mobile_verification_token = null;
                $user->save();
                Toastr::success('Password change success.');
                return redirect('login');
            }
        }else{
            return back()->withErrors(['error' => trans('Sorry invalid mobile or email address.')]);
        }
        return back()->withErrors(['error' => trans('Sorry invalid mobile or email address.')]);
    }




    //reseller password reset
    public function resellerPasswordRecover(){
        return view('reseller.passwords.reset-form');
    }
    public function resellerPasswordRecoverNotify(Request $request){

        $input = $request->all();

        $request->validate( [
            'emailOrMobile' => 'required',
        ]);

        $emailOrMobile = trim($input['emailOrMobile']);

        $fieldType = filter_var($request->emailOrMobile, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        $user = Reseller::where($fieldType,$emailOrMobile)->first();

        if(!$user){
            return redirect()->route('reseller.passwordRecover')->withErrors(['emailOrMobile' => trans('Reseller does not exist')]);
        }
        if($fieldType == 'email'){

            $user->email_verification_token = Str::random(32);
            $user->mobile_verification_token = null;
            $user->updated_at = Carbon::now()->addHours(1);
            $user->save();

            //send notification in email
            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            if (count(Mail::failures()) > 0) {
                return redirect('reseller/password/recover')->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
            } else {

                return redirect('reseller/password/recover')->with('status', trans('Password reset link has been sent to your email address.'));
            }
        }else{
            $this->validate($request, [
                'emailOrMobile' => 'min:11|numeric|regex:/(01)[0-9]/',
            ]);
            $code = rand(1111,9999);
            $user->mobile_verification_token = $code;
            $user->email_verification_token = null;
            $user->updated_at = Carbon::now()->addHours(1);
            $user->save();

            if ($user) {
                $msg = Config::get('siteSetting.site_name'). ' Password reset verification code is: '.$code;
                $response = $this->systemMessage($user->mobile,$msg);
                $url = 'reseller/password/recover?mobile='.$user->mobile;

                return redirect($url)->with('status', trans('Password reset verification code has been sent to your mobile number.'));
            } else {
                return redirect('reseller/password/recover')->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
            }
        }

        return redirect()->back()->withErrors(['emailOrMobile' => trans('User does not exist')]);
    }
    public function resellerPasswordRecoverVerify(Request $request){
        $user = null;

        if($request->email && $request->token){
            $request->validate([
                'email' => 'required|email',
            ]);
            $user = Reseller::where('status', 'active');
            $user->where('email', $request->email);
            $user->where('email_verification_token', $request->token);
            $user = $user->first();
            if($user){
                if($user->updated_at <= Carbon::now()){
                    return back()->with('error', 'Session token has expired.');
                }
                return view('reseller.passwords.reset');

            }else{
                return redirect()->route('reseller.passwordRecover')->withErrors(['emailOrMobile' => trans('Invalid email address or tokens.')]);
            }
        }elseif($request->mobile && $request->otp_code){
            $this->validate($request, [
                'mobile' => 'min:11|numeric|regex:/(01)[0-9]/',
            ]);
            $user = Reseller::where('status', 'active');
            $user->where('mobile', $request->mobile);
            $user->where('mobile_verification_token', $request->otp_code);
            $user = $user->first();
            if($user){
                if($user->updated_at <= Carbon::now()){
                    return back()->with('error', 'Session token has expired.');
                }
                return view('reseller.passwords.reset');
            }else{
                return redirect()->back()->withErrors(['otp_code' => trans('Invalid verification code.')]);
            }
        }else{
            return redirect()->route('reseller.passwordRecover')->with('error', 'Sorry Error occurred. Please try again.');
        }
    }


    public function resellerPasswordRecoverUpdate(Request $request)
    {
        //Validate input
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);
        $user = null;
        if($request->mobile && $request->otp_code) {
            $this->validate($request, [
                'mobile' => 'min:11|numeric|regex:/(01)[0-9]/',
            ]);
            $user = Reseller::where('status', 'active');
            $user->where('mobile', $request->mobile);
            $user->where('mobile_verification_token', $request->otp_code);
            $user = $user->first();
            if($user){
                $user->password = Hash::make($request->password);
                $user->mobile_verification_token = null;
                $user->save();
                Toastr::success('Password change success.');
                return redirect()->route('resellerLoginForm');
            }

        }elseif ($request->email && $request->token) {
            $request->validate([
                'email' => 'required|email',
            ]);
            $user = Reseller::where('status', 'active');
            $user->where('email', $request->email);
            $user->where('email_verification_token', $request->token);
            $user = $user->first();
            if($user){
                $user->password = Hash::make($request->password);
                $user->email_verification_token = null;
                $user->save();
                Toastr::success('Password change success.');
                return redirect()->route('resellerLoginForm');
            }
        }
        return back()->withErrors(['error' => trans('Sorry Reseller invalid OTP or User Not Found.')]);
    }



    //seller password reset

    public function sellerPasswordRecover(){
        return view('vendors.passwords.reset-form');
    }
    public function sellerPasswordRecoverNotify(Request $request){

        $input = $request->all();

        $this->validate($request, [
            'emailOrMobile' => 'required',
        ]);

        $emailOrMobile = trim($input['emailOrMobile']);

        $fieldType = filter_var($request->emailOrMobile, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        $user = Vendor::where($fieldType,$emailOrMobile)->first();

        if(!$user){
            return redirect('seller/password/recover')->withErrors(['emailOrMobile' => trans('Seller does not exist')]);
        }
        if($fieldType == 'email'){

            $user->email_verification_token = Str::random(32);
            $user->mobile_verification_token = null;
            $user->updated_at = Carbon::now()->addHours(1);
            $user->save();

            //send notification in email
            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            if (count(Mail::failures()) > 0) {
                return redirect('seller/password/recover')->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
            } else {

                return redirect('seller/password/recover')->with('status', trans('Password reset link has been sent to your email address.'));
            }
        }else{
            $this->validate($request, [
                'emailOrMobile' => 'min:11|numeric|regex:/(01)[0-9]/',
            ]);
            $code = rand(1111,9999);
            $user->mobile_verification_token = $code;
            $user->email_verification_token = null;
            $user->updated_at = Carbon::now()->addHours(1);
            $user->save();

            if ($user) {
                $msg = Config::get('siteSetting.site_name'). ' Password reset verification code is: '.$code;
                $response = $this->sendSms($user->mobile,$msg);
                $url = 'seller/password/recover?mobile='.$user->mobile;
                return redirect($url)->with('status', trans('Password reset verification code has been sent to your mobile number.'));
            } else {
                return redirect('seller/password/recover')->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
            }
        }

        return redirect()->back()->withErrors(['emailOrMobile' => trans('User does not exist')]);
    }

    public function sellerPasswordRecoverVerify(Request $request){
        $user = null;

        if($request->email && $request->token){
            $request->validate([
                'email' => 'required|email',
            ]);
            $user = Vendor::where('status', 'active');
            $user->where('email', $request->email);
            $user->where('email_verification_token', $request->token);
            $user = $user->first();
            if($user){
                if($user->updated_at <= Carbon::now()){
                    return back()->with('error', 'Session token has expired.');
                }
                return view('vendors.passwords.reset');
            }else{
              return redirect('seller/password/recover')->withErrors(['emailOrMobile' => trans('Invalid email address or token.')]);
            }
        }elseif($request->mobile && $request->otp_code){
            $this->validate($request, [
                'mobile' => 'min:11|numeric|regex:/(01)[0-9]/',
            ]);
            $user = Vendor::where('status', 'active');
            $user->where('mobile', $request->mobile);
            $user->where('mobile_verification_token', $request->otp_code);
            $user = $user->first();
            if($user){
                if($user->updated_at <= Carbon::now()){
                    return back()->with('error', 'Session token has expired.');
                }
                return view('vendors.passwords.reset');
            }else{
                return redirect()->back()->withErrors(['otp_code' => trans('Invalid verification code.')]);
            }
        }else{
            return redirect('seller/password/recover')->with('error', 'Sorry Error occurred. Please try again.');
        }
    }

    public function sellerPasswordRecoverUpdate(Request $request)
    {
        //Validate input
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);
        $user = null;
        if($request->mobile && $request->otp_code) {
            $this->validate($request, [
                'mobile' => 'min:11|numeric|regex:/(01)[0-9]/',
            ]);
            $user = Vendor::where('status', 'active');
            $user->where('mobile', $request->mobile);
            $user->where('mobile_verification_token', $request->otp_code);
            $user = $user->first();
            if($user){
                $user->password = Hash::make($request->password);
                $user->mobile_verification_token = null;
                $user->save();
                Toastr::success('Password change success.');
                return redirect()->route('vendorLoginForm');
            }
        elseif ($request->email && $request->token) {
            $request->validate([
                'email' => 'required|email',
            ]);
            $user = Vendor::where('status', 'active');
            $user->where('email', $request->email);
            $user->where('email_verification_token', $request->token);
            $user = $user->first();
            if($user){
                $user->password = Hash::make($request->password);
                $user->email_verification_token = null;
                $user->save();
                Toastr::success('Password change success.');
                return redirect()->route('vendorLoginForm');
            }
        }
        }else{
            return back()->withErrors(['error' => trans('Sorry invalid mobile or email address.')]);
        }
        return back()->withErrors(['error' => trans('Sorry invalid mobile or email address.')]);
    }



}
