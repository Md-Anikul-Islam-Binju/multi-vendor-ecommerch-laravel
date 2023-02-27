<?php  

$products = App\Models\Product::where('status', 'active')->selectRaw('id,title,selling_price,discount,discount_type, slug, feature_image')->orderBy('views', 'desc')->take($section->item_number)->get(); 
?>
@if(count($products)>0)
<section class="section" @if($section->layout_width == 1) style="background:{{$section->background_color}}" @endif>
  <div class="container" @if($section->layout_width != 1) style="background:{{$section->background_color}};border-radius: 5px; padding:5px;" @endif>
    <div class="row">
      @if($section->thumb_image && $section->image_position == 'left')
        <div class="col-md-3">
          <div style="background: #fff;padding: 5px">
            <img style="width: 100%;height: 100%;" src="{{ asset('upload/images/homepage/'.$section->thumb_image) }}">
          </div>
        </div>
      @endif
      <div class="col-md-{{($section->thumb_image) ? 9 : 12}} col-sm-12 col-xs-12">
        
          <span class="title" style="color: {{$section->text_color}} !important;">{{$section->title}}</span> 
          <span class="moreBtn" style="border: 1px solid {{$section->text_color}};"><a href="{{route('moreProducts', $section->slug)}}" style="color: {{$section->text_color}} !important;">See More</a></span>
         
          <div class="clearfix module horizontal">
                <div class="products-category">
                    <div class="category-slider-inner products-list yt-content-slider releate-products grid" data-rtl="yes" data-autoplay="yes" data-pagination="no" data-delay="4" data-speed="0.6" data-margin="5" data-items_column0="6" data-items_column1="6" data-items_column2="5" data-items_column3="3" data-items_column4="2" data-arrows="yes" data-lazyload="yes" data-loop="yes" data-hoverpause="yes">
                      @foreach($products as $product)
                      <div class="item-inner product-thumb trg transition product-layout">
                          @include('frontend.homepage.products')
                      </div>
                      @endforeach
                    </div>
                </div>
          </div>
      </div>
     @if($section->thumb_image && $section->image_position == 'right')
      <div class="col-md-3">
        <div style="background: #fff;padding: 5px">
          <img style="width: 100%;height: 100%;" src="{{ asset('upload/images/homepage/'.$section->thumb_image) }}">
        </div>
      </div>
      @endif
    </div>
  </div>
</section>

@endif