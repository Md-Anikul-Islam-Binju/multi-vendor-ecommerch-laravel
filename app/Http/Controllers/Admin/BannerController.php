<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BannerImage;
use App\Models\Page;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    use CreateSlug;
    // Banner list
    public function index(Request $request)
    {
        $banners = Banner::leftJoin('pages', 'banners.page_name', 'pages.id');
            if($request->title){
                $keyword = $request->title;
                $banners->where(function ($query) use ($keyword) {
                    $query->orWhere('banners.title', 'like', '%' . $keyword . '%');
                    $query->orWhere('pages.title', 'like', '%' . $keyword . '%');
                    $query->orWhere('banners.page_name', 'like', '%' . $keyword . '%');
                });
            }
            if($request->page && $request->page != 'all'){
                $banners->where('pages.slug', $request->page);
            }
            $perPage = 15;
            if($request->show){
                $perPage = $request->show;
            }
        $banners = $banners->orderBy('position', 'asc')->select('banners.*', 'pages.title as page_title')->paginate($perPage);
        $pages = Page::orderBy('title', 'asc')->where('status', 1)->get();
        return view('admin.banners.banner')->with(compact('banners', 'pages'));
    }

    // store Banner
    public function store(Request $request)
    {
        $banner_type = ($request->banner_type) ? $request->banner_type : 1;
        $data = new Banner();
        $data->banner_type = $banner_type;
        $data->title = $request->title;
        $data->page_name = $request->page_name;
        $data->status = ($request->status ? 1 : 0);
        $data->created_by = Auth::guard('admin')->id();

        $width = 1200/$banner_type;
        //if feature image set
        if ($request->hasFile('banner1')) {
            $image = $request->file('banner1');
            $new_image_name = rand(0000, 9999).$image->getClientOriginalName();
//            $image_path = public_path('upload/images/banner/' . $new_image_name);
//            $image_resize = Image::make($image);
//            $image_resize->resize($width, 250);
//            $image_resize->save($image_path);
            $image->move(public_path('upload/images/banner/'), $new_image_name);

            $data->banner1 = $new_image_name;
            $data->btn_link1 = $request->btn_link1;
        }
        if ($request->hasFile('banner2')) {
            $image = $request->file('banner2');
            $new_image_name = rand(0000, 9999).$image->getClientOriginalName();
            // $image_path = public_path('upload/images/banner/' . $new_image_name);
            // $image_resize = Image::make($image);
            // $image_resize->resize($width, 250);
            // $image_resize->save($image_path);
            $image->move(public_path('upload/images/banner/'), $new_image_name);

            $data->banner2 = $new_image_name;
            $data->btn_link2 = $request->btn_link2;
        }
        if ($request->hasFile('banner3')) {
            $image = $request->file('banner3');
            $new_image_name = rand(0000, 9999).$image->getClientOriginalName();
            // $image_path = public_path('upload/images/banner/' . $new_image_name);
            // $image_resize = Image::make($image);
            // $image_resize->resize($width, 250);
            // $image_resize->save($image_path);
            $image->move(public_path('upload/images/banner/'), $new_image_name);

            $data->banner3 = $new_image_name;
            $data->btn_link3 = $request->btn_link3;
        }
        if ($request->hasFile('banner4')) {
            $image = $request->file('banner4');
            $new_image_name = rand(0000, 9999).$image->getClientOriginalName();
            // $image_path = public_path('upload/images/banner/' . $new_image_name);
            // $image_resize = Image::make($image);
            // $image_resize->resize($width, 250);
            // $image_resize->save($image_path);
            $image->move(public_path('upload/images/banner/'), $new_image_name);

            $data->banner4 = $new_image_name;
            $data->btn_link4 = $request->btn_link4;
        }

        if ($request->hasFile('banner5')) {
            $image = $request->file('banner5');
            $new_image_name = rand(0000, 9999).$image->getClientOriginalName();
            // $image_path = public_path('upload/images/banner/' . $new_image_name);
            // $image_resize = Image::make($image);
            // $image_resize->resize($width, 250);
            // $image_resize->save($image_path);
            $image->move(public_path('upload/images/banner/'), $new_image_name);

            $data->banner5 = $new_image_name;
            $data->btn_link5 = $request->btn_link5;
        }
        if ($request->hasFile('banner6')) {
            $image = $request->file('banner6');
            $new_image_name = rand(0000, 9999).$image->getClientOriginalName();
            // $image_path = public_path('upload/images/banner/' . $new_image_name);
            // $image_resize = Image::make($image);
            // $image_resize->resize($width, 250);
            // $image_resize->save($image_path);
            $image->move(public_path('upload/images/banner/'), $new_image_name);

            $data->banner6 = $new_image_name;
            $data->btn_link6 = $request->btn_link6;
        }

        $store = $data->save();

        if($store){
            Toastr::success('Banner added successfully.');
        }else{
            Toastr::error('Banner cannot added.!');
        }

        return back();
    }

    //Banner edit
    public function edit($id)
    {
        $data['data'] = Banner::find($id);
        $data['pages'] = Page::orderBy('title', 'asc')->where('status', 1)->get();
        echo view('admin.banners.editform')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $data = Banner::find($request->id);
        $data->title = $request->title;
        $data->page_name = $request->page_name;
        $data->status = ($request->status ? 1 : 0);
        $data->btn_link1 = $request->btn_link1;
        $data->btn_link2 = $request->btn_link2;
        $data->btn_link3 = $request->btn_link3;
        $data->btn_link4 = $request->btn_link4;
        $data->btn_link5 = $request->btn_link5;
        $data->btn_link6 = $request->btn_link6;

        $width = 1200/$data->banner_type;
        //if feature image set
        if ($request->hasFile('banner1')) {
            $image = $request->file('banner1');
            $new_image_name = rand(0000, 9999).$image->getClientOriginalName();
//            $image_path = public_path('upload/images/banner/' . $new_image_name);
//            $image_resize = Image::make($image);
//            $image_resize->resize($width, 250);
//            $image_resize->save($image_path);
            $image->move(public_path('upload/images/banner/'), $new_image_name);

            $data->banner1 = $new_image_name;

        }
        if ($request->hasFile('banner2')) {
            $image = $request->file('banner2');
            $new_image_name = rand(0000, 9999).$image->getClientOriginalName();
            // $image_path = public_path('upload/images/banner/' . $new_image_name);
            // $image_resize = Image::make($image);
            // $image_resize->resize($width, 250);
            // $image_resize->save($image_path);
            $image->move(public_path('upload/images/banner/'), $new_image_name);

            $data->banner2 = $new_image_name;

        }
        if ($request->hasFile('banner3')) {
            $image = $request->file('banner3');
            $new_image_name = rand(0000, 9999).$image->getClientOriginalName();
            // $image_path = public_path('upload/images/banner/' . $new_image_name);
            // $image_resize = Image::make($image);
            // $image_resize->resize($width, 250);
            // $image_resize->save($image_path);
            $image->move(public_path('upload/images/banner/'), $new_image_name);
            $data->banner3 = $new_image_name;

        }
        if ($request->hasFile('banner4')) {
            $image = $request->file('banner4');
            $new_image_name = rand(0000, 9999).$image->getClientOriginalName();
           // $image_path = public_path('upload/images/banner/' . $new_image_name);
            // $image_resize = Image::make($image);
            // $image_resize->resize($width, 250);
            // $image_resize->save($image_path);
            $image->move(public_path('upload/images/banner/'), $new_image_name);
            $data->banner4 = $new_image_name;
        }
        if ($request->hasFile('banner5')) {
            $image = $request->file('banner5');
            $new_image_name = rand(0000, 9999).$image->getClientOriginalName();
           // $image_path = public_path('upload/images/banner/' . $new_image_name);
            // $image_resize = Image::make($image);
            // $image_resize->resize($width, 250);
            // $image_resize->save($image_path);
            $image->move(public_path('upload/images/banner/'), $new_image_name);
            $data->banner5 = $new_image_name;
        } if ($request->hasFile('banner6')) {
            $image = $request->file('banner6');
            $new_image_name = rand(0000, 9999).$image->getClientOriginalName();
           // $image_path = public_path('upload/images/banner/' . $new_image_name);
            // $image_resize = Image::make($image);
            // $image_resize->resize($width, 250);
            // $image_resize->save($image_path);
            $image->move(public_path('upload/images/banner/'), $new_image_name);
            $data->banner6 = $new_image_name;
        }

        $update = $data->save();


        if($update){
            Toastr::success('Banner update successfully.');
        }else{
            Toastr::error('Banner cannot update.!');
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        $banner = Banner::find($id);
        if($banner){
            for ($i=1; $i <= $banner->banner_type; $i++) {
                $banner_image = 'banner'.$i;
                $image_path = public_path('upload/images/banner/' . $banner->$banner_image);
                if ($banner->$banner_image && file_exists($image_path)) {
                    unlink($image_path);
                }
            }
            $banner->delete();
            $output = [
                'status' => true,
                'msg' => 'Banner deleted successful.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Item cannot deleted.'
            ];
        }
        return response()->json($output);
    }

    public function bannerImage_delete(Request $request){
        $bannerImage = Banner::find($request->id);
        $imageNo = 'banner'.$request->imageNo;

        if($bannerImage) {
            $image_path = public_path('upload/images/banner/' . $bannerImage->$imageNo);
            if ( $bannerImage->$imageNo && file_exists($image_path)) {
                unlink($image_path);
            }
            $bannerImage->$imageNo = null;
            $bannerImage->save();
            $output = [
                'status' => true,
                'msg' => 'Banner image deleted successful.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Banner can\'t deleted.'
            ];
        }
        return response()->json($output);
    }

}
