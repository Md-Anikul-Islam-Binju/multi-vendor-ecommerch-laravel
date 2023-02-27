@extends('layouts.frontend')
@section('title', $category->name . ' | '. Config::get('siteSetting.site_name') )
@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.range.css') }}">
    <style type="text/css">
        .ratting label{font-size: 18px;}
        .slider-container{margin-top: 12px;}
        .pagination>li>a, .pagination>li>span{padding: 6px 10px;}

        #loadCategory .section{max-height: 375px !important; overflow: hidden;margin-top: 10px; margin-bottom: 5px;}
        #loadCategory .products-list .product-layout {max-width: 230px;max-height: 335px; min-height: 150px;}
    
    .img-wrap{width: 100%;height: 100px;  display: block;overflow: hidden;}
    .img-wrap img{height: 100%;width: 100%;object-fit: contain;}
    </style>
@endsection
@section('content')
    <!-- Main Container  -->
    <div class="breadcrumbs">
        <div class="container">
            <ul class="breadcrumb-cate">
                <li><a href="{{url('/')}}"><i class="fa fa-home"></i> </a></li>
                <li><a href="javascript:void(0)">{{ Request::route('catslug') }}</a></li>
            </ul>
        </div>
    </div>
    
    <div class="so-page-builder" >
        <div class="page-builder-ltr" id="loadCategory">
        	@if($banners)
               @include('frontend.sliders.slider2')
            @endif
			@include('frontend.products.productsBySubcategory')
        </div>

        <div class="ajax-load  text-center" id="data-loader"><img src="{{asset('frontend/image/loading.gif')}}"></div>
    </div>
    
@endsection

@section('js')
<script type="text/javascript">

    $(document).ready(function(){
    
        var page = 2;
        loadMoreProducts(page);
        function loadMoreProducts(page){
           
            $.ajax(
                {
                    url: '?page=' + page,
                    type: "get",
                    beforeSend: function()
                    {
                        $('.ajax-load').show();
                    }
                })
            .done(function(data)
            {
                $('.ajax-load').hide();
                $("#loadCategory").append(data.html);
                
                // Content slider
                $('.yt-content-slider').each(function () {
                    var $slider = $(this),
                    $panels = $slider.children('div'),
                    data = $slider.data();
                    // Remove unwanted br's
                    //$slider.children(':not(.yt-content-slide)').remove();
                    // Apply Owl Carousel
        
                    $slider.owlCarousel2({
                        responsiveClass: true,
                        mouseDrag: true,
                        video:true,
                    lazyLoad: (data.lazyload == 'yes') ? true : false,
                        autoplay: (data.autoplay == 'yes') ? true : false,
                        autoHeight: (data.autoheight == 'yes') ? true : false,
                        autoplayTimeout: data.delay * 1000,
                        smartSpeed: data.speed * 1000,
                        autoplayHoverPause: (data.hoverpause == 'yes') ? true : false,
                        center: (data.center == 'yes') ? true : false,
                        loop: (data.loop == 'yes') ? true : false,
                  dots: (data.pagination == 'yes') ? true : false,
                  nav: (data.arrows == 'yes') ? true : false,
                        dotClass: "owl2-dot",
                        dotsClass: "owl2-dots",
                  margin: data.margin,
                    navText:  ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                        
                        responsive: {
                            0: {
                                items: data.items_column4 
                                },
                            480: {
                                items: data.items_column3
                                },
                            768: {
                                items: data.items_column2
                                },
                            992: { 
                                items: data.items_column1
                                },
                            1200: {
                                items: data.items_column0 
                                }
                        }
                    });
                });
                
       
                //check section last page
                if(page <= '{{$subcategories->lastPage()}}' ){
                    page++;
                    loadMoreProducts(page);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                $('.ajax-load').hide();
            });
        }
    });
</script>
@endsection