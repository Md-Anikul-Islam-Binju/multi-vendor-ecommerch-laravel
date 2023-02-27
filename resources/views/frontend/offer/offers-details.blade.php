@extends('layouts.frontend')
@section('title', $offer->title .' | Offer | '. Config::get('siteSetting.site_name') )
@section('metatag')
    <meta name="title" content="{{$offer->title}}">
    <meta name="description" content="{{$offer->title}}">
 
    <!-- Open Graph general (Facebook, Pinterest & Google+) -->
    <meta property="og:description" content="{{$offer->title}}">
    <meta property="og:description" content="{!!$offer->title!!}">
    <meta property="og:image" content="{{asset('upload/images/offer/thumbnail/'.$offer->thumbnail)}}">
    <meta property="og:url" content="{{ url()->full() }}">
    <meta property="og:site_name" content="{{Config::get('siteSetting.site_name')}}">
    <meta property="og:locale" content="en">
    <meta property="og:type" content="website">
    <meta property="fb:admins" content="1323213265465">
    <meta property="fb:app_id" content="13212465454">
    <meta property="og:type" content="e-commerce">

    <!-- Schema.org for Google -->

    <meta itemprop="title" content="{{$offer->title}}">
    <meta itemprop="description" content="{{$offer->title}}">
    <meta itemprop="image" content="{{asset('upload/images/offer/thumbnail/'.$offer->thumbnail)}}">

    <!-- Twitter -->
    <meta name="twitter:card" content="{{$offer->title}}">
    <meta name="twitter:title" content="{{$offer->title}}">
    <meta name="twitter:description" content="{{$offer->title}}">
    <meta name="twitter:site" content="{{url('/')}}">
    <meta name="twitter:creator" content="@Neyamul">
    <meta name="twitter:image:src" content="{{asset('upload/images/offer/thumbnail/'.$offer->thumbnail)}}">

    <!-- Twitter - Product (e-commerce) -->

@endsection
@section('css')
<style type="text/css">
.progress{background-color: #f5f5f5eb;}
.progress-bar{background-color: #c5e3fb;color: #fc2828;}
.common-home .label-sale{width: 100%;
right: -68px;
top: 12px !important;
font-weight: 600;
border: 1px solid red;
color: #fffcfc;
background: #ff3839;
transform: rotateZ(45deg);
}

.blink{text-decoration: blink;-webkit-animation-name: blinker;-webkit-animation-duration: 0.9s;-webkit-animation-iteration-count:infinite;-webkit-animation-timing-function:ease-in-out;-webkit-animation-direction: alternate; color: #ffbc00}
.liveBox{ position: absolute; color: red; font-size: 20px; top: -20px; right: 15px;
}
.liveBtn{text-align: center;    margin: 10px;}
.offer_area { height: 155px; background: linear-gradient(#0364c7b8, #eeefcfeb);  width: 100%; text-align: center; padding-top: 12px; margin-top: 10px; margin-bottom: 60px; position: relative;
}
.offer-info{text-align: left;display: inline-block;padding: 10px;border-radius: 5px;margin-bottom: 10px;}
.offer-info p{line-height: 16px;}
.offer-left-right{margin-top: 25px !important;}
.offer-left-right .caption{min-height: 50px;overflow: hidden;line-height: normal;text-align: center;}
.offer-left-right .caption a{color: #da154a !important;font-weight: 600;
font-size: 12px;}

.offer-top-product{left: auto; left: 50%;transform: translate(-50%, -0%);position: absolute;}
.offer-image_area{width: 100%; overflow: hidden; border-radius: 4px; padding: 5px 15px; background: #fff;}
.offer-image_area img{width: 100%;height: 100%}
.offer-title{ margin-top: 20px;padding: 10px 5px; color: #000;  height: 60px;overflow: hidden;}
.offer_area p{color: #000; font-size:30px; margin-bottom: 100%}
@media (max-width: 768px) {
.offer-title p{font-size: 20px;}
.offer-top-product{width: 80%;}
.offers{background-size: inherit !important;}
.offer_area{margin-top: 20px;margin-bottom: 65px; border-top-right-radius: 25px;
border-top-left-radius: 25px;
border-bottom-right-radius: 25px;
border-bottom-left-radius: 25px;}
}

.count{ display: inline-flex; margin: 0 auto; text-align: center; align-items: center;}
.count_d { position: relative;width: 57px;border-radius: 5px; padding: 10px 0px;margin: 0px 3px;background:#fbfbfb;color:#000;overflow: hidden;
}
.count_d:before{content: '';position: absolute;top: 0;left: 0;width: 100%;height: 50%;}
.count_d span {display: block;text-align: center;font-size: 15px;font-weight: 800;}
.count_d h2 { display: block;text-align: center;font-size: 8px;font-weight: 800;text-transform: uppercase;color:{{($offer->text_color) ? $offer->text_color : '#fff'}};margin: 0;}
.irotate {text-align: center;margin: 0 auto;display: block;}
.thisis {display: inline-block;vertical-align: middle;}
.slidem {text-align: center; min-width: 90px;}
.offerTitle{color: #ff6e26;font-size: 24px;font-family: OpenSans;display: inline-block !important; font-weight: 600; padding-right: 10px;}
</style>
@endsection
@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <ul class="breadcrumb-cate">
                <li><a href="{{url('/')}}"><i class="fa fa-home"></i> </a></li>
                <li><a href="{{route('offers')}}" class="offerTitle">Offer</a> {{$offer->title}}</li>
            </ul>
        </div>
    </div> 
    <section class="offers" style="padding: 10px 0;background:{{$offer->background_color}};color:{{$offer->text_color}};">
        <div class="container" id="purchase_offer">
          <div class="">
            <img alt="" src="{{asset('upload/images/offer/banner/'.$offer->banner)}}">
            
            @if(now() <= $offer->start_date)
              <div class="liveBtn">
                
                  <span class="blink">Offer Upcomming</span>
                  <div class="head" id="offerDate" data-offerDate="{{Carbon\Carbon::parse($offer->start_date)->format('m,d,Y H:i:s')}}">
                    
                    <div class="count">
                      <div class="count_d">
                      <h2>Days</h2>
                        <span id="days">00</span>
                      </div>
                      <div class="count_d">
                      <h2>HOURS</h2>
                        <span id="hour">00</span>
                      </div>
                      <div class="count_d">
                      <h2>MINUTES</h2>
                        <span id="minutes">00</span>
                      </div>
                      <div class="count_d">
                      <h2>SECONDS</h2>
                        <span id="seconds">00</span>
                      </div>
                    </div>
                  </div>
                  
              </div>
            @elseif(now() >= $offer->start_date && now() <= $offer->end_date)
              
                <div class="liveBtn">
                    <span class="blink"><i class="fa fa-play-circle"></i> Live Offer</span>
                   
                    <div class="head" id="offerDate" data-offerDate="{{Carbon\Carbon::parse($offer->end_date)->format('m,d,Y H:i:s')}}">
                      
                      <div class="count">
                        <div class="count_d">
                        <h2>Days</h2>
                          <span id="days">00</span>
                        </div>
                        <div class="count_d">
                        <h2>HOURS</h2>
                          <span id="hour">00</span>
                        </div>
                        <div class="count_d">
                        <h2>MINUTES</h2>
                          <span id="minutes">00</span>
                        </div>
                        <div class="count_d">
                        <h2>SECONDS</h2>
                          <span id="seconds">00</span>
                        </div>
                      </div>
                    </div>
                  </div>
               
            @else
              <div class="liveBtn">
                    <h3 ><i class="fa fa-play-circle"></i> Offer closed</h3>
                   
                    <div >
                      
                      <div class="count">
                        <div class="count_d">
                        <h2>Days</h2>
                          <span id="days">00</span>
                        </div>
                        <div class="count_d">
                        <h2>HOURS</h2>
                          <span id="hour">00</span>
                        </div>
                        <div class="count_d">
                        <h2>MINUTES</h2>
                          <span id="minutes">00</span>
                        </div>
                        <div class="count_d">
                        <h2>SECONDS</h2>
                          <span id="seconds">00</span>
                        </div>
                      </div>
                    </div>
                  </div>
               
            @endif
          </div>
        </div>
        <div class="container">
            <div class="products-category">
                
                    @if(count($offer_products)>0)
                        <div class="products-list grid row " id="loadProducts">
                            @include('frontend.offer.products')
                        </div>
                        <div class="ajax-load  text-center" id="data-loader"><img src="{{asset('frontend/image/loading.gif')}}"></div>
                        @if($offer->offer_type == 'kanamachi' && now() >= $offer->start_date && now() <= $offer->end_date)
                        <div style="text-align:center;background: #10101030;padding: 5px;border-radius: 50%;margin: 8px;">
                            @if(Auth::check())
                            <a style="font-size: 2rem;font-weight: bold;" class="blink" href="{{ route('offer.buyOffer', $offer->slug) }}"> Buy Offer Click Here</a>
                            @else <span style="font-size: 2rem;font-weight: bold;cursor: pointer;" class="blink" data-toggle="modal" data-target="#so_sociallogin">Click Here To Buy Offer</span> @endif
                        </div>
                        @endif
                    @endif
                    @if($offer->notes)
                        <div class="offer-info" style="width: 100%; background: #00000029;color:{!! $offer->text_color !!};">
                         {!! $offer->notes !!}
                        </div> 
                    @endif
                 
            </div>
        </div>
    </section>
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
                
                //check section last page
                if(page <= '{{$offer_products->lastPage()}}' ){
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

<script type="text/javascript">

    var offerDate = $('#offerDate').attr('data-offerDate');
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

