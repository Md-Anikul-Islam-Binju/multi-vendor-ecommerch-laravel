<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\SubModule;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::with('sub_modules')
            ->where('parent_id', null)
        ->orderBy('position', 'asc')
        ->get();
        Session::forget('modules');
        return view('admin.module.module')->with(compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'module_name' => 'required',
        ]);

        $data = new Module();
        $data->module_name = $request->module_name;
        $data->slug = Str::slug($request->module_name);
        $data->route = ($request->route) ? $request->route : null;
        $data->icon = ($request->icon ? $request->icon : 'fa fa-align-left');
        $data->status = ($request->status ? 1 : 0);
        $store = $data->save();
        if($store){
            Toastr::success('Module create successful.');
        }else {
            Toastr::erro('Module create failed.');
        }
        return back();
    }

    public function edit($id)
    {
        $data = Module::find($id);
        echo view('admin.module.module-edit')->with(compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'module_name' => 'required',
        ]);

        $user_id = Auth::guard('admin')->id();
        $data = Module::find($request->id);
        $data->module_name = $request->module_name;
        if($request->route){
        $data->route = ($request->route) ? $request->route : null;
        }
        $data->icon = ($request->icon ? $request->icon : 'fa fa-align-left');
        $data->updated_by = $user_id;
        $data->status = ($request->status ? 1 : 0);
        $store = $data->save();
        if($store){
            Toastr::success('Module update successful.');
        }else {
            Toastr::erro('Module update failed.');
        }

        return back();
    }

    public function delete($id)
    {
        $delete = Module::find($id);
        if($delete){
            $delete->delete();
            $output = [
                'status' => true,
                'msg' => 'Module deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Module cannot deleted.'
            ];
        }
        return response()->json($output);
    }

    //sub module store
    public function submoduleStore(Request $request)
    {
        $request->validate([
            'module_id' => 'required',
            'submodule_name' => 'required',
        ]);
        Session::put("module_id", $request->module_id);
        $data = new Module();
        $data->parent_id = $request->module_id;
        $data->module_name = $request->submodule_name;
        $data->slug = Str::slug($request->submodule_name);
        $data->route = ($request->route) ? $request->route : null;
        $data->is_hidden_sidebar = ($request->is_hidden_sidebar) ? 1 : null;
        $data->is_hidden_role_permission = ($request->is_hidden_role_permission) ? 1 : null;
        $data->status = ($request->status ? 1 : 0);
        $store = $data->save();
        if($store){
            Toastr::success('Module create successful.');
        }else {
            Toastr::erro('Module create failed.');
        }
        return back();
    }

    public function submoduleEdit($id)
    {
        $data = SubModule::find($id);
        echo view('admin.module.submodule-edit')->with(compact('data'));
    }

    public function submoduleUpdate(Request $request)
    {
        $request->validate([
            'submodule_name' => 'required',
        ]);
        $user_id = Auth::guard('admin')->id();
        $data = SubModule::find($request->id);
        $data->submodule_name = $request->submodule_name;
        if($request->route){
        $data->route = ($request->route) ? $request->route : null;
        }
        if($request->is_hidden_sidebar){
            $data->is_hidden_sidebar = ($request->is_hidden_sidebar) ? 1 : null;
        }
        if($request->is_hidden_role_permission){
            $data->is_hidden_role_permission = ($request->is_hidden_role_permission) ? 1 : null;
        }
        $data->updated_by = $user_id;
        $data->status = ($request->status ? 1 : 0);
        $store = $data->save();
        if($store){
            Toastr::success('Module update successful.');
        }else {
            Toastr::erro('Module update failed.');
        }

        return back();
    }
    public function submoduleDelete($id)
    {
        $delete = SubModule::find($id);
        if($delete){
            $delete->delete();
            $output = [
                'status' => true,
                'msg' => 'Module deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Module cannot deleted.'
            ];
        }
        return response()->json($output);
    }
}
