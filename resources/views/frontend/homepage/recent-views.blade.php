<?php  
$recentViews = (Cookie::has('recentViews') ? json_decode(Cookie::get('recentViews')) :  []);
$section_number = (count($recentViews) < $section->section_number) ? count($recentViews) : $section->section_number;
?>
@if(count($recentViews)>0)
<section class="section" style="max-height:initial !important; {!! (!$section->layout_width == 1) ?: 'background:'.$section->background_color !!}">
  	<div class="container" @if($section->layout_width != 1) style="background:{{$section->background_color}};border-radius: 5px; padding:5px;" @endif>
    	<div class="row">
	      	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	      		<span class="title" style="color: {{$section->text_color}} !important;">{{$section->title}}</span> 
	      	</div>
  			@for($i=0; $i < $section_number; $i++)
  			@php
  			$category_id = $recentViews[$i];
  			$products = App\Models\Product::where(function($query) use ($category_id){
  				$query->where('category_id', $category_id)
                ->orWhere('subcategory_id', $category_id )
                ->orWhere('childcategory_id', $category_id);
            })->selectRaw('id, title,selling_price,discount,discount_type, slug, feature_image')
			->inRandomOrder()->take($section->item_number)->where('status', 'active')->get();
			$category_name = App\Models\Category::find($category_id);
  			@endphp
  			@if(count($products)>0)
      		<div style="max-height: 395px !important;overflow: hidden; " class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	          	<span  style="padding-left: 6px; color: {{$section->text_color}} !important;">{{($category_name) ? $category_name->name : ''}}</span> 
	         	<!--  <span class="moreBtn" style="border: 1px solid {{$section->text_color}};"><a href="{{route('moreProducts', $section->slug)}}" style="color: {{$section->text_color}} !important;">See More</a></span> -->
	          	<div class="clearfix module horizontal">
	                <div class="products-category">
	                    <div class="category-slider-inner products-list yt-content-slider releate-products grid" data-rtl="yes" data-autoplay="no" data-pagination="no" data-delay="4" data-speed="0.6" data-margin="5" data-items_column0="6" data-items_column1="6" data-items_column2="5" data-items_column3="3" data-items_column4="2" data-arrows="yes" data-lazyload="yes" data-loop="yes" data-hoverpause="yes">
	                      @foreach($products as $product)
	                      <div class="item-inner product-thumb trg transition product-layout">
	                          @include('frontend.homepage.products')
	                      </div>
	                      @endforeach
	                    </div>
	                </div>
	          	</div>
      		</div>
      		@endif
      		@endfor
    	</div>
  </div>
</section>
@endif
