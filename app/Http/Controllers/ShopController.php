<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\Slider;
use App\Models\State;
use App\Vendor;
use App\Models\HomepageSection;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shop(Request $request){
        $sellers = Vendor::where('status', 'active');
        //check search keyword
        if($request->src) {
            $sellers->where('shop_name', 'like', '%' . $request->src . '%');
        }
        if($request->state) {
            $sellers->where('state', $request->state);
        }if($request->city) {
            $sellers->where('city', $request->city);
        }if($request->area) {
            $sellers->where('area', $request->area);
        }
        $data['sellers'] = $sellers->paginate(12);
        if($request->filter){
            return view('frontend.shop.filter_shop')->with($data);
        }
        $data['page'] = Page::where('slug', \Request::segment(1))->where('status', 1)->first();
        $id = 0;
        if($data['page']){
            $id = $data['page']->id;
        }
        $data['states'] = State::where('country_id', 18)->get();
        $data['banners'] = Banner::where('page_name', 'all')->orWhere('page_name', $id)->get();

        return view('frontend.shop.shop')->with($data);
    }

    public function shop_details($shop_name){
        $data['sections'] = HomepageSection::where('status', 1)->orderBy('position', 'asc')->paginate(5);
        $data['seller'] = Vendor::with(['allproducts','reviews'])->where('slug', $shop_name)->first();
        return view('frontend.shop.shop_details')->with($data);
    }

    public function seller_products(Request $request, $shop_name, $catslug=null){
        $data['seller'] = Vendor::with(['allproducts','reviews'])->where('slug', $shop_name)->first();
        $products = Product::where('vendor_id', $data['seller']->id)->where('status', 'active');
        //check search keyword
        if ($request->q) {
            $keyword = $request->q;
            $products->where(function ($query) use ($keyword) {
                $query->orWhere('title', 'like', '%' . $keyword . '%');
                $query->orWhere('meta_keywords', 'like', '%' . $keyword . '%');
                $query->orWhere('summery', 'like', '%' . $keyword . '%');
                $query->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }

        if ($catslug) {
            $cat = Category::where('slug', $catslug)->first();
            if ($cat){
                $products->where(function ($query) use ($cat) {
                    $query->orWhere('category_id', $cat->id);
                    $query->orWhere('subcategory_id', $cat->id);
                    $query->orWhere('childcategory_id', $cat->id);
                });
            }
        }

        //check ratting
        if ($request->ratting) {
            $products = $products->where('avg_ratting', $request->ratting);
        }

        //check brand
        if ($request->brand) {
            if (!is_array($request->brand)) { // direct url tags
                $brand = explode(',', $request->brand);
            } else { // filter by ajax
                $brand = implode(',', $request->brand);
            }
            $products = $products->whereIn('brand_id', $brand);
        }
        $field = 'id'; $value = 'desc';
        if (isset($request->sortby) && $request->sortby) {
            try {
                $sort = explode('-', $request->sortby);
                if ($sort[0] == 'name') {
                    $field = 'title';
                } elseif ($sort[0] == 'price') {
                    $field = 'selling_price';
                } elseif ($sort[0] == 'ratting') {
                    $field = 'avg_ratting';
                } else {
                    $field = 'id';
                }
                $value = ($sort[1] == 'a' || $sort[1] == 'l') ? 'asc' : 'desc';
                $products = $products->orderBy($field, $value);
            }catch (\Exception $exception){}
        }
        $products = $products->orderBy($field, $value);

        //check price keyword
        if ($request->price) {
            $price = explode(',', $request->price);
            $products = $products->whereBetween('selling_price', [$price[0], $price[1]]);
        }

        //check perPage
        $perPage = 24;
        if (isset($request->perPage) && $request->perPage) {
            $perPage = $request->perPage;
        }
        $data['products'] = $products->selectRaw('products.id,title,selling_price,discount, discount_type, products.slug, feature_image' )->paginate($perPage);
        //check ajax request
        if($request->filter){
            return view('frontend.products.filter_products')->with($data);
        }else {
            $data['categories'] = Category::join('products', 'categories.id', 'products.category_id')
                ->where('vendor_id', $data['seller']->id)
                ->where('categories.status', 1)
                ->groupBy('categories.id')
                ->selectRaw('categories.id,categories.name, categories.slug')->get();
            //get all category id for brand
            $category_id = array_column($data['categories']->toArray(), 'id');
            $data['brands'] = Brand::whereIn('category_id', $category_id)->select('id', 'name', 'slug')->get();

            return view('frontend.shop.seller_products')->with($data);
        }
    }
}
