<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Page;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{
    use CreateSlug;

    public function __construct(){
        Session::forget('menus');
    }

    public function index()
    {
        $data['menus'] = Menu::orderBy('position', 'asc')->get();
        return view('admin.menu.menu')->with($data);
    }
 

    public function store(Request $request)
    {

        $request->validate([
            'source_id' => 'required',
            'name' => 'required',
        ]);
        $data = new Menu();
        $data->name = $request->name;
        $data->slug = $this->createSlug('menus', $request->name);
        $data->menu_source = $request->menu_type;
        $data->source_id = implode(',', $request->source_id);
        $data->top_header = ($request->top_header ? 1 : null);
        $data->main_header = ($request->main_header ? 1 : null);
        $data->footer = ($request->footer ? 1 : null);
        $data->status = ($request->status ? 1 : 0);

        $store = $data->save();
        if($store){
            if($request->menu_type == 'category'){
               foreach ($request->source_id as $id){
                    $category = Category::find($id);
                    $category->menu_id = $data->id;
                    $category->save();
                }

            }elseif($request->menu_type == 'page'){
                foreach ($request->source_id as $id){
                    $category = Page::find($id);
                    $category->menu_id = $data->id;
                    $category->save();
                }
            }else{
                echo '';
            }

            Session::forget('menus');
            Toastr::success('Menu Create Successfully.');
        }else{
            Toastr::error('Menu Cannot Create.!');
        }

        return back();
    }


    public function edit($id)
    {
        $data['data'] = Menu::find($id);

        if ($data['data']->menu_source == 'category'){
            $data['getSources'] = Category::where('parent_id', '!=', null)->where('subcategory_id', null)->where('status', 1)->orderBy('name', 'asc')->get();
        }
        if ($data['data']->menu_source == 'page') {
            $data['getSources'] = Page::where('status', 1)->get();
        }
        echo view('admin.menu.menu-edit')->with($data);
    }


    public function update(Request $request)
    {
        $request->validate([
            'source_id' => 'required',
            'name' => 'required',
        ]);
        $data = Menu::find($request->id);
        $data->name = $request->name;
        $data->menu_source = $request->menu_type;
        $data->source_id = implode(',', $request->source_id);
        $data->top_header = ($request->top_header ? 1 : null);
        $data->main_header = ($request->main_header ? 1 : null);
        $data->footer = ($request->footer ? 1 : null);
        $data->status = ($request->status ? 1 : 0);

        $store = $data->save();
        if($store){
            if($request->menu_type == 'category'){
                foreach ($request->source_id as $id){
                    $category = Category::find($id);
                    $category->menu_id = $data->id;
                    $category->save();
                }

            }elseif($request->menu_type == 'page'){
                foreach ($request->source_id as $id){
                    $category = Page::find($id);
                    $category->menu_id = $data->id;
                    $category->save();
                }
            }else{
                echo '';
            }
            Session::forget('menus');
            Toastr::success('Menu Update Successfully.');
        }else{
            Toastr::error('Menu Cannot Update.!');
        }

        return back();
    }

    public function delete($id)
    {
        $delete = Menu::where('id', $id)->delete();
        Session::forget('menus');
        if($delete){

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

    public function getMenuSourch($type){
        $getSources = [];
        $output = '';
        if($type == 'category'){
            $categories = Category::with('get_subcategory')->where('parent_id', '!=', null)->where('subcategory_id', null)->orderBy('name', 'asc')->where('status', 1)->get();
            if(count($categories)>0){
                foreach ($categories as $source) {
                    $output .= ' <option value="'.$source->id.'">'.$source->name.'</option>';
                    if(count($source->get_subcategory)>0){

                        foreach($source->get_subcategory as $childcategory){
                            $output .= '<option value="'.$childcategory->id.'">&nbsp;&nbsp;-'.$childcategory->name.'</option>';

                        }
                    }
                }
            }
        }elseif($type == 'page'){
            $getSources = Page::where('status', 1)->get();
            if(count($getSources)>0){
                foreach ($getSources as $source) {
                    $output .= ' <option value="'.$source->id.'">'.$source->title.'</option>';
                }
            }
        }else{
            $output = '';
        }
        echo $output;
    }

}
