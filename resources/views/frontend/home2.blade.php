@extends('layouts.2frontend')
@section('title', Config::get('siteSetting.title'))
@section('metatag')
    <meta name="description" content="Multipurpose eCommerce website">

    <meta name="keywords" content="Multipurpose, eCommerce, website" />

    <meta name="robots" content="index,follow" />
    <link rel="canonical" href="{{ url()->full() }}">
    <link rel="amphtml" href="{{ url()->full() }}" />
    <link rel="alternate" href="{{ url()->full() }}">

    <!-- Schema.org for Google -->

    <meta itemprop="description" content="Multipurpose eCommerce website">
    <meta itemprop="image" content="{{asset('frontend')}}/images/logo/logo.png">

    <!-- Twitter -->
    <meta name="twitter:card" content="Multipurpose eCommerce website">
    <meta name="twitter:title" content="Multipurpose eCommerce website">
    <meta name="twitter:description" content="Multipurpose eCommerce website">
    <meta name="twitter:site" content="{{url('/')}}">
    <meta name="twitter:creator" content="@Neyamul">
    <meta name="twitter:image:src" content="{{asset('frontend')}}/images/logo/logo.png">
    <meta name="twitter:player" content="#">
    <!-- Twitter - Product (e-commerce) -->

    <!-- Open Graph general (Facebook, Pinterest & Google+) -->
    <meta name="og:description" content="Multipurpose eCommerce website">
    <meta name="og:image" content="{{asset('frontend')}}/images/logo/logo.png">
     <meta name="og:url" content="{{ url()->full() }}">
    <meta name="og:site_name" content="Bdtype">
    <meta name="og:locale" content="en">
    <meta name="og:type" content="website">
    <meta name="fb:admins" content="1323213265465">
    <meta name="fb:app_id" content="13212465454">
    <meta name="og:type" content="article">
@endsection

@section('css')

@endsection
@section('content')
    @if(Config::get('siteSetting.slider'))
    <!-- Slider Arae Start -->
    @include('frontend.sliders.slider2')
    <!-- Slider Arae End -->
    @endif
    <!-- Main Container  -->
    <div id="content">
      	<div class="so-page-builder">
      		<div class="container page-builder-ltr homepage">
      			@foreach($sections as $section)
		            @include('frontend.homepage.'.$section->type) 
	            @endforeach  
	      	</div>
	    </div>
    </div>
@endsection