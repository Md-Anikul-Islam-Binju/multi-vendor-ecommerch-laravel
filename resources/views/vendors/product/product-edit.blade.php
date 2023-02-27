@extends('vendors.partials.vendor-master')
@section('title', 'Update product')

@section('css-top')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('css') 
<link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
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
    .bootstrap-tagsinput{ width: 100% !important;padding: 5px;}
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
                            <li class="breadcrumb-item active">create</li>
                        </ol>
                        <a href="{{route('vendor.product.list')}}" class="btn btn-info btn-sm d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Product List</a>
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

                    <form action="{{route('vendor.product.update', $product->id)}}" data-parsley-validate enctype="multipart/form-data" method="post" id="product">
                        @csrf

                        <div class="form-body">
                            <div class="row" style="align-items: flex-start; overflow: visible;">
                                <div class="col-md-12">

                                    <div class="row">
                                        <div class="col-md-12 title_head">
                                            Product Basic Information
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="title">Product Title</label>
                                                <input type="text" value="{{$product->title}}" name="title" required="" id="title" placeholder = 'Enter title' class="form-control" >
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
                                                <select required=""  onchange="get_subcategory(this.value)" name="category" id="category" class="select2 form-control custom-select">
                                                   <option value="">Select category</option>
                                                   @foreach($categories as $category)
                                                   <option {{ $product->category_id == $category->id ? 'selected' : ''  }} value="{{$category->id}}">{{$category->name}}</option>
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
                                                <select onchange="get_subchild_category(this.value)" required name="subcategory" id="subcategory" class="select2 form-control custom-select">
                                                    <option value="">Select Subcategory</option>
                                                    @foreach($subcategories as $subcategory)
                                                    <option @if($subcategory->id == $product->subcategory_id) selected @endif value="{{$subcategory->id}}">{{$subcategory->name}}</option>
                                                    @endforeach
                                                </select>
                                               
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="subchildcategory">Select Child Category</label>
                                                <select onchange="getAttributeByCategory(this.value, 'getAttributesByChildcategory')" name="childcategory"  id="subchildcategory" class="select2 form-control custom-select">
                                                    <option value="">Select Child Category</option>
                                                   @foreach($childcategories as $childcategory)
                                                    <option {{ $product->childcategory_id == $childcategory->id ? 'selected' : ''  }}  value="{{$childcategory->id}}">{{$childcategory->name}}</option>
                                                    @endforeach
                                                </select>
                                               
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="purchase_price">Purchase Price (optional)</label>
                                                <input type="number" value="{{$product->purchase_price}}" min="0" name="purchase_price" id="purchase_price" placeholder = 'Enter purchase price' class="form-control" >
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
                                                <input required type="number" min="0" value="{{$product->selling_price}}"  name="selling_price" id="selling_price" placeholder = 'Enter selling price' class="form-control" >
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-9">
                                            <div class="form-group">
                                                <label for="discount">Discount</label>
                                                <input type="number" min="0" value="{{$product->discount}}"  name="discount" id="discount" placeholder = 'Enter discount' class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-3" style="padding-left: 0">
                                            <div class="form-group">
                                                <label for="discount_type">Type</label>
                                                <select name="discount_type" class="form-control">
                                                    <option @if($product->discount_type == Config::get('siteSetting.currency_symble')) selected @endif value="{{Config::get('siteSetting.currency_symble')}}">{{Config::get('siteSetting.currency_symble')}}</option>
                                                    <option  @if($product->discount_type == '%') selected @endif  value="%">%</option>
                                                </select>
                                            </div>
                                        </div>

                                       <div class="col-md-12 title_head">
                                            Product Variation & Features
                                        </div>
                                        <div class="col-md-12">
                                          
                                        @foreach ($product->get_variations as $variation)
                                            <?php
                                            //set attribute name for js variable & function
                                            $attribute_fields = str_replace('', '_', $variation->attribute_name);
                                            ?>
                                            <span id="feature{{$variation->id}}">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="checkbox2">
                                                            <input style="display: none;" checked type="checkbox" id="check{{$variation->id}}" name="featureUpdate[{{$variation->attribute_id}}]" value="{{$variation->id}}">
                                                            <label  for="check{{$variation->id}}">Product {{$variation->attribute_name}} <i onclick="deleteVariation({{$variation->id}})" title="Delete this attribute" style="color: red" class="ti-trash"></i> 
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                @php $i = 1; @endphp
                                                @foreach($variation->get_variationDetails as $variationDetail)
                                                <div class="col-md-12" id="product_variation_details{{ $variationDetail->id }}">
                                                <div class="row">
                                                    <div class="col-sm-2 nopadding">
                                                        <div class="form-group">
                                                            @if($i==1)
                                                            <span class="required">Name</span>
                                                            @endif
                                                            <select class="select2 form-control" name="attributeValueUpdate[{{$variation->attribute_id}}][]">
                                                                <option value="{{$variationDetail->attributeValue_name}}">{{$variationDetail->attributeValue_name}}</option>
                                                              
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- check qty weather set or not -->
                                                    <div class="col-sm-2 nopadding">
                                                        <div class="form-group">
                                                            @if($i==1)<span>SKU</span>@endif
                                                            <input type="text" value="{{$variationDetail->sku}}" class="form-control" name="skuUpdate[{{$variation->attribute_id}}][]" placeholder="Enter SKU">
                                                        </div>
                                                    </div> 
                                                    <!-- check qty weather set or not -->
                                                    <div class="col-sm-1 nopadding">
                                                        <div class="form-group">
                                                            @if($i==1)<span>Quantity</span>@endif
                                                            <input type="text" value="{{$variationDetail->quantity}}" class="form-control" name="qtyUpdate[{{$variation->attribute_id}}][]" placeholder="Enter Qty">
                                                        </div>
                                                    </div>
                                                    <!-- check price weather set or not -->
                                                    <div class="col-sm-2 nopadding">
                                                        <div class="form-group">
                                                           @if($i==1) <span>Price</span>@endif
                                                            <input type="number" value="{{$variationDetail->price}}" class="form-control" name="priceUpdate[{{$variation->attribute_id}}][]" placeholder="Enter price">
                                                        </div>
                                                    </div>
                                                    @if($variationDetail->color != null)
                                                    <div class="col-sm-2 nopadding"><div class="form-group">
                                                        @if($i==1)<span>Select Color</span>@endif
                                                        <input onfocus="(this.type='color')" placeholder="Pick Color" class="form-control" value="{{$variationDetail->color}}" name="colorUpdate[{{$variation->attribute_id}}][]"></div>
                                                    </div>
                                                    @endif
                                                    <!-- check image weather set or not -->
                                                    @if($variationDetail->image != null)
                                                    <div class="col-sm-2 nopadding">
                                                        <div class="form-group">
                                                            @if($i==1)<span>Upload Image</span>@endif

                                                            <div class="input-group">
                                                                <input type="file" class="form-control" name="imageUpdate[{{$variation->attribute_id}}][]">
                                                                <img width="40" src="{{ asset('upload/images/product/varriant-product/thumb/'. $variationDetail->image) }}" alt="">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="col-1"  @if($i==1) style="padding-top: 20px;" @endif><button class="btn btn-danger" type="button" onclick="deleteDataCommon('product_variation_details', '{{$variationDetail->id}}')"><i class="fa fa-times"></i></button></div>
                                                </div>
                                                </div>
                                                @php $i++; @endphp
                                                @endforeach
                                                <div id="{{$attribute_fields}}_fields"></div>
                                                <div class="row justify-content-md-center"><div class="col-md-4"> <span style="cursor: pointer;" class="btn btn-info btn-sm" onclick="{{$attribute_fields}}_fields()"><i class="fa fa-plus"></i> Add More</span></div></div> <hr>
                                            </span>
                                        @endforeach
                                            <div id="productVariationField">
                                             <!-- //get un use attribute variation -->
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

                                                                        <select class="form-control select2" name="attributeValue[{{$attribute->id}}][]">
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
                                                                        <input type="text" class="form-control" name="sku[{{$attribute->id}}][]"  placeholder="SKU">
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
                                            </div>
                                           
                                            <div id="getAttributesByCategory"></div>
                                            <div id="getAttributesBySubcategory"></div>
                                            <div id="getAttributesByChildcategory"></div>
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
                                                    <input @if($feature->is_required) required @endif type="text" name="featureValue[{{$feature->id}}]" value="{{ ($feature->featureValue) ? $feature->featureValue->value : null}}" class="form-control" placeholder="Input value here">
                                                </div>
                                                @endforeach
                                            </div>
                                            
                                            <div id="PredefinedFeatureBycategory"></div>
                                            <div id="PredefinedFeatureBySubcategory"></div>
                                            <div id="PredefinedFeatureByChildcategory"></div>

                                            <!-- <div class="form-group row"><span class="col-4 col-sm-2 text-right col-form-label">Feature name</span> <div class="col-8 col-sm-4"> <input type="text" class="form-control"  name="extraFeatureName[]"  placeholder="Feature name"> </div><span class="col-4 col-sm-2 text-right col-form-label">Feature Value</span> <div class="col-7 col-sm-3"> <input type="text" name="extraFeatureValue[]" class="form-control"  placeholder="Input value here"> </div> <div class="col-1"><button class="btn btn-success" type="button" onclick="extraPredefinedFeature();"><i class="fa fa-plus"></i></button></div></div>
                                            <div id="extraPredefinedFeature"></div>
                                            <div class="row justify-content-md-center"><div class="col-md-4"> <span  style="cursor: pointer;" class="btn btn-info btn-sm" onclick="extraPredefinedFeature()"><i class="fa fa-plus"></i> Add More Feature </span></div></div> <hr/> -->
            
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" >Short Summery</label>
                                               <textarea style="resize: vertical;" rows="3" name="summery" class="summernote form-control">{{$product->summery}}</textarea>
                                           </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required">Product Description</label>
                                               <textarea required name="description" id="mymce" class=" form-control">{{$product->description}}</textarea>
                                           </div>
                                        </div>
                                          
                                        <div class="col-md-12">
                                            <div class="row">
                                                @if(config('siteSetting.shipping_method') == 'product_wise_shipping')
                                                <div class="col-md-12 title_head">
                                                    Shipping & Delivery
                                                </div>
                                               
                                                <!-- <div class="col-md-12">
                                                   <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="required" >Product Package</label>
                                                        </div>
                                                        <div class="col-sm-4 nopadding">
                                                           <div class="form-group">
                                                                <span>Package Weight (kg)</span>
                                                                <input type="number" min="1" class="form-control" value="{{ $product->weight }}" name="weight"  placeholder="Enter weight">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-12 nopadding">
                                                             <label class="required">Package Dimensions (cm) </label>
                                                        </div>
                                                        <div class="col-md-3 nopadding">
                                                            <div class="form-group">
                                                                <span class="required">Length (cm)</span>
                                                                <input type="number" min="1" class="form-control" value="{{$product->length }}" name="length"  placeholder="Enter Length">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 nopadding">
                                                            <div class="form-group">
                                                                <span class="required">Width (cm)</span>
                                                                <input required type="number" min="1" class="form-control" value="{{ $product->width }}" name="width"  placeholder="Enter Width">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 nopadding">
                                                            <div class="form-group">
                                                                <span>Height (cm)</span>
                                                                <input required type="number" min="1" class="form-control" value="{{ $product->height }}" name="height"  placeholder="Enter Height">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="checkbox2 shipping-method">
                                                            <label  for="free_shipping">
                                                                <input type="radio" @if($product->shipping_method == 'free') checked @endif name="shipping_method" id="free_shipping" required value="free"> 
                                                            Free Shipping</label>

                                                            <label for="flate_shipping"><input type="radio" @if($product->shipping_method == 'flate') checked @endif name="shipping_method" id="flate_shipping" required value="flate"> 
                                                            Flate Shipping</label>
                                                            <label for="location_shipping">
                                                            <input type="radio" @if($product->shipping_method == 'location') checked @endif name="shipping_method" id="location_shipping" required value="location"> 
                                                            Location-based shipping</label>

                                                           
                                                        </div>
                                                    </div>
                                                    <div class="row" id="shipping-field"></div>
                                                </div>
                                                @endif
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="required" for="product_type">Cart Button</label>
                                                <select required onchange="productType(this.value)" name="product_type" id="product_type" class=" form-control">
                                                   @foreach($cartButtons as $cartButton)
                                                   <option @if($product->product_type == $cartButton->slug) selected @endif  value="{{$cartButton->slug}}">{{$cartButton->btn_name}}</option>
                                                   @endforeach
                                                </select>
                                                @if ($errors->has('product_type'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('product_type') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                            <div id="showProductType"></div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="required" for="stock">Product Stock</label>
                                                <input type="text" value="{{ $product->stock }}"  name="stock" id="stock" placeholder = 'Example: 100'class="form-control" >
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="stock">SKU</label>
                                                <input type="text" value="{{ $product->sku }}"  name="sku" id="sku" placeholder = 'Example: sku-120' class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="unit">Measurement Unit</label>
                                                <input type="text" value="{{$product->unit}}"  name="unit" id="unit" placeholder = 'Example: KG, Pc etc' class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="required" for="brand">Brand </label>
                                                <select name="brand" id="brand" style="width:100%" id="brand" class="form-control select2 custom-select">

                                                   <option value="">Select Brand</option>
                                                   @foreach($brands as $brand)
                                                   <option @if($product->brand_id == $brand->id) selected @endif value="{{$brand->id}}">{{$brand->name}}</option>
                                                   @endforeach
                                               </select>
                                           </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group"> 
                                                <label class="dropify_image required">Feature Image</label>
                                                <input type="file" data-default-file="{{asset('upload/images/product/thumb/'.$product->feature_image)}}" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="5M"  name="feature_image" id="input-file-events">
                                                <i style="color:red;font-size: 11px"> Image Size 600px*600px</i>
                                            </div>
                                            @if ($errors->has('feature_image'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('feature_image') }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                
                                                <div class="checkbox2">
                                                  <input  @if(count($product->videos)>0) checked @endif name="product_video" type="checkbox" id="product_video" value="1"> 
                                                  <label for="product_video">Add Video</label>
                                                </div>
                                                          
                                            </div>
                                            @if(count($product->videos)>0)
                                           
                                            @foreach($product->videos as $video)
                                                <div class="row" id="product_videos{{$video->id}}" style="align-items: center">
                                                <div class="col-10">
                                                    <div class="form-group">
                                                        <span for="video_provider" class="required">Provider</span>
                                                        <select required name="video_provider[]" id="video_provider" class="form-control custom-select">
                                                            <option @if($video->provider == 'youtube') selected @endif value="youtube">Youtube</option> 
                                                            <option @if($video->provider == 'vimeo') selected @endif value="vimeo">Vimeo</option>
                                                        </select>
                                                        <span class="required">Video link</span>
                                                        <input class="form-control" required name="video_link[]" id="video_link" placeholder="Exm: https://www.youtube.com" value="{{$video->link}}" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                    <button class="btn btn-danger" type="button" onclick="deleteDataCommon('product_videos', '{{$video->id}}')"><i class="fa fa-times"></i></button>
                                                </div>
                                                </div>
                                            @endforeach
                                             @endif
                                            <div id="video_display"  style="display: {{(count($product->videos)>0) ? 'block' : 'none'}};">
                                                <div id="extra_video_fields"></div>
                                                <div class="form-group" style="text-align: center;"><span  style="cursor: pointer;" class="btn btn-info btn-sm" onclick="extra_video_fields()"><i class="fa fa-plus"></i> Add More </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="checkbox2">
                                                            <input  @if($product->meta_title != null) checked @endif type="checkbox" id="checkSeo" name="secheck" value="1">
                                                            <label for="checkSeo">Allow Product SEO</label>
                                                      </div>      
                                                    </div> 
                                                    <div  id="seoField" @if($product->meta_title == null) style="display: none;" @endif>  
                                                        
                                                        <div class="form-group">
                                                            <span class="required" for="meta_title">Meta Title</span>
                                                            <input type="text" value="{{$product->meta_title}}"  name="meta_title" id="meta_title" placeholder = 'Enter meta title'class="form-control" >
                                                        </div>
                                                        <div class="form-group">
                                                            <span class="required">Meta Keywords( <span style="font-size: 12px;color: #777;font-weight: initial;">Write meta tags Separated by Comma[,]</span> )</span>

                                                             <div class="tags-default">
                                                                <input  value="{{$product->meta_keywords}}" type="text" name="meta_keywords[]"  data-role="tagsinput" placeholder="Enter meta keywords" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <span class="control-label" for="meta_description">Meta Description</span>
                                                            <textarea class="form-control" name="meta_description" id="meta_description" rows="2" style="resize: vertical;" placeholder="Enter Meta Description">{{$product->meta_description}}</textarea>
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
    <script>

        productType('{{$product->product_type}}');
        function productType(item) {
            if(item == 'add-to-download'){
                $("#showProductType").html(`<div class="row" style="align-items: center">
                    <div class="col-12"><div class="form-group">
                    <span class="required">Attach File</span>
                    <select class="form-control" onchange="fileType(this.value)">
                    <option value="upload">Local Upload</option>
                    <option value="link">External Link</option>
                    </select>
                    <div id="showfileType"> </div>

                    </div>
                    </div>
                </div>`);
            }else{
                $("#showProductType").html('');
            }
        }
        fileType("{{$product->file ? 'upload' : 'link' }}");
        function fileType(item) {
            if(item == 'upload'){
                $("#showfileType").html(`
                    <span class="required">Attach File</span>
                    <input @if(!$product->file) required @endif name="file" type="file" class="form-control">
                    @if($product->file)<a target="_blank" href="{{asset('upload/file/product/'.$product->file)}}">View Attach File </a>@endif
                `);
            }else{
                $("#showfileType").html('<span class="required">External File link</span><input class="form-control" @if(!$product->file_link) required @endif name="file_link" value="{{$product->file_link}}" id="video_link" placeholder="Exm: https://drive.google.com" type="text">');
            }
        }
    </script>
    <script type="text/javascript">
        //check required fieled is filled or not
        $('#uploadBtn').on("click", function(){
          let valid = true;
          $('[required]').each(function() {
            if ($(this).is(':invalid') || !$(this).val()) valid = false;
          })
          if (valid){  document.getElementById('pageLoading').style.display = 'block';  };
        })

        function get_subcategory(id=''){
            if(id){
            document.getElementById('pageLoading').style.display ='block';
        
            //get attribute by category
                getAttributeByCategory(id, 'getAttributesByCategory');
            //when main category change reset attribute fields
                $('#getAttributesBySubcategory').html(' ');
                $('#getAttributesByChildcategory').html(' ');
                $('#productVariationField').html(' ');

         
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
        }
        }        
        
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
                    }else{
                        $("#"+category).html('');
                    }
                    document.getElementById('pageLoading').style.display ='none';
                }
            });
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

        // delete product feature 
        function deleteVariation(id){
            if(confirm('Are you sure delete.?')) {
                var route = '{{ route("deleteVariation", ":id") }}';
                route = route.replace(":id", id);
                $.ajax({
                    url:route,
                    method:"get",
                    success:function(data){
                        if(data.status){
                            $("#feature"+id).remove();
                            toastr.success(data.msg);
                        }else{
                            toastr.error(data.msg);
                        }
                    }
                });
            }else{
                return false;
            }
        }  
    </script>

    <!-- //add extra attribute value -->
    @foreach($product->get_variations as $variation)
        @if($variation->get_attribute)
        <?php
            //column divited by attribute field
            if($variation->get_attribute->qty && $variation->get_attribute->price && $variation->get_attribute->color && $variation->get_attribute->image){
                $col = 2;
            }else{
                $col = 2;
            }

            //set attribute name for js variable & function
            $attribute_fields = str_replace('', '_', $variation->get_attribute->name);
        ?>

        <script type="text/javascript">


        var {{$attribute_fields}} = 1;
        //add dynamic attribute value fields by attribute
        function {{$attribute_fields}}_fields() {

            {{$attribute_fields}}++;
            var objTo = document.getElementById('{{$attribute_fields}}_fields')
            var divtest = document.createElement("div");
            divtest.setAttribute("class", "form-group removeclass" + {{$attribute_fields}});
            var rdiv = 'removeclass' + {{$attribute_fields}};
            divtest.innerHTML = '<div class="row" style="margin:0"> <div class="col-sm-2 nopadding"> <div class="form-group"> <select required class="select2 form-control" name="attributeValueUpdate[{{$variation->get_attribute->id}}][]"> @if(count($variation->get_attribute->get_attrValues)>0) <option value="">Select {{$attribute_fields}}</option> @foreach($variation->get_attribute->get_attrValues as $value) <option value="{{$value->name}}">{{$value->name}}</option> @endforeach @else <option value="">Value Not Found</option> @endif </select> </div> </div> <div class="col-sm-2 nopadding"><div class="form-group"><input type="text" class="form-control" name="skuUpdate[{{$variation->get_attribute->id}}][]" placeholder="SKU"> </div></div>  @if($variation->get_attribute->qty)  <div class="col-sm-1 nopadding"> <div class="form-group"><input type="text" class="form-control"  name="qtyUpdate[{{$variation->get_attribute->id}}][]"  placeholder="Qty"></div></div>@endif  @if($variation->get_attribute->price)  <div class="col-sm-{{$col}} nopadding"><div class="form-group"><input type="number" class="form-control" name="priceUpdate[{{$variation->get_attribute->id}}][]"  placeholder="price"></div></div>@endif @if($variation->get_attribute->color)<div class="col-sm-{{$col}} nopadding"><div class="form-group"><input onfocus="(this.type=\'color\')" placeholder="Pick Color" class="form-control" name="colorUpdate[{{$variation->get_attribute->id}}][]"  ></div></div>@endif @if($variation->get_attribute->image) <div class="col-sm-{{$col}} nopadding"><div class="form-group"><div class="input-group"><input type="file" class="form-control" name="imageUpdate[{{$variation->get_attribute->id}}][]"></div></div></div>@endif<div class="col-1"><button class="btn btn-danger" type="button" onclick="remove_{{$attribute_fields}}_fields(' + {{$attribute_fields}} + ');"><i class="fa fa-times"></i></button></div></div>';

            objTo.appendChild(divtest);
            $(".select2").select2();
        }
        //remove dynamic extra field
        function remove_{{$attribute_fields}}_fields(rid) {
            $('.removeclass' + rid).remove();
        }

        //Allow checkbox check/uncheck handle
        $("#check"+{{$variation->get_attribute->id}}).change(function() {
            if(this.checked) {
                $("#attribute"+{{$variation->get_attribute->id}}).show();
            }else
            {
                $("#attribute"+{{$variation->get_attribute->id}}).hide();

            }
        });

        </script>
        @endif
    @endforeach
 

    <script>
    $(document).ready(function() {
        //select current shiipping method field
        $("#"+"{{$product->shipping_method}}"+"_shipping").change();
        // Basic
        $('.dropify').dropify();
    });

 
    @if(config('siteSetting.shipping_method') == 'product_wise_shipping')
  
    $("#free_shipping").change(function() {
        if(this.checked) { $("#shipping-field").html('<div class="col-md-3"><span>Estimated Shipping Time</span><input class="form-control" name="shipping_time" value="{{$product->shipping_time}}" placeholder="Exm: 3-4 days" type="text"></div>'); }
        else { $("#shipping-field").html(''); }
       
    });

    $("#flate_shipping").change(function() {
        if(this.checked) { $("#shipping-field").html('<div class="col-md-3"><span class="required">Shipping Cost</span><input class="form-control" name="shipping_cost" value="{{$product->shipping_cost}}" placeholder="Exm: 50" min="1" type="number"></div><div class="col-md-3"><span>Estimated Shipping Time</span><input class="form-control" name="shipping_time" value="{{$product->shipping_time}}" placeholder="Exm: 3-4 days" type="text"></div>'); }
        else { $("#shipping-field").html(''); }
    });     
  
    $("#location_shipping").change(function() {
        if(this.checked) { $("#shipping-field").html('<div class="col-md-3"><span class="required">Select Specific Region</span><select required name="ship_region_id" id="ship_region_id" class="select2 form-control custom-select"> @foreach($regions as $region) <option {{($product->ship_region_id == $region->id) ? "selected" : null}} value="{{$region->id}}">{{$region->name}}</option> @endforeach </select></div><div class="col-md-2"><span class="required">Shipping Cost</span><input class="form-control" name="shipping_cost" value="{{$product->shipping_cost}}" placeholder="Exm: 50" min="1" type="number"></div></div><div class="col-md-3"><span>Others region shipping cost</span><input class="form-control" name="other_region_cost" value="{{$product->other_region_cost}}" placeholder="Exm: 55" min="1" type="number"></div><div class="col-md-3"><span>Estimated Shipping Time</span><input class="form-control" name="shipping_time" value="{{$product->shipping_time}}" placeholder="Exm: 3-4 days" type="text"></div>'); }
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
        divtest.innerHTML = '<div class="form-group row"><span class="col-4 col-sm-2 text-right col-form-label">Feature name</span> <div class="col-8 col-sm-4"> <input type="text" class="form-control"  name="FeatureName[]"  placeholder="Feature name"> </div><span class="col-4 col-sm-2 text-right col-form-label">Feature Value</span> <div class="col-7 col-sm-3"> <input type="text" name="FeatureValue[]" class="form-control"  placeholder="Input value here"> </div> <div class="col-1"><button class="btn btn-danger" type="button" onclick="remove_extraPredefinedFeature(' + extraAttribute + ');"><i class="fa fa-times"></i></button></div></div>';

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
        divtest.setAttribute("class", "removeclass" + product_video);
        var rdiv = 'removeclass' + product_video;
        divtest.innerHTML = '<div class="row" style="align-items: center"><div class="col-10"><div class="form-group"><span for="video_provider" class="required">Video Type</span><select required name="video_provider[]" id="video_provider" class="form-control custom-select"><option value="youtube">Youtube</option> <option value="vimeo">Vimeo</option></select><span class="required">Video link</span><input class="form-control" required name="video_link[]" id="video_link" placeholder="Exm: https://www.youtube.com" value="" type="text"></div></div><div class="col-1"><button class="btn btn-danger" type="button" onclick="remove_extra_video_fields(' + product_video + ');"><i class="fa fa-times"></i></button></div></div>';

        objTo.appendChild(divtest)
    }
    //remove dynamic extra field
    function remove_extra_video_fields(rid) {
        $('.removeclass' + rid).remove();
    }

    </script>
   

        <!-- wysuhtml5 Plugin JavaScript -->
    <script src="{{asset('assets')}}/node_modules/tinymce/tinymce.min.js"></script>
    <script>
    $(document).ready(function() {

        if ($("#mymce").length > 0) {
            tinymce.init({
                selector: "textarea#mymce",
                theme: "modern",
                height: 300,
                toolbar:false,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

            });
        }
    });
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
    </script>

 <!--     //get un use attribute variation -->
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
            divtest.innerHTML = '<div class="row"> <div class="col-sm-2 nopadding"> <div class="form-group"> <select class="select2 form-control" name="attributeValue[{{$attribute->id}}][]"> @if($attribute->get_attrValues) @if(count($attribute->get_attrValues)>0) <option value="">{{$attribute_fields}}</option> @foreach($attribute->get_attrValues as $value) <option value="{{$value->name}}">{{$value->name}}</option> @endforeach @else <option value="">Value Not Found</option> @endif @endif </select> </div> </div> <div class="col-sm-{{$col}} nopadding"><div class="form-group"><input type="text" class="form-control" name="sku[{{$attribute->id}}][]"  placeholder="SKU"></div></div> @if($attribute->qty)  <div class="col-sm-1 nopadding"> <div class="form-group"><input type="text" class="form-control"  name="qty[{{$attribute->id}}][]"  placeholder="Qty"></div></div>@endif  @if($attribute->price)  <div class="col-sm-{{$col}} nopadding"><div class="form-group"><input type="number" class="form-control" name="price[{{$attribute->id}}][]"  placeholder="price"></div></div>@endif @if($attribute->color)<div class="col-sm-{{$col}} nopadding"><div class="form-group"><input onfocus="(this.type=\'color\')" placeholder="Pick Color" class="form-control" name="color[{{$attribute->id}}][]"  ></div></div>@endif @if($attribute->image) <div class="col-sm-{{$col}} nopadding"><div class="form-group"><div class="input-group"><input type="file" class="form-control" name="image[{{$attribute->id}}][]"></div></div></div>@endif<div class="col-1"><button class="btn btn-danger" type="button" onclick="remove_{{$attribute_fields}}_fields(' + {{$attribute_fields}} + ');"><i class="fa fa-times"></i></button></div></div>';

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
            }
            else
            {
                $("#attribute"+{{$attribute->id}}).hide();

            }
        });
        @endforeach


        $(".select2").select2();
    </script>

@endsection
