
  <link href="{{asset('frontend')}}/css/quickview/quickview.css" rel="stylesheet">
    <style type="text/css">
      
      .availability.in-stock span {
        color: #fff;
        background-color: #5cb85c;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: bold;
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
      box-sizing: border-box;
      display: inline-block;
      position: relative;
      height: 25px;
      margin-right: 5px;
      overflow: hidden;
      text-align: center;
      border: 1px solid #eff0f5;
      border-radius: 2px;
      padding: 0 3px;
     
    }

    .attribute-select select {
        border-radius: 3px;
        background: #fff;
        border: 1px solid #ff5e00;
        color: #3d3d3d;
        padding: 0 9px;
        margin-bottom: 10px;
     
    }

    .attributes label{margin: 0;cursor: pointer;text-shadow: 0px 1px 0px #0000003d;}
    .attributes input{display: none;}
     
   .attributes .active .selected{
      background: url('{{asset('frontend')}}/image/icon/icon-whylist.png') no-repeat left;
      padding-left: 15px;
     
     
  }
    </style>


  @php
  $avg_ratting = round($product->reviews->avg('ratting'), 1);
  $total_review = count($product->reviews);

@endphp
    
<div id="wraper">
    
  <!-- Main Container  -->
  
  
  <div class="product-detail">
    <div id="product-quick" class="product-info">
      <div class="product-view row">
        <div class="left-content-product ">
          <div class="product-view product-detail">
                  <div class="product-view-inner clearfix">
                     <div class="content-product-left  col-md-5 col-sm-6 col-xs-12">
                      <div class="so-loadeding"></div>
                      <div class="large-image  class-honizol">
                       
                       <img class="product-image-zoom" src="{{asset('upload/images/product/'. $product->feature_image)}}" data-zoom-image="{{asset('upload/images/product/'. $product->feature_image)}}" title="image">
                      </div>
                      <div id="thumb-slider" class="full_slider category-slider-inner products-list yt-content-slider" data-rtl="no" data-autoplay="no" data-pagination="no" data-delay="4" data-speed="0.6" data-margin="10" data-items_column0="3" data-items_column1="3" data-items_column2="3" data-items_column3="3" data-items_column4="2" data-arrows="yes" data-lazyload="yes" data-loop="no" data-hoverpause="yes">
                          <div class="owl2-item " >
                            <div class="image-additional">
                             <a data-index="0" class="img thumbnail" data-image="{{asset('upload/images/product/'. $product->feature_image)}}" title="Canada Travel One or Two European Facials at  Studio">
                             <img src="{{asset('upload/images/product/thumb/'. $product->feature_image)}}" title="thumbnail" >
                             </a>
                            </div>
                           </div>
                          <?php $index = 1; ?>
                          @foreach($product->get_galleryImages as $image)
                           <div class="owl2-item " >
                            <div class="image-additional">
                             <a data-index="{{$index}}" class="img thumbnail" data-image="{{asset('upload/images/product/gallery/'. $image->image_path)}}" title="Canada Travel One or Two European Facials at  Studio">
                             <img src="{{asset('upload/images/product/gallery/thumb/'. $image->image_path)}}" title="thumbnail {{$index}}" >
                             </a>
                            </div>
                           </div>
                            <?php $index++; ?>
                         @endforeach

                           
                      </div>
                    </div>
                    <div class="content-product-right col-md-7 col-sm-6 col-xs-12">
                      
                      <div class="title-product">
                       <h1>{{$product->title}}</h1>
                      </div>
                      <div class="box-review">
                        <div class="rating">
                          <div class="rating">
                          <div class="rating-box">
                            {{\App\Http\Controllers\HelperController::ratting($avg_ratting)}}
                            <a class="reviews_button" href="#tab-review">{{$total_review}} reviews</a> 
                          </div>
                        </div>
                       
                        @if($product->get_brand)
                        <p>Brand: {{$product->get_brand->name}} | @endif <span class="availability in-stock"> Availability: <span> <i class="fa fa-check-square-o"></i> In Stock</span></span> </p>
                      </div>
                      <div class="product_page_price price">
                        @php
                            $discount =  \App\Http\Controllers\OfferController::discount($product->id, Session::get('offerId'));
                        @endphp
                        @if($discount)
                          <span class="price-new"><span id="price-special">{{Config::get('siteSetting.currency_symble')}}{{$discount['discount_price'] }}</span></span>
                            <span>
                              <span class="price-old" id="price-old">{{Config::get('siteSetting.currency_symble')}}{{$product->selling_price}}</span>
                              <span class="discount">
                               -@if($discount['discount_type'] != '%'){{$discount['discount_type']}}@endif{{$discount['discount']}}@if($discount['discount_type'] == '%'){{$discount['discount_type']}}@endif

                                <strong>OFF</strong>
                              </span>
                            </span>
                        @else
                            <span class="price-new"><span id="price-special">{{Config::get('siteSetting.currency_symble')}}{{$product->selling_price}}</span></span>
                        @endif

                      </div>
                      <form action="{{route('cart.add')}}" id="addToCart" method="get"> 
                      <div class="product-box-desc">
                       
                        @foreach ($product->get_variations as $variation)
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
                                <!-- get feature details -->
                                 @foreach($variation->get_variationDetails as $variationDetail)
                                  <!-- show feature attribute value name -->

                                    <label @if($variationDetail->color) style="background:{{$variationDetail->color}}; color:#ebebeb; " @endif class="attributes_value @if($i == 1) active @endif" for="{{$attribute_name.$variationDetail->id}}" >
                                    <span class="selected"></span>
                                    <input @if($i == 1) checked @endif onclick="changeColor('{{$attribute_name}}', {{$variationDetail->id}})" id="{{$attribute_name.$variationDetail->id}}" value="{{ $variationDetail->attributeValue_name}}" name="{{$attribute_name}}"  type="{{($variation->in_display==3) ? 'radio' : 'radio'}}" />

                                    {{ $variationDetail->attributeValue_name}}</label>
                                    <?php $i++; ?>

                                  @endforeach
                                </li>
                              </ul>
                          </div>
                          @endif
                        @endforeach
                      </div>
                      <div class="short_description form-group">
                       <h3>OverView</h3>
                       {{Str::limit($product->summery, 150)}}
                      </div>
                     
                      <div id="product">
                          <div class="box-cart clearfix">
                          <div class="form-group box-info-product">
                             <div class="option quantity">
                              <div class="input-group quantity-control" unselectable="on" style="user-select: none;">
                               <input class="form-control" type="text" name="quantity" value="1">
                               <input type="hidden" name="product_id" value="{{$product->id}}">
                               <span class="input-group-addon product_quantity_down fa fa-caret-down"></span>
                               <span class="input-group-addon product_quantity_up fa fa-caret-up"></span>
                              </div>
                             </div>
                             <div class="cart">
                              <input type="button" value="Add to Cart" class="addToCartBtn btn btn-mega btn-lg " data-toggle="tooltip" title="Add to cart" data-original-title="Add to cart">
                           
                              <input style="background: #0077b5;" type="button" id="buy-now" value="Buy Now" class="btn btn-success" data-toggle="tooltip" title="Buy Now" data-original-title="Buy Now">
                              </div>
                             <div class="add-to-links wish_comp">
                              <ul class="blank">
                               <li class="wishlist">
                                <a title="Add To Wishlist" onclick="addToWishlist({{$product->id}})" ><i class="fa fa-heart"></i></a>
                               </li>
                               <li class="compare">
                                <a title="Add To Compare" onclick="addToCompare({{$product->id}})"  ><i class="fa fa-random"></i></a>
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
      </div>
    </div>
  </div>
    
  <!-- //Main Container -->


</div>



<!-- End Color Scheme
============================================ -->



<!-- Include Libs & Plugins
============================================ -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="{{asset('frontend')}}/js/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="{{asset('frontend')}}/js/bootstrap.min.js"></script>

<script type="text/javascript" src="{{asset('frontend')}}/js/owl-carousel/owl.carousel.js"></script>
<script type="text/javascript" src="{{asset('frontend')}}/js/slick-slider/slick.js"></script>
<script type="text/javascript" src="{{asset('frontend')}}/js/themejs/libs.js"></script>
<script type="text/javascript" src="{{asset('frontend')}}/js/unveil/jquery.unveil.js"></script>
<script type="text/javascript" src="{{asset('frontend')}}/js/countdown/jquery.countdown.min.js"></script>
<script type="text/javascript" src="{{asset('frontend')}}/js/dcjqaccordion/jquery.dcjqaccordion.2.8.min.js"></script>
<script type="text/javascript" src="{{asset('frontend')}}/js/datetimepicker/moment.js"></script>
<script type="text/javascript" src="{{asset('frontend')}}/js/datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="{{asset('frontend')}}/js/jquery-ui/jquery-ui.min.js"></script>


<script type="text/javascript" src="{{asset('frontend')}}/js/quickview/jquery.magnific-popup.min.js"></script>

<script type="text/javascript" src="{{asset('frontend')}}/js/themejs/application.js"></script>
<script type="text/javascript" src="{{asset('frontend')}}/js/themejs/homepage.js"></script>

<script type="text/javascript" src="{{asset('frontend')}}/js/themejs/addtocart.js"></script>  

  <script>
      $('.large-image').magnificPopup({
        items: [
          {src: '{{asset("upload/images/product/". $product->feature_image)}}' },
        @foreach($product->get_galleryImages as $image)
          {src: '{{asset("upload/images/product/gallery/". $image->image_path)}}' },
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
   $('#buy-now').click(function(){
          $.ajax({
            url:'{{route("buyDirect")}}',
            type:'get',
            data:$('#addToCart').serialize()+ '&buyDirect=buy',
            success:function(data){
                if(data.status == 'success'){
                  link = "{{route('checkout', ':product_id')}}";
                  link = link.replace(':product_id', data.buy_product_id);
                  window.location.href = link+"?process-to-checkout";
                }else{
                  toastr.error(data.msg);
                }
              }
          });
      });

      $('.addToCartBtn').click(function(){
          
          $.ajax({
            url:'{{route("cart.add")}}',
            type:'get',
           
            data:$('#addToCart').serialize(),
            success:function(data){
                if(data.status == 'success'){
                    var url = window.location.origin;
                    addProductNotice(data.msg, '<img src="'+url+'/upload/images/product/thumb/'+data.image+'" alt="">', '<h3>'+data.title+'</h3>', 'success');
       
                    $('#cartCount').html(Number($('#cartCount').html())+1);
                   
                }else{
                    toastr.error(data.msg);
                }
              }
          });
      });

</script>

