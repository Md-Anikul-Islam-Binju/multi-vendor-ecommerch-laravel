<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Offer;
use App\Models\OfferProduct;
use App\Models\Page;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class FrontPagesController extends Controller
{
    // all custom page display in
    public function page($slug)
    {
        $data['page'] = Page::where('slug', $slug)->where('status', 1)->first();
        if($data['page']){
            $slug = ($data['page']->is_default == 1) ? $data['page']->slug : 'page';
            //get this site banner
            $data['banners'] = Banner::where('page_name', $data['page']->id)->orderBy('position', 'asc')->where('status', 1)->get();
            return view('frontend.pages.'.$slug)->with($data);
        }
        return view('404');
    }

    // today deals
    public function todayDeals()
    {
        $data['page'] = Page::where('slug', \Request::segment(1))->where('status', 1)->first();

        if($data['page']){
            $data['products'] = Product::orderBy('id', 'desc')->where('status', 'active')->paginate(24);
            $data['banners'] = Banner::where('page_name', 'all')->orWhere('page_name', $data['page']->id)->orderBy('position', 'asc')->where('status', 1)->get();
            return view('frontend.pages.today-deals')->with($data);
        }
        return view('404');
    }

    // get mega discount
    public function megaDiscount ()
    {
        $data['page'] = Page::where('slug', \Request::segment(1))->where('status', 1)->first();
        if($data['page']){
            $data['products'] = Product::where('discount', '!=', null)->where('status', 'active')->paginate(24);
            $data['banners'] = Banner::where('page_name', 'all')->orWhere('page_name', $data['page']->id)->orderBy('position', 'asc')->where('status', 1)->get();
            return view('frontend.pages.mega-discount')->with($data);
        }
        return view('404');
    }

    // get top brand
    public function topBrand ()
    {
        $data['brands'] = Brand::leftJoin('products', 'products.brand_id', 'brands.id')
            ->leftJoin('order_details', 'products.id', 'order_details.product_id')
            ->where('brands.status', 1)
            ->selectRaw('brands.*, count(order_details.product_id)  as total_order')
            ->groupBy('brands.id')
            ->orderBy('total_order', 'desc')
            ->get();

        if($data['brands']){
            $data['page'] = Page::where('slug', \Request::segment(1))->where('status', 1)->first();
            $id = 0;
            if($data['page']){
                $id = $data['page']->id;
            }
            $data['banners'] = Banner::where('page_name', 'all')->orWhere('page_name', $id)->orderBy('position', 'asc')->where('status', 1)->where('status', 1)->get();
            return view('frontend.pages.top-brand')->with($data);
        }
        return view('404');
    }
    // get top brand
    public function brandProducts(Request $request, $slug)
    {
        $data['brand'] = Brand::where('slug', $slug)->first();

        if($data['brand']){
            $products = Product::with('offer_discount.offer:id')->where('brand_id', $data['brand']->id);
            //check search keyword
            if ($request->q) {
                $products->where('title', 'like', '%' . $request->q . '%');
            }
            //check ratting
            if ($request->ratting) {
                $products->where('avg_ratting', $request->ratting);
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
                    $products->orderBy($field, $value);
                }catch (\Exception $exception){}
            }
            $products->orderBy($field, $value);

            //check price keyword
            if ($request->price) {
                $price = explode(',', $request->price);
                $products->whereBetween('selling_price', [$price[0], $price[1]]);
            }

            //check perPage
            $perPage = 15;
            if (isset($request->perPage) && $request->perPage) {
                $perPage = $request->perPage;
            }
            $data['products'] = $products->where('status', 'active')->paginate($perPage);

            if($request->filter){
                return view('frontend.products.filter_products')->with($data);
            }else{
                return view('frontend.pages.brandProducts')->with($data);
            }
        }
        return view('404');
    }

    public function error404(){
        return view('404');
    }
}
