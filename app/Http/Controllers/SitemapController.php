<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Page;
class SitemapController extends Controller
{

	public function __construct(){
        $sitemap_active = SiteSetting::where('type', 'sitemap')->where('status', 1)->first();
        //check sitemap active or deactive
        if(!$sitemap_active){
            return redirect()->route('404')->send();
        }
    }

    //xml sitemap setting
    public function sitemapSetting() {
        return view('admin.setting.seo-setting');
    }

    //xml sitemap location
	public function index() {
		return response()->view('sitemap.index')->header('Content-Type', 'text/xml');
	}
    //xml pages sitemap
	public function pages() {
		$pages = Page::orderBy("id", "desc")->select(["slug","updated_at"])->get();
		return response()->view('sitemap.pages', [
		'pages' => $pages,
		])->header('Content-Type', 'text/xml');
	}

	//xml product sitemap
	public function products() {
		$products = Product::orderBy("id", "desc")->take(1000)->select(["slug", "feature_image", "updated_at"])->get();
		return response()->view('sitemap.products', [
		'products' => $products,
		])->header('Content-Type', 'text/xml');
	}
    //xml category sitemap
	public function categories() {
		$categories = Category::with('get_subcategory')->orderBy("id", "desc")->get();
		return response()->view('sitemap.category', [
		'categories' => $categories,
		])->header('Content-Type', 'text/xml');
	}

	//all category list
    public function catSitemap(){
        return view('frontend.pages.category-sitemap');
    }
}
