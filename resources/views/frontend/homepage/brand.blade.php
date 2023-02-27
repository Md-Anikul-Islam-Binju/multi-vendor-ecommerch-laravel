<?php $brands = App\Models\Brand::where('top', 1)->where('status', 1)->take($section->item_number)->get(); ?>
@if(count($brands)>0)

<section class="section" @if($section->layout_width == 1) style="background:{{$section->background_color}}" @endif>
    <div class="container" @if($section->layout_width != 1) style="background:{{$section->background_color}};border-radius: 5px; padding: 5px;" @endif>
    
        <div class="row">
        <div class="col-md-12 catalog">
        	 <span class="title" style="color: {{$section->text_color}} !important;">{{$section->title}}</span> 
            <span class="moreBtn" style="background: linear-gradient(to right, {{$section->background_color}}, #ffffff);border: 1px solid {{$section->text_color}}; box-shadow: 1px 1px 3px -1px {{$section->text_color}}"><a href="{{route('topBrand')}}" style="color: {{$section->text_color}} !important;">See More</a></span>
        </div>
        @foreach($brands as $brand)
        <div class="col-xs-3 col-md-1" style="padding-left: 5px; padding-right: 5px;margin-bottom:10px;">
        	<div class="brand-list">
                <a href="{{ route('brandProducts', $brand->slug) }}"> 
                <div class="brand-thumb">
                    <img src="{{asset('upload/images/brand/thumb/'.$brand->logo)}}" >
                </div>
                </a>
            </div>
        </div>
        @endforeach
        </div>
    </div>
</section>
@endif