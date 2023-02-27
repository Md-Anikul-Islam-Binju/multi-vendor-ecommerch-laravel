@extends('layouts.frontend')
@section('title', $page->title . ' | '. Config::get('siteSetting.site_name') )

@section('metatag')
    <meta name="title" content="{{$page->meta_title}}">
    <meta name="description" content="{{$page->meta_description}}">
    <meta name="keywords" content="{{$page->meta_keywords}}" />
    
    <!-- Open Graph general (Facebook, Pinterest & Google+) -->
    <meta property="og:description" content="{{$page->title}}">
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
    @include('frontend.sliders.slider2')
    <div class="container" style="background: #fff;">
        <div class="row">
            <div id="content" class="col-sm-12">
                <div class="about_us">
                    <div class="about_wrapper">
                       <h3 class="title-page font-ct">{{$page->title}}</h3>
                       <div class="content-page">
                        {!! $page->description !!}
                       </div>
                    </div>
               </div>
         
            </div>
        </div>
    </div>

@endsection

