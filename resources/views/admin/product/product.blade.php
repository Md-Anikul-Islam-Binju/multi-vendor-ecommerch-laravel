@extends('layouts.admin-master')
@section('title', 'Upload product')

@section('css-top')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('css')
<link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('assets')}}/node_modules/html5-editor/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />

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
    form label{font-weight: 600;}
    form span{font-size: 12px;}
    #main-wrapper{overflow: visible !important;}
    .shipping-method label{font-size: 13px; font-weight:500; margin-left: 15px; }
    #shipping-field{padding: 0 15px;margin-bottom: 10px; }

    .form-control{padding-left: 5px; overflow: hidden;}
</style>
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

                    <form method="post" action="{{route('admin.product.store')}}" data-parsley-validate enctype="multipart/form-data"  id="product">
                        @csrf
                        <div class="form-body">
                            <div class="row" style="align-items: flex-start; overflow: visible;">
                                <div class="col-md-9 divrigth_border">
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
                                                   <option @if(Session::get("category_id") == $category->id) selected @endif  value="{{$category->id}}">{{$category->name}}</option>
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
                                        <div class="col-md-12 title_head">
                                            Product Price 
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="purchase_price">Purchase Price</label>
                                                <input type="number" value="{{old('purchase_price')}}" min="0" name="purchase_price" data-parsley-required-message = "Purchase price is required" id="purchase_price" placeholder = 'Enter purchase price' class="form-control" >
                                                <span>Only you can see</span>
                                                @if ($errors->has('purchase_price'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('purchase_price') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="" for="selling_price">Price</label>
                                                <input data-parsley-required-message = "Selling price is required"  type="number" min="0" value="{{old('selling_price')}}"  name="selling_price" id="selling_price" placeholder = 'Enter selling price' class="form-control" >
                                            </div>
                                        </div>


                                        
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="" for="reseller_price">Reseller Price</label>
                                                <input data-parsley-required-message = "ReSeller price is required" type="number" min="0" value="{{old('reseller_price')}}"  name="reseller_price" id="reseller_price" placeholder = 'Enter reseller price' class="form-control" >
                                            </div>
                                        </div>
                                        
                                        

                                        
                                        <div class="col-md-2 col-9">
                                            <div class="form-group">
                                                <label for="discount_price">Discount Price</label>
                                                <input type="number" min="0" value="{{old('discount_price')}}"  name="discount_price" id="discount_price" placeholder = 'Enter discount price' class="form-control" >
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-9 d-none">
                                            <div class="form-group">
                                                <label for="discount">Discount</label>
                                                <input type="number" min="0" value="{{old('discount')}}"  name="discount" id="discount" placeholder = 'Enter discount' class="form-control" >
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-3 d-none" style="padding-left: 0">
                                            <div class="form-group">
                                                <label for="discount_type">Type</label>
                                                <select name="discount_type" class="form-control">
                                                    <option value="{{Config::get('siteSetting.currency_symble')}}" selected>Flat</option>
                                                    <option value="%">Percentage</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12 title_head">
                                            Product Variation & Features
                                        </div>
                                        @foreach($attributes as $attribute)

                                        <?php
                                            //column divited by attribute field
                                            if($attribute->qty && $attribute->price && $attribute->color && $attribute->image){
                                                $col = 2;
                                            }else{
                                                $col = 2;
                                            }

                                            //set attribute name for js variable & function
                                            $attribute_fields = str_replace('-', '_', $attribute->slug);
                                        ?>
                                        <div class="col-md-12">
                                            <!-- Allow attribute checkbox button -->
                                            <div class="form-group">
                                                <div class="checkbox2">
                                                    <input type="checkbox" id="check{{$attribute->id}}" name="attribute[{{$attribute->id}}]" value="{{$attribute->name}}">
                                                    <label for="check{{$attribute->id}}">Allow Product {{$attribute->name}}</label>
                                                </div>
                                            </div>
                                            <!--Value fields show & hide by allow checkbox -->
                                            <div id="attribute{{$attribute->id}}" style="display: none;">

                                                <div class="row">
                                                    <div class="col-sm-2 nopadding">
                                                        <div class="form-group">
                                                            <span class="required">{{$attribute->name}} Name</span>

                                                            <select class="form-control" name="attributeValue[{{$attribute->id}}][]">
                                                                @if($attribute->get_attrValues)
                                                                    @if(count($attribute->get_attrValues)>0)
                                                                        <option value="">Select {{$attribute_fields}}</option>
                                                                        @foreach($attribute->get_attrValues as $value)
                                                                            <option value="{{$value->name}}">{{$value->name}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="">Value Not Found</option>
                                                                    @endif
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-{{$col}} nopadding">
                                                        <div class="form-group">
                                                            <span>SKU</span>
                                                            <input type="text" class="form-control sku" name="sku[{{$attribute->id}}][]"  placeholder="SKU">
                                                        </div>
                                                    </div>
                                                    <!-- check qty weather set or not -->
                                                    @if($attribute->qty)
                                                    <div class="col-sm-1 nopadding">
                                                        <div class="form-group">
                                                            <span>Quantity</span>
                                                            <input type="text" class="form-control"  name="qty[{{$attribute->id}}][]"  placeholder="Qty">
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <!-- check price weather set or not -->
                                                    @if($attribute->price)
                                                    <div class="col-sm-{{$col}} nopadding">
                                                        <div class="form-group">
                                                            <span>Price</span>
                                                            <input type="text" class="form-control" name="price[{{$attribute->id}}][]"  placeholder="price">
                                                        </div>
                                                    </div>
                                                    @endif

                                                    @if($attribute->color)<div class="col-sm-{{$col}} nopadding"><div class="form-group"><span>Select Color</span><input onfocus="(this.type='color')" placeholder="Pick Color" class="form-control"  name="color[{{$attribute->id}}][]" ></div></div>@endif

                                                    <!-- check image weather set or not -->
                                                    @if($attribute->image)
                                                    <div class="col-sm-{{$col}} nopadding">
                                                        <div class="form-group">
                                                            <span>Upload Image</span>

                                                            <div class="input-group">
                                                                <input type="file" class="form-control" name="image[{{$attribute->id}}][]">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="col-1 nopadding" style="padding-top: 20px">
                                                        <button class="btn btn-success" type="button" onclick="{{$attribute_fields}}_fields();"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                </div>
                                                <div id="{{$attribute_fields}}_fields"></div>
                                                <div class="row justify-content-md-center"><div class="col-md-4"> <span  style="cursor: pointer;" class="btn btn-info btn-sm" onclick="{{$attribute_fields}}_fields()"><i class="fa fa-plus"></i> Add More {{$attribute->name}}</span></div></div> <hr/>
                                            </div>
                                        </div>

                                        @endforeach
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

                                            <div class="row">
                                                @foreach($features as $feature)
                                                <div style="margin-bottom:10px;" class="col-4 @if($feature->is_required) required @endif col-sm-2 text-right col-form-label">{{$feature->name}}
                                                <input type="hidden" value="{{$feature->name}}" class="form-control" name="features[{{$feature->id}}]"></div>
                                                <div class="col-8 col-sm-4">
                                                    <input @if($feature->is_required) required @endif type="text" name="featureValue[{{$feature->id}}]" value="" class="form-control" placeholder="Input value here">
                                                </div>
                                                @endforeach
                                            </div>

                                            <div id="PredefinedFeatureBycategory"></div>
                                            <div id="PredefinedFeatureBySubcategory"></div>
                                            <div id="PredefinedFeatureByChildcategory"></div>
                                           
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" >Short Summery</label>
                                               <textarea data-parsley-required-message = "Summery is required" style="resize: vertical;" rows="3" name="summery" class="form-control newtextarea">{{old('summery')}}</textarea>
                                           </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required">Product Description</label>
                                               <textarea data-parsley-required-message = "Description is required" required="" name="description" rows="10" class="textarea_editor form-control newtextarea">{{old('description')}}</textarea>
                                           </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="">Product specification</label>
                                               <textarea name="specification" rows="10" class="textarea_editor form-control newtextarea">{{old('specification')}}</textarea>
                                           </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                @if(config('siteSetting.shipping_method') == 'product_wise_shipping')
                                                <div class="col-md-12 title_head">
                                                    Shipping & Delivery
                                                </div>

                                               
                                                <div class="col-md-12">
                                                    
                                                    <div class="form-group">
                                                        <div class="checkbox2 shipping-method">
                                                            <label for="free_shipping"><input data-parsley-required-message = "Shipping is required" type="radio" name="shipping_method" id="free_shipping" required value="free">
                                                            Free Shipping</label>

                                                            <label for="Flate_shipping"><input type="radio" name="shipping_method" id="Flate_shipping" required value="Flate">
                                                            Flate Shipping</label>
                                                            <label for="Location_shipping">
                                                            <input type="radio" name="shipping_method" id="Location_shipping" required value="location">
                                                            Location-based shipping</label>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="shipping-field"></div>
                                                
                                                </div>
                                                @endif
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="" id="extraPredefinedFeature"></div>
                                                    </div>
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
                                                <label class="required" for="product_type">Cart Button</label>
                                                <select required onchange="productType(this.value)" name="product_type" id="product_type" class=" form-control">
                                                   @foreach($cartButtons as $cartButton)
                                                   <option @if(Session::get("product_type") == $cartButton->slug) selected @endif  value="{{$cartButton->slug}}">{{$cartButton->btn_name}}</option>
                                                   @endforeach
                                                </select>
                                                @if ($errors->has('product_type'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('product_type') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div id="showProductType"></div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="stock">Product Stock</label>
                                                <input type="text" value="{{old('stock')}}"  name="stock" id="stock" placeholder = 'Example: 100' class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="weight">Product Weight (Kg)</label>
                                                <input type="text" value="{{old('weight')}}"  name="weight" id="weight" placeholder = 'Example: 1Kg' class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="stock">SKU</label>
                                                <input type="text"   name="sku" id="sku" placeholder = 'Example: sku-120' class="form-control sku" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="unit">Measurement Unit</label>
                                                <input type="text" value="{{old('unit')}}"  name="unit" id="unit" placeholder = 'Example: KG, Pc etc' class="form-control" >
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="reward_points">Reward points</label>
                                                <input type="text" value="{{old('reward_points')}}"  name="reward_points" id="reward_points" placeholder = 'Enter points' class="form-control" >
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
                                                <label class="dropify_image required">Thumbnail Image</label>
                                                <input type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg svg png gif"  data-max-file-size="5M"  name="feature_image" id="input-file-events">
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
                                                <i style="color:red;font-size: 11px">Select Multiple Image(Press Ctrl + Mouse click)</i>
                                            </div>
                                            @if ($errors->has('gallery_image'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('gallery_image') }}
                                                </span>
                                            @endif
                                        </div>

                                    
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="vendor">Vendor </label>
                                                <select name="vendor_id" required id="vendor" style="width:100%" id="vendor" data-parsley-required-message = "Please select vendor" class="select2 form-control custom-select">
                                                   <option disabled value="">Select Vendor</option>
                                                   @foreach($vendors as $vendor)
                                                   <option data-name="{{substr($vendor->vendor_name,0,1).substr($vendor->shop_name,0,1)}}"  @if(Session::get("vendor_id") == $vendor->id) selected @endif  value="{{$vendor->id}}">{{$vendor->shop_name}}</option>
                                                   @endforeach
                                               </select>
                                           </div>
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
                                                <div style="text-align: center;"><span  style="cursor: pointer;" class="btn btn-info btn-sm" onclick="extra_video_fields()"><i class="fa fa-plus"></i> Add More </span>
                                                </div>

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
                            <button type="submit" id="uploadBtn" name="submit" value="save" class="btn btn-success"> <i class="fa fa-save"></i> Save Product </button>

                            <button type="reset" class="btn waves-effect waves-light btn-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->

@endsection

@section('js')
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>

    <script type="text/javascript">
    
    var sel = document.getElementById('vendor');
var selected = sel.options[sel.selectedIndex];
var extra = selected.getAttribute('data-name');
    $('.sku').val(extra+Math.random().toString(36).substring(2,10));
    
    $("#vendor").change(function(){
        var sel = document.getElementById('vendor');
var selected = sel.options[sel.selectedIndex];
var extra = selected.getAttribute('data-name');
    $('.sku').val(extra+Math.random().toString(36).substring(2,10));
});
    
    
    
    
    
    
    
        //check required fieled is filled or not
        $('#uploadBtn').on("click", function(){
          let valid = true;
          $('[required]').each(function() {
            if ($(this).is(':invalid') || !$(this).val()) valid = false;
          })
          if (valid){  document.getElementById('pageLoading').style.display = 'block';  };
        })


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

     <!--  //get  attribute variation -->
    <script type="text/javascript">
        @foreach($attributes as $attribute)

        <?php
            //column divited by attribute field
            if($attribute->qty && $attribute->price && $attribute->color && $attribute->image){
                $col = 2;
            }else{
                $col = 2;
            }

            //set attribute name for js variable & function
            $attribute_fields = str_replace('-', '_', $attribute->slug);
        ?>
        var {{$attribute_fields}} = 1;
        //add dynamic attribute value fields by attribute
        function {{$attribute_fields}}_fields() {

            {{$attribute_fields}}++;
            var objTo = document.getElementById('{{$attribute_fields}}_fields')
            var divtest = document.createElement("div");
            divtest.setAttribute("class", "removeclass" + {{$attribute_fields}});
            var rdiv = 'removeclass' + {{$attribute_fields}};
            divtest.innerHTML = '<div class="row"> <div class="col-sm-2 nopadding"> <div class="form-group"> <select required class="select2 form-control" name="attributeValue[{{$attribute->id}}][]"> @if($attribute->get_attrValues) @if(count($attribute->get_attrValues)>0) <option value="">{{$attribute_fields}}</option> @foreach($attribute->get_attrValues as $value) <option value="{{$value->name}}">{{$value->name}}</option> @endforeach @else <option value="">Value Not Found</option> @endif @endif </select> </div> </div> <div class="col-sm-{{$col}} nopadding"><div class="form-group"><input type="text" class="form-control" name="sku[{{$attribute->id}}][]"  placeholder="SKU"></div></div> @if($attribute->qty)  <div class="col-sm-1 nopadding"> <div class="form-group"><input type="text" class="form-control"  name="qty[{{$attribute->id}}][]"  placeholder="Qty"></div></div>@endif  @if($attribute->price)  <div class="col-sm-{{$col}} nopadding"><div class="form-group"><input type="number" class="form-control" name="price[{{$attribute->id}}][]"  placeholder="price"></div></div>@endif @if($attribute->color)<div class="col-sm-{{$col}} nopadding"><div class="form-group"><input onfocus="(this.type=\'color\')" placeholder="Pick Color" class="form-control" name="color[{{$attribute->id}}][]"  ></div></div>@endif @if($attribute->image) <div class="col-sm-{{$col}} nopadding"><div class="form-group"><div class="input-group"><input type="file" class="form-control" name="image[{{$attribute->id}}][]"></div></div></div>@endif<div class="col-1"><button class="btn btn-danger" type="button" onclick="remove_{{$attribute_fields}}_fields(' + {{$attribute_fields}} + ');"><i class="fa fa-times"></i></button></div></div>';

            objTo.appendChild(divtest)
        }
        //remove dynamic extra field
        function remove_{{$attribute_fields}}_fields(rid) {
            $('.removeclass' + rid).remove();
        }

        //Allow checkbox check/uncheck handle
        $("#check"+{{$attribute->id}}).change(function() {
            if(this.checked) {
                $("#attribute"+{{$attribute->id}}).show();
                
            } else {
                $("#attribute"+{{$attribute->id}}).hide();
            }
        });
        @endforeach
        
    </script>



    <script>
        function productType(item) {
            if(item == 'add-to-download'){
                $("#showProductType").html(`<div class="row" style="align-items: center">
                    <div class="col-12"><div class="form-group">
                    <span class="required">Attach File</span>
                    <select class="form-control" onchange="fileType(this.value)">
                    <option value="upload">Local Upload</option>
                    <option value="link">External Link</option>
                    </select>
                    <div id="showfileType">
                    <span class="required">Attach File</span>
                    <input name="file" required type="file" class="form-control">
                    </div>

                    </div>
                    </div>
                </div>`);
            }else{
                $("#showProductType").html('');
            }
        }

        function fileType(item) {
            if(item == 'upload'){
                $("#showfileType").html(`
                    <span class="required">Attach File</span>
                    <input required name="file" type="file" class="form-control">
                `);
            }else{
                $("#showfileType").html('<span class="required">External File link</span><input class="form-control" required name="file_link" id="video_link" placeholder="Exm: https://drive.google.com" type="text">');
            }
        }
    </script>

    <script>

    $(document).ready(function() {
        $(".select2").select2();
        // Basic
        $('.dropify').dropify();

    });
    
    $("#B2C").change(function() {
        if(this.checked) { $("#sales_type").html('<div class="col-md-4"><div class="form-group" ><label>Retail System Cost</label><input class="form-control" name="retail_system_cost" placeholder="Enter system cost" type="number" min="0"></div></div><div class="col-md-4"><div class="form-group" ><label>Retail Marketing Cost</label><input class="form-control" name="retail_marketing_cost" placeholder="Enter marketing cost" type="number" min="0"></div></div>'); }
        else { $("#sales_type").html(''); }
    });    
    $("#B2B").change(function() {
        if(this.checked) { $("#sales_type").html('<div class="col-md-4"><div class="form-group" ><label class="required">Minimum Order Qty</label><input required class="form-control" name="minimum_order_qty" placeholder="Enter order qty" type="number" min="0"></div></div><div class="col-md-4"><div class="form-group" ><label>Wholesale System Cost</label><input class="form-control" name="wholesale_system_cost" placeholder="Enter system cost" type="number" min="0"></div></div><div class="col-md-4"><div class="form-group" ><label>Wholesale Marketing Cost</label><input class="form-control" name="wholesale_marketing_cost" placeholder="Enter marketing cost" type="number" min="0"></div></div>'); }
        else { $("#sales_type").html(''); }
    });$("#Both").change(function() {
        if(this.checked) { $("#sales_type").html('<div class="col-md-4"><div class="form-group" ><label>Retail System Cost</label><input class="form-control" name="retail_system_cost" placeholder="Enter system cost" type="number" min="0"></div></div><div class="col-md-4"><div class="form-group" ><label>Retail Marketing Cost</label><input class="form-control" name="retail_marketing_cost" placeholder="Enter marketing cost" type="number" min="0"></div></div><div class="col-md-4"><div class="form-group" ><label class="required">Minimum Order Qty</label><input required class="form-control" name="minimum_order_qty" placeholder="Enter order qty" type="number" min="0"></div></div><div class="col-md-4"><div class="form-group" ><label>Wholesale System Cost</label><input class="form-control" name="wholesale_system_cost" placeholder="Enter system cost" type="number" min="0"></div></div><div class="col-md-4"><div class="form-group" ><label>Wholesale Marketing Cost</label><input class="form-control" name="wholesale_marketing_cost" placeholder="Enter marketing cost" type="number" min="0"></div></div>'); }
        else { $("#sales_type").html(''); }
    });

    @if(config('siteSetting.shipping_method') == 'product_wise_shipping')

    $("#free_shipping").change(function() {
        if(this.checked) { $("#shipping-field").html('<div class="col-md-3"><span>Estimated Shipping Time</span><input class="form-control" name="shipping_time" placeholder="Exm: 3-4 days" type="text"></div>'); }
        else { $("#shipping-field").html(''); }
    });
   $("#Flate_shipping").change(function() {
        if(this.checked) { $("#shipping-field").html('<div class="col-md-3"><span class="required">Shipping Cost</span><input class="form-control" name="shipping_cost" placeholder="Exm: 50" min="1" value="{{Session::get("shipping_cost")}}" type="number"></div><div class="col-md-3"><span>Estimated Shipping Time</span><input class="form-control" value="{{Session::get("shipping_time")}}" name="shipping_time" placeholder="Exm: 3-4 days" type="text"></div>'); }
        else { $("#shipping-field").html(''); }
    });


    $("#Location_shipping").change(function() {
        if(this.checked) { $("#shipping-field").html('<div class="col-md-3"><span class="required">Select Specific Region</span><select required name="ship_region_id" id="ship_region_id" class="select2 form-control custom-select"><option value="">select Region</option> @foreach($regions as $region) <option @if(Session::get("ship_region_id") == $region->id) selected @endif value="{{$region->id}}">{{$region->name}}</option> @endforeach </select></div><div class="col-md-2"><span class="required">Shipping Cost</span><input class="form-control" name="shipping_cost" value="{{Session::get("shipping_cost")}}" placeholder="Exm: 50" min="1" type="number"></div></div><div class="col-md-3"><span>Others region shipping cost</span><input class="form-control" value="{{Session::get("other_region_cost")}}" name="other_region_cost" placeholder="Exm: 55" min="1" type="number"></div><div class="col-md-3"><span>Estimated Shipping Time</span><input class="form-control" name="shipping_time" placeholder="Exm: 3-4 days" value="{{Session::get("shipping_time")}}" type="text"></div>');
            
            $(".select2").select2();

        }
        else { $("#shipping-field").html(''); }
    });

    @endif
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
        divtest.setAttribute("class", " removeclass" + product_video);
        var rdiv = 'removeclass' + product_video;
        divtest.innerHTML = '<div class="row" style="align-items: center"><div class="col-10"><div class="form-group"><span for="video_provider" class="required">Video Type</span><select required name="video_provider[]" id="video_provider" class="form-control custom-select"><option value="youtube">Youtube</option> <option value="Vimeo">Vimeo</option></select><span class="required">Video link</span><input class="form-control" required name="video_link[]" id="video_link" placeholder="Exm: https://www.youtube.com" value="" type="text"></div></div><div class="col-1"><button class="btn btn-danger" type="button" onclick="remove_extra_video_fields(' + product_video + ');"><i class="fa fa-times"></i></button></div></div>';

        objTo.appendChild(divtest)
    }
    //remove dynamic extra field
    function remove_extra_video_fields(rid) {
        $('.removeclass' + rid).remove();
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
    <script src="{{asset('assets')}}/node_modules/html5-editor/bootstrap-wysihtml5.js"></script>
   <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script> 
  <script type="text/javascript">
 
     bkLib.onDomLoaded(function () {

    var textareas = document.getElementsByClassName("newtextarea");

    for(var i=0;i<textareas.length;i++)
     {
        var myNicEditor = new nicEditor();
        myNicEditor.panelInstance(textareas[i]);

     }
});
  </script>
@endsection