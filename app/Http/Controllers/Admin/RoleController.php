<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Role;
use App\Models\RolePermission;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use function GuzzleHttp\Psr7\str;

class RoleController extends Controller
{

    public function index()
    {
        $get_data = Role::orderBy('id', 'asc')->get();
        return view('admin.role.role')->with(compact('get_data'));
    }

    public function create()
    {
        $get_data = Role::orderBy('id', 'asc')->get();

        return view('admin.role')->with(compact('get_data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $data = [
            'name' => $request->name,
            'notes' => $request->notes,
            'slug' => str::slug($request->name),
            'status' => ($request->status ? 1 : 0)
        ];

        $store = Role::create($data);
        if($store){
            Toastr::success('Role created successful.');
        }else{
            Toastr::error('Role connot created.');
        }
        return back();
    }

    public function edit($id)
    {
        $data = Role::find($id);
        echo view('admin.edit.role')->with(compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $data = [
            'name' => $request->name,
            'notes' => $request->notes,
            'status' => ($request->status ? 1 : 0)
        ];

        $update = Role::where('id', $request->id);
        if(!Auth::guard('admin')->check()){
            $update->where('created_by', Auth::guard('vendor')->id());
        }
        $update = $update->update($data);
        if($update){
            Toastr::success('Role update successful.');
        }else{
            Toastr::error('Role connot update.');
        }
        return back();
    }

    public function delete($id)
    {
        $delete = Role::where('id', $id);

        if(!Auth::guard('admin')->check()){
            $delete->where('created_by', Auth::guard('vendor')->id());
        }
        $delete = $delete->delete();
        if($delete){
            $output = [
                'status' => true,
                'msg' => 'Role deleted successful.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Role cannot deleted.'
            ];
        }
        return response()->json($output);
    }

    public function permissionIndex($slug)
    {
        $role = Role::where('slug', $slug)->select('name','id')->first();

        if($role){
            $role_id = $role->id;
            $modules = Module::with(['sub_modules' => function ($query){
                    $query->where('is_hidden_role_permission', null);
                },
                'sub_modules.rolePermission' => function ($query) use ($role_id) {
                $query->where('role_id', '=', $role_id); }])
                ->orderBy('position', 'asc')->where('parent_id', null)
                ->get()->toArray();

            return view('admin.role.rolePermission')->with(compact('modules','role'));
        }
        return back();
    }

    public function permissionStore(Request $request){
        //dd($request->all());
        $user_id = Auth::guard('admin')->id();
        foreach($request->modules as $module){
            if($module) {
                $permission_id = $request->permission_id[$module];
                $permission[] = [
                    'id' => $permission_id,
                    'role_id' => $request->role_id,
                    'module_id' => $module,
                    'is_view' => (isset($request->is_view[$module]) && $request->is_view[$module]) ? 1 : 0,
                    'is_add' => (isset($request->is_add[$module]) && $request->is_add[$module]) ? 1 : 0,
                    'is_edit' => (isset($request->is_edit[$module]) && $request->is_edit[$module]) ? 1 : 0,
                    'is_delete' => (isset($request->is_delete[$module]) && $request->is_delete[$module]) ? 1 : 0,
                    'created_by' => $user_id,
                    'updated_by' => $user_id,
                ];
            }
        }

        RolePermission::upsert($permission, ['id'], ['is_view', 'is_add', 'is_edit', 'is_delete', 'updated_by']);
        //The first argument inserted / updated, second set uniqueBy, third (optional) set specific update column: upsert(array $values, $uniqueBy, $update = null)
        Toastr::success('Role permission update successful.');
        return back();
    }
}
