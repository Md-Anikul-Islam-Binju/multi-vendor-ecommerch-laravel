@extends('layouts.frontend')
@section('title', Config::get('siteSetting.title'))
@section('metatag')
    <meta name="title" content="{{Config::get('siteSetting.title')}}">
    <meta name="description" content="{{Config::get('siteSetting.description')}}">
    <meta name="keywords" content="{{Config::get('siteSetting.meta_keywords')}}" />
    <meta name="robots" content="index,follow" />

    <!-- Open Graph general (Facebook, Pinterest & Google+) -->
    <meta property="og:title" content="{{Config::get('siteSetting.title')}}">
    <meta property="og:description" content="{{Config::get('siteSetting.description')}}">
    <meta property="og:image" content="{{asset('upload/images/'.Config::get('siteSetting.meta_image'))}}">
    <meta property="og:url" content="{{ url()->full() }}">
    <meta property="og:site_name" content="{{Config::get('siteSetting.site_name')}}">
    <meta property="og:locale" content="bd">
    <meta property="og:type" content="e-commerce">
    <!-- Schema.org for Google -->

    <meta itemprop="title" content="{{Config::get('siteSetting.title')}}">
    <meta itemprop="description" content="{{Config::get('siteSetting.description')}}">
    <meta itemprop="image" content="{{asset('upload/images/'.Config::get('siteSetting.meta_image'))}}">

    <!-- Twitter -->
    <meta name="twitter:card" content="{{Config::get('siteSetting.title')}}">
    <meta name="twitter:title" content="{{Config::get('siteSetting.title')}}">
    <meta name="twitter:description" content="{{Config::get('siteSetting.description')}}">
    <meta name="twitter:site" content="{{url('/')}}">
    <meta name="twitter:creator" content="@Neyamul">
    <meta name="twitter:image:src" content="{{asset('upload/images/'.Config::get('siteSetting.meta_image'))}}">
    <meta name="twitter:player" content="#">
    <!-- Twitter - Product (e-commerce) -->

@endsection
@section('css')
<style type="text/css">
.block-service-home6 ul > li:last-child{border-right: none;}
.brand-thumb{position: relative;width: 100%;padding: 3px;max-height: 90px;
background: #fff;text-align: center;}
.desc-listcategoreis { color: #000;text-align: center;padding: 0px;background: #fff;}
.brand-thumb img{max-height: 100%}
.homepage .section{max-height: 400px !important; overflow: hidden;}
.homepage .products-list .product-layout {max-width: 230px;max-height: 335px; min-height: 150px;}
.price-offer{ display: block; width: 80px; text-align: center; line-height: normal;margin: 3px auto 10px;padding: 1px 0;color: #fff;font-size: 12px;background: #ff4733;border-radius: 15px;}
.img-wrap{width: 100%;height: 100px;  display: block;overflow: hidden;}
.img-wrap img{height: 100%;width: 100%;object-fit: contain;}
@-webkit-keyframes blinker {
from {opacity: 1.0;}
to {opacity: 0.1;}
}
.blink{text-decoration: blink;-webkit-animation-name: blinker;-webkit-animation-duration: 0.7s;-webkit-animation-iteration-count:infinite;-webkit-animation-timing-function:ease-in-out;-webkit-animation-direction: alternate;color: #ffbc00}
.liveBox{ position: absolute;color: red;font-size: 20px;top: -20px;right: 15px;}
.offer_section{margin-top: 66px;display: block;}
.liveBtn {text-align: center; position: absolute;transform: translate(-50%, 0%);display: inline-block;top: 10px;
    left: 50%;font-weight: 800;color: #fff;}
.offer_area { position: relative;text-align: center;display: inline-block;}
.offer-left-right{margin-top: 25px !important;}
.offer-left-right .caption{min-height: 50px;overflow: hidden;line-height: normal;text-align: center;}
.offer-left-right .caption a{color: #da154a !important;font-weight: 600;
font-size: 12px;}
.offer-top-product{left: 50%;transform: translate(-50%, -50%);position: absolute;}
.offer-image_area{width: 100%; overflow: hidden; border-radius: 4px; padding: 5px 15px; background: #fff;}
.offer-image_area img{width: 100%;height: 100%}
.offer-title{color: #000;height: 48px;padding:15px; margin-top: 50px; overflow: hidden;}
.offer_area p{color: #000; font-size: 25px; margin-bottom: 100%}
@media (max-width: 512px) {
.offer-title p{font-size: 20px;}
.offer-top-product { left: 20%; transform: translate(-10%, -50%); }

.offer_area{margin-top: 0px;margin-bottom: 0px; border-top-right-radius: 25px; border-top-left-radius: 25px; border-bottom-right-radius: 25px;
border-bottom-left-radius: 25px;}
.offer_area{height: 135px;}
.offer-title{margin-top: 35px;}
}

.count{
  display: inline-flex;margin: 0 auto;text-align: center;align-items: center;}
.count_d { position: relative; width: 50px;padding: 5px 0px;margin: 0px 3px;background-image: linear-gradient(to right, #4e0c25 ,#8e0d3c,#0a060e);color: #eef1f5; overflow: hidden;
} 
.count_d:before{ content: ''; position: absolute; top: 0;left: 0;width: 100%;}
.count_d span {display: block;text-align: center;font-size: 15px; font-weight: 800;}
.count_d h2 {display: block;text-align: center;font-size: 8px;font-weight: 800;text-transform: uppercase;margin: 0;}
.irotate {text-align: center;margin: 0 auto;display: block;
    }
    .thisis { display: inline-block;vertical-align: middle;}
    .slidem {text-align: center;min-width: 90px;}
    .catSection{ background: #EADAEB; padding:10px 10px 15px; margin-bottom: 10px; border-radius: 3px;}
    .cat-title{ color: #333; text-transform: capitalize; font-size: 14px;}
    .catSection img{border-radius: 5px;}
    .catSection:hover{ box-shadow: 0 2px 4px 0 rgba(0,0,0,.25); }
</style>
@endsection
@section('content')
    <!-- Slider Arae Start -->
    @include('frontend.sliders.slider4')
    <!-- Slider Arae End -->
    <!-- Main Container  -->
    <div class="so-page-builder" >
        <div class="page-builder-ltr homepage" id="loadProducts">
            <!-- Load products here -->
        </div>
        <div class="ajax-load  text-center" id="data-loader"><img src="{{asset('frontend/image/loading.gif')}}" alt="img"></div>
    </div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        var page = 1;
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
                $("#loadProducts").append(data.html);
                
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
                
                var offerDate = $('#offerDate').attr('data-offerDate');
                if(offerDate){
                var count = new Date(offerDate).getTime();
                var x = setInterval(function() {

                var now = new Date().getTime();
                var time = count - now;
        
                var days = Math.floor(time / (1000 * 60 * 60 * 24));
                var hours = Math.floor((time % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((time % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((time % (1000 * 60)) / 1000);
        
                document.getElementById("days").innerHTML = days;
                document.getElementById("hour").innerHTML = hours;
                document.getElementById("minutes").innerHTML = minutes;
                document.getElementById("seconds").innerHTML = seconds;
        
                if (days < 0) {
                  clearInterval(x);
                  document.getElementById("days").innerHTML = "EXPIRED";
                }
              }, 1000);
            }
                //check section last page
                if(page <= '{{$sections->lastPage()}}' ){
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

    //offer title slide
    jQuery(".slidem").prepend(jQuery(".slidem > p:last").clone()); /* copy last div for the first slideup */
    jQuery.fn.slideFadeToggle  = function(speed, easing, callback) {
        return this.animate({opacity: 'toggle', height: 'toggle'}, speed, easing, callback);
    }; /* slideup fade toggle code */
    var divS = jQuery(".slidem > p"), /* get the divs to slideup */
        sDiv = jQuery(".slidem > p").length, /* get the number of divs to slideup */
        n = 0; /* starting counter */
    function slidethem() { /* slide fade function */
        jQuery( divS ).eq( n ).slideFadeToggle(1000,"swing",n=n+1); /* slide fade the div at 1000ms swing and add to counter */
        jQuery( divS ).eq( n ).show(); /* make sure the next div is displayed */
    }
    ( function slideit() { /* slide repeater */
        if( n == sDiv ) { /* check if at the last div */
            n = 0; /* reset counter */
            jQuery( divS ).show(); /* reset the divs */
        }
        slidethem(); /* call slide function */
        if(n == sDiv) { /* check if at the last div */
            setTimeout(slideit,1); /* slide up first div fast */
        } else {
            setTimeout(slideit,5000); /* slide up every 1000ms */
        }
    } )();

</script>
@endsection