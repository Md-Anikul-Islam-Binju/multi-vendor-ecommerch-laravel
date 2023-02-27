<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategorySection;
use App\Models\Product;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CategorySectionController extends Controller
{
    use CreateSlug;
    public function index()
    {
        $data['categories'] = Category::where('parent_id', null)->orderBy('name', 'asc')->get();
        $data['categorySections'] = CategorySection::orderBy('position', 'asc')->get();
        return view('admin.category_section.index')->with($data);
    }
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
        ]);
        $section = new CategorySection();
        $section->title = $request->title;
        $section->sub_title = $request->sub_title;
        $section->category_id = $request->category_id;
        $section->subcategory_id = implode(',', $request->subcategory_id);
        $section->background_color = $request->background_color;
        $section->text_color = $request->text_color;
        $section->is_feature = ($request->is_feature ? 1 : 0);
        $section->status = ($request->status ? 1 : 0);
        $store = $section->save();
        if($store){
            Toastr::success('Category section added successfully.');
        }else{
            Toastr::error('Category section can\'t added.');
        }

        return back();
    }



    public function edit($id)
    {

        $data['categories'] = Category::where('parent_id', null)->orderBy('name', 'asc')->get();
        $data['section'] = CategorySection::where('id', $id)->first();
        $data['subcategories'] = Category::with('get_subchild_category')->where('parent_id', $data['section']->category_id)->orderBy('name', 'asc')->get();

        return view('admin.category_section.edit')->with($data);

    }


    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required'
        ]);
        $section = CategorySection::find($request->id);
        $section->title = $request->title;
        $section->sub_title = $request->sub_title;
        $section->category_id = $request->category_id;
        $section->subcategory_id = implode(',', $request->subcategory_id);
        $section->background_color = $request->background_color;
        $section->text_color = $request->text_color;
        $section->is_feature = ($request->is_feature ? 1 : 0);
        $section->status = ($request->status ? 1 : 0);
        $store = $section->save();
        if($store){
            Toastr::success('Category section update successfully.');
        }else{
            Toastr::error('Category section update failed.');
        }

        return back();
    }

    public function delete($id)
    {
        $section = CategorySection::find($id);

        if($section){
            $section->delete();
            $output = [
                'status' => true,
                'msg' => 'Category section deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Category section cannot deleted.'
            ];
        }
        return response()->json($output);
    }

    public function getSubChildcategory (Request $request){
        $output = '';
        $subcategories = Category::with('get_subchild_category')->where('parent_id', $request->category_id)->orderBy('name', 'asc')->get();
        foreach($subcategories as $subcategory) {
            $output .= ' <option value="' . $subcategory->id . '">' . $subcategory->name .'('. count($subcategory->productsBySubcategory). ')</option>';
            if (count($subcategory->get_subchild_category) > 0) {
                foreach ($subcategory->get_subchild_category as $child_category) {
                    $output .= ' <option value="' . $child_category->id . '">--' . $child_category->name .'('. count($child_category->productsByChildCategory). ')</option>';
                }
            }
        }
        echo $output;
    }

}
