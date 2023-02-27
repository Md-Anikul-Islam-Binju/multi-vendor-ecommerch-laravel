@extends('layouts.frontend')
@section('title', $product_detail->title . ' | '. Config::get('siteSetting.site_name'))
@php
  $avg_ratting = round($product_detail->reviews->avg('ratting'), 1);
  $total_review = count($product_detail->reviews);
  $ratting_star = $product_detail->reviews->groupBy('ratting')->map->count()->toArray();
  $ratting1 = array_key_exists(1, $ratting_star) ? $ratting_star[1] : 0;
  $ratting2 = array_key_exists(2, $ratting_star) ? $ratting_star[2] : 0;
  $ratting3 = array_key_exists(3, $ratting_star) ? $ratting_star[3] : 0;
  $ratting4 = array_key_exists(4, $ratting_star) ? $ratting_star[4] : 0;
  $ratting5 = array_key_exists(5, $ratting_star) ? $ratting_star[5] : 0;
@endphp
@section('metatag')
    <meta name="keywords" content="{{ $product_detail->meta_keywords }}" />
    <meta name="description" content="{!! strip_tags($product_detail->description) !!}">
    <meta name="image" content="{{asset('upload/images/product/'.$product_detail->feature_image) }}">
    <meta name="rating" content="5">
    <!-- Schema.org for Google -->
    <meta itemprop="name" content="{{$product_detail->title}}">
    <meta itemprop="description" content="{!! strip_tags($product_detail->description) !!}">
    <meta itemprop="image" content="{{asset('upload/images/product/'.$product_detail->feature_image) }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{$product_detail->title}}">
    <meta name="twitter:description" content="{!! strip_tags($product_detail->description) !!}">
    <meta name="twitter:site" content="{{ url()->full() }}">
    <meta name="twitter:creator" content="@neyamul">
    <meta name="twitter:image:src" content="{{asset('upload/images/product/'.$product_detail->feature_image) }}">
    <meta name="twitter:player" content="#">
    <!-- Twitter - Product (e-commerce) -->

    <!-- Open Graph general (Facebook, Pinterest & Google+) -->
    <meta property="og:title" content="{{$product_detail->title}}">
    <meta property="og:description" content="{!! strip_tags($product_detail->description) !!}">
    <meta property="og:image" content="{{asset('upload/images/product/'.$product_detail->feature_image) }}">
    <meta property="og:url" content="{{ url()->full() }}">
    <meta property="og:site_name" content="{{Config::get('siteSetting.site_name')}}">
    <meta property="og:locale" content="bd">
    <meta property="og:type" content="product">
@endsection

@section('css')
  <style>
    .reviews{background: #fff;}
    .single-review{border-bottom: 1px solid #eff0f5;padding: 10px;}
    .single-review .review-img{float: left;flex: inherit;}
    .single-review .review-top-wrap{margin:0px;}
    .out-stock{background: #ff5050; padding: 3px 5px; border-radius: 5px; color: #fff;}
    .in-stock {background: #329c32; padding: 3px 5px; border-radius: 5px; color: #fff;} 
    .heading {
      font-size: 15px;
      margin-right: 25px;
    }
    .average-ratting .fa {
      font-size: 20px;
    }
    .checked {
      color: orange;
    }
    /* Three column layout */
    .side {
      float: left;
      width: 12%;
      margin-top:0px;
    }
    .middle {
      margin-top:0px;
      float: left;
      width: 70%;
    }
    /* Place text to the right */
    .right {
      padding-left: 5px;
    }
    /* Clear floats after the columns */
    .row:after {
      content: "";
      display: table;
      clear: both;
    }
    /* The bar container */
    .bar-container {
      width: 100%;
      background-color: #f1f1f1;
      text-align: center;
      color: white;
    }
    /* Individual bars */
    .bar-5 {width: {{ ($total_review >0) ? ($ratting5 / $total_review)*100 : 0 }}%; height: 16px; background-color: #ff9800;}
    .bar-4 {width: {{ ($total_review >0) ? ($ratting4 / $total_review)*100 : 0 }}%; height: 16px; background-color: #ff9800;}
    .bar-3 {width: {{ ($total_review >0) ? ($ratting3 / $total_review)*100 : 0 }}%; height: 16px; background-color: #ff9800;}
    .bar-2 {width: {{ ($total_review >0) ? ($ratting2 / $total_review)*100 : 0 }}%; height: 16px; background-color: #ff9800;}
    .bar-1 {width: {{ ($total_review >0) ? ($ratting1 / $total_review)*100 : 0 }}%; height: 16px; background-color: #ff9800;}
    /* Responsive layout - make the columns stack on top of each other instead of next to each other */
    .review-filterSort {
        height: 44px;
        padding-left: 10px;
        margin: 10px 0;
        border-top: 1px solid #eff0f5;
        border-bottom: 1px solid #eff0f5;
    }
    .review-filterSort .filterSort {
        float: right;
        display: inline-block;
        padding: 0 12px;
        height: 44px;
        line-height: 44px;
        border-left: 1px solid #eff0f5;
        font-size: 13px;
        color: #757575;
        cursor: pointer;
    }
    .review-filterSort .title {
        display: inline-block;
        height: 44px;
        line-height: 44px;
        font-size: 14px;
        color: #212121;
    }
    .availability.in-stock span {
        color: #fff;
        background-color: #5cb85c;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: bold;
    }
    /*text more & less*/
    a.morelink {
        text-decoration:none;
        outline: none;
    }
    .morecontent span {
        display: none;
    }
    /*text more & less*/
    .divrigth_border:after {
    content: '';
      width: 0;
      height: 100%;
      position: absolute;
      top: 3px;
      right: 0px;
      margin-left: 0px;
      z-index: 999;
      border-right: 1px solid #ececec;
    }

    .delivery_header {
        padding: 5px 0px;
        margin-bottom: 8px;
        border-bottom: 1px solid #eff0f5;
    }
    .location_icon {
        width: 30px;
        font-size: 25px;
        padding-right: 10px;
        text-align: center;
        display: table-cell;
        vertical-align: middle;
    }

    .all_location{
        position: absolute;
        top: 65px;
        right: 15px;
        background: #fff;
        width: 95%;
        padding: 0 10px;
        text-align: left;
        z-index: 999;
        display: none;
      }

    ul.location-list li{border-bottom: 1px solid #e6e6e6cc;cursor: pointer;padding:2px 5px;}
    ul.location-list li:hover{background: #f9f9f9;}

    .location_address {
        max-width: 195px;
        line-height: initial;
        word-break: break-word;
        display: table-cell;
        vertical-align: middle;
        color: #202020;
        padding-right: 15px;
    }
    .location_address p{padding: 0;margin: 0; font-size: 14px;}
    .location_address i{font-size: 11px;}


    .location_link{
      font-size: 11px;
      display: table-cell;
      vertical-align: middle;
      color: #009db4;
      text-align: right;
      text-transform: uppercase;
      white-space: nowrap;
    }
    .location_link .rate{font-size: 20px;color:#e74c3c;}

    .wishlistbtn{width: 100%;margin-bottom: 10px;}
    .buy-now{width: 100%;background: #ef8c0f;}
    .seller-option{ margin: 10px 0;}
    .seller-header{ border-bottom: 1px solid #eae9e9;font-size: 1.3rem;color: #000;}
    .seller_content { width: 100%; padding-right: 10px; display: table-cell; font-size: 12px;vertical-align: text-bottom;padding: 0 5px;border-right: 1px solid #e6e6e6; text-align: center;}

    .chat_response, .seller_shipTime{font-size: 25px;}
    .view-stor{width:100%;margin:3px 0px; }
    .contact-seller{margin-top: 7px;}
    
    .best-seller-custom.best-seller {

      border-top: 0 !important;
      box-shadow: none;
      border: none;;

    }
    .attribute_title{display: inline-block;vertical-align: top;min-width: 50px;}

    .attributes{
      box-sizing: border-box;
      display: inline-block;
      position: relative;
      margin-right: 5px;
      overflow: hidden;
      text-align: center;

    }
    .attributes_value{
      width: 60px;
      height: 30px;
      box-sizing: border-box;
      display: inline-block;
      position: relative;
   
      margin-right: 5px;
      overflow: hidden;
      text-align: left;
      border: 1px solid #eff0f5;
      border-radius: 3px;
     
    }

    .attribute-select select {
        border-radius: 3px;
        background: #fff;
        border: 1px solid #ff5e00;
        color: #3d3d3d;
        padding: 0 9px;
        margin-bottom: 10px;

    }

    .attributes label{margin: 0;cursor: pointer;text-shadow: 0px 1px 0px #0000003d;font-weight: bold;}
    .attributes input{display: none;}

   .attributes .active .selected{
      background: url('https://www.pinclipart.com/picdir/middle/16-161607_orange-checkmark-clipart-check-mark-clip-art-tick.png') no-repeat left;
      padding: 7px 26px 0px;
      background-size:contain;

  }

  .average-ratting span.fa-stack{width: 23px;}
  .video-btn{position: relative;display: inline-flex;    align-items: center; background: #e2dfdf;width: 70px;height: 70px;}
  .playBtn{position: absolute;text-align: center; width: 100%;font-size: 45px;}

  </style>
@endsection
@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <ul class="breadcrumb-cate">
                <li><a href="{{route('home.category', $product_detail->get_category->slug ?? '') }}">{{$product_detail->get_category->name ?? ''}}</a></li>
                @if($product_detail->get_subcategory ?? false)
                <li><a href="{{route('home.category', [$product_detail->get_category->slug ?? '', $product_detail->get_subcategory->slug]) }}">{{$product_detail->get_subcategory->name}}</a></li>
                @endif
                @if($product_detail->get_childcategory ?? false)
                <li><a href="{{route('home.category', [$product_detail->get_category->slug ?? '', $product_detail->get_subcategory->slug ?? '', $product_detail->get_childcategory->slug]) }}">{{$product_detail->get_childcategory->name}}</a></li>
                @endif
                <li>{{$product_detail->title}}</li>
            </ul>
        </div>
    </div>
 
    <!-- Shop details Area start -->
    <div class="container product-detail" style="padding-top: 10px; background: #fff">
      <div class="row">
          <div id="content" style="padding-top: 0; margin-top: 0" class="col-md-9 col-sm-9 col-xs-12 divrigth_border sticky-content">
              <div class="sidebar-overlay "></div>
              <div class="product-view product-detail">
                <div class="product-view-inner clearfix">
                  <div class="content-product-left  col-md-5 col-sm-6 col-xs-12">
                    <div class="so-loadeding"></div>
                    <div class="large-image  class-honizol">

                     <img class="product-image-zoom" src="{{asset('upload/images/product/'. $product_detail->feature_image)}}" data-zoom-image="{{asset('upload/images/product/'. $product_detail->feature_image)}}" title="image">
                    </div>
                    <div id="thumb-slider" class="full_slider category-slider-inner products-list yt-content-slider" data-rtl="no" data-autoplay="yes" data-pagination="no" data-delay="4" data-speed="0.6" data-margin="10" data-items_column0="3" data-items_column1="3" data-items_column2="3" data-items_column3="3" data-items_column4="2" data-arrows="yes" data-lazyload="yes" data-loop="no" data-hoverpause="yes">
                        <div class="owl2-item " >
                          <div class="image-additional">
                           <a data-index="0" class="img thumbnail" data-image="{{asset('upload/images/product/'. $product_detail->feature_image)}}" >
                           <img src="{{asset('upload/images/product/thumb/'. $product_detail->feature_image)}}" title="thumbnail" >
                           </a>
                          </div>
                         </div>
                         <?php $index = 1; ?>
                        @foreach($product_detail->videos as $video)
                           <a  data-index="{{$index}}"  class="video-btn" data-toggle="modal" data-type="{{$video->provider}}" data-src="{{$video->link}}" data-target="#video_pop">

                           <span class="playBtn"><i class="fa fa-play-circle"></i></span>

                           </a>
                          <?php $index++; ?>
                        @endforeach
                                 
                        @foreach($product_detail->get_galleryImages as $image)
                         <div class="owl2-item " >
                          <div class="image-additional">
                           <a data-index="{{$index}}" class="img thumbnail" data-image="{{asset('upload/images/product/gallery/'. $image->image_path)}}">
                           <img src="{{asset('upload/images/product/gallery/thumb/'. $image->image_path)}}" title="thumbnail {{$index}}" alt="">
                           </a>
                          </div>
                         </div>
                          <?php $index++; ?>
                        @endforeach

                        @foreach ($product_detail->get_variations as $variation)
                        @foreach($variation->get_variationDetails as $variationDetail)
                        @if($variationDetail->image)
                         <div class="owl2-item " >
                          <div class="image-additional">
                           <a data-index="{{$index}}" id="variationImage{{$variationDetail->id}}" class="img thumbnail" data-image="{{asset('upload/images/product/varriant-product/'. $variationDetail->image)}}">
                           <img src="{{asset('upload/images/product/varriant-product/thumb/'. $variationDetail->image)}}" title="thumbnail {{$index}}" alt="">
                           </a>
                          </div>
                         </div>
                          <?php $index++; ?>
                          @endif
                        @endforeach
                        @endforeach
                    </div>
                  </div>
                  <div class="content-product-right col-md-7 col-sm-6 col-xs-12">

                    <div class="title-product">
                     <h1>{{$product_detail->title}}</h1>
                    </div>
                    <div class="box-review">
                      <div class="rating">
                        <div class="rating-box">
                          {{\App\Http\Controllers\HelperController::ratting($avg_ratting)}}
                          <a class="reviews_button" href="#tab-review">{{$total_review}} reviews</a> / <a class="write_review_button" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">Write a review</a>
                        </div>
                      </div>

                      @if($product_detail->get_brand)
                      <p>Brand: {{$product_detail->get_brand->name}} | @endif
                        <span class="availability"> Availability: <span class="@if($product_detail->stock>0) in-stock  @else out-stock @endif"> <i class="fa fa-check-square-o"></i>@if($product_detail->stock>0) In Stock @else  Out of stock @endif</span></span> </p>
                    </div>
                    <div class="inner-box-desc">
                        @if($product_detail->sku)<div class="model"><span>Product SKU: </span> {{$product_detail->sku}}</div>@endif
                        
                      </div>
                    
                    <div class="product_page_price price">
                     
                      <?php  
                        $discount = $calculate_discount = null;
                        $selling_price =  $product_detail->selling_price ;
                        $getOffer =  App\Models\Offer::join('offer_products', 'offers.id', 'offer_products.offer_id')->join('products', 'offer_products.product_id','products.id')
                          ->where('offers.slug', request()->get('offer'))
                          ->where('offer_products.product_id', $product_detail->id)
                          ->where('offers.start_date', '<=',  Carbon\Carbon::now())->where('offers.end_date', '>=', Carbon\Carbon::now())->where('offers.status', '=', 1)->where('offers.offer_type', '!=', 'kanamachi')
                          ->selectRaw('offer_products.offer_discount, offer_products.discount_type')->first();
                        //dd($getOffer);
                        if($getOffer){
                            $discount = $getOffer->offer_discount;
                            $discount_type = $getOffer->discount_type;
                        }else{
                            $discount = $product_detail->discount;
                            $discount_type = $product_detail->discount_type;
                        }
                        $price = $selling_price;
                        if($discount){
                            $calculate_discount = App\Http\Controllers\HelperController::calculate_discount($selling_price, $discount, $discount_type );
                            $price = $calculate_discount['price'];
                        }
                      ?>


                          

                          @if (Auth::guard('reseller')->check())
                          
                          <span class="price-new"><span id="price-special" style="border: 1px solid red; border-radius: 10px 10px; padding: 0 15px">{{Config::get('siteSetting.currency_symble')}}{{$product_detail->reseller_price}}</span></span>

                          @else

                              @if($discount)
                              <span class="price-new"><span id="price-special">{{Config::get('siteSetting.currency_symble')}}{{ $price  }}</span></span>
                              <span>
                                <span class="price-old" id="price-old">{{Config::get('siteSetting.currency_symble')}}{{$selling_price}}</span>
                                <span class="discount">
                                  {{$calculate_discount['discount']}}%
                                  <strong>OFF</strong>
                                </span>
                                </span>
                              @else


                            <span class="price-new"><span id="price-special">{{Config::get('siteSetting.currency_symble')}}{{$selling_price}}</span></span>
                          @endif
                      @endif


                    </div>
                    
                    
                    <!-- <div class="btn-group" id="currency-change">
                        <i>Change Currency</i>
                        <select onchange="currencyChanage(this.value)" style="padding: 1px 10px; border-radius: 3px; font-size: 12px;">
                          @foreach($currencies as $currency)
                          <option value="{{$currency->code}}">{{$currency->symbol .' '. $currency->code}}</option> 
                          @endforeach

                        </select>
                      </div> -->
                    <!-- check weather offer  -->
                    <form action="{{route('buyDirect')}}{{(request()->get('offer')) ? '?offer='. request()->get('offer') : ''}}" id="addToCart" method="post">
                    @csrf
                    @if(request()->get('offer')) <input type="hidden" value="{{ request()->get('offer') }}" name="offer"> @endif
                    <div class="product-box-desc">
                      <!-- //get feature attribute-->
                      @foreach ($product_detail->get_variations as $variation)

                        <!-- show attribute name -->
                        <?php $i=1; $attribute_name = str_replace(' ', '', $variation->attribute_name); ?>
                        @if($variation->in_display==2)

                        <div class="product-size attribute-select">
                            <span class="attribute_title"> {{$variation->attribute_name}}: </span>
                            <select name="{{$attribute_name}}">
                                <!-- get feature details -->
                                @foreach($variation->get_variationDetails as $variationDetail)

                                  <option value="{{ $variationDetail->attributeValue_name}}">{{ $variationDetail->attributeValue_name}}</option>

                                @endforeach
                            </select>
                        </div>
                        @else
                        <div class="product-size">
                          <ul>
                              <li class="attribute_title">{{$variation->attribute_name}}: </li>
                              <li class="attributes {{$attribute_name}}">
                              <!-- get variation details -->
                               @foreach($variation->get_variationDetails as $variationDetail)
                                <!-- show variation attribute value name -->
                                  @if($variationDetail->quantity > 0)
                                  <label data-price="{{$variationDetail->price}}" id="productVariation{{$variationDetail->id}}" onclick="productVariation({{$variationDetail->id}})" style="background:{{$variationDetail->color}} url('{{asset('upload/images/product/varriant-product/thumb/'. $variationDetail->image)}}'); background-size: cover; color:#ebebeb; @if($variation->attribute_name != 'Color') width: inherit;height: inherit; @endif" class="attributes_value @if($i == 1) active @endif" for="{{$attribute_name.$variationDetail->id}}" >
                                  <span class="selected">
                                  <input @if($i == 1) checked @endif onclick="changeColor('{{$attribute_name}}', {{$variationDetail->id}})" id="{{$attribute_name.$variationDetail->id}}" value="{{ $variationDetail->attributeValue_name}}" name="{{$attribute_name}}"  type="{{($variation->in_display==3) ? 'radio' : 'radio'}}" />

                                  {{ $variationDetail->attributeValue_name}}</span> </label>
                                  <?php $i++; ?>
                                  @endif
                                @endforeach
                              </li>
                            </ul>
                        </div>
                        @endif
                      @endforeach
                    </div>
                    <div class="short_description form-group">
                     <h3>OverView</h3>
                     {!! $product_detail->summery !!}
                        <br>
                        <a onclick="navigator.clipboard.writeText('{{$product_detail->summery}}')"  >Click to Copy <i class="fa fa-copy"></i></a>
                    </div>
                    <div id="product">

                        <div class="box-cart clearfix">
                        <div class="form-group box-info-product">
                          <div class="option quantity">
                            <div class="input-group quantity-control" unselectable="on" style="user-select: none;">
                             <input class="form-control" value="{{($product_detail->sales_type == 'B2B') ? $product_detail->minimum_order_qty : 1}}" min="{{($product_detail->sales_type == 'B2B') ? $product_detail->minimum_order_qty : 1}}" type="text" name="quantity">
                             <input type="hidden" name="product_id" value="{{$product_detail->id}}">
                             <span class="input-group-addon product_quantity_down fa fa-caret-down"></span>
                             <span class="input-group-addon product_quantity_up fa fa-caret-up"></span>
                            </div>
                          </div>

                          <div class="cart">
                            <!-- voucher product cannot added cart -->
                            @if($product_detail->voucher != 1)
                            <input type="button" value="{{str_replace('-', ' ', $product_detail->product_type ?? 'Add to cart')}}" class="addToCartBtn btn btn-mega btn-lg " data-toggle="tooltip" title="Add to cart" data-original-title="Add to cart">
                            @endif

                                  <input style="background: #0077b5;" type="submit" value="Buy Now" class="btn btn-success buyNowBtn" data-toggle="tooltip" title="Buy Now" data-original-title="Buy Now">

                          </div>
                            <h1></h1>
                          <div class="add-to-links wish_comp">
                            <ul class="blank">
                             <li class="wishlist" title="Add To Wishlist" data-toggle="tooltip" data-original-title="Add To Wishlist">
                              <a  @if(Auth::check())  onclick="addToWishlist({{$product_detail->id}})" @else data-toggle="modal" data-target="#so_sociallogin" @endif ><i class="fa fa-heart"></i></a>
                             </li>
                             <li class="compare" title="Add To Compare" data-toggle="tooltip" data-original-title="Add To Compare">
                              <a onclick="addToCompare({{$product_detail->id}})"  ><i class="fa fa-random"></i></a>
                             </li>

                             <li class="compare" title="Copy to clipboard" data-toggle="tooltip" data-original-title="Add To Compare">

                              <a onclick="navigator.clipboard.writeText('{{url()->current()}}')"  ><i class="fa fa-copy"></i></a>

                             </li>

                             <li class="compare" title="Share on facebook" data-toggle="tooltip" data-original-title="Add To Compare">

                              <a href="https://facebook.com/sharer.php?u={{ url()->current() }}"  target="_blank"><i class="fa fa-facebook"></i></a>
                             </li>

                            </ul>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </form>
                  </div>
                </div>
              </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12 sticky-content" >
            
              <div class="delivery-option">
                <div class="delivery-header">
                  <div class="delivery_header_title">Delivery Options</div>
                </div>
            
                @if($product_detail->shipping_method == 'location')
                <div class="delivery_header">
                  <div class="delivery_location">
                    <div class="location_icon">
                      <i class="fa fa-map-marker"></i>
                    </div>
                    <div class="location_address">
                      <p>Shipping Cost</p>
                      <i>Under {{$product_detail->shipping_region->name ?? ''}} : {{Config::get('siteSetting.currency_symble') .' '.  $product_detail->shipping_cost}}</i><br/>
                      <i>Outside {{$product_detail->shipping_region->name ?? ''}}: {{Config::get('siteSetting.currency_symble') .' '. $product_detail->other_region_cost}}</i><br/>
                      @if($product_detail->shipping_time)<i>Estimated shipping time: {{$product_detail->shipping_time}}</i>@endif
                    </div>
                    <div class="location_link">
                      <a class="rate">@if($product_detail->shipping_cost){{Config::get('siteSetting.currency_symble')}}{{$product_detail->shipping_cost}}@endif</a>
                    </div>
                  </div>
                </div>
               
                @elseif($product_detail->shipping_method == 'free')

                <div class="delivery_header">
                  <div class="delivery_location">
                        <div class="location_icon">
                          <i class="fa fa-shipping-fast">{{Config::get('siteSetting.currency_symble')}}</i>
                        </div>
                        <div class="location_address">
                          <p>Free Shipping Available</p>
                           @if($product_detail->shipping_time)<i>Estimated shipping time: {{$product_detail->shipping_time}}</i>@endif
                        </div>
                    </div>
                </div>
                @elseif($product_detail->shipping_method == 'price')
                <div class="delivery_header">
                  <div class="delivery_location">
                        <div class="location_icon">
                          <i class="fa fa-home"></i>
                        </div>
                        <div class="location_address">
                          <p>Shipping Cost</p>
                          @if($product_detail->shipping_time)<i>Estimated shipping time: {{$product_detail->shipping_time}}</i>@endif
                         </div>
                          <div class="location_link">
                           <a class="rate">@if($product_detail->shipping_cost){{Config::get('siteSetting.currency_symble')}}{{$product_detail->shipping_cost}}@endif</a>
                        </div>
                    </div>
                </div>
                @else
                <div class="delivery_header">
                  <div class="delivery_location">
                        <div class="location_icon">
                          <i class="fa fa-home"></i>
                        </div>
                        <div class="location_address">
                          <p>Shipping Cost</p>
                          @if($product_detail->shipping_time)<i>Estimated shipping time: {{$product_detail->shipping_time}}</i>@endif
                         </div>
                          <div class="location_link">
                           <a class="rate">@if($product_detail->shipping_cost){{Config::get('siteSetting.currency_symble')}}{{$product_detail->shipping_cost}}@endif</a>
                        </div>
                    </div>
                </div>
                @endif

                @if($product_detail->cash_on_delivery)
                <div class="delivery_header">
                  <div class="delivery_location">
                        <div class="location_icon">
                          <i class="fa fa-handshake">{{Config::get('siteSetting.currency_symble')}}</i>
                        </div>
                        <div class="location_address">
                          <p>Cash on delivery available</p>
                         </div>
                    </div>
                </div>
                @endif

                <div class="delivery_header">
                  <div class="delivery_location">
                        <div class="location_icon">
                          <i class="fa fa-handshake">{{Config::get('siteSetting.currency_symble')}}</i>
                        </div>
                        <div class="location_address">
                          <p> Secure Payment</p>
                          <i>100% secure payment</i>
                        </div>
                    </div>
                </div>
              </div>
            
              <div class="seller-option">

                @if($product_detail->vendor)
                Sold By
                <div class="seller-header">
                  <a href="{{ route('shop_details', $product_detail->vendor->slug) }}"> <i class="fa fa-shopping-bag"></i> {{$product_detail->vendor->shop_name}}

                    <!-- <span style="float: right;"><i class="fa fa-comments"></i> Chat Now</span> --></a>
                </div>
                <div class="delivery_header">
                  @php $seller_ratting = ($product_detail->vendor) ?  round($product_detail->vendor->reviews->avg('ratting'), 1) : 0; @endphp
                  <div class="delivery_location">
                        <div class="seller_content ">
                          Ratings
                          <div class="seller_ratting">
                          {{\App\Http\Controllers\HelperController::ratting($seller_ratting)}}
                          </div>
                        </div><div class="seller_content ">
                          
                          <div class="seller_ratting">
                          <a class="btn-success btn" style="margin-top: 15px;" href="{{ route('shop_details', $product_detail->vendor->slug) }}">
                                  <i class="icofont-plus"></i>
                                  Visit Store
                                </a>
                          </div>
                        </div>
                        

                          <div class="contact-seller">
                            <ul class="list">
                              <li>
                                
                              </li>
                             
                            </ul>
                        </div>
                  </div>
                </div>
                @endif
              </div>
          </div>
      </div>
      <div class="row">
        <div class="product-attribute module" style="overflow-x: scroll;">
          <div class="row content-product-midde clearfix">
              <div class="col-xs-12">
                <div class="producttab ">
                  <div class="tabsslider  ">
                    <ul class="nav nav-tabs font-sn">
                       <li class="active"><a data-toggle="tab" href="#tab-description">Description</a></li>

                       <li class=""><a data-toggle="tab" href="#tab-download">Download Image</a></li>

                        @if(strlen($product_detail->specification) > 0)

                       <li><a href="#tab-specification" data-toggle="tab">Specification</a></li>
                    @endif
                      <!--  <li><a href="#tab-review" data-toggle="tab">Buy & Return Policy</a></li> -->
                    </ul>
                    <div class="tab-content ">
                      <div class="tab-pane active" id="tab-description">

                         {!! $product_detail->description !!}

                          <a onclick="navigator.clipboard.writeText('{{$product_detail->description}}')" class="d-md-block d-none">Click to copy<i class="fa fa-copy"></i></a>

                      </div>

                         <div class="tab-pane" id="tab-download">

                             <h4>Gallery Image</h4>

                             @foreach($product_detail->get_galleryImages as $image)
                                 <a href="{{ route('download', ['g', $image->image_path]) }}">
                                     <img src="{{asset('upload/images/product/gallery/thumb/'. $image->image_path)}}" title="thumbnail {{$index}}" alt="" style="width: 90px">
                                 </a>
                             @endforeach


                             <h4>Varrient Image</h4>
                             @foreach ($product_detail->get_variations as $variation)
                                 @foreach($variation->get_variationDetails as $variationDetail)
                                     @if($variationDetail->image)
                                         <a href="{{ route('download', ['v', $variationDetail->image]) }}">
                                             <img src="{{asset('upload/images/product/varriant-product/thumb/'. $variationDetail->image)}}" title="thumbnail" alt="" style="width: 90px">
                                         </a>
                                     @endif
                                 @endforeach
                             @endforeach




                      </div>



                      @if(strlen($product_detail->specification) > 0)
                            <div class="tab-pane" id="tab-specification">
                                <div class="row">
                                    <div class="col-md-8" >
                                        <p>
                                            {!! $product_detail->specification !!}

                                        </p>
                                        {{--@foreach($product_detail->get_features as $feature)

                                          <div class="col-6 col-md-6">
                                              <strong>{{ $feature->name }}: </strong> {{$feature->value}}
                                          </div>
                                        @endforeach--}}
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
     
    </div>
  <div class="container" style="background: #fff;margin-top: 5px;">
     <div class="row" >
          <div class="col-md-12" id="tab-review">
            <div class="row">
                <div class="col-md-12">
                    <!-- Section Title -->
                    <div class="section-title">
                        <h2>Customer reviews</h2>
                    </div>
                    <!-- Section Title -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 average-ratting">
                    <h1 class="heading">User Rating</h1>
                    <p style="font-size: 30px;"><span style="font-size: 50px">{{$avg_ratting}}</span>/5</p>
                    {{\App\Http\Controllers\HelperController::ratting($avg_ratting)}}
                    <p>{{$avg_ratting}} average based on {{$total_review}} reviews.</p>
                    
                </div>
               
                <div class="col-md-8">
                    <div class="side">
                    <div>5 star</div>
                    </div>
                    <div class="middle">
                    <div class="bar-container">
                    <div class="bar-5"></div>
                    </div>
                    </div>
                    <div class="side right">
                    <div>{{$ratting5}}</div>
                    </div>
                    <div class="side">
                    <div>4 star</div>
                    </div>
                    <div class="middle">
                    <div class="bar-container">
                    <div class="bar-4"></div>
                    </div>
                    </div>
                    <div class="side right">
                    <div>{{$ratting4}}</div>
                    </div>
                    <div class="side">
                    <div>3 star</div>
                    </div>
                    <div class="middle">
                    <div class="bar-container">
                    <div class="bar-3"></div>
                    </div>
                    </div>
                    <div class="side right">
                    <div>{{$ratting3}}</div>
                    </div>
                    <div class="side">
                    <div>2 star</div>
                    </div>
                    <div class="middle">
                    <div class="bar-container">
                    <div class="bar-2"></div>
                    </div>
                    </div>
                    <div class="side right">
                    <div>{{$ratting2}}</div>
                    </div>
                    <div class="side">
                    <div>1 star</div>
                    </div>
                    <div class="middle">
                    <div class="bar-container">
                    <div class="bar-1"></div>
                    </div>
                    </div>
                    <div class="side right">
                    <div>{{$ratting1}}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="review-filterSort">
                        <span class="title">Product Reviews</span>
                        <!-- <div class="filterSort">
                            <i class="fa fa-sort"></i><span> Filter:</span><span class="condition">All star</span>
                        </div>
                        <div class="filterSort">
                            <i class="fa fa-sort"></i><span> Sort:</span>
                            <span class="condition">Relevance</span>
                        </div> -->
                    </div>
                </div>
                <div class="col-md-12">
                  @if(count($product_detail->reviews)>0)
                    <div class="review-wrapper blog-listitem">
                      @foreach($product_detail->reviews->toArray() as $review)
                        <div class="single-review">
                            <div class="review-img">
                                <img width="35" height="35" src="{{asset('upload/users/'.$review['user']['photo'])}}" alt=" " />
                            </div>
                            <div class="review-content">
                                <div class="review-top-wrap">
                                    <div class="review-left">
                                        <div class="rating-product">
                                          @for($r=1; $r<=5; $r++)
                                            <i class="fa fa-star {{ ($r <= $review['ratting']) ? 'checked' : ' ' }}"></i>
                                          @endfor
                                          <p style="margin: -8px 0 0;"> By <a href="#">{{$review['user']['name']}}</a> | {{Carbon\Carbon::parse($review['created_at'])->diffForHumans()}}</p>
                                        </div>
                                        
                                         <!-- <div style="float: right;">
                                            <a href="#">Reply</a>
                                        </div> -->
                                    </div>
                                    
                                </div>
                               
                                <div class="review-bottom">
                                    <p class="more">
                                       {{ $review['review'] }}
                                    </p>
                                    @foreach($review['review_image_video'] as $image_video)
                                        
                                        @if( $image_video['review_image'])
                                        <a style="display: inline-flex;" class="popup-gallery" href="{{asset('upload/review/'.$image_video['review_image'])}}">
                                          <img  width="70" height="70" src="{{asset('upload/review/'.$image_video['review_image'])}}" alt="">
                                        </a>
                                        @endif

                                        @if( $image_video['review_video'])
                                          <a href="#" class="video-btn" data-toggle="modal" data-type="video" data-src="{{asset('upload/review/'.$image_video['review_video'])}}" data-target="#video_pop">
                                            <span class="playBtn"><i class="fa fa-play-circle"></i></span>
                                          </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                      @endforeach
                    </div>
                  @else
                  <div style="text-align: center;">No product reviews</div>
                  @endif
                </div>
            </div>
          </div>
          
        </div>
        </div>
    @if(count($related_products)>0)
      <section style="margin-bottom: 10px;">
        <div class="container">
          <div class="products-list grid row number-col-6 so-filter-gird" >
             <h3 class="modtitle" style="margin:10px 0 0">Related Products</h3>
              @foreach($related_products as $product)
              <div class="product-layout col-lg-2 col-md-2 col-sm-4 col-xs-6">
                  @include('frontend.products.products')
              </div>
              @endforeach
          </div>
        </div>
      </section>
    @endif
    <div class="modal fade in" id="video_pop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content" style="background-color: inherit;border:none;box-shadow: none;">
           <div class="modal-body">        
              <button style="background: #bdbdbd;color:#f90101;opacity: 1;padding: 0 5px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>        
               <!-- 16:9 aspect ratio -->
               <div id="showVideoFrame"></div>                
           </div>        
         </div>
       </div>
    </div>
@endsection


@section('js')
  <script type="text/javascript">
    
      function productVariation(id){
        $('#variationImage'+id).click();
        var price = $('#productVariation'+id).data('price');
        if(price){
          $('#price-special').html('{{Config::get('siteSetting.currency_symble')}}'+price);
        }
      }
      function currencyChanage(currency_code){
         
        var price = '{{$price}}';
       
        $.ajax({
          url:'{{route("changeCurrency")}}',
          type:'get',
          data:{currency_code:currency_code,price:price},
          success:function(data){
              if(data.status){
                $('#price-special').html(data.price);
              }
            }
        });
      }
  </script>
  <script>
      $('.large-image').magnificPopup({
        items: [
          {src: '{{asset("upload/images/product/". $product_detail->feature_image)}}' },
        @foreach($product_detail->get_galleryImages as $image)
          {src: '{{asset("upload/images/product/gallery/". $image->image_path)}}' },
        @endforeach
        @foreach ($product_detail->get_variations as $variation)
        @foreach($variation->get_variationDetails as $variationDetail)
        @if($variationDetail->image)
          {src: '{{asset("upload/images/product/varriant-product/". $variationDetail->image)}}' },
          @endif
        @endforeach
        @endforeach
        ],
        gallery: { enabled: true, preload: [0,2] },
        type: 'image',
        mainClass: 'mfp-fade',
        callbacks: {
          open: function() {

            var activeIndex = parseInt($('#thumb-slider .img.active').attr('data-index'));
            var magnificPopup = $.magnificPopup.instance;
            magnificPopup.goTo(activeIndex);
          }
        }
      });
  </script>

  <script type="text/javascript">
      function changeColor(name, id){

        $('.'+name+' label').click(function() {
          $(this).addClass('active').siblings().removeClass('active');
        });

      }


      $('.addToCartBtn').click(function(){

          $.ajax({
            url:'{{route("cart.add")}}',
            type:'get',

            data:$('#addToCart').serialize(),
            success:function(data){
                if(data.status == 'success'){
                    var url = window.location.origin;
                    addProductNotice(data.msg, '<img src="'+url+'/upload/images/product/thumb/'+data.image+'" alt="">', '<h3>'+data.title+'</h3>', 'success');

                    $('.cartCount').html(Number($('.cartCount').html())+1);

                }else{
                    toastr.error(data.msg);
                }
              }
          });
      });

  </script>

  <!-- text more & less -->
  <script type="text/javascript">



      $(document).ready(function() {



        var showChar = 200;
        var ellipsestext = "...";
        var moretext = "more";
        var lesstext = "less";
        $('.more').each(function() {
            var content = $(this).html();

            if(content.length > showChar) {

                var c = content.substr(0, showChar);
                var h = content.substr(showChar-1, content.length - showChar);

                var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                $(this).html(html);
            }

        });

        $(".morelink").click(function(){
            if($(this).hasClass("less")) {
                $(this).removeClass("less");
                $(this).html(moretext);
            } else {
                $(this).addClass("less");
                $(this).html(lesstext);
            }
            $(this).parent().prev().toggle();
            $(this).prev().toggle();
            return false;
        });
    });



  </script>
  <!-- text more & less -->
@endsection
