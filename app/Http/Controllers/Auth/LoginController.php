<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Providers\RouteServiceProvider;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Config;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'emailOrMobile' => 'required',
            'password' => 'required',
        ]);
        $emailOrMobile = trim($input['emailOrMobile']);
        $password = trim($input['password']);
        //remember credentials
        Cookie::queue('emailOrMobile', $emailOrMobile, time() + (86400));
        Cookie::queue('password', $password, time() + (86400));
        $user_id = (Cookie::has('user_id') ? Cookie::get('user_id') :  Session::get('user_id'));

        $fieldType = filter_var($request->emailOrMobile, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        $user = User::where($fieldType, $emailOrMobile)->first();
        if($user){
            if($user->activation != '1') {
                $url = route('userAccountVerify').'?'.$fieldType.'='.$emailOrMobile;
                return redirect($url)->with('error', $user->name. ' your account is not activated. Please verify '.$fieldType.', verification code has been sent to your '.$fieldType.'.');
            }
            if($user->status != '1') {
                Auth::logout();
                return back()->with('error', $user->name. ' your account is deactive. Please contact with administrator.');
            }
            if(auth()->attempt(array($fieldType => $emailOrMobile, 'password' => $password)))
            {
                Cart::where('user_id', $user_id)->update(['user_id' => Auth::id()]);
                //check duplicate records
                $duplicateRecords = Cart::select('product_id')
                    ->where('user_id', Auth::id())
                    ->selectRaw( 'id, count("product_id") as occurences')
                    ->groupBy('product_id')
                    ->having('occurences', '>', 1)
                    ->get();
                //delete duplicate record
                foreach($duplicateRecords as $record) {
                    $record->where('id', $record->id)->delete();
                }

                Toastr::success('Logged in success.');
                if(Session::has('redirectLink')){
                    return redirect(Session::get('redirectLink'));
                }
                return redirect()->intended(route('user.dashboard'));
            }
        }
        Toastr::error( $fieldType. ' or password is invalid.');
        return back()->with('error', $fieldType. ' or password is invalid.');
    }

    public function logout() {
        Auth::logout();
        Toastr::success('Just Logged Out!');
        return redirect()->route('login');
    }
}
