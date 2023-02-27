<?php

namespace App\Http\Controllers\User;

use App\Mail\EmailVerifyMail;
use App\Models\SiteSetting;
use App\Models\Notification;
use App\Traits\CreateSlug;
use App\Traits\Sms;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserRegController extends Controller
{
    use Sms;
    use CreateSlug;
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function RegisterForm() {
        return view('users.register');
    }
    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|unique:users|min:11|numeric|regex:/(01)[0-9]/',
            'password' => 'required|min:6'
        ]);

        //user account verification sms
        $account_activation = SiteSetting::where('type', 'customer_account_activation')->first();

        if($request->email || ( $account_activation->status == 1 && $account_activation->value == 'email')){
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
        }

        //check customer registration active
        $registration = SiteSetting::where('type', 'customer_registration')->first();
        if ($registration->status == 0) {
            return back()->with('error', 'Registration is closed by Admin');
        }
        //check google robot reCaptcha
        $reCaptcha = SiteSetting::where('type', 'google_recaptcha')->first();
        if($reCaptcha->status == 1 && isset($_POST['g-recaptcha-response'])){
            $secretKey = $reCaptcha->secret_key;
            $captcha = $_POST['g-recaptcha-response'];
            if(!$captcha){
                Toastr::error('Please check the robot check.');
                return back();
            }
            $ip = $_SERVER['REMOTE_ADDR'];
            $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
            $responseKeys = json_decode($response,true);
            if(intval($responseKeys["success"]) !== 1) {
                Toastr::error('Please check the robot check.');
                return back();
            }
        }

        $mobile = trim($request->mobile);
        $email = trim($request->email);
        $password = trim($request['password']);

        $username = $this->createSlug('users', $request->name, 'username');
        $username = trim($username, '-');
        $code = rand(1111,9999);
        $user = new User;
        $user->name = $request->name;
        $user->username = $username;
        $user->email =  $email;
        $user->mobile = $mobile;
        $user->mobile_verification_token = $code;
        $user->email_verification_token = Str::random(32);
        $user->password = Hash::make($password);
        $user->updated_at = Carbon::now()->addHours(1);
        $user->activation = ($account_activation->status == 1) ? 0 : 1;
        $success = $user->save();

        if($success) {
            $fieldType = ($request->email ? 'email' : 'mobile');
            $emailOrMobile = ($request->email ? $request->email : $request->mobile);

            Cookie::queue('emailOrMobile',$mobile, time() + (86400));
            Cookie::queue('password', $password, time() + (86400));
            //insert notification in database
            Notification::create([
                'type' => 'register',
                'fromUser' => Auth::id(),
                'toUser' => null,
                'item_id' => Auth::id(),
                'notify' => 'register new user',
            ]);
            Toastr::success('Registration in success.');

            if($account_activation->status == 1 ) {
                if ($mobile && $account_activation->value == 'sms') {
                    $msg = 'Thank you for registering with ' . $_SERVER['SERVER_NAME'] . '. Account verification code is: ' . $code;
                    $this->systemMessage($mobile, $msg);
                    $url = route('userAccountVerify') . '?mobile=' . $mobile;
                    return redirect($url)->with('error', $user->name . ' your account is not active. Please verify your ' . $fieldType . ', verification code has been sent to your ' . $fieldType . '.');
                }
                if($email && $account_activation->value == 'email'){
                    //send notification in email
                    Mail::to($email)->send(new EmailVerifyMail($user));
                    if (count(Mail::failures()) > 0) {
                        return redirect()->back()->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
                    } else {
                        $url = route('userAccountVerify') . '?email=' . $email;
                        return redirect($url)->with('error', $user->name . ' your account is not activated. Please verify your email, verification link has been sent to your email address.');
                    }
                }
            }

            if (Auth::attempt([$fieldType => $emailOrMobile, 'password' => $password])) {
                //send registration success mobile notify
                if(Auth::user()->mobile){
                    $customer_mobile = Auth::user()->mobile;
                    $msg = 'Hello '.Auth::user()->name.', Thank you for registering with '.$_SERVER['SERVER_NAME'].'.';
                    $this->systemMessage($customer_mobile, $msg);
                }

                if(Session::has('redirectLink')){
                    return redirect(Session::get('redirectLink'));
                }
                return redirect()->intended(route('user.dashboard'));
            }

        }else{
            Toastr::error('Registration failed try again.');
            return back()->withInput();
        }
    }

    public function resendVerifyToken(Request $request){

        $input = $request->all();

        $this->validate($request, [
            'token' => 'required',
        ]);
        $token = trim($input['token']);

        $fieldType = filter_var($request->token, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        $user = User::where($fieldType,$token)->first();
        if($user) {
            if ($user->activation == 1){
                return back()->with('error', 'Your account already verified.');
            }
            if ($fieldType == 'email') {
                $user->email_verification_token = Str::random(32);
                $user->mobile_verification_token = null;
                $user->updated_at = Carbon::now()->addHours(1);
                $user->save();
                //send notification in email
                Mail::to($user->email)->send(new EmailVerifyMail($user));
                if (count(Mail::failures()) > 0) {
                    return redirect()->back()->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
                } else {
                    return redirect()->back()->with('status', trans('Account verification link has been sent to your email address.'));
                }
            } elseif ($fieldType == 'mobile') {
                $this->validate($request, [
                    'token' => 'min:11|numeric|regex:/(01)[0-9]/',
                ]);
                $code = rand(1111, 9999);
                $user->mobile_verification_token = $code;
                $user->email_verification_token = null;
                $user->updated_at = Carbon::now()->addHours(1);
                $user->save();

                if ($user) {
                    $msg = Config::get('siteSetting.site_name') . ' Account verification code is: ' . $code;
                    $response = $this->systemMessage($user->mobile, $msg);
                    $url = route('userAccountVerify') . '?mobile=' . $user->mobile;
                    return redirect($url)->with('status', trans('Account verification code has been sent to your mobile number.'));
                } else {
                    return redirect()->back()->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
                }
            } else {
                return redirect()->back()->withErrors(['token' => trans('User does not exist')]);
            }
        }
        return redirect()->back()->withErrors(['token' => trans('User does not exist')]);
    }

    public function userAccountVerify(Request $request){
        $user = null;
        if($request->mobile && $request->otp_code){
            $this->validate($request, [
                'mobile' => 'min:11|numeric|regex:/(01)[0-9]/',
            ]);
            $user = User::where('status', 1);
            $user->where('mobile', $request->mobile);
            $user->where('mobile_verification_token', $request->otp_code);
            $user = $user->first();

            if($user){
                if($user->activation ==1){
                    return back()->with('error', 'Your account already verified.');
                }
                if($user->updated_at <= Carbon::now()){
                    return back()->with('error', 'Session token has expired.');
                }
                $user->activation = 1;
                $user->mobile_verification_token = null;
                $user->mobile_verified_at = Carbon::now();
                $user->save();
                return redirect()->route('login')->with('status', 'Your account is activated, You can login now.');
            }else{
                return redirect()->back()->withErrors(['otp_code' => trans('Invalid verification code.')]);
            }
        }
        elseif($request->email && $request->token){
            $request->validate([
                'email' => 'required|email',
            ]);
            $user = User::where('status', 1);
            $user->where('email', $request->email);
            $user->where('email_verification_token', $request->token);
            $user = $user->first();
            if($user){
                if($user->updated_at <= Carbon::now()){
                    return back()->with('error', 'Session token has expired.');
                }
                $user->activation = 1;
                $user->email_verification_token = null;
                $user->email_verified_at = Carbon::now();
                $user->save();
                return redirect()->route('login')->with('status', 'Your account is activated, You can login now.');
            }else{
                return redirect()->back()->withErrors(['token' => trans('Invalid email address or token.')]);
            }
        }
        else{
            if($request->all()){
                $fieldType = filter_var($request->token, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
                $user = User::where($fieldType, $request->$fieldType)->first();
                if ($user && $user->activation == 1){
                    return back()->with('error', 'Your account already verified.');
                }
                return view('users.verify-account');
            }else{
                return view('404');
            }
        }
    }


}
