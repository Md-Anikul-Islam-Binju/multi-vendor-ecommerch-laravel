<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Social;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Session;

class SocialController extends Controller
{
    public function socialSetting()
    {
        $socials = Social::where('type', 'admin')->orderBy('position', 'asc')->get();
        return view('admin.setting.social')->with(compact('socials'));
    }
    public function socialSettingStore(Request $request)
    {
        $name_icon = explode('*', $request->social_name);
        $social = new Social();
        $social->type = 'admin';
        $social->social_name = $name_icon[0];
        $social->icon = $name_icon[1];
        $social->link = $request->link;
        $social->background = $request->background_color;
        $social->text_color = $request->text_color;
        $social->status = ($request->status) ? 1 : 0;
        $social->save();
        Toastr::success('Insert success');
        return back();
    }
    public function socialSettingEdit($id){
        $social = Social::find($id);
        return view('admin.setting.social-edit');
    }
    public function socialSettingUpdate(Request $request, $id)
    {
        $social = Social::find($id);
        $social->icon = $request->icon;
        $social->link = $request->link;
        $social->background = $request->background;
        $social->text_color = $request->text_color;
        $social->save();
        Toastr::success('Update success');
        return back();
    }

    public function socialSettingDelete($id){
        $social = Social::find($id);

        if($social){
            $social->delete();
            $output = [
                'status' => true,
                'msg' => 'Item deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Item cannot deleted.'
            ];
        }
        return response()->json($output);

    }

    public function socialLoginSetting()
    {
        return view('admin.setting.social-login');
    }

}
