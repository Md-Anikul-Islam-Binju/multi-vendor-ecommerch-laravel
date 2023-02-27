@extends('layouts.frontend')
@section('title', 'Offers  | '. Config::get('siteSetting.site_name') )
@section('css')
<style type="text/css">

.progress{background-color: #f5f5f5eb;}
.progress-bar{background-color: #c5e3fb;color: #fc2828;}
.common-home .label-sale{width: 100%;
right: -75px;
top: 8px !important;
font-weight: 600;
border: 1px solid red;
color: #fffcfc;
background: #ff3839;
transform: rotateZ(45deg);
}
@-webkit-keyframes blinker {
from {opacity: 1.0;}
to {opacity: 0.1;}
}
.blink{text-decoration: blink;-webkit-animation-name: blinker;-webkit-animation-duration: 0.7s;-webkit-animation-iteration-count:infinite;-webkit-animation-timing-function:ease-in-out;-webkit-animation-direction: alternate; color: #ffbc00}
.liveBox{ position: absolute; color: red; font-size: 20px; top: -20px; right: 15px;
}
.liveBtn {    width: 285px; height: 105px; transition: auto; display: inline-block;border-radius: 5px;font-weight: 800;color: #fff;transform: translate(-50%, -0%);left: 50%;position: absolute;margin-top: 5px;
}
.offer_area { height: 155px; width: 100%; text-align: center; padding-top: 10px; margin-top: 20px; margin-bottom: 60px; position: relative; border-radius: 5px;
}
.offer-info{text-align: left;display: inline-block;padding: 10px;border-radius: 5px;margin-bottom: 10px;}
.offer-info p{line-height: 16px;}
.offer-left-right{margin-top: 25px !important;}
.offer-left-right .caption{min-height: 50px;overflow: hidden;line-height: normal;text-align: center;}
.offer-left-right .caption a{color: #da154a !important;font-weight: 600;
font-size: 12px;}
.offer-top-product{left: 50%;transform: translate(-50%, -50%);position: absolute;}
.offer-image_area{width: 100%; overflow: hidden; border-radius: 4px; padding: 5px 15px; background: #fff;}
.offer-image_area img{width: 100%;height: 100%}
.offer-title{color: #000;height: 48px;padding:15px; margin-top: 0px; overflow: hidden;}
.offer_area p{color: #000; font-size: 25px; margin-bottom: 100%}
@media (max-width: 768px) {
.offer-title p{font-size: 20px;}
.offer-top-product{width: 80%;}
.offers{background-size: inherit !important;}
.offer_area{margin-top: 20px;padding-top: 10px; margin-bottom: 65px; border-top-right-radius: 25px;
border-top-left-radius: 25px;
border-bottom-right-radius: 25px;
border-bottom-left-radius: 25px;}
}

.offer_box{padding: 10px 10px;border-radius: 5px; display: block;}
.offer_box:hover{box-shadow: 0 4px 7px 0 rgb(0 0 0 / 25%);}
.count{ display: inline-flex; margin: 0 auto; text-align: center; align-items: center;}
.count_d {position: relative;width: 57px;padding: 5px 0px 15px;margin: 0px 3px;border-radius: 5px;overflow: hidden;}
.count_d:before{ content: '';  position: absolute;top: 0;left: 0;width: 100%;height: 50%;}
.count_d span { display: block; text-align: center; font-size: 16px; font-weight: 800;}
.count_d h2 { display: block; text-align: center; font-size: 8px; font-weight: 800; text-transform: uppercase; margin: 0;}
.irotate {  text-align: center;  margin: 0 auto; display: block;}
.thisis { display: inline-block; vertical-align: middle; }
.slidem { text-align: center; min-width: 90px;}
.offerTitle{color: #ff6e26;font-size: 24px;font-family: OpenSans;display: inline-block !important; font-weight: 600; padding-right: 10px;}
</style>
@endsection
@section('content')
   
    <!-- Main Container  -->
    <div class="breadcrumbs">
        <div class="container">
            
            <ul class="breadcrumb-cate">
                <li><a href="{{url('/')}}"><i class="fa fa-home"></i> </a></li>
                <li>Offers</li>
            </ul>
        </div>
    </div> 
    @include('frontend.sliders.slider2')
    <div class="row" >
    <div class="container" style="background: #fff">

    @if(count($offers)>0)
        @foreach($offers as $offer)
            <div class="col-md-6">
                <a class="offer_box" href="{{route('offer.details', $offer->slug)}}">
                <div class="offer_area" style="background:{{$offer->background_color}}">
                    
                    <div class="offer-title">
                        <div class="irotate">
                          <div class="thisis slidem">
                            <p style="color: {{$offer->text_color}}">{{$offer->title}}</p>
                          
                          </div>
                        </div>
                    </div>
                    @if(now() <= $offer->start_date)
                        <div class="liveBtn">
                        
                          <span class="blink">Offer Upcomming</span>
                          <div class="head clockdiv" id="offerDate" data-date="{{Carbon\Carbon::parse($offer->start_date)->format('m,d,Y H:i:s')}}">
                            
                            <div class="count">
                              <div class="count_d" style="background:{{$offer->background_color}}; color: {{$offer->text_color}}">
                                <span class="days">00</span>
                                <h2>Days</h2>
                              </div>
                              <div class="count_d" style="background:{{$offer->background_color}}; color: {{$offer->text_color}}">
                                <span class="hours">00</span>
                                <h2>HOURS</h2>
                              </div>
                              <div class="count_d" style="background:{{$offer->background_color}}; color: {{$offer->text_color}}">
                                <span class="minutes">00</span>
                                <h2>MINUTES</h2>
                              </div>
                              <div class="count_d" style="background:{{$offer->background_color}}; color: {{$offer->text_color}}">
                                <span class="seconds" style="background:{{$offer->background_color}}; color: {{$offer->text_color}}">00</span>
                                <h2>SECONDS</h2>
                              </div>
                            </div>
                          </div>
                        </div>
                    @elseif(now() >= $offer->start_date && now() <= $offer->end_date)
                        <div class="liveBtn">
                          <span class="blink">Offer Started</span>
                          <div class="head clockdiv" id="offerDate" data-date="{{Carbon\Carbon::parse($offer->end_date)->format('m,d,Y H:i:s')}}">
                            
                            <div class="count">
                              <div class="count_d" style="background:{{$offer->background_color}}; color: {{$offer->text_color}}">
                                <span class="days">00</span>
                                <h2>Days</h2>
                              </div>
                              <div class="count_d" style="background:{{$offer->background_color}}; color: {{$offer->text_color}}">
                                <span class="hours">00</span>
                                <h2>HOURS</h2>
                              </div>
                              <div class="count_d" style="background:{{$offer->background_color}}; color: {{$offer->text_color}}">
                                <span class="minutes">00</span>
                                <h2>MINUTES</h2>
                              </div>
                              <div class="count_d" style="background:{{$offer->background_color}}; color: {{$offer->text_color}}">
                                <span class="seconds" style="background:{{$offer->background_color}}; color: {{$offer->text_color}}">00</span>
                                <h2>SECONDS</h2>
                              </div>
                            </div>
                          </div>
                        </div>
                    @else
                        <span class="liveBtn" style="padding: 8px 60px 23px;">Closed <br/> Offer</span>
                    @endif
                </div> 
                </a>
            </div>
        @endforeach
    </div>
    </div>
    @else
        <div style="text-align: center;">
            <i style="font-size: 80px;" class="fa fa-shopping-cart"></i>
             <h1>Sorry at this moment any offer not available.</h1>
            Click here <a href="{{url('/')}}">Back To Home</a>
        </div>
    @endif
 @endsection

@section('js')
<script type="text/javascript">
    
document.addEventListener('readystatechange', event => {
    if (event.target.readyState === "complete") {
        var clockdiv = document.getElementsByClassName("clockdiv");
        var countDownDate = new Array();
        for (var i = 0; i < clockdiv.length; i++) {
            countDownDate[i] = new Array();
            countDownDate[i]['el'] = clockdiv[i];
            countDownDate[i]['time'] = new Date(clockdiv[i].getAttribute('data-date')).getTime();
            countDownDate[i]['days'] = 0;
            countDownDate[i]['hours'] = 0;
            countDownDate[i]['seconds'] = 0;
            countDownDate[i]['minutes'] = 0;
        }
      
        var countdownfunction = setInterval(function() {
            for (var i = 0; i < countDownDate.length; i++) {
                var now = new Date().getTime();
                var distance = countDownDate[i]['time'] - now;
                 countDownDate[i]['days'] = Math.floor(distance / (1000 * 60 * 60 * 24));
                 countDownDate[i]['hours'] = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                 countDownDate[i]['minutes'] = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                 countDownDate[i]['seconds'] = Math.floor((distance % (1000 * 60)) / 1000);
                
                 if (distance < 0) {
                    countDownDate[i]['el'].querySelector('.days').innerHTML = 0;
                    countDownDate[i]['el'].querySelector('.hours').innerHTML = 0;
                    countDownDate[i]['el'].querySelector('.minutes').innerHTML = 0;
                    countDownDate[i]['el'].querySelector('.seconds').innerHTML = 0;
                 }else{
                    countDownDate[i]['el'].querySelector('.days').innerHTML = countDownDate[i]['days'];
                    countDownDate[i]['el'].querySelector('.hours').innerHTML = countDownDate[i]['hours'];
                    countDownDate[i]['el'].querySelector('.minutes').innerHTML = countDownDate[i]['minutes'];
                    countDownDate[i]['el'].querySelector('.seconds').innerHTML = countDownDate[i]['seconds'];
                }
            }
        }, 1000);
    }
});

</script>


@endsection