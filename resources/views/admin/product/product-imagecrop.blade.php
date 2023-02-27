@extends('layouts.admin-master')
@section('title', 'Upload product')

@section('css-top')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('css')
<link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('assets')}}/node_modules/summernote/dist/summernote-bs4.css" rel="stylesheet" type="text/css" />
<link href="{{asset('assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
<style type="text/css">
    @media screen and (min-width: 640px) {
        .divrigth_border::after {
            content: '';
            width: 0;
            height: 100%;
            margin: -1px 0px;
            position: absolute;
            top: 0;
            left: 100%;
            margin-left: 0px;
            border-right: 3px solid #e5e8ec;
        }
    }
    .dropify_image{
            position: absolute;top: -14px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
        }
    .dropify-wrapper{
        height: 100px !important;
    }
    .bootstrap-tagsinput{
            width: 100% !important;
            padding: 5px;
        }
    .closeBtn{position: absolute;right: 0;bottom: 10px;}
   
    form span{font-size: 12px;}
    #main-wrapper{overflow: visible !important;}
    .shipping-method label{font-size: 13px; font-weight:500; margin-left: 15px; }
    #shipping-field{padding: 0 15px;margin-bottom: 10px; }

    .form-control{padding-left: 5px; overflow: hidden;}

.preview {
overflow: hidden;
width: 160px; 
height: 160px;
margin: 10px;
border: 1px solid red;
}

</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
@endsection

@section('content')

    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h4 class="text-themecolor">Add New product</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Product</a></li>
                                <li class="breadcrumb-item active">Create</li>
                            </ol>
                        <a href="{{route('admin.product.list')}}" class="btn btn-info btn-sm d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Product List</a>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->

            <div class="card">
                <div id="pageLoading"></div>
                <div class="card-body">

                    <form action="{{route('admin.product.store')}}" data-parsley-validate enctype="multipart/form-data" method="post" id="product">
                        @csrf

                        <div class="form-body">
                            <div class="row" style="align-items: flex-start; overflow: visible;">
                                <div class="col-md-9 divrigth_border sticky-conent">
                                    <div class="row">
                                        <div class="col-md-12 title_head">
                                            Product Basic Information
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="title">Product Title</label>
                                                <input type="text" data-parsley-required-message = "Product title is required" value="{{old('title')}}" name="title" required="" id="title" placeholder = 'Enter title' class="form-control" >
                                                @if ($errors->has('title'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('title') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="required" for="category">Select category</label>
                                                <select required  onchange="get_subcategory(this.value)" name="category" id="category" class="select2 form-control custom-select">
                                                   <option value="">Select category</option>
                                                   @foreach($categories as $category)
                                                   <option @if(Session::get("category_id") == $category->id) selected @endif  value="{{$category->id}}">{{$category->name}} ({{ count($category->productsByCategory) }})</option>
                                                   @endforeach
                                                </select>
                                                @if ($errors->has('category'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('category') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="required" for="subcategory">Select subcategory</label>
                                                <select onchange="get_subchild_category(this.value)" required name="subcategory" id="subcategory" class="form-control select2 custom-select">
                                                   <option value="">Select first category</option>
                                                </select>
                                                @if ($errors->has('subcategory'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('subcategory') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="subchildcategory">Select Child Category</label>
                                                <select onchange="getAttributeByCategory(this.value, 'getAttributesByChildcategory')" name="childcategory"  id="subchildcategory" class="select2 form-control custom-select">
                                                   <option value="">Select first sub category</option>

                                                </select>
                                                @if ($errors->has('childcategory'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('childcategory') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="required" for="purchase_price">Purchase Price</label>
                                                <input required type="text" value="{{old('purchase_price')}}"  name="purchase_price" data-parsley-required-message = "Purchase price is required" id="purchase_price" placeholder = 'Enter purchase price' class="form-control" >
                                                @if ($errors->has('purchase_price'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('purchase_price') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="required" for="selling_price">Selling Price</label>
                                                <input data-parsley-required-message = "Selling price is required" required type="text" value="{{old('selling_price')}}"  name="selling_price" id="selling_price" placeholder = 'Enter selling price' class="form-control" >
                                            </div>
                                        </div>

                                        <div class="col-md-3  col-9">
                                            <div class="form-group">
                                                <label for="discount">Discount</label>
                                                <input type="text" value="{{old('discount')}}"  name="discount" id="discount" placeholder = 'Enter discount' class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-3" style="padding-left: 0">
                                            <div class="form-group">
                                                <label for="discount_type">Type</label>
                                                <select name="discount_type" class="form-control">
                                                    <option value="{{Config::get('siteSetting.currency_symble')}}">{{Config::get('siteSetting.currency_symble')}}</option>
                                                    <option value="%">%</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12 title_head">
                                            Product Attribute & Features
                                        </div>
                                        <div class="col-md-12">

                                            <div id="productVariationField" >
                                                <div id="getAttributesByCategory"></div>
                                                <div id="getAttributesBySubcategory"></div>
                                                <div id="getAttributesByChildcategory"></div>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <!-- Allow attribute checkbox button -->
                                            <div class="form-group">
                                                <div class="checkbox2">
                                                    <label for="predefinedFeature">Product Features</label>
                                                </div>
                                            </div>

                                            <div id="PredefinedFeatureBycategory"></div>
                                            <div id="PredefinedFeatureBySubcategory"></div>
                                            <div id="PredefinedFeatureByChildcategory"></div>
                                           <!--  <div class="form-group row"><span class="col-4 col-sm-2 text-right col-form-label">Feature name</span> <div class="col-8 col-sm-4"> <input type="text" class="form-control"  name="extraFeatureName[]"  placeholder="Feature name"> </div><span class="col-4 col-sm-2 text-right col-form-label">Feature Value</span> <div class="col-7 col-sm-3"> <input type="text" name="extraFeatureValue[]" class="form-control"  placeholder="Input value here"> </div> <div class="col-1"><button class="btn btn-success" type="button" onclick="extraPredefinedFeature();"><i class="fa fa-plus"></i></button></div></div>
                                            <div id="extraPredefinedFeature"></div>
                                            <div class="row justify-content-md-center"><div class="col-md-4"> <span  style="cursor: pointer;" class="btn btn-info btn-sm" onclick="extraPredefinedFeature()"><i class="fa fa-plus"></i> Add More Feature </span></div></div> <hr/> -->

                                        </div>

                                        <div class="col-md-12">
                                        	<div class="form-group">
                                        		<label class="required" >Short Summery</label>
	                                           <textarea data-parsley-required-message = "Summery is required" style="resize: vertical;" rows="3" name="summery" class="form-control">{{old('summery')}}</textarea>
	                                       </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required">Product Description</label>
                                               <textarea data-parsley-required-message = "Description is required" required="" name="description" class="summernote form-control">{{old('description')}}</textarea>
                                           </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12 title_head">
                                                    Shipping & Delivery
                                                </div>

                                                <!-- 
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="required" >Product Package</label>
                                                        </div>
                                                        <div class="col-sm-4 nopadding">
                                                           <div class="form-group">
                                                                <span>Package Weight (kg)</span>
                                                                <input required type="number" min="1" class="form-control"  name="weight"  placeholder="Enter weight">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 nopadding">
                                                             <label class="required">Package Dimensions (cm) </label>
                                                        </div>
                                                        <div class="col-md-3 nopadding">
                                                            <div class="form-group">
                                                                <span class="required">Length (cm)</span>
                                                                <input required type="number" min="1" class="form-control"  name="length"  placeholder="Enter Length">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 nopadding">
                                                            <div class="form-group">
                                                                <span class="required">Width (cm)</span>
                                                                <input required type="number" min="1" class="form-control"  name="width"  placeholder="Enter Width">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 nopadding">
                                                            <div class="form-group">
                                                                <span>Height (cm)</span>
                                                                <input required type="number" min="1" class="form-control" name="height"  placeholder="Enter Height">
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                                -->
                                                <div class="col-md-12">
                                                    <div class="form-group">

                                                        <div class="checkbox2">
                                                          <input type="checkbox" required id="ship_time" value="1">
                                                          <label class="required"  for="ship_time">Allow Shipping Charge</label>
                                                        </div>

                                                    </div>
                                                    <div id="ship_time_display"  style="display: none;">

                                                        <div class="form-group">
                                                            <div class="checkbox2 shipping-method">
                                                                <label for="free_shipping"><input data-parsley-required-message = "Shipping is required" type="radio" name="shipping_method" id="free_shipping" required value="free">
                                                                Free Shipping</label>

                                                                <label for="Flate_shipping"><input type="radio" name="shipping_method" id="Flate_shipping" required value="Flate">
                                                                Flate Shipping</label>
                                                                <label for="Location_shipping">
                                                                <input type="radio" name="shipping_method" id="Location_shipping" required value="location">
                                                                Location-based shipping</label>

                                                                <label for="Price_shipping">
                                                                <input type="radio" name="shipping_method" id="Price_shipping" required value="price">
                                                                Price-based shipping</label>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="shipping-field"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="checkbox2">
                                                            <input type="checkbox" id="checkSeo" name="secheck" value="1">
                                                            <label for="checkSeo">Allow Product SEO</label>
                                                      </div>
                                                    </div>
                                                    <div  id="seoField" style="display: none;">

                                                        <div class="form-group">
                                                            <span class="required" for="meta_title">Meta Title</span>
                                                            <input type="text" value="{{old('meta_title')}}"  name="meta_title" id="meta_title" placeholder = 'Enter meta title'class="form-control" >
                                                        </div>
                                                        <div class="form-group">
                                                            <span class="required">Meta Keywords( <span style="font-size: 12px;color: #777;font-weight: initial;">Write meta tags Separated by Comma[,]</span> )</span>

                                                             <div class="tags-default">
                                                                <input  type="text" name="meta_keywords[]"  data-role="tagsinput" placeholder="Enter meta keywords" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <span class="control-label" for="meta_description">Meta Description</span>
                                                            <textarea class="form-control" name="meta_description" id="meta_description" rows="2" style="resize: vertical;" placeholder="Enter Meta Description">{{old('meta_description')}}</textarea>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 sticky-conent">
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="stock">Product Stock</label>
                                                <input type="text" value="{{old('stock')}}"  name="stock" id="stock" placeholder = 'Example: 100' class="form-control" >
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="stock">SKU</label>
                                                <input type="text" value="{{old('sku')}}"  name="sku" id="sku" placeholder = 'Example: sku-120' class="form-control" >
                                            </div>
                                        </div>

                                       
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="brand">Brand </label>
                                                <select name="brand" required id="brand" style="width:100%" id="brand" data-parsley-required-message = "Brand is required" class="select2 form-control custom-select">
                                                   <option value="">Select Brand</option>
                                                   @foreach($brands as $brand)
                                                   <option  @if(Session::get("brand") == $brand->id) selected @endif  value="{{$brand->id}}">{{$brand->name}}</option>
                                                   @endforeach
                                               </select>
                                           </div>
                                        </div>

                                    	<div class="col-md-12">
                                            <div class="form-group">
                                                <label class="dropify_image required">Feature Image</label>
                                                <label id="feature_image_area" for="feature_image">
                                                <input type="file" class="dropify feature_image" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="2M"  name="feature_image" id="feature_image"></label>
                                            </div>
                                            @if ($errors->has('feature_image'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('feature_image') }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="dropify_image">Gallery Image</label>
                                                <input  type="file" multiple class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="2M"  name="gallery_image[]" id="input-file-events">
                                            </div>
                                            @if ($errors->has('gallery_image'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('gallery_image') }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">

                                                <div class="checkbox2">
                                                  <input name="product_video" type="checkbox" id="product_video" value="1">
                                                  <label for="product_video">Add Video</label>
                                                </div>

                                            </div>
                                            <div id="video_display"  style="display: none;">
                                                <div id="extra_video_fields"></div>
                                                <div class="form-group" style="text-align: center;"><span  style="cursor: pointer;" class="btn btn-info btn-sm" onclick="extra_video_fields()"><i class="fa fa-plus"></i> Add More </span>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="vendor">Vendor </label>
                                                <select name="vendor_id" required id="vendor" style="width:100%" id="vendor" data-parsley-required-message = "Please select vendor" class="select2 form-control custom-select">
                                                   <option value="">Select Vendor</option>
                                                   @foreach($vendors as $vendor)
                                                   <option  @if(Session::get("vendor_id") == $vendor->id) selected @endif  value="{{$vendor->id}}">{{$vendor->shop_name}}</option>
                                                   @endforeach
                                               </select>
                                           </div>
                                        </div>

                                         <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="manufacture_date">Manufacture date(Mfd)</label>
                                                <input type="date" value="{{old('manufacture_date')}}" placeholder = 'Enter manufacture date' name="manufacture_date" id="manufacture_date" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="expired_date">Expired date(Exd)</label>
                                                <input type="date" value="{{old('expired_date')}}" placeholder = 'Enter expired date' name="expired_date" id="expired_date" class="form-control" >
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group">

                                                <label class="switch-box" style="top:-12px;">Status</label>

                                                    <div class="custom-control custom-switch">
                                                      <input name="status" {{ (old('status') == 'on') ? 'checked' : '' }} checked type="checkbox" class="custom-control-input" id="status">
                                                      <label style="padding: 5px 12px" class="custom-control-label" for="status">Publish/Unpublish</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div><hr>
                        <div class="form-actions pull-right" style="float: right;">
                            <button type="submit"  name="submit" value="save" class="btn btn-success"> <i class="fa fa-save"></i> Save Product </button>

                            <button type="reset" class="btn waves-effect waves-light btn-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="modalLabel">Laravel Cropper Js - Crop Image Before Upload - Tutsmake.com</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">
<div class="img-container">
<div class="row">
<div class="col-md-8">
<img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
</div>
<div class="col-md-4">
<div class="preview"></div>
<div class="cropimg"></div>
</div>
</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
<button type="button" class="btn btn-primary" id="crop">Crop</button>
</div>
</div>
</div>
</div>
@endsection

@section('js')
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>

    <script type="text/javascript">
       
        @if(old('category'))
            get_subcategory({{old('category')}});
        @endif

        @if(Session::has("category_id")) 
            get_subcategory({{Session::get("category_id")}});
        @endif

        function get_subcategory(id=''){
            if(id){
            document.getElementById('pageLoading').style.display ='block';

            //get attribute by category
            getAttributeByCategory(id, 'getAttributesByCategory');
            //when main category change reset attribute fields
            $('#getAttributesBySubcategory').html(' ');
            $('#getAttributesByChildcategory').html(' ');

            //get product feature by sub category
            getFeature(id, 'PredefinedFeatureBycategory');
            //when category change reset feature
            $('#PredefinedFeatureBySubcategory').html(' ');
            $('#PredefinedFeatureByChildcategory').html(' ');

            var  url = '{{route("getSubCategory", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#subcategory").html(data);
                        $("#subcategory").focus();
                    }else{
                        $("#subcategory").html('<option value="">subcategory not found</option>');
                    }
                    document.getElementById('pageLoading').style.display ='none';
                }
            });
        }else{
            $("#subcategory").html(' <option value="">Select first category</option>');
        }
        }
        
        @if(Session::has("subcategory_id")) 
            get_subchild_category({{Session::get("subcategory_id")}});
        @endif
        function get_subchild_category(id=''){
            if(id){
            //enable loader
            document.getElementById('pageLoading').style.display ='block';

            //get product feature by sub category
            getFeature(id, 'PredefinedFeatureBySubcategory');
            //when sub category change reset feature
            $('#PredefinedFeatureByChildcategory').html(' ');

            //get attribute by sub category
            getAttributeByCategory(id, 'getAttributesBySubcategory');
            //when sub category change reset attribute fields
             $('#getAttributesByChildcategory').html(' ');

            var  url = '{{route("getSubChildCategory", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){

                    if(data){
                        $("#subchildcategory").html(data);
                        $("#subchildcategory").focus();
                    }else{
                        $("#subchildcategory").html('<option value="">Childcategory not found</option>');
                    }
                    document.getElementById('pageLoading').style.display ='none';

                }
            });
        }else{
            $("#subchildcategory").html(' <option value="">Select first subcategory</option>');
        }
        }

        // get Attribute by Category
        function getAttributeByCategory(id, category){
            if(id){
            //enable loader
            document.getElementById('pageLoading').style.display ='block';

            //get product feature by child category
            if(category == 'getAttributesByChildcategory'){
                getFeature(id, 'PredefinedFeatureByChildcategory');
            }

            var  url = '{{route("getAttributeByCategory", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){

                    if(data){
                        $("#"+category).html(data);
                        $(".select2").select2();
                    }else{
                        $("#"+category).html('');
                    }
                    document.getElementById('pageLoading').style.display ='none';
                }
            });
        }else{
            $("#"+category).html('');
        }
        }

        // get feature by Category
        function getFeature(id, category){

            var  url = '{{route("getFeature", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){

                    if(data){
                        $("#"+category).html(data);
                    }else{
                        $("#"+category).html('');
                    }
                }
            });
        }
    </script>

    <script>
var $modal = $('#modal');
var image = document.getElementById('image');
var cropper;
$("body").on("change", ".feature_image", function(e){
    var files = e.target.files;
    var done = function (url) {
    image.src = url;
    $modal.modal('show');
    };
    var reader;
    var file;
    var url;
    if (files && files.length > 0) {
        file = files[0];
        if (URL) {
        done(URL.createObjectURL(file));
        } else if (FileReader) {
        reader = new FileReader();
        reader.onload = function (e) {
        done(reader.result);
        };
        reader.readAsDataURL(file);
        }
    }
});
$modal.on('shown.bs.modal', function () {
    cropper = new Cropper(image, {
    aspectRatio: 1,
    viewMode: 3,
    preview: '.preview',

    });
}).on('hidden.bs.modal', function () {
    cropper.destroy();
    cropper = null;
    });
    $("#crop").click(function(){
        canvas = cropper.getCroppedCanvas({
        width: 600,
        height: 600,
        zoomable:false,
        
         type: 'circle' //square
    });
    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob); 
        reader.onloadend = function() {
            var base64data = reader.result; 

            $('#feature_image_area').html('<div style="width: 250px;height: 130px; float: left;position: relative;border: 1px solid #e6e2e2;  margin-right: 3px;"> <img style="width: 100%; height: 100%;" src="'+base64data+'" > <span title="Delete Gallerry Image" onclick="deleteGallerryImage(45)" style="cursor: pointer; position: absolute;top: -4px;right: 0;color: red;"><i class="fa fa-times"></i></span> </div><input type="file" style="display:none" name="feature_image" accept="image/*" id="feature_image" class="feature_image"><input type="hidden" value="'+base64data+'" name="crop_feature_image" >');
            
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "crop-image-upload",
                data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data},
                success: function(data){
                    console.log(data);
                    $modal.modal('hide');
                    alert("Crop image successfully uploaded");
                }
            });
        }
    });
})
</script>

    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

    });

    $("#ship_time").change(function() {
        if(this.checked) { $("#ship_time_display").show(); }
        else { $("#ship_time_display").hide(); }
    });

    $("#free_shipping").change(function() {
        if(this.checked) { $("#shipping-field").html('<div class="col-md-3"><span>Estimated Shipping Time</span><input class="form-control" name="shipping_time" placeholder="Exm: 3-4 days" type="text"></div>'); }
        else { $("#shipping-field").html(''); }

    });
   $("#Flate_shipping").change(function() {
        if(this.checked) { $("#shipping-field").html('<div class="col-md-3"><span class="required">Shipping Cost</span><input class="form-control" name="shipping_cost" placeholder="Exm: 50" min="1" value="{{Session::get("shipping_cost")}}" type="number"></div><div class="col-md-3"><span>Estimated Shipping Time</span><input class="form-control" value="{{Session::get("shipping_time")}}" name="shipping_time" placeholder="Exm: 3-4 days" type="text"></div>'); }
        else { $("#shipping-field").html(''); }
    });

    $("#Price_shipping").change(function() {
        if(this.checked) { $("#shipping-field").html('<div class="col-md-3"><span class="required">Order price above</span><input class="form-control" required name="order_price_above" placeholder="0.00" min="1" type="number"></div><div class="col-md-3><div class="form-group"><div class="checkbox2 shipping-method"><label for="Free_shipping"><span class="required">Shipping Rate</span><br/><br/><input type="checkbox" name="free_shipping" id="Free_shipping" value="1"> Free Shipping</label></div></div></div><div class="col-md-3"><span>Or shipping cost</span><input class="form-control" name="shipping_cost" placeholder="Exm: 3-4 days" type="text"></div><div class="col-md-3"><span>Estimated Shipping Time</span><input class="form-control" name="shipping_time" placeholder="Exm: 3-4 days" type="text"></div>'); }
        else { $("#shipping-field").html(''); }
    });

    $("#Location_shipping").change(function() {
        if(this.checked) { $("#shipping-field").html('<div class="col-md-3"><span class="required">Select Specific Region</span><select required name="ship_region_id" id="ship_region_id" class="select2 form-control custom-select"><option value="">select Region</option> @foreach($regions as $region) <option @if(Session::get("ship_region_id") == $region->id) selected @endif value="{{$region->id}}">{{$region->name}}</option> @endforeach </select></div><div class="col-md-2"><span class="required">Shipping Cost</span><input class="form-control" name="shipping_cost" value="{{Session::get("shipping_cost")}}" placeholder="Exm: 50" min="1" type="number"></div></div><div class="col-md-3"><span>Others region shipping cost</span><input class="form-control" value="{{Session::get("other_region_cost")}}" name="other_region_cost" placeholder="Exm: 55" min="1" type="number"></div><div class="col-md-3"><span>Estimated Shipping Time</span><input class="form-control" name="shipping_time" placeholder="Exm: 3-4 days" value="{{Session::get("shipping_time")}}" type="text"></div>');
            
            $(".select2").select2();

        }
        else { $("#shipping-field").html(''); }
    });


    //allow seo fields
    $("#checkSeo").change(function() {
        if(this.checked) { $("#seoField").show(); }
        else { $("#seoField").hide(); }
    });


    </script>

    <script type="text/javascript">


    var extraAttribute = 1;
    //add dynamic attribute value fields by attribute
    function extraPredefinedFeature() {

        extraAttribute++;
        var objTo = document.getElementById('extraPredefinedFeature')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", " removeclass" + extraAttribute);
        var rdiv = 'removeclass' + extraAttribute;
        divtest.innerHTML = '<div class="form-group row"><span class="col-4 col-sm-2 text-right col-form-label">Feature name</span> <div class="col-8 col-sm-4"> <input type="text" class="form-control"  name="Features[]" placeholder="Feature name"> </div><span class="col-4 col-sm-2 text-right col-form-label">Feature Value</span> <div class="col-7 col-sm-3"> <input type="text" name="FeatureValue[]" class="form-control"  placeholder="Input value here"> </div> <div class="col-1"><button class="btn btn-danger" type="button" onclick="remove_extraPredefinedFeature(' + extraAttribute + ');"><i class="fa fa-times"></i></button></div></div>';

        objTo.appendChild(divtest)
    }
    //remove dynamic extra field
    function remove_extraPredefinedFeature(rid) {
        $('.removeclass' + rid).remove();
    }


    //Allow checkbox check/uncheck handle
    $("#product_video").change(function() {

        if(this.checked) {
            $("#video_display").show();
            extra_video_fields();
        }
        else {

            $("#extra_video_fields").html('');
            $("#video_display").hide();
        }
    });


    var product_video = 1;
    //add dynamic attribute value fields by attribute
    function extra_video_fields() {

        product_video++;
        var objTo = document.getElementById('extra_video_fields')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "form-group removeclass" + product_video);
        var rdiv = 'removeclass' + product_video;
        divtest.innerHTML = '<div class="row" style="align-items: center"><div class="col-10"><div class="form-group"><span for="video_provider" class="required">Video Type</span><select required name="video_provider[]" id="video_provider" class="form-control custom-select"><option value="youtube">Youtube</option> <option value="Vimeo">Vimeo</option></select><span class="required">Video link</span><input class="form-control" required name="video_link[]" id="video_link" placeholder="Exm: https://www.youtube.com" value="" type="text"></div></div><div class="col-1"><button class="btn btn-danger" type="button" onclick="remove_extra_video_fields(' + product_video + ');"><i class="fa fa-times"></i></button></div></div>';

        objTo.appendChild(divtest)
    }
    //remove dynamic extra field
    function remove_extra_video_fields(rid) {
        $('.removeclass' + rid).remove();
    }

    </script>

   <script src="{{asset('assets')}}/node_modules/summernote/dist/summernote-bs4.min.js"></script>
    <script>
    $(function() {

        $('.summernote').summernote({
            height: 200, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });

        $('.inline-editor').summernote({
            airMode: true
        });

    });

    window.edit = function() {
            $(".click2edit").summernote()
        },
        window.save = function() {
            $(".click2edit").summernote('destroy');
        }

    </script>
    <script src="{{asset('assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script type="text/javascript">
        // Enter form submit preventDefault for tags
        $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
          if(e.keyCode == 13) {
            e.preventDefault();
            return false;
          }
        });

        $(".select2").select2();
    </script>

@endsection

