<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SiteSettingController extends Controller
{
    //site all configuration
    public function siteSettings(Request $request){
        $siteSettings = SiteSetting::orderBy('position', 'asc')->get();
        return view('admin.setting.site-setting')->with(compact('siteSettings'));
    }

    //update site value
    public function siteSettingUpdate(Request $request){

        $data = $request->except('_token', 'type');
        foreach($data as $field => $value) {
            SiteSetting::where('type', $request->type)->update([$field => $value]);
        }
        if(request()->isMethod('get')) {
            $output = array(
                'status' => 'success',
                'msg' => 'Value set successful.'
            );
            return response()->json($output);
        }
        Toastr::success('Update success');
        return back();
    }

    //site status Active/Deactive change function
    public function siteSettingActiveDeactive(Request $request){

        $status = DB::table('site_settings')->where('type', $request->field)->first();
        $field =  $request->field;
        if($status){
            if($status->status == 1){
                DB::table('site_settings')->where('type', $request->field)->update(['status' => 0]);
            }else{
                DB::table('site_settings')->where('type', $request->field)->update(['status' => 1]);
            }
            $output = array( 'status' => true, 'message' => str_replace('_', ' ', $field). ' update successful.');
        }else{
            $output = array( 'status' => false, 'message' => str_replace('_', ' ', $field). ' can\'t update.!');
        }
        return response()->json($output);
    }

    //google recaptcha view & configure
    public function google_recaptcha(Request $request){
        //update reCaptcha
        if(request()->isMethod('get')){
            $google_recaptcha = SiteSetting::where('type', 'google_recaptcha')->first();
            return view('admin.setting.google_recaptcha')->with(compact('google_recaptcha'));
        }

        $google_recaptcha = SiteSetting::find($request->id);
        if($google_recaptcha){
            $google_recaptcha->public_key = $request->recaptcha_site_key;
            $google_recaptcha->secret_key = $request->recaptcha_secret_key;
            $google_recaptcha->save();
        }

        Toastr::success('Google recaptcha update success.');
        return back();
    }

    //otp view & configurations
    public function otp_configurations(Request $request)
    {
        $otp_configure = SiteSetting::where('type', 'otp_configurations')->first();
        if(request()->isMethod('post')){
            //active tap
            Session::put('activeTap', $request->otp_method);
            //otp method active && use set use for
            $otp_configure->value = $request->otp_method;
            $otp_configure->value2 = implode(',', $request->user_for);
            $otp_configure->save();
        }
        return view('admin.setting.otp_configurations')->with(compact('otp_configure'));
    }

    //smtp view
    public function smtp_settings(Request $request)
    {
        return view('admin.setting.smtp_setting');
    }

    //update env key
    public function env_key_update(Request $request)
    {
        Session::put('activeTap', $request->activeTap);
        foreach ($request->types as $type => $value) {
            $this->overWriteEnvFile($type, $value);
        }

        Toastr::success('Update success');
        return back();
    }

    //env key over write helper method
    public function overWriteEnvFile($type, $val)
    {

        $path = base_path('.env');
        if (file_exists($path)) {
            $val = '"'.trim($val).'"';
            if(is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0){
                //replace & overwrite data
                $updateData =  str_replace( $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path) );
                file_put_contents($path, $updateData);
            }
            else{
                //insert new line
                file_put_contents($path, file_get_contents($path)."\r\n".$type.'='.$val);
            }
        }

    }
}
