<?php  

$products = App\Models\Product::with('offer_discount.offer:id')->where('status', 'active')->where('vendor_id', $seller->id)->selectRaw('id,title,selling_price,discount,discount_type, slug, feature_image')->orderBy('views', 'desc')->take(12)->get(); 
?>
@if(count($products)>6)
<section class="section" >
 <span class="title"> Recommended For You</span>
  <div class="products-list grid row number-col-4 so-filter-gird" style="margin-left: 0px;">
      @foreach($products as $product)
      <div class="product-layout col-lg-2 col-md-2 col-sm-3 col-xs-6">
          @include('frontend.products.products')
      </div>
      @endforeach
  </div>
</section>
@endif