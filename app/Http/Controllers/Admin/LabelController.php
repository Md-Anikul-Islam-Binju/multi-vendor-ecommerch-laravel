<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Models\Services;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class LabelController extends Controller
{
    use CreateSlug;
    public function index()
    {
        $labels = Label::orderBy('position', 'asc')->get();
        return view('admin.label.label')->with(compact('labels'));
    }

    // Services store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'order_no' => 'required'
        ]);

        $data = new Label();
        $data->name = $request->name;
        $data->order_no = $request->order_no;
        $data->notes = ($request->notes ? $request->notes : null);
        $data->status = ($request->status ? 1 : 0);

        //if label image set
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $new_image_name = $this->uniqueImagePath('labels', 'image', $image->getClientOriginalName());
            $image->move(public_path('upload/images/label'), $new_image_name);
            $data->image = $new_image_name;
        }
        $store = $data->save();

        if($store){
            Toastr::success('Label added successful.');
        }else{
            Toastr::error('Label cannot added.!');
        }

        return back();
    }

    //Edit services
    public function edit($id)
    {
        $data = Label::find($id);
        echo view('admin.label.labelEdit')->with(compact('data'));
    }
    // Update service
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'order_no' => 'required'
        ]);

        $data = Label::find($request->id);
        $data->name = $request->name;
        $data->order_no = $request->order_no;
        $data->notes = ($request->notes ? $request->notes : null);
        $data->status = ($request->status ? 1 : 0);

        //if feature image set
        if ($request->hasFile('image')) {
            //delete image from folder
            $image_path = public_path('upload/images/label/'. $data->image);
            if(file_exists($image_path) && $data->image){
                unlink($image_path);
            }
            $image = $request->file('image');
            $new_image_name = $this->uniqueImagePath('labels', 'image', $image->getClientOriginalName());
            $image->move(public_path('upload/images/label'), $new_image_name);
            $data->image = $new_image_name;
        }
        $store = $data->save();

        if($store){
            Toastr::success('Label update successfully.');
        }else{
            Toastr::error('Label cannot update.!');
        }
        return back();
    }

    //Delete service
    public function delete($id)
    {
        $services = Label::find($id);

        if($services){
            $image_path = public_path('upload/images/label/'. $services->image);
            if(file_exists($image_path)){
                unlink($image_path);
            }
            $services->delete();
            $output = [
                'status' => true,
                'msg' => 'Label deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Label cannot deleted.'
            ];
        }
        return response()->json($output);
    }
}
