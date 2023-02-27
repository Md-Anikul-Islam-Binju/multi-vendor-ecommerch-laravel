<?php
	$banner = App\Models\Banner::find($section->product_id); 
?>

@if($banner)
<section style="@if($section->layout_width == 1) background:{{$section->background_color}}; @endif padding:5px;">
  <div class="container" @if($section->layout_width != 1) style="background:{{$section->background_color}};border-radius: 3px; padding: 5px;" @endif>
    
    @if($banner->banner_type>1)
    <span class="title" style="color: {{$section->text_color}} !important;">{{$section->title}}</span>
    @endif
  	<div class="row">
    @for($i=1;$i<=$banner->banner_type; $i++)
    @php $col = round(12/$banner->banner_type); 
    $mobcol = ($banner->banner_type == 1) ? 12 : 6;
    $btn_link = 'btn_link'.$i;
    $banner_img = 'banner'.$i;
    @endphp
	  <div class="col-md-{{$col}} col-xs-{{$mobcol}}" style="margin-bottom: 10px;">
	      <div class="banner-layout-5 clearfix">
	        <div class="banner-22  banners">
	        <div>
	        <a title="{{$banner->title}}" href="{{url($banner->$btn_link)}}"><img src="{{asset('upload/images/banner/'.$banner->$banner_img)}}"></a>
	        </div>
	        </div>
	      </div>
	  </div>
	  @endfor
	 </div>
	</div>
</section>
@endif
