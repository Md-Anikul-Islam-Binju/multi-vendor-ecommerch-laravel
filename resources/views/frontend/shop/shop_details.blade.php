@extends('layouts.frontend')
@section('title', $seller->shop_name.' | '. Config::get('siteSetting.site_name') )

@section('metatag')
  <meta name="title" content="{{$seller->shop_name}}">
    <meta name="description" content="{!! strip_tags($seller->shop_dsc) !!}">
    <meta name="image" content="{{ ($seller->banner) ? asset('upload/vendors/banner/'.$seller->banner) : asset('upload/vendors/logo/'.$seller->logo) }}">
   
    <!-- Schema.org for Google -->
    <meta itemprop="name" content="{{$seller->shop_name}}">
    <meta itemprop="description" content="{!! strip_tags($seller->shop_dsc) !!}">
    <meta itemprop="image" content="{{ ($seller->banner) ? asset('upload/vendors/banner/'.$seller->banner) : asset('upload/vendors/logo/'.$seller->logo) }}">
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('frontend/css/jquery.range.css') }}">
  <style type="text/css">
      #wrapper{background: #fdfdfdc7;}
      .ratting label{font-size: 18px;}
      .slider-container{margin-top: 12px;}
      .pagination>li>a, .pagination>li>span{padding: 6px 10px;}

     .seller-thumb{position: relative;width: 100%;padding: 3px;height: 100px;
      background: #fff;text-align: center;}
      .desc-listcategoreis {
          color: #000;
          text-align: center;
          padding: 0px;
          background: #fff;
          overflow: hidden;
      }
      .seller-thumb img{height: 100%}


  .profile-header {

    width: 100%;
    height: 230px;
    position: relative;
    background-position: center !important;
      background-size: cover!important;
    box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.2);
  }

  .profile-img img {
    border-radius: 50%;
    height: 230px;
    width: 230px;
    border: 5px solid #fff;
    box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
   
    left: 50px;
    top: 20px;
    z-index: 5;
    background: #fff;
  }


  .profile-nav-info h3 {
    font-variant: small-caps;
    font-size: 2rem;
    font-family: sans-serif;
    font-weight: bold;
  }

  .profile-nav-info .address {
    display: flex;
    font-weight: bold;
    color: #777;
  }



  .profile-option:hover {
    background: #fff;
    border: 1px solid #e40046;
  }
  .profile-option:hover .notification i {
    color: #e40046;
  }

  .profile-option:hover span {
    background: #e40046;
  }


  .profile-btn {
    display: flex;
  }

  button.chatbtn,
  button.createbtn {
    border: 0;
    padding: 5px 10px;
    border-radius: 3px;
    background: #e40046;
    color: #fff;
    font-size: 1rem;
    margin: 5px 2px;
    cursor: pointer;
    outline: none;
    margin-bottom: 10px;
    transition: background 0.3s ease-in-out;
    box-shadow: 0px 5px 7px 0px rgba(0, 0, 0, 0.3);
  }

  button.chatbtn:hover,
  button.createbtn:hover {
    background: rgba(288, 0, 70, 0.9);
  }

  button.chatbtn i,
  button.createbtn i {
    margin-right: 5px;
  }

  .nav {
    width: 100%;
   position: relative;
  }

  .nav ul {
    display: flex;
    justify-content: space-around;
    list-style-type: none;
    height: 40px;
    background: #fff;
    margin-bottom: 20px;
    background: #ececec;
  }

  .nav ul li {

    cursor: pointer;
    text-align: left;
    transition: all 0.2s ease-in-out;
  }
  .nav ul li a{display: block;padding: 10px;white-space: nowrap;}

  .nav ul li:hover,
  .nav ul li.active {
    box-shadow: 0px -3px 0px rgba(288, 0, 70, 0.9) inset;
  }
  .user-rating {
      display: flex;
  }
  @media (min-width: 920px) {
  .seller-details{
      min-width: 220px;
      max-width: 400px;
      position: relative;
      bottom: -10px;
      left: -50px;
      color: #000000;
      border-radius: 3px;
      background: #ffffff52;
      padding: 10px 25px;}

  }
  </style>
@endsection
@section('content')

    @php $avg_ratting = round($seller->reviews->avg('ratting'), 1); @endphp
    <div class="container" >
        <div class="profile-header" style="background:#fff url({{asset('upload/vendors/banner/'.$seller->banner)}}); margin-top: 5px;">
              <div class="row">
                <div class="col-xs-12 col-md-3 ">
                  <div class="profile-img">
                  <img src="{{asset('upload/vendors/logo/'.($seller->logo ? $seller->logo : 'logo.png'))}}" width="200" alt="Logo"></div>
                </div>
                <div class="col-xs-12 col-md-7">
                  <div class="seller-details">
                     <h3 style="margin: 0">{{$seller->shop_name}}</h3>
                     <p style="line-height: 1">{{Str::limit($seller->shop_dsc, 250)}}</p>
                     <div class="user-rating">
                        <h3 class="rating"><span style="font-size: 30px">{{$avg_ratting}}</span>/5 </h3>
                        <div class="rate">
                          <div class="star-outer">
                            <div class="star-inner">
                             {{\App\Http\Controllers\HelperController::ratting($avg_ratting)}} 
                            </div>
                          </div>
                          <!-- <span class="no-of-user-rate"><span>{{count($seller->reviews)}}</span> Seller reviews</span> 
                           <p style="margin: 0;line-height: 1">{{count($seller->reviews)}}  Followers</p>
                           -->
                        </div>

                      </div>
                      
                      
                    </div>
                  </div>
              </div>
        </div>
    </div>
    <div class="container">
      <div class="nav">
            <ul>
              <li class="active"><a @if(!Request::is('shop_details')) href="{{route('shop_details', [$seller->slug])}}" @endif> Homepage</a></li>
              <li  class=""><a href="{{route('seller_products', [$seller->slug])}}">All Products </a></li>
              <li class=""><!--  <a href="#">Reviews </a> --></li>
              <form method="GET" action="{{route('seller_products', [$seller->slug])}}">
                <div class="input-group" style="margin-top: 3px;">
                    <input type="text" placeholder="Search" class="form-control"  name="q" value="@if(Request::get('q')){!! Request::get('q') !!}@endif" id="sellerKey" value="{!! Request::get('q') !!}">
                    <div class="input-group-btn">
                        <button class="btn btn-success"  type="submit" id="submit_text_search"><i class="fa fa-search"></i></button>
                    </div>
                </div> 
              </form>
            </ul>
        </div>
    </div>
        
    <div class="container">
     @include('frontend.shop.best-selling')
     @include('frontend.shop.today-deals')
     @include('frontend.shop.recommended')
    </div>
    
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('frontend')}}/js/themejs/noui.js"></script>

@endsection