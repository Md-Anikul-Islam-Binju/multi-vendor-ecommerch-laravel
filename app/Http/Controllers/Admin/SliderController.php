<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use App\Traits\CreateSlug;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Brian2694\Toastr\Facades\Toastr;

class SliderController extends Controller
{
    use CreateSlug;
    // Slider list
    public function index()
    {
        $sliders = Slider::orderBy('position', 'asc')->get();
        return view('admin.slider.slider')->with(compact('sliders'));
    }

    // store slider
    public function store(Request $request)
    {

        $request->validate([
            'phato' => 'required|mimes:jpeg,jpg,png,gif'
        ]);

        $data = new Slider();
        $data->title = $request->title;
        $data->title_size = $request->title_size;
        $data->title_color = $request->title_color;
        $data->title_style = $request->title_style;
        $data->type = $request->type;
        $data->subtitle = $request->subtitle;
        $data->subtitle_size = $request->subtitle_size;
        $data->subtitle_color = $request->subtitle_color;
        $data->subtitle_style = $request->subtitle_style;
        $data->btn_text = $request->btn_text;
        $data->btn_link = $request->btn_link;
        $data->text_position = $request->text_position;
        $data->bg_color = $request->bg_color;
        $data->status = ($request->status ? 1 : 0);
        $data->created_by = Auth::id();

        //if feature image set
        if ($request->hasFile('phato')) {
            $image = $request->file('phato');
            $new_image_name = $this->uniqueImagePath('sliders', 'phato', $image->getClientOriginalName());

            // $image_path = public_path('upload/images/slider/' . $new_image_name);
            // $image_resize = Image::make($image);
            // $image_resize->resize(1350, 400);
            // $image_resize->save($image_path);

            $image->move(public_path('upload/images/slider/'), $new_image_name);

            $data->phato = $new_image_name;
        }

        $store = $data->save();

        if($store){
            Toastr::success('Slider added successfully.');
        }else{
            Toastr::error('Slider cannot added.!');
        }
       
        return back();
    }

    //Slider edit
    public function edit($id)
    {
        $data = Slider::find($id);
        echo view('admin.slider.editform')->with(compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $data = Slider::find($request->id);
        $data->title = $request->title;
        $data->title_size = $request->title_size;
        $data->title_color = $request->title_color;
        $data->title_style = $request->title_style;

        $data->subtitle = $request->subtitle;
        $data->subtitle_size = $request->subtitle_size;
        $data->subtitle_color = $request->subtitle_color;
        $data->subtitle_style = $request->subtitle_style;
        $data->btn_text = $request->btn_text;
        $data->btn_link = $request->btn_link;
        $data->text_position = $request->text_position;
        $data->bg_color = $request->bg_color;
        $data->status = ($request->status ? 1 : 0);
        $data->updated_by = Auth::id();

        //if feature image set
        if ($request->hasFile('phato')) {
            //delete image from folder
            $image_path = public_path('upload/images/slider/'. $data->phato);
            if(file_exists($image_path) && $data->phato){
                unlink($image_path);
            }

            $image = $request->file('phato');
            $new_image_name = $this->uniqueImagePath('sliders', 'phato', $image->getClientOriginalName());

            // $image_path = public_path('upload/images/slider/' . $new_image_name);
            // $image_resize = Image::make($image);
            // $image_resize->resize(1350, 400);
            // $image_resize->save($image_path);

            $image->move(public_path('upload/images/slider/'), $new_image_name);

            $data->phato = $new_image_name;
        }

        $update = $data->save();
        if($update){
            Toastr::success('Slider update successfully.');
        }else{
            Toastr::error('Slider cannot update.!');
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        $slider = Slider::find($id);

        if($slider){
            $image_path = public_path('upload/images/slider/'. $slider->phato);
            if(file_exists($image_path)){
                unlink($image_path);
            }
            $slider->delete();
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

}
