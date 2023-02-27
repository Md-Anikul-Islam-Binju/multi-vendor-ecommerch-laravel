<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class UserLoginController extends Controller
{
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

        if(auth()->attempt(array($fieldType => $emailOrMobile, 'password' => $password)))
        {
            if(Auth::user()->activation != '1') {
                $url = route('userAccountVerify').'?'.$fieldType.'='.$emailOrMobile;
                return redirect($url)->with('error', Auth::user()->name. ' your account is not activated. Please verify '.$fieldType.', verification code has been sent to your '.$fieldType.'.');
            }
            if(Auth::user()->status != '1') {
                  Toastr::error(Auth::user()->name. ' your account is deactive.');
                  Auth::logout();
                  return back()->withInput();
              }

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

            if(Session::has('redirectLink')){
                return redirect(Session::get('redirectLink'));
            }
            Toastr::success('Logged in success.');
            return redirect()->back();
      }else{
          Toastr::error( $fieldType. ' or password is invalid.');
          return back()->withInput();
      }
    }

    public function logout() {
      Auth::logout();
      Toastr::success('Just Logged Out!');
      return redirect()->route('login');
    }
}
