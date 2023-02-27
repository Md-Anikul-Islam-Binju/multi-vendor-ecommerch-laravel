<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Currency;
use App\Models\HomepageSection;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductVariation;
use App\Models\ProductVariationDetails;
use App\Models\SiteSetting;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    //home page function
    public function index(Request $request)
    {
        $data = [];
        //get all homepage section
        $data['sections'] = HomepageSection::where('status', 1)->orderBy('position', 'asc')->paginate(3);
        //check ajax request
        if ($request->ajax()) {
            $view = view('frontend.homepage.homesection', $data)->render();
            return response()->json(['html'=>$view]);
        }
        $data['sliders'] = Slider::where('status', 1)->where('type', 'homepage')->orderBy('position', 'asc')->get();
        return view('frontend.home')->with($data);
    }

    //product show by category
    public function category(Request $request)
    {
        $data['products'] = $data['banners'] = $data['product_variations'] = $data['category'] = $data['filterCategories'] = $data['brands'] = [];

        try {
            $products = Product::with('offer_discount.offer:id');

            if ($request->catslug) {
                $data['category'] = Category::where('slug', $request->catslug)->first();
                if($data['category']) {
                    $data['filterCategories'] = $data['category']->get_subcategory;
                    //get product by category id
                    $products = $products->where('category_id', $data['category']->id);
                }
            }
            if ($request->subslug) {
                $data['category'] = Category::where('slug', $request->subslug)->first();
                if($data['category']) {
                    $data['filterCategories'] = $data['category']->get_subchild_category;
                    //get product by sub category id
                    $products = $products->where('subcategory_id', $data['category']->id);
                }
            }
            if ($request->childslug) {
                $data['category'] = Category::where('slug', $request->childslug)->first();
                if($data['category']) {
                    $data['filterCategories'] = Category::where('subcategory_id', $data['category']->subcategory_id)->get();
                    $products = $products->where('childcategory_id', $data['category']->id);
                }
            }

            if(!$data['category']){
                return view('frontend.pages.category-sitemap');
            }

            //recent views set category id
            $recent_catId = $data['category']->id;
            $recentViews = (Cookie::has('recentViews') ? json_decode(Cookie::get('recentViews')) :  []);
            $recentViews = array_merge([$recent_catId], $recentViews);
            $recentViews = array_values(array_unique($recentViews)); //reindex & remove duplicate value
            Cookie::queue('recentViews', json_encode($recentViews), time() + (86400));

            //check search keyword
            if ($request->q) {
                $products = $products->where('title', 'like', '%' . $request->q . '%');
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
            $perPage = 16;
            if (isset($request->perPage) && $request->perPage) {
                $perPage = $request->perPage;
            }

            $products = $products->selectRaw('id,title,selling_price,discount, discount_type,slug, feature_image')->where('status', 'active');
            //get product id for product_variations
            $product_id  = $products->get()->pluck('id')->toArray();

            $data['product_variations'] = ProductVariation::with('allVariationValues')
                ->whereIn('product_id', $product_id)
                ->groupBy('attribute_id')
                ->get();

            //check weather ajax request identify filter parameter
            foreach ($data['product_variations'] as $filterAttr) {
                $filter = strtolower($filterAttr->attribute_name);
                if ($request->$filter) {
                    if (!is_array($request->$filter)) { // direct url tags
                        $tags = explode(',', $request->$filter);
                    } else { // filter by ajax
                        $tags = implode(',', $request->$filter);
                    }
                    //get product id from url filter id (size=1,2)
                    $productsFilter = ProductVariationDetails::whereIn('attributeValue_name', $tags)->groupBy('product_id')->get()->pluck('product_id');
                    $products = $products->whereIn('id', $productsFilter);
                }
            }
            $data['products'] = $products->paginate($perPage);

        }catch (\Exception $e){

        }

        if($request->filter){
            return view('frontend.products.filter_products')->with($data);
        }else{
            if($data['category']){
                $data['banners'] = Banner::where('page_name', $data['category']->slug)->where('status', 1)->get();
                $data['brands'] = Brand::where('category_id', $data['category']->id)->where('status', 1)->get();
            }
            return view('frontend.products.category')->with($data);
        }
    }
    //search products
    public function search(Request $request)
    {
        $search = Product::where('products.status', 'active');
        $keywords = request('q');
        if($request->q) {
            $search->where(function ($query) use ($keywords) {
                $query->orWhere('title', 'like', '%' . $keywords . '%');
                $query->orWhere('meta_keywords', 'like', '%' . $keywords . '%');
            });
        }
        //check brand
        if ($request->brand) {
            if (!is_array($request->brand)) { // direct url tags
                $brand = explode(',', $request->brand);
            } else { // filter by ajax
                $brand = implode(',', $request->brand);
            }
            $search->whereIn('brand_id', $brand);
        }

        if ($request->cat){
            $search->join('categories', 'products.category_id', 'categories.id');
            $search->where('categories.slug', $request->cat);
        }
        $search = $search->first();
        $data['products'] = $data['specifications'] = $data['category'] = $data['filterCategories'] = $data['brands'] = [];
        //dd($get_products);
        if($search) {
            $products = Product::where('products.status', 'active');
            $specifications = ProductAttribute::orderBy('id', 'asc');
            if ($search->category_id) {
                $data['category'] = Category::where('id', $search->category_id)->first();
                $data['filterCategories'] = $data['category']->get_subcategory;
                //get product attribute by category id
                $specifications->where('category_id', $data['category']->id);

            }
            if (!$search->childcategory_id && !$search->subcategory_id && $search->category_id) {
                $specifications->orWhere('category_id', $data['category']->id)
                    ->orWhereIn('category_id', $data['filterCategories']->pluck('id'))
                    ->orWhereIn('category_id', $data['category']->get_subchild_category->pluck('id'));
            }
            if ($search->subcategory_id) {
                $data['category'] = Category::where('id', $search->subcategory_id)->first();
                $data['filterCategories'] = $data['category']->get_subchild_category;
                //get product attribute by sub category id
                $specifications->where('category_id', $data['category']->id);

            }
            if ($search->childcategory_id) {
                $data['category'] = Category::where('id', $search->childcategory_id)->first();
                $data['filterCategories'] = Category::where('subcategory_id', $data['category']->subcategory_id)->get();
                //get product attribute by child category id
                $specifications->where('category_id', $data['category']->id);

            }
            //check search keyword
            if ($request->q) {
                $products->where(function ($query) use ($keywords) {
                    $query->orWhere('title', 'like', '%' . $keywords . '%');
                    $query->orWhere('meta_keywords', 'like', '%' . $keywords . '%');
                });
            }

            //check ratting
            if ($request->ratting) {
                $products = $products->where('avg_ratting', $request->ratting);
            }

            if ($request->cat){
                $products->join('categories', 'products.category_id', 'categories.id');
                $products->where('categories.slug', $request->cat);
            }

            //check orderby
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
                    $value = (($sort[1] == 'a' || $sort[1] == 'l')) ? 'asc' : 'desc';

                    $products = $products->orderBy($field, $value);
                }catch (\Exception $exception){}
            }

            //check price keyword
            if ($request->price) {
                $price = explode(',', $request->price);
                $products = $products->whereBetween('selling_price', [$price[0], $price[1]]);
            }

            $data['specifications'] = $specifications->get();

            //check weather ajax request identify filter parameter

            foreach ($data['specifications'] as $filterAttr) {
                $filter = strtolower($filterAttr->name);
                if ($request->$filter) {
                    if (!is_array($request->$filter)) { // direct url tags
                        $tags = explode(',', $request->$filter);
                    } else { // filter by ajax
                        $tags = implode(',', $request->$filter);
                    }
                    //get product id from url filter id (size=1,2)
                    $productsFilter = ProductFeatureDetail::whereIn('attributeValue_id', $tags)->groupBy('product_id')->get()->pluck('product_id');

                    $products = $products->whereIn('products.id', $productsFilter);
                }
            }
            //check perPage
            $perPage = 16;
            if (isset($request->perPage) && $request->perPage) {
                $perPage = $request->perPage;
            }
            $data['products'] = $products->selectRaw('products.id,title,reseller_price,selling_price,discount, discount_type, products.slug, feature_image' )->paginate($perPage);
            $data['brands'] = Brand::where('category_id', $data['category']->id)->where('status', 1)->get();

        }

        //check ajax request
        if($request->filter){
            return view('frontend.products.filter_products')->with($data);
        }else{
            return view('frontend.products.search_products')->with($data);
        }
    }
    //display product details by product id/slug
    public function product_details(Request $request, $slug)
    {

        $data['product_detail'] = Product::with('offer_discount.offer:id','reviews.review_image_video', 'reviews.user:id,name,photo', 'reviews.review_comments.user:id,name,photo', 'user:id,name', 'get_features','get_variations.get_variationDetails')
            ->where('slug', $slug)->first();

        //dd($data['product_detail']);

        if($data['product_detail']) {
            //recent views set category id
            $recent_catId = ($data['product_detail']->childcategory_id) ? $data['product_detail']->childcategory_id : $data['product_detail']->subcategory_id;
            $recentViews = (Cookie::has('recentViews') ? json_decode(Cookie::get('recentViews')) :  []);
            $recentViews = array_merge([$recent_catId], $recentViews);
            $recentViews = array_values(array_unique($recentViews)); //reindex & remove duplicate value
            Cookie::queue('recentViews', json_encode($recentViews), time() + (86400));

            $data['refund'] = SiteSetting::where('type', 'refund_request_time')
                ->orWhere('type', 'refund_sticker')
                ->orWhere('type', 'allow_refund_request')->get()->toArray();
            $data['currencies'] = Currency::where('status', 1)->get();

            $data['product_detail']->increment('views'); // news view count
            $related_products = Product::where('status', 'active');
            if($data['product_detail']->childcategory_id != null){
                $category_feild = 'childcategory_id';
                $category_id = $data['product_detail']->childcategory_id;
            }elseif($data['product_detail']->subcategory_id != null){
                $category_feild = 'subcategory_id';
                $category_id = $data['product_detail']->subcategory_id;
            }else{
                $category_feild = 'category_id';
                $category_id = $data['product_detail']->category_id;
            }

            $data['related_products'] = $related_products->where($category_feild, $category_id)->selectRaw('id,title,slug,feature_image,selling_price,discount,discount_type,summery')->where('id', '!=', $data['product_detail']->id)->take(8)->get();

            //get offer slug
            return view('frontend.products.product_details')->with($data);
        }else{
            return view('404');
        }
    }

    public function moreProducts($slug)
    {
        $data['section'] = HomepageSection::where('slug', $slug)->where('status', 1)->first();
        if($data['section']){
            if($slug == 'recommended-for-you'){
                $data['products'] = Product::with('offer_discount.offer:id')->where('status', 'active')->selectRaw('id,title,selling_price,discount,discount_type, slug, feature_image')->orderBy('views', 'desc')->paginate(16);
            }else {
                $data['products'] = Product::with('offer_discount.offer:id')->whereIn('id', explode(',', $data['section']->product_id))->orderBy('id', 'desc')->where('status', 'active')->paginate(16);
            }
            return view('frontend.homepage.moreProducts')->with($data);
        }
        return view('frontend.404');
    }

    public function quickview(Request $request, $slug){
        $data['product'] = Product::with('user:id,name','get_category:id,name','get_features')->where('slug', $slug)->first();
        $data['type'] = ($request->type) ? $request->type : 'on';
        $data['offer'] = $request->offer ? $request->offer : null;
        if($data['product']) {
            return view('frontend.products.quickview-iframe')->with($data);
        }else{
            return 'Product not found.';
        }
    }
}
