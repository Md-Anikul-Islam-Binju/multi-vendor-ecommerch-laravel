@extends('layouts.frontend')
@section('title', $page->title . ' | '. Config::get('siteSetting.site_name') )
@section('metatag')
    <meta name="title" content="{{$page->meta_title}}">
    <meta name="description" content="{{$page->meta_description}}">
    <meta name="keywords" content="{{$page->meta_keywords}}" />
    
    <!-- Open Graph general (Facebook, Pinterest & Google+) -->
    <meta property="og:description" content="{{$page->meta_title}}">
    <meta property="og:image" content="{{asset('upload/pages/'.$page->meta_image)}}">
    <meta property="og:url" content="{{ url()->full() }}">
    <meta property="og:site_name" content="{{Config::get('siteSetting.site_name')}}">
    <meta property="og:locale" content="en">
    <meta property="og:type" content="website">
    <meta property="fb:admins" content="1323213265465">
    <meta property="fb:app_id" content="13212465454">
    <meta property="og:type" content="e-commerce">

    <!-- Schema.org for Google -->

    <meta itemprop="title" content="{{$page->meta_title}}">
    <meta itemprop="description" content="{{$page->meta_title}}">
    <meta itemprop="image" content="{{asset('upload/pages/'.$page->meta_image)}}">

    <!-- Twitter -->
    <meta name="twitter:card" content="{{$page->meta_title}}">
    <meta name="twitter:title" content="{{$page->meta_title}}">
    <meta name="twitter:description" content="{{$page->meta_title}}">
    <meta name="twitter:site" content="{{url('/')}}">
    <meta name="twitter:creator" content="@Neyamul">
    <meta name="twitter:image:src" content="{{asset('upload/pages/'.$page->meta_image)}}">
  
    <!-- Twitter - Product (e-commerce) -->

@endsection

@section('css')


<style>
    .map {
       
        width: 100%;
        height: 100%;
    }

    .header {
        background-color: #F5F5F5;
        color: #36A0FF;
      
        font-size: 27px;
        padding: 10px;
    }
</style>
@endsection
@section('content')

<!-- Main Container  -->
<div class="breadcrumbs">
    <div class="container">
        
        <ul class="breadcrumb-cate">
            <li><a href="{{url('/')}}"><i class="fa fa-home"></i> </a></li>
            <li>{{$page->title}}</li>
        </ul>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div>
                <div class="panel panel-default">
                    <div class="text-center header">{{$page->title}}</div>
                    <div class="panel-body text-center">
                        
                      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d913.1187285395503!2d90.41006102917423!3d23.730438226750564!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b923c89d9409%3A0xad5b63c5e86fe5af!2sDarus%20Salam%20Arcade%20Mosque!5e0!3m2!1sen!2sbd!4v1634111682927!5m2!1sen!2sbd" width="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
              
                    </div>
                </div>
            </div>
           
        </div>
        <div class="col-md-6">
             <div class="well well-sm">
                <fieldset>
                    <legend class="text-center header">Office Address</legend>
                </fieldset>
                <div class="panel-body text-center">
                    <div class="contactinfo">
                    <img width="200" src="{{ asset('upload/images/logo/'.Config::get('siteSetting.logo') )}}" title="" alt="">
                    
                    <p>{{Config::get('siteSetting.footer')}}</p>
                    <div class="content-footer">

                      <div class="address">
                        <label><i class="fa fa-map-marker" aria-hidden="true"></i></label>
                        <span>{{Config::get('siteSetting.address')}}</span>
                      </div>
                      <div class="phone">
                        <label><i class="fa fa-phone" aria-hidden="true"></i></label>
                        <span>{{Config::get('siteSetting.phone')}}</span>
                      </div>
                      <div class="email">
                        <label><i class="fa fa-envelope"></i></label>
                        <a href="#">{{Config::get('siteSetting.email')}}</a>
                      </div>
                    </div>
                  </div>
                     {!! $page->description !!}
                    <hr />
                </div>
                <form action="#" class="form-horizontal" method="post">
                    <fieldset>
                        <legend class="text-center header">Contact Form</legend>
                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-1">
                                <input id="name" required name="name" type="text" placeholder="Full Name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-1">
                                <input id="email" required name="email" type="text" placeholder="Email Address" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-1">
                                <input id="phone" required name="phone" type="text" placeholder="Phone" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-1">
                                <textarea required class="form-control" id="message" name="message" placeholder="Enter your massage for us here. We will get back to you within 2 business days." rows="3"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
    </div>
    </div>
</div>


  
    
    
@endsection

@section('js')

<script src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
    jQuery(function ($) {
        function init_map1() {
            var myLocation = new google.maps.LatLng(38.885516, -77.09327200000001);
            var mapOptions = {
                center: myLocation,
                zoom: 16
            };
            var marker = new google.maps.Marker({
                position: myLocation,
                title: "Property Location"
            });
            var map = new google.maps.Map(document.getElementById("map1"),
                mapOptions);
            marker.setMap(map);
        }
        init_map1();
    });
</script>
@endsection