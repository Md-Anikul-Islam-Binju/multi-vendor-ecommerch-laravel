<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Traits\CreateSlug;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    use CreateSlug;

    //view page lists
    public function index()
    {
        $pages = Page::orderBy('position', 'asc')->get();
        return view('admin.pages.page-lists')->with(compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.pages');
    }

    //create new page
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        //insert page
        $data  = new Page();
        $data->title = $request->title;
        $data->slug = $this->createSlug('pages', $request->slug);
        $data->description = $request->page_dsc;
        $data->meta_title = $request->meta_title;
        $data->meta_keywords = ($request->meta_keywords) ? implode(',', $request->meta_keywords) : null;
        $data->meta_description = $request->meta_description;
        $data->top_header = ($request->top_header ? 1 : null);
        $data->main_header = ($request->main_header ? 1 : null);
        $data->footer = ($request->footer ? 1 : null);
        $data->status = ($request->status ? 1 : 0);
        $data->created_by = Auth::guard('admin')->id();
        //if  meta_image set
        if ($request->hasFile('meta_image')) {
            $image = $request->file('meta_image');
            $new_image_name = rand(0000, 9999).$image->getClientOriginalName();
            $image->move(public_path('upload/pages/'), $new_image_name);
            $data->meta_image = $new_image_name;
        }
        $store = $data->save();

        if($store){
            Toastr::success('Page Create Successfully.');
        }else{
            Toastr::success('Page Can\'t Create.');
        }
        return back();
    }

    // View edit data by item ID
    public function edit($slug)
    {
        $data['data'] = Page::where('slug', $slug)->first();
        echo view('admin.pages.page-edit')->with($data);
    }

    //update page
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $data  = Page::find($id);
        $data->title = $request->title;
        $data->description = $request->page_dsc;
        $data->meta_title = $request->meta_title;
        $data->meta_keywords = ($request->meta_keywords) ? implode(',', $request->meta_keywords) : null;
        $data->meta_description = $request->meta_description;
        $data->top_header = ($request->top_header ? 1 : null);
        $data->main_header = ($request->main_header ? 1 : null);
        $data->footer = ($request->footer ? 1 : null);
        $data->status = ($request->status ? 1 : 0);
        $data->updated_by = Auth::guard('admin')->id();
        //if  meta_image set
        if ($request->hasFile('meta_image')) {
            //delete previous meta_image
            $meta_image = public_path('upload/pages/'. $data->meta_image);
            if(file_exists($meta_image) && $data->meta_image){
                unlink($meta_image);
            }
            $image = $request->file('meta_image');
            $new_image_name = rand(0000, 9999).$image->getClientOriginalName();
            $image->move(public_path('upload/pages/'), $new_image_name);
            $data->meta_image = $new_image_name;
        }
        $data->save();
        Toastr::success('Page Update Successfully.');

        return back();
    }

    // Delete page
    public function delete($id)
    {
        $delete = Page::where('id', $id)->delete();

        if($delete){
            $output = [
                'status' => true,
                'msg' => 'Page deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Page cannot deleted.'
            ];
        }
        return response()->json($output);
    }

    //get slug by title
    public function getSlug(Request $request)
    {
        echo $this->createSlug('pages', $request->title);
    }

    // Status change function
    public function status($status){
        $status = Page::find($status);
        if($status){
            if($status->status == 1){
                $status->update(['status' => 0]);
                $output = array( 'status' => 'unpublish',  'message'  => 'Page Unpublished');
            }else{
                $status->update(['status' => 1]);
                $output = array( 'status' => 'publish',  'message'  => 'Page Published');
            }
        }
        return response()->json($output);
    }

    // Change menu status
    public function MenuStatus(Request $request, $id){
        $status = Page::find($id);
        if($request->type == 'header'){
            if($status->show_header != null){
                $status->update(['show_header' => $request->status]);
                $output = array( 'status' => 'remove',  'message'  => 'Remove From Menu');
            }else{
                $status->update(['show_header' => $request->status]);
                $output = array( 'status' => 'added',  'message'  => 'Added To Menu');
            }
        }else{
            if($status->show_footer != null){
                $status->update(['show_footer' => $request->status]);
                $output = array( 'status' => 'remove',  'message'  => 'Remove From Menu');
            }else{
                $status->update(['show_footer' => $request->status]);
                $output = array( 'status' => 'added',  'message'  => 'Added To Menu');
            }
        }

        return response()->json($output);
    }
}
