@extends('layouts.frontend')
@section('title', Config::get('siteSetting.title'))

@section('css')
	<style type="text/css">
        .category-box{ transition: .5s; position: relative; height: 45px; font-size: 12px;  font-weight: bold; background: #fff;display: block;border:2px solid #ccc; border-radius: 3px; cursor: pointer; padding: 10px 10px;line-height: 1;margin-bottom:  10px;}
        .category-box:hover{border:2px solid {{ config('siteSetting.text_color') }};background:#ccc;}
        .catSection{background: #fff; overflow: auto; padding: 1rem; margin-bottom: 1rem;}
        .category{font-weight: bold;font-size: 16px;color: #000;margin-top: 15px;}
        .subcategory{font-weight: bold;font-size: 14px;color: #1686cc;margin-top: 10px;}
        .childcategory{color: #333;}
   </style>
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <ul class="breadcrumb-cate">
                <li><a href="{{url('/')}}"><i class="fa fa-home"></i> </a></li>
                <li>All Categories</li>
                
            </ul>
        </div>
    </div>
    @php $categories = App\Models\Category::where('parent_id', '=', null)->orderBy('orderBy', 'asc')->where('status', 1)->get(); @endphp
    <div class="container">
        <span class="title">Products by Category</span>
        <div class="row catSection">
            @foreach($categories as $category)
          	<div class="col-md-2 col-xs-6">
                <a class="category-box" href="#category{{$category->slug}}">
                	<span style="position: absolute;top: 8px;">
                        <img width="30" src="{{asset('upload/images/category/thumb/'.$category->image)}}" alt=""> 
                    </span>
                    <span style="margin-left: 38px;display: block;"> {{$category->name}} </span>
                </a>
          	</div>
            @endforeach
        </div>
        @foreach($categories as $category)
        <div class="row catSection" id="category{{$category->slug}}">
            <div class="col-md-12">
            <a href="{{ route('home.category', $category->slug) }}" class="clearfix"><img width="25" src="{{asset('upload/images/category/thumb/'.$category->image)}}" alt="">
            <span class="category">{{$category->name}}</span></a>
            </div>
            @if(count($category->get_subcategory)>0)
            @foreach($category->get_subcategory as $subcategory)
                <div class="col-md-6 sticky-content">
                    <a href="{{ route('home.category', [$category->slug, $subcategory->slug]) }}" class="subcategory">{{$subcategory->name}}</a>
                    @if(count($subcategory->get_subchild_category)>0)
                    <div class="row">
                    @foreach($subcategory->get_subchild_category as $childcategory)
                        <div class="col-md-6"><a class="childcategory" href="{{ route('home.category',[ $category->slug, $subcategory->slug, $childcategory->slug]) }}" >{{$childcategory->name}}</a></div>
                    @endforeach
                    </div>
                    @endif
                </div>
            @endforeach
            @endif
        </div>
        @endforeach
    </div>
    
@endsection

@section('js')
<script type="text/javascript">
    var $root = $('html, body');

    $('a[href^="#"]').click(function() {
        var href = $.attr(this, 'href');

        $root.animate({
            scrollTop: $(href).offset().top
        }, 500, function () {
            window.location.hash = href;
        });

        return false;
    });
</script>
@endsection