<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Models\Social;
use App\Models\Upzilla;
use App\Models\Country;
use App\Models\SiteSetting;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class GeneralSettingController extends Controller
{
    use CreateSlug;
    public function __construct()
    {

        Session::forget('siteSetting');
        $setting = GeneralSetting::first();
        if(!$setting){
            GeneralSetting::create([
                'currency' => 'USD',
                'currency_symble' => '$'
            ]);
        }
    }

    //general Setting edit
    public function generalSetting()
    {
        $setting = GeneralSetting::first();
        $countries = Country::all();
        return view('admin.setting.general-setting')->with(compact('setting', 'countries'));
    }

    //general Setting update
    public function generalSettingUpdate(Request $request, $id)
    {
        $setting = GeneralSetting::find($id);

        if($setting){
            $setting->site_name = $request->site_name;
            $setting->site_owner = $request->site_owner;
            $setting->phone = $request->phone;
            $setting->email = $request->email;
            $setting->currency = $request->currency;
            $setting->currency_symble = $request->currency_symble;
            $setting->date_format = $request->date_format;
            $setting->country = $request->country;
            $setting->bg_color = $request->bg_color;
            $setting->text_color = $request->text_color;
            $setting->about = $request->about;
            $setting->address = $request->address;
            $setting->save();
            Toastr::success('Setting update success.');
        }else{
            Toastr::error('Sorry something went wrong try again.');
        }

        return back();
    }

    public function logoSetting()
    {
        $setting = GeneralSetting::selectRaw('id, logo,invoice_logo,favicon')->first();
        return view('admin.setting.logo')->with(compact('setting'));
    }

    public function logoSettingUpdate(Request $request, $id)
    {
        $setting = GeneralSetting::find($id);

        //if  logo set
        if ($request->hasFile('logo')) {
            //delete previous logo
            $get_logo = public_path('upload/images/logo/'. $setting->logo);
            if($setting->logo && file_exists($get_logo) ){
                unlink($get_logo);
            }
            $image = $request->file('logo');
            $new_image_name = $this->uniqueImagePath('general_settings', 'logo', $image->getClientOriginalName());
            $image->move(public_path('upload/images/logo'), $new_image_name);
            $setting->logo = $new_image_name;
        }
        //if invoice logo set
        if ($request->hasFile('invoice_logo')) {
            //delete previous logo
            $invoice_logo = public_path('upload/images/logo/'. $setting->invoice_logo);
            if($setting->invoice_logo && file_exists($invoice_logo)){
                unlink($invoice_logo);
            }
            $image = $request->file('invoice_logo');
            $new_image_name = 'invoice-'.$this->uniqueImagePath('general_settings', 'invoice_logo', $image->getClientOriginalName());

            $image_path = public_path('upload/images/logo/' . $new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(300, 100);
            $image_resize->save($image_path);
            $setting->invoice_logo = $new_image_name;
        }
        //if favicon set
        if ($request->hasFile('favicon')) {
            //delete previous logo
            $get_favicon = public_path('upload/images/logo/'. $setting->favicon);
            if($setting->favicon && file_exists($get_favicon)){
                unlink($get_favicon);
            }
            $image = $request->file('favicon');
            $new_image_name = 'favicon-'.$this->uniqueImagePath('general_settings', 'favicon', $image->getClientOriginalName());

            $image_path = public_path('upload/images/logo/' . $new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(32, 32);
            $image_resize->save($image_path);
            $setting->favicon = $new_image_name;
        }

        $setting->save();
        Toastr::success('Logo update sucess');
        return back();

    }


    public function headerSetting()
    {
        $setting = GeneralSetting::first();
        return view('admin.setting.header-setting')->with(compact('setting'));
    }


    public function headerSettingUpdate(Request $request, $id)
    {
        $setting = GeneralSetting::find($id);

        if(!$setting){
            Toastr::error('Sorry something went wrong try again.');
            return back();
        }
        $setting->header = $request->header;
        $setting->header_no = $request->header_no;
        $setting->header_bg_color = $request->header_bg_color;
        $setting->header_text_color = $request->header_text_color;
        $setting->save();

        Toastr::success('Header update success.');
        return back();
    }


    public function footerSetting()
    {
        $setting = GeneralSetting::first();
        return view('admin.setting.footer')->with(compact('setting'));
    }
    public function footerSettingUpdate(Request $request, $id)
    {
        $setting = GeneralSetting::find($id);

        if(!$setting){
            Toastr::error('Sorry something went wrong try again.');
            return back();
        }
        $setting->footer = $request->footer;
        $setting->footer_no = $request->footer_no;
        $setting->footer_bg_color = $request->footer_bg_color;
        $setting->footer_text_color = $request->footer_text_color;
        $setting->copyright_text = $request->copyright_text;
        $setting->copyright_bg_color = $request->copyright_bg_color;
        $setting->copyright_text_color = $request->copyright_text_color;
        $setting->save();
        Toastr::success('Footer update success.');
        return back();
    }

    public function googleSetting(Request $request)
    {
        //update google analytics
        if(request()->isMethod('get')){
            return view('admin.setting.google-config');
        }

        if(request()->isMethod('post')){
            Session::put('googleSettingTab', $request->googleSettingTab);
            //update analytics
            if($request->googleSettingTab == 'analytics'){
                $analytics = GeneralSetting::find($request->id);
                $analytics->google_analytics = $request->google_analytics;
                $analytics->google_adsense = $request->google_adsense;
                $analytics->save();
            }

            Toastr::success($request->googleSettingTab.' update success.');
        }
        return back();
    }


    public function seoSetting(Request $request)
    {
        //update reCaptcha
        if(request()->isMethod('get')){
            $setting = GeneralSetting::selectRaw('id, title,meta_keywords,description,meta_image')->first();;
            return view('admin.setting.seo-setting')->with(compact('setting'));
        }

        if(request()->isMethod('post')){
            $setting = GeneralSetting::find($request->id);
            $setting->title = $request->title;
            $setting->meta_keywords = ($request->meta_keywords) ? implode(',', $request->meta_keywords) : null;
            $setting->description = $request->description;
            //if  meta_image set
            if ($request->hasFile('meta_image')) {
                //delete previous meta_image
                $meta_image = public_path('upload/images/'. $setting->meta_image);
                if(file_exists($meta_image) && $setting->meta_image){
                    unlink($meta_image);
                }
                $image = $request->file('meta_image');
                $new_image_name = $this->uniqueImagePath('general_settings', 'meta_image', $request->title.'.'.$image->getClientOriginalExtension());
                $image->move(public_path('upload/images/'), $new_image_name);
                $setting->meta_image = $new_image_name;
            }
             $setting->save();
            Toastr::success('SEO setting update success.');
        }
        return back();
    }
}
