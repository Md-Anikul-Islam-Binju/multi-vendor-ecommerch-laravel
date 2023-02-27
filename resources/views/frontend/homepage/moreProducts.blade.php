@extends('layouts.frontend')
@section('title', $section->title)

@section('content')
    <!-- Main Container  -->
    <div class="breadcrumbs">
        <div class="container">
            
            <ul class="breadcrumb-cate">
                <li><a href="{{url('/')}}"><i class="fa fa-home"></i> </a></li>
                <li><a href="#">{{ $section->title }}</a></li>
            </ul>
        </div>
    </div>
    
    <div class="container product-detail">
     
        <div class="row">
          <div class="col-sm-12">
          <div class="banners">
            <div>
              <a href="#">
              <img src="{{asset('frontend')}}/image/catalog/demo/category/electronic-cat.png" alt="Apple Cinema 30&quot;">
              </a>
            </div>
          </div>
          </div>
        </div>
        <?php $related_products = App\Models\Product::whereNotIn('id', explode(',', $section->product_id))->where('subcategory_id', $products[0]->subcategory_id)->orderBy('id', 'desc')->paginate(5);
            ?>
        <div class="row">
           @if(count($products)>0)
            <div id="content" class="col-md-{{count($related_products)>0 ? 9 : 12}} col-sm-9 col-xs-12 sticky-content" >
                <div class="products-category">
                  <div class="products-list grid row number-col-6 so-filter-gird">
                      @foreach($products as $product)
                      <div class="product-layout col-md-{{count($related_products)>0 ? 3 : 2}} col-sm-4 col-xs-6">
                          @include('frontend.homepage.products')
                      </div>
                      @endforeach
                  </div>

                  <div class="product-filter product-filter-bottom filters-panel">
                      <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                         {{$products->appends(request()->query())->links()}}
                        </div>
                      <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of total {{$products->total()}} entries ({{$products->lastPage()}} Pages)</div>
                  </div>
                </div>
            </div>
           
            @if(count($related_products)>0)
            <div class="col-md-3 sticky-content">
              <div class="moduletable module so-extraslider-ltr best-seller best-seller-custom">
                <h3 class="modtitle"><span>Related products</span></h3>
                <div class="modcontent">
                  <div id="so_extra_slider" class="so-extraslider buttom-type1 preset00-1 preset01-1 preset02-1 preset03-1 preset04-1 button-type1">
                    <div class="extraslider-inner " >
                        <div class="item ">
                          @foreach($related_products as $related_product)
                          <div class="item-wrap style1 ">
                            <div class="item-wrap-inner">
                             <div class="media-left">
                              <div class="item-image">
                                 <div class="item-img-info product-image-container ">
                                  <div class="box-label">
                                  </div>
                                  <a class="lt-image" data-product="66" href="{{ route('product_details', $related_product->slug) }}" >
                                  <img src="{{asset('upload/images/product/thumb/'. $related_product->feature_image)}}" alt="">
                                  </a>
                                 </div>
                              </div>
                             </div>
                             <div class="media-body">
                              <div class="item-info">
                                 <!-- Begin title -->
                                 <div class="item-title">
                                  <a href="{{ route('product_details', $related_product->slug) }}" target="_self">
                                 {{Str::limit($related_product->title, 20)}}
                                  </a>
                                 </div>
                                 
                                 <div class="price  price-left" style="font-size: 12px;">
                                  <!-- Begin ratting -->
                                 <div>
                                 {{\App\Http\Controllers\HelperController::ratting(round($related_product->reviews->avg('ratting'), 1))}}
                                 </div>
                                  <?php  
                                      $discount = null;
                                      $selling_price = $product->selling_price;
                                      $discount = ($product->discount) ? $product->discount : null;
                                      $discount_type = $product->discount_type;
                                      if($discount){
                                      $calculate_discount = App\Http\Controllers\HelperController::calculate_discount($selling_price, $discount, $discount_type );
                                    }
                                  ?>
                                    @if($discount)
                                        <span class="price-new">{{Config::get('siteSetting.currency_symble')}}{{ $calculate_discount['price'] }}</span>
                                        <span class="price-old">{{Config::get('siteSetting.currency_symble')}}{{$selling_price}}</span>
                                    @else
                                        <span class="price-new">{{Config::get('siteSetting.currency_symble')}}{{$selling_price}}</span>
                                    @endif
                                </div>

                                @if($discount)
                                <div class="price-sale price-right">
                                    <span class="discount">
                                      @if($discount_type == '%')-@endif{{$calculate_discount['discount']}}%
                                    <strong>OFF</strong>
                                  </span>
                                </div>
                                @endif
                              </div>
                             </div>
                             <!-- End item-info -->
                            </div>
                            <!-- End item-wrap-inner -->
                          </div>
                          @endforeach
                        </div>
                    </div>
                  </div>
                </div>
             </div>
            </div>
            @endif
          @else
            <div style="text-align: center;">
                <i style="font-size: 80px;" class="fa fa-shopping-cart"></i>
                <h1>Sorry Products Not Found!!.</h1>
               
                Click here <a href="{{url('/')}}">Continue Shopping</a>
            </div>
          @endif
        </div>
    </div>
    
 @endsection
