<?php  
$categorySections = App\Models\CategorySection::with('category')->where('is_feature', 1)->where('status', 1)->get();
$firstSec = 1;

?>
@if(count($categorySections)>99999)
<section  @if($section->layout_width == 1) style=" margin:10px auto;background:{{$section->background_color}}" @endif>
  <div class="container" @if($section->layout_width != 1) style=" margin:10px auto;background:{{$section->background_color}};border-radius: 5px; padding:5px;" @endif>
        <div class="module so-listing-tabs-ltr home3_listingtab_style2">
             <span class="title" style="color: {{$section->text_color}} !important;">{{$section->title}}</span> 
            <div class="row">
            @foreach($categorySections as $categorySection)
            	@php 
            		$sectionSubcategory = explode(',', $categorySection->subcategory_id);
            	@endphp
            	@if($firstSec == 1)
                <div class="col-md-4">
                    <div class="row catSection" style="margin: 0; padding: 25px 10px 5px;background: {{$categorySection->background_color}};">

                         <div class="col-xs-12">
                         	<a style="color: {{$categorySection->text_color}};" href="{{route('home.category', $categorySection->category->slug)}}">
                            <strong class="cat-title" style="font-size: 18px;color: {{$categorySection->text_color}};"> {{$categorySection->title}}</strong>
                            @if($categorySection->sub_title)<p>{{$categorySection->sub_title}}</p>@endif
                        	</a>
                        </div>
                        @for($i=0; $i < 3; $i++)

                            @php 
                            $sectionCategory_id =  $sectionSubcategory[$i];
                            $sectionProduct = App\Models\Product::with(['get_subcategory', 'get_childcategory'])
                            ->where(function($query) use ($sectionCategory_id){
                                $query->where('subcategory_id', $sectionCategory_id )
                                ->orWhere('childcategory_id', $sectionCategory_id);
                            })->where('status', 'active')->first(); @endphp
                            @if($sectionProduct)
    	                        @if($i == 0)
    	                       	<div class="col-xs-8">
    	                       		<a class="link exclick" title="{{$sectionProduct->title}}" href="{{route('home.category', [$categorySection->category->slug, $sectionProduct->get_subcategory->slug, $sectionProduct->get_childcategory->slug])}}">
    	                            <img src="{{asset('upload/images/product/thumb/'.$sectionProduct->feature_image)}}" style="width: 100%;height: 100%" title="" alt="">
    	                        	</a>
    	                        </div>
    	                        @else
    	                        <div class="col-xs-4">
    	                            <div class="row">
    	                       			<a class="link exclick" title="{{$sectionProduct->title}}" href="{{route('home.category', [$categorySection->category->slug, $sectionProduct->get_subcategory->slug, $sectionProduct->get_childcategory->slug])}}">
    	                                <div class="col-xs-12" style="margin-bottom: 10px;padding: 0"><img src="{{asset('upload/images/product/thumb/'.$sectionProduct->feature_image)}}" title="" alt=""></div>
    	                              	</a>
    	                            </div>
    	                        </div>
    	                        @endif
                            @endif
                        @endfor
                    </div>
                </div>
              	@else
                <div class="col-md-4" >
                    <div class="row catSection" style="background: {{$categorySection->background_color}};">
                        <div class="col-xs-12">
                        	<a style="color: {{$categorySection->text_color}};" href="{{route('home.category', $categorySection->category->slug)}}">
                            <strong class="cat-title" style="color: {{$categorySection->text_color}};"> {{$categorySection->title}}</strong>
                           
                        	</a>
                        </div>
                    @for($i=0; $i < 3; $i++)

                    @if(isset($sectionSubcategory[$i]))
                        @php 
                         $sectionCategory_id =  $sectionSubcategory[$i];
                        $sectionProduct = App\Models\Product::with(['get_subcategory', 'get_childcategory'])
                            ->where(function($query) use ($sectionCategory_id){
                                $query->where('subcategory_id', $sectionCategory_id )
                                ->orWhere('childcategory_id', $sectionCategory_id);
                            })->where('status', 'active')->first(); @endphp
                        @if($sectionProduct)
                        <div class="col-xs-4">
                            <a class="link exclick" title="{{$sectionProduct->title}}" href="{{route('home.category', [$categorySection->category->slug, $sectionProduct->get_subcategory->slug, $sectionProduct->get_childcategory->slug])}}">
                                <span  style="width: 100%; display: block;overflow: hidden;">
                                    <img src="{{asset('upload/images/product/thumb/'.$sectionProduct->feature_image)}}"  alt="">
                                </span>
                            </a>
                        </div>
                        @endif
                    @endif
                    @endfor
                    </div>
                </div>
                @endif
                @php $firstSec++; @endphp
            @endforeach
            </div>
        </div>
	</div>
</section>
@endif
