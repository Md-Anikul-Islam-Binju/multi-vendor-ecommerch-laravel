<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    use CreateSlug;

    public function index()
    {
        $data['get_data'] = Brand::orderBy('position', 'asc')->paginate(25);
        return view('admin.brand')->with($data);
    }
    // store brand
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
        ]);
        $data = new Brand();
        $data->category_id = $request->category_id;
        $data->name = $request->name;
        //$data->details = $request->details;
        $data->slug = $this->createSlug('brands', $request->name);
        $data->status = ($request->status ? 1 : 0);

        if ($request->hasFile('phato')) {
            $image = $request->file('phato');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();

            $image_path = public_path('upload/images/author/' . $new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(120, 120);
            $image_resize->save($image_path);

//            $image->move(public_path('upload/images/brand'), $new_image_name);

            $data->logo = $new_image_name;
        }

        $store = $data->save();
        if($store){
            Toastr::success('User Create Successful.');
        }else{
            Toastr::error('User Cannot Create.!');
        }

        return back();
    }

    //edit brand
    public function edit($id)
    {
      
        $data['data'] = Brand::find($id);
        echo view('admin.edit.brand')->with($data);
    }

    //update brand
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
        ]);
        $data = Brand::find($request->id);
        $data->category_id = $request->category_id;
         $data->details = $request->details;
        $data->name = $request->name;
        $data->status = ($request->status ? 1 : 0);

        if ($request->hasFile('phato')) {
            //delete image from folder
            $image_path = public_path('upload/images/author/'. $data->logo);
            if(file_exists($image_path) && $data->logo){
                unlink($image_path);
//                unlink(public_path('upload/images/brand/'. $data->logo));
            }
            $image = $request->file('phato');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();

            $image_path = public_path('upload/images/author/' . $new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(120, 120);
            $image_resize->save($image_path);

//            $image->move(public_path('upload/images/brand'), $new_image_name);

            $data->logo = $new_image_name;
        }

        $store = $data->save();
        if($store){
            Toastr::success('Author Update Successful.');
        }else{
            Toastr::error('Author Cannot Update.!');
        }

        return back();
    }


    public function delete($id)
    {
        $delete = Brand::where('id', $id)->first();

        if($delete){
            $image_path = public_path('upload/images/author/'. $delete->logo);
            if(file_exists($image_path) && $delete->logo){
                unlink($image_path);
//                unlink(public_path('upload/images/author/'. $delete->logo));
            }
            $delete->delete();

            $output = [
                'status' => true,
                'msg' => 'Author deleted successful.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Author cannot deleted.'
            ];
        }
        return response()->json($output);
    }


}
