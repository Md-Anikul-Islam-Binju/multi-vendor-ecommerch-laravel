<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use App\Models\CartButton;
use App\Models\SiteSetting;
use App\Traits\ExcelImport;
use App\Vendor;
use App\Models\Brand;
use App\Models\Country;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HomepageSection;
use App\Models\PredefinedFeature;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductFeature;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use App\Models\ProductVariationDetails;
use App\Models\ProductVideo;
use App\Models\State;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProductController extends Controller
{
    use CreateSlug, ExcelImport;
    // get product lists function


    public function download(): BinaryFileResponse
    {
        $file= public_path("excel-example/example.xlsx");

        $headers = array(
            'Content-Type: application',
        );

        return Response::download($file, 'Example.xlsx', $headers);
    }

    public function test()
    {
        try {

            $imagePath = public_path('excel_temp_image\6277728b21f35.jpg');
            $res = Image::make($imagePath);
            $res->resize(500,200);
            $res->save();
        }
        catch (Exception $exception){
            echo $exception->getMessage();
        }
    }

    public function productImport()
    {
        return view('admin.product.excel-import');
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function productImportUpload(Request $request): RedirectResponse
    {
        ini_set("memory_limit", "80000M");
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);


        $success = 0;
        $error = 0;
        if ($request->hasFile('file')){
            $path = $request->file('file')->getRealPath();
            //return $this->excelExtract($path);
            foreach ($this->excelExtract($path) as $key => $item){

                $item->categoryId = $item->category;
                $item->subCategoryId = $item->sub_category;
                $upload = $this->excelUpload($item->name, $item->wholeSalePrice, $item->retailPrice, $item->description, $item->imagePath, $item->brand, $item->sku, $item->categoryId, $item->subCategoryId, $item->vendor, $item->stock);

                if ($upload){
                    $success++;
                }else{
                    $error++;
                }
            }
        }
        Toastr::success("Success: $success, Errors: $error");
        return back();

    }

    private function excelUpload($name, $wholeSalePrice, $retailPrice, $description, string $imagePath, $brand, $sku, $categoryId, $subCategoryId, $vendor,$stock = 0,$unit=null): bool
    {


        $findVendor = Vendor::query()->where('shop_name', 'LIKE', $vendor);
        if ($findVendor->count()>0){
            $vendorId = $findVendor->first()->id;
        }else{
            $vendorId = null;
        }
        $findBrand = Brand::query()->where('name', 'LIKE', $brand);
        $brandId = $findBrand->count()===0?null:$findBrand->first()->id;
        $categoryFind = Category::query()->where('name', 'LIKE', $categoryId);
        $subCategoryFind = Category::query()->where('name', 'LIKE', $subCategoryId);
        if ($categoryFind->count()===0 OR $subCategoryFind->count()===0){
            return false;
        }

        $categoryId = $categoryFind->first()->id;
        $subCategoryId = $subCategoryFind->first()->id;

        // Insert product
        $data = new Product();
        $data->vendor_id = $vendorId;
        $data->title = $name;
        $data->slug = $this->createSlug('products', $name);
        $data->sku = $sku;
        $data->summery = $description;
        $data->description = $description;
        $data->category_id = $categoryId;
        $data->subcategory_id = $subCategoryId;
        $data->brand_id = $brandId;
        $data->purchase_price = 0;
        $data->selling_price = $retailPrice;
        $data->reseller_price = $wholeSalePrice;
        $data->specification = $description;





        $data->discount_type =  null;
        $data->stock = $stock;
        $data->total_stock = $stock;
        $data->manufacture_date = '';
        $data->expired_date = '';
        $data->video =  null;


        $data->cash_on_delivery =  null;

        $data->voucher = null;
        $data->meta_title =  null;
        $data->meta_keywords =  null;
        $data->meta_description =  null;
        $data->status =  'active';
        $data->created_by = Auth::guard('admin')->id();

        $image = $imagePath;
        //if feature image set
        if (strlen($imagePath)<0) {
            $data->feature_image = $imagePath;
        }
        $productSave = $data->save();

        if($productSave) {

                $productStock = Product::find($data->id);
                $productStock->stock = $stock;
                $productStock->total_stock = $stock;
                $productStock->save();
            return true;
        }else{
            return false;
        }


    }




    public function index(Request $request, $status='')
    {
        $products = Product::orderBy('id', 'desc');
        if($status){
            if($status == 'stock-out'){
                $products->where('stock', '<=', 0);
            }
            elseif($status == 'image-missing'){
                $products->where('feature_image', null);
            }elseif($status == 'seo-missing'){
                $products->where(function ($query){
                    $query->orWhere('meta_title', null)->orWhere('meta_keywords', null)->orWhere('meta_description', null);
                });
            }
            else{
                $products->where('status', $status);
            }
        }

        if(!$status && $request->status && $request->status != 'all'){
            $products->where('status', $request->status);
        }
        if($request->brand && $request->brand != 'all'){
            $products->where('brand_id', $request->brand);
        }
        if($request->seller && $request->seller != 'all'){
        $products->where('vendor_id', $request->seller);
        }



        if($request->title){
            $products->where('title', 'LIKE', '%'. $request->title .'%');
        }


        if($request->sku){
            $products->where('sku', 'LIKE', '%'. $request->sku .'%');
        }



        $data['products'] = $products->paginate(15);

        $data['all_products'] = Product::count();
        $data['stockout_products'] = Product::where('stock', '<=', 0)->count();
        $data['active_products'] = Product::where('status', 'active')->count();
        $data['deactive_products'] = Product::where('status', 'deactive')->count();
        $data['pending_products'] = Product::where('status', 'pending')->count();
        $data['image_missing'] = Product::where('feature_image', null)->count();
        $data['seo_missing'] = Product::orWhere('meta_title', null)->orWhere('meta_keywords', null)->orWhere('meta_description', null)->count();
        $data['brands'] = Brand::orderBy('position', 'asc')->where('status', 1)->get();
        $data['vendors'] = Vendor::orderBy('shop_name', 'asc')->where('status', 'active')->get();

        return view('admin.product.product-lists')->with($data);
    }

    // Add new product
    public function upload()
    {
        $data['vendors'] = Vendor::orderBy('shop_name', 'asc')->where('status', 'active')->get();
        $data['regions'] = State::orderBy('name', 'asc')->get();
        $data['brands'] = Brand::orderBy('name', 'asc')->where('status', 1)->get();
        $data['categories'] = Category::with('productsByCategory')->where('parent_id', '=', null)->orderBy('name', 'asc')->where('status', 1)->get();
        $data['cartButtons'] = CartButton::orderBy('position', 'asc')->get();
        $data['attributes'] = ProductAttribute::where('category_id', 'all')->get();
        $data['features'] = PredefinedFeature::where('category_id', 'all')->get();
        return view('admin.product.product')->with($data);
    }

    //store new product
    public function store(Request $request): RedirectResponse
    {
        
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'subcategory' => 'required',            
            'feature_image' => 'image|mimes:jpeg,png,jpg,gif'
        ]);

        // Insert product
        $data = new Product();
        $data->vendor_id = ($request->vendor_id ? $request->vendor_id : null);
        $data->title = $request->title;
        $data->slug = $this->createSlug('products', $request->title);
        $data->sku = $request->sku;
        $data->summery = $request->summery;
        $data->description = $request->description;
        $data->category_id = $request->category;
        $data->subcategory_id = $request->subcategory;
        $data->childcategory_id = ($request->childcategory) ? $request->childcategory : null;
        $data->brand_id = ($request->brand ? $request->brand : null);
        $data->purchase_price = $request->purchase_price;
        $data->selling_price = ($request->selling_price) ? $request->selling_price : '0.00';
        $data->reseller_price = ($request->reseller_price) ? $request->reseller_price : '0.00';
        $data->specification = ($request->specification) ? $request->specification : '';
        $data->weight = ($request->weight) ? $request->weight : 1.000;

        $data->discount = ($request->discount) ? $request->discount : null;

        if($request->discount_price)
        {    
            $data->discount =  $request->selling_price - $request->discount_price;
        }else{
            $data->discount =  0;
        }

        $data->discount_type = ($request->discount_type) ? $request->discount_type : null;
        $data->stock = ($request->stock) ? $request->stock : 0;
        $data->total_stock = ($request->stock) ? $request->stock : 0;
        $data->manufacture_date = $request->manufacture_date;
        $data->expired_date = $request->expired_date;
        $data->video = ($request->product_video) ? 1 : null;
       
        if($request->shipping_method){
            $data->shipping_method = ($request->shipping_method) ? $request->shipping_method : null;
            $data->order_qty = ($request->order_qty) ? $request->order_qty : null;
            $data->free_shipping = ($request->free_shipping) ? 1 : null;
            $data->shipping_cost = ($request->shipping_cost) ? $request->shipping_cost : null;
            $data->discount_shipping_cost = ($request->discount_shipping_cost) ? $request->discount_shipping_cost : null;
            $data->ship_region_id = ($request->ship_region_id) ? $request->ship_region_id : null;

            $data->other_region_cost = ($request->other_region_cost) ? $request->other_region_cost : null;
            $data->shipping_time = ($request->shipping_time) ? $request->shipping_time : null;
        }
        $data->cash_on_delivery = ($request->cash_on_delivery) ? $request->cash_on_delivery : null;

        $data->voucher = ($request->voucher) ? 1 : null;
        $data->meta_title = ($request->meta_title) ? $request->meta_title : null;
        $data->meta_keywords = ($request->meta_keywords) ? implode(',', $request->meta_keywords) : null;
        $data->meta_description = ($request->meta_description) ? $request->meta_description : null;
        $data->status = ($request->status ? 'active' : 'deactive');
        $data->created_by = Auth::guard('admin')->id();

        //if feature image set
        if ($request->hasFile('feature_image')) {
            $image = $request->file('feature_image');
            $new_image_name = uniqid().'.'.$image->getClientOriginalExtension();
            $image_path = public_path('upload/images/product/thumb/' . $new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(200, 200);
            $image_resize->save($image_path);
            $image->move(public_path('upload/images/product'), $new_image_name);
            $data->feature_image = $new_image_name;
        }



        //if meta image set
        if ($request->hasFile('meta_image')) {
            $image = $request->file('meta_image');
            $new_image_name = uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/images/product/meta_image'), $new_image_name);
            $data->meta_image = $new_image_name;
        }

        $data->product_type = ($request->product_type ? $request->product_type : 'add-to-cart');
        $data->file_link = $request->file_link ?? null;
        //if file set
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $new_file_name = $this->uniqueImagePath('products', 'file', $request->title.'.'.$image->getClientOriginalExtension());
            $file->move(public_path('upload/file/product'), $new_file_name);
            $data->file = $new_file_name;
        }
        $store = $data->save();

        if($store) {
            $total_qty = 0;
            //insert variation
            if ($request->attribute) {

                foreach ($request->attribute as $attribute_id => $attr_value) {
                    //insert product feature name in feature table
                    $feature = new ProductVariation();
                    $feature->product_id = $data->id;
                    $feature->attribute_id = $attribute_id;
                    $feature->attribute_name = $attr_value;
                    $feature->in_display = 1;
                    $feature->save();
                    if(isset($request->attributeValue) && array_key_exists($attribute_id, $request->attributeValue)) {
                        for ($i = 0; $i < count($request->attributeValue[$attribute_id]); $i++) {
                            $quantity = 0;
                            //check weather attribute value set
                            if (array_key_exists($i, $request->attributeValue[$attribute_id]) && $request->attributeValue[$attribute_id][$i]) {
                                //insert feature attribute details in ProductFeatureDetail table
                                $quantity = (isset($request->qty[$attribute_id]) && array_key_exists($i, $request->qty[$attribute_id]) ? $request->qty[$attribute_id][$i] : 0);
                                $feature_details = new ProductVariationDetails();
                                $feature_details->product_id = $data->id;
                                $feature_details->attribute_id = $attribute_id;
                                $feature_details->variation_id = $feature->id;
                                $feature_details->attributeValue_name = $request->attributeValue[$attribute_id][$i];
                                $feature_details->sku = (isset($request->sku[$attribute_id]) && is_array($request->sku[$attribute_id]) && array_key_exists($i, $request->sku[$attribute_id]) ? $request->sku[$attribute_id][$i] : 0);
                                $feature_details->quantity = $quantity;
                                $feature_details->price = (isset($request->price[$attribute_id]) && is_array($request->price[$attribute_id]) && array_key_exists($i, $request->price[$attribute_id]) ? $request->price[$attribute_id][$i] : 0);
                                $feature_details->color = (isset($request->color[$attribute_id]) && is_array($request->color[$attribute_id]) && array_key_exists($i, $request->color[$attribute_id]) ? $request->color[$attribute_id][$i] : null);

                                //if attribute variant image set
                                if (isset($request->image[$attribute_id]) && array_key_exists($i, $request->image[$attribute_id])) {
                                    $image = $request->image[$attribute_id][$i];
                                    $new_variantimage_name = $this->uniqueImagePath('product_variation_details', 'image', $request->title.'.'.$image->getClientOriginalExtension());

                                    $image_path = public_path('upload/images/product/varriant-product/thumb/' . $new_variantimage_name);
                                    $image_resize = Image::make($image);
                                    $image_resize->resize(250, 200);
                                    $image_resize->save($image_path);

                                    $image->move(public_path('upload/images/product/varriant-product'), $new_variantimage_name);
                                    $feature_details->image = $new_variantimage_name;
                                }
                                $feature_details->save();
                            }
                            //count total stock quantity
                            $total_qty += $quantity;
                        }
                    }
                }
            }
            //insert additional Feature data
            if ($request->features) {
                try {
                    foreach ($request->features as $feature_id => $feature_name) {
                        if ($request->featureValue[$feature_id]) {
                            $extraFeature = new ProductFeature();
                            $extraFeature->product_id = $data->id;
                            $extraFeature->feature_id = $feature_id;
                            $extraFeature->name = $feature_name;
                            $extraFeature->value = $request->featureValue[$feature_id];
                            $extraFeature->save();
                        }
                    }
                } catch (Exception $exception) {

                }
            }
            // gallery Image upload
            if ($request->hasFile('gallery_image')) {
                $gallery_image = $request->file('gallery_image');
                foreach ($gallery_image as $image) {
                    $new_image_name = uniqid().'.'.$image->getClientOriginalExtension();
                    $image_path = public_path('upload/images/product/gallery/thumb/' . $new_image_name);
                    $image_resize = Image::make($image);
                    $image_resize->resize(200, 200);
                    $image_resize->save($image_path);
                    $image->move(public_path('upload/images/product/gallery'), $new_image_name);

                    ProductImage::create([
                        'product_id' => $data->id,
                        'image_path' => $new_image_name
                    ]);
                }
            }
            //video upload
            if (isset($request->video_provider)) {
                for ($i = 0; $i < count($request->video_provider); $i++) {
                    ProductVideo::create(['product_id' => $data->id,
                        'provider' => $request->video_provider[$i],
                        'link' => $request->video_link[$i]
                    ]);
                }
            }
            //update total quantity
            if ($total_qty != 0){
                $productStock = Product::find($data->id);
                $productStock->stock = ($total_qty != 0) ? $total_qty : $request->stock;
                $productStock->total_stock = ($total_qty != 0) ? $total_qty : $request->stock;
                $productStock->save();
            }

            Toastr::success('Product Create Successfully.');
        }else{
            Toastr::error('Product Cannot Create.!');
        }
        return back();
    }

    //clone product

    public function clone($slug): RedirectResponse
    {

        $product = Product::find($slug);
        $newP = $product->replicate();
        $newP->slug = $product->slug."-duplicate";
        $newP->unit = 1;
        $newP->save();
        Toastr::success('Duplicate Success');
        return back();
    }

    //edit product
    public function edit($slug)
    {
        $data['product'] = Product::with('get_variations.get_variationDetails','videos')->where('slug', $slug)->first();

        $data['vendors'] = Vendor::orderBy('id', 'asc')->where('status', 'active')->get();
        $data['regions'] = State::orderBy('name', 'asc')->get();
        $data['brands'] = Brand::orderBy('name', 'asc')->where('status', 1)->get();
        $data['cartButtons'] = CartButton::orderBy('position', 'asc')->get();
        // categroy id make array for query
        $category_id = [];
        if($data['product']->category_id) {
            $category_id[] = $data['product']->category_id;
        }if($data['product']->subcategory_id) {
        $category_id[] = $data['product']->subcategory_id;
    }if($data['product']->childcategory_id) {
        $category_id[] = $data['product']->childcategory_id;
    }
        //get  attributes
        $data['attributes'] = ProductAttribute::whereIn('category_id', $category_id)
            ->orWhere('category_id', 'all')
            ->doesntHave('variations')->get();

        $product_id = $data['product']->id;
        $data['features'] = PredefinedFeature::with(['featureValue' => function ($query) use ($product_id) {
            $query->where('product_id', $product_id);
        }])->whereIn('category_id', $category_id)
            ->orWhere('category_id', 'all')->get();
        $data['categories'] = Category::where('parent_id', '=', null)->where('status', 1)->get();
        $data['subcategories'] = Category::where('parent_id', '=', $data['product']->category_id)->where('status', 1)->get();
        $data['childcategories'] = Category::where('subcategory_id', '=', $data['product']->subcategory_id)->where('status', 1)->get();
        return view('admin.product.product-edit')->with($data);
    }

    //update product
    public function update(Request $request, $product_id)
    {
        //return $request->all();
        $admin_id = Auth::guard('admin')->id();
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'subcategory' => 'required',
            'selling_price' => 'required',
        ]);
        // Insert product
        $data = Product::find($product_id);
        $data->vendor_id = ($request->vendor_id ? $request->vendor_id : null);
        $data->title = $request->title;
        $data->sku = $request->sku;
        $data->summery = $request->summery;
        $data->description = $request->description;
        $data->category_id = $request->category;
        $data->subcategory_id = $request->subcategory;
        $data->specification = $request->specification;
        $data->childcategory_id = ($request->childcategory) ? $request->childcategory : null;
        $data->brand_id = ($request->brand ? $request->brand : null);
        $data->purchase_price = $request->purchase_price;
        $data->selling_price = ($request->selling_price) ? $request->selling_price : '0.00';
        $data->weight = ($request->weight) ? $request->weight : $data->weight;


        
        $data->reseller_price = $request->reseller_price;

        //$discount_amount= $request->selling_price - $request->discount;

        if($request->discount_price)
        {    
            $data->discount =  $request->selling_price - $request->discount_price;
        }else{
            $data->discount =  0;
        }


        //$data->discount = ($request->discount) ? $request->discount : null;

        $data->discount_type = ($request->discount_type) ? $request->discount_type : null;
        $data->stock = ($request->stock) ? $request->stock : 0;
        $data->total_stock = ($request->stock) ? $request->stock : 0;
        $data->manufacture_date = $request->manufacture_date;
        $data->expired_date = $request->expired_date;
        $data->video = ($request->product_video) ? 1 : null;
       
        if($request->shipping_method){
            $data->shipping_method = ($request->shipping_method) ? $request->shipping_method : null;
            $data->order_qty = ($request->order_qty) ? $request->order_qty : null;
            $data->free_shipping = ($request->free_shipping) ? 1 : null;
            $data->shipping_cost = ($request->shipping_cost) ? $request->shipping_cost : null;
            $data->discount_shipping_cost = ($request->discount_shipping_cost) ? $request->discount_shipping_cost : null;
            $data->ship_region_id = ($request->ship_region_id) ? $request->ship_region_id : null;
            $data->other_region_cost = ($request->other_region_cost) ? $request->other_region_cost : null;
            $data->shipping_time = ($request->shipping_time) ? $request->shipping_time : null;
        }
        $data->cash_on_delivery = ($request->cash_on_delivery) ? $request->cash_on_delivery : null;
        $data->voucher = ($request->voucher) ? 1 : null;
        $data->meta_title = ($request->meta_title) ? $request->meta_title : null;
        $data->meta_keywords = ($request->meta_keywords) ? implode(',', $request->meta_keywords) : null;
        $data->meta_description = ($request->meta_description) ? $request->meta_description : null;
        $data->status = ($request->status ? 'active' : 'deactive');
        $data->updated_by = $admin_id;
        $data->product_type = ($request->product_type ? $request->product_type : 'add-to-cart');
        $data->file_link = $request->file_link ?? null;
        //if file set
        $ea = explode('-', $data->slug);


        if ($request->hasFile('file')) {
            if ($data->unit > 0){ //duplicate check
                return $request->all();
                $getfile_path = public_path('upload/file/product/'. $data->file);
                if(file_exists($getfile_path) && $data->file){
                    unlink($getfile_path);

                }
            }

            $file = $request->file('file');
            $new_file_name = $this->uniqueImagePath('products', 'file', $file->getClientOriginalName());
            $file->move(public_path('upload/file/product'), $new_file_name);
            $data->file = $new_file_name;
        }
        if ($request->hasFile('gallery_image')) {
            $gallery_image = $request->file('gallery_image');
            foreach ($gallery_image as $image) {
                $new_image_name = uniqid().'.'.$image->getClientOriginalExtension();
                $image_path = public_path('upload/images/product/gallery/thumb/' . $new_image_name);
                $image_resize = Image::make($image);
                $image_resize->resize(200, 200);
                $image_resize->save($image_path);
                $image->move(public_path('upload/images/product/gallery'), $new_image_name);

                ProductImage::create([
                    'product_id' => $data->id,
                    'image_path' => $new_image_name
                ]);
            }
        }
        //if feature image set
        if ($request->hasFile('feature_image')) {

            $ea = explode('-', $data->slug);

            if (end($ea) !== 'duplicate')
            {

                $getimage_path = public_path('upload/images/product/'. $data->feature_image);
                if(file_exists($getimage_path) && $data->feature_image){
                    unlink($getimage_path);
                    unlink(public_path('upload/images/product/thumb/'. $data->feature_image));
                    Toastr::success("old image delete");
                }

            }else{
                $data->slug = $this->createSlug('products', $request->title);
            }

            $image = $request->file('feature_image');
            $new_image_name = $this->uniqueImagePath('products', 'feature_image', $request->title.'.'.$image->getClientOriginalExtension());

            $image_path = public_path('upload/images/product/thumb/' . $new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(200, 200);
            $image_resize->save($image_path);

            $image->move(public_path('upload/images/product'), $new_image_name);

            $data->feature_image = $new_image_name;
        }

        //if meta image set
        if ($request->hasFile('meta_image')) {
            $getimage_path = public_path('upload/images/product/meta_image'. $data->meta_image);
            if(file_exists($getimage_path) && $data->meta_image){
                unlink($getimage_path);
            }
            $image = $request->file('meta_image');
            $new_image_name = $this->uniqueImagePath('products', 'meta_image', $request->title.'.'.$image->getClientOriginalExtension());
            $image->move(public_path('upload/images/product/meta_image'), $new_image_name);
            $data->meta_image = $new_image_name;
        }

        $update = $data->save();

        if($update){
            //update variation value
            if($request->featureUpdate){
                foreach ($request->featureUpdate as $attribute_id => $variation_id){
                    if($request->attributeValueUpdate && array_key_exists($attribute_id, $request->attributeValueUpdate)) {
                        for ($i = 0; $i < count($request->attributeValueUpdate[$attribute_id]); $i++) {
                            //check weather attribute value set
                            if (array_key_exists($i, $request->attributeValueUpdate[$attribute_id]) ) {
                                //insert or update feature attribute details in ProductVariationDetails table
                                $feature_details = ProductVariationDetails::where('attributeValue_name', $request->attributeValueUpdate[$attribute_id][$i])
                                    ->where('product_id', $product_id)->first();
                                if (!$feature_details) {
                                    $feature_details = new ProductVariationDetails();
                                }
                                $feature_details->product_id = $product_id;
                                $feature_details->attribute_id = $attribute_id;
                                $feature_details->variation_id = $variation_id;
                                $feature_details->attributeValue_name = $request->attributeValueUpdate[$attribute_id][$i];
                                $feature_details->sku = (isset($request->skuUpdate[$attribute_id]) && array_key_exists($i, $request->skuUpdate[$attribute_id]) ? $request->skuUpdate[$attribute_id][$i] : 0);
                                $feature_details->quantity = (isset($request->qtyUpdate[$attribute_id]) && array_key_exists($i, $request->qtyUpdate[$attribute_id]) ? $request->qtyUpdate[$attribute_id][$i] : 0);
                                $feature_details->price = (isset($request->priceUpdate[$attribute_id]) && array_key_exists($i, $request->priceUpdate[$attribute_id]) ? $request->priceUpdate[$attribute_id][$i] : 0);
                                $feature_details->color = (isset($request->colorUpdate[$attribute_id]) && array_key_exists($i, $request->colorUpdate[$attribute_id]) ? $request->colorUpdate[$attribute_id][$i] : null);

                                //if attribute variant image set
                                if (isset($request->imageUpdate[$attribute_id]) && array_key_exists($i, $request->imageUpdate[$attribute_id])) {
                                    $image = $request->imageUpdate[$attribute_id][$i];
                                    $new_variantimage_name = $this->uniqueImagePath('product_variation_details', 'image', $request->title.'.'.$image->getClientOriginalExtension());

                                    $image_path = public_path('upload/images/product/varriant-product/thumb/' . $new_variantimage_name);
                                    $image_resize = Image::make($image);
                                    $image_resize->resize(250, 200);
                                    $image_resize->save($image_path);

                                    $image->move(public_path('upload/images/product/varriant-product'), $new_variantimage_name);
                                    $feature_details->image = $new_variantimage_name;
                                }
                                $feature_details->save();
                            }
                        }
                    }
                }
            }

            //insert new variation
            if($request->attribute){
                foreach ($request->attribute as $attribute_id => $attr_value){
                    //insert product feature name in feature table
                    $feature = new ProductVariation();
                    $feature->product_id = $data->id;
                    $feature->attribute_id = $attribute_id;
                    $feature->attribute_name = $attr_value;
                    $feature->in_display= 1;
                    $feature->save();

                    for ($i=0; $i< count($request->attributeValue[$attribute_id]); $i++){
                        $quantity = 0;
                        //check weather attribute value set
                        if(array_key_exists($i, $request->attributeValue[$attribute_id]) && $request->attributeValue[$attribute_id][$i]) {
                            //insert feature attribute details in ProductVariationDetails table
                            $feature_details = new ProductVariationDetails();
                            $feature_details->product_id = $data->id;
                            $feature_details->attribute_id = $attribute_id;
                            $feature_details->variation_id = $feature->id;
                            $feature_details->attributeValue_name = $request->attributeValue[$attribute_id][$i];
                            $feature_details->sku = (isset($request->sku[$attribute_id]) && array_key_exists($i, $request->sku[$attribute_id]) ? $request->sku[$attribute_id][$i] : 0);
                            $feature_details->quantity = (isset($request->qty[$attribute_id]) && array_key_exists($i, $request->qty[$attribute_id]) ? $request->qty[$attribute_id][$i] : 0);
                            $feature_details->price = (isset($request->price[$attribute_id]) && array_key_exists($i, $request->price[$attribute_id]) ? $request->price[$attribute_id][$i] : 0);
                            $feature_details->color = (isset($request->color[$attribute_id]) && array_key_exists($i, $request->color[$attribute_id]) ? $request->color[$attribute_id][$i] : null);

                            //if attribute variant image set
                            if (isset($request->image[$attribute_id]) && array_key_exists($i, $request->image[$attribute_id])) {
                                $image = $request->image[$attribute_id][$i];
                                $new_variantimage_name = $this->uniqueImagePath('product_variation_details', 'image', $image->getClientOriginalName());

                                $image_path = public_path('upload/images/product/varriant-product/thumb/' . $new_variantimage_name);
                                $image_resize = Image::make($image);
                                $image_resize->resize(250, 200);
                                $image_resize->save($image_path);

                                $image->move(public_path('upload/images/product/varriant-product'), $new_variantimage_name);
                                $feature_details->image = $new_variantimage_name;
                            }
                            $feature_details->save();
                        }
                    }
                }
            }

            //insert or update product feature
            if($request->features){
                try {
                    foreach($request->features as $feature_id => $feature_name) {

                        $extraFeature = ProductFeature::where('product_id', $product_id)->where('feature_id', $feature_id)->first();
                        if(!$extraFeature){
                            $extraFeature = new ProductFeature();
                        }
                        $extraFeature->product_id = $product_id;
                        $extraFeature->feature_id = $feature_id;
                        $extraFeature->name = $feature_name;
                        $extraFeature->value = ($request->featureValue[$feature_id]) ? $request->featureValue[$feature_id] : null;
                        $extraFeature->save();

                    }
                }catch (Exception $exception){

                }
            }

            //video upload
            if(isset($request->video_provider)){
                for ($i=0; $i< count($request->video_provider); $i++) {
                    ProductVideo::updateOrCreate(['product_id' => $product_id,
                        'provider' => $request->video_provider[$i],
                        'link' => $request->video_link[$i]
                    ],['product_id' => $product_id,
                        'provider' => $request->video_provider[$i],
                        'link' => $request->video_link[$i]
                    ]);
                }
            }
        }

        Toastr::success('Product update Successfully.');
        return redirect()->route('admin.product.list');
    }

    // delete product
    public function delete($id)
    {
        $product = Product::find($id);
        if($product){
            $image_path = public_path('upload/images/product/'. $product->feature_image);
            if(file_exists($image_path) && $product->feature_image){
                unlink($image_path);
                unlink(public_path('upload/images/product/thumb/'. $product->feature_image));
            }

            $product->delete();

            $gallery_images = ProductImage::where('product_id',  $product->id)->get();
            foreach ($gallery_images as $gallery_image) {
                $image_path = public_path('upload/images/product/varriant-product/'. $gallery_image->image_path);
                if(file_exists($image_path) && $gallery_image->image_path){
                    unlink($image_path);
                    unlink(public_path('upload/images/product/varriant-product/thumb/'. $gallery_image->image_path));
                }
                $gallery_image->delete();
            }
            ProductVariation::where('product_id',  $product->id)->delete();
            $variationDetails = ProductVariationDetails::where('product_id',  $product->id)->get();
            foreach ($variationDetails as $variation) {
                $image_path = public_path('upload/images/product/varriant-product/'. $variation->image);
                if(file_exists($image_path) && $variation->image){
                    unlink($image_path);
                    unlink(public_path('upload/images/product/varriant-product/thumb/'. $variation->image));
                }
                $variation->delete();
            }
            ProductFeature::where('product_id',  $product->id)->delete();
            $output = [
                'status' => true,
                'msg' => 'Product deleted successful.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Product cannot delete.'
            ];
        }
        return response()->json($output);
    }

    //get highlight popup
    public function highlight($product_id){
        $product = Product::find($product_id);
        if($product){
            return view('admin.product.hightlight')->with(compact('product'));
        }
        return false;
    }

    //add remove highlight product
    public function highlightAddRemove(Request $request){

        $section = HomepageSection::find($request->section_id);

        $products_id =  ($section->product_id) ? explode(',', $section->product_id) : [];

        if(in_array($request->product_id, $products_id)){
            //remove product id from array
            unset($products_id[array_search($request->product_id, $products_id)]);
            $output = [
                'status' => false,
                'msg' => 'Product remove successfully.'
            ];

        }else{
            //add product id in array
            array_push($products_id, $request->product_id);
            $output = [
                'status' => true,
                'msg' => 'Product added successfully.'
            ];
        }
        //update hompagesection table
        $section->update(['product_id' => implode(',', $products_id)]);

        return response()->json($output);

    }

    //insert gallery image
    public function storeGalleryImage(Request $request)
    {
        $request->validate([
            'gallery_image' => 'required'
        ]);
        // gallery Image upload
        if ($request->hasFile('gallery_image')) {
            $gallery_image = $request->file('gallery_image');
            foreach ($gallery_image as $image) {
                $new_image_name = $this->uniqueImagePath('product_images', 'image_path', $image->getClientOriginalName());
                $image_path = public_path('upload/images/product/gallery/thumb/' . $new_image_name);
                $image_resize = Image::make($image);
                $image_resize->resize(200, 200);
                $image_resize->save($image_path);
                $image->move(public_path('upload/images/product/gallery'), $new_image_name);
                ProductImage::create( [
                    'product_id' => $request->product_id,
                    'image_path' => $new_image_name
                ]);
            }

            Toastr::success('Gallery image upload successfully.');
            return back();
        }
        Toastr::error('Gallery image upload failed.');
        return back();
    }

    //display gallery image
    public function getGalleryImage($product_id){
        $product_images = ProductImage::where('product_id', $product_id)->get();

        return view('admin.product.gallery-images')->with(compact('product_images', 'product_id'));
    }

    // delete GalleryImage
    public function deleteGalleryImage($id)
    {
        $find = ProductImage::find($id);
        if($find){
            //delete image from folder
            $thumb_image_path = public_path('upload/images/product/gallery/thumb/'. $find->image_path);
            $image_path = public_path('upload/images/product/gallery/'. $find->image_path);
            if(file_exists($image_path) && $find->image_path){
                unlink($image_path);
                unlink($thumb_image_path);
            }
            $find->delete();
            $output = [
                'status' => true,
                'msg' => 'Gallery Image deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Gallery Image cannot deleted.'
            ];
        }
        return response()->json($output);
    }


}
