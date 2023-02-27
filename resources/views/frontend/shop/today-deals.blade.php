<?php  

$products = App\Models\Product::with('offer_discount.offer:id')->where('status', 'active')->where('vendor_id', $seller->id)
->selectRaw('products.id,title,selling_price,discount,discount_type, slug, feature_image')->orderBy('id', 'desc')->take(10)->get(); 

?>
@if(count($products)>0)
<section class="section" >
 
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        
          <span class="title">Today Deals</span> 
         <!--  <span class="moreBtn" ><a href="" >See More</a></span> -->
         
          <div class="clearfix module horizontal">
              <div class="products-category">
                  <div class="category-slider-inner products-list yt-content-slider releate-products grid" data-rtl="yes" data-autoplay="yes" data-pagination="no" data-delay="1" data-speed="1.5" data-margin="5" data-items_column0="6" data-items_column1="6" data-items_column2="5" data-items_column3="3" data-items_column4="2" data-arrows="yes" data-lazyload="yes" data-loop="yes" data-hoverpause="yes">
                    @foreach($products as $product)
                    <div class="item-inner product-thumb trg transition product-layout">
                        @include('frontend.homepage.products')
                    </div>
                    @endforeach
                  </div>
              </div>
          </div>
      </div>
  
  </div>
</section>
@endif