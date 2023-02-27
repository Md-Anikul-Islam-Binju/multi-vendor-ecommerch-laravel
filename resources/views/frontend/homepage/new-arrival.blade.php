<?php  

$products = App\Models\Product::where('status', 'active')
->selectRaw('products.id,title,selling_price,discount,discount_type, slug, feature_image')->orderBy('id', 'desc')->take($section->item_number)->get(); 

?>
@if(count($products)>0)
<section class="section" @if($section->layout_width == 1) style="background:{{$section->background_color}}" @endif>
  <div class="container" @if($section->layout_width != 1) style="background:{{$section->background_color}};border-radius: 5px; padding:5px;" @endif>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        
          <span class="title" style="color: {{$section->text_color}} !important;">{{$section->title}}</span> 
          <span class="moreBtn" style="background: linear-gradient(to right, {{$section->background_color}}, #ffffff);border: 1px solid {{$section->text_color}}; box-shadow: 1px 1px 3px -1px {{$section->text_color}}"><a href="{{route('todayDeals')}}" style="color: {{$section->text_color}} !important;">See More</a></span>
         
            <div class="clearfix module horizontal">
                  <div class="products-category">
                      <div class="category-slider-inner products-list yt-content-slider releate-products grid" data-rtl="yes" data-autoplay="yes" data-pagination="no" data-delay="7" data-speed="0.6" data-margin="5" data-items_column0="6" data-items_column1="5" data-items_column2="3" data-items_column3="3" data-items_column4="2" data-arrows="yes" data-lazyload="yes" data-loop="yes" data-hoverpause="yes">
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
  </div>
</section>
@endif