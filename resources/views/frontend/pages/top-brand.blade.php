@extends('layouts.frontend')
@section('title', 'Top Brand | '. Config::get('siteSetting.site_name') )

@section('css')
<style type="text/css">
    .brand-thumb{position: relative;width: 100%;padding: 3px;height: 100px;
    background: #fff;text-align: center;}
    .desc-listcategoreis {
        color: #000;
        text-align: center;
        padding: 0px;
        background: #fff;
        overflow: hidden;
    }
    .brand-thumb img{height: 100%}
</style>
@endsection 
@section('content')

    <!-- Main Container  -->
    <div class="breadcrumbs">
        <div class="container">
            <ul class="breadcrumb-cate">
                <li><a href="{{url('/')}}"><i class="fa fa-home"></i> </a></li>
                <li>Top Brand</li>
            </ul>
        </div>
    </div>
    @include('frontend.sliders.slider2')
    <div class="container">
        <div class="row">
            <h3 style="padding-top: 10px"><img style="width: 130px;" src="{{asset('frontend/image/brand/brand.png')}}"> Top {{count($brands)}} Brands</h3>
            @foreach($brands as $brand)
            <div class="col-xs-4 col-md-2" style="padding-right: 0px;margin-bottom:10px;">
                <div class="brand-list">
                    <a href="{{ route('brandProducts', $brand->slug) }}"> 
                    <div class="brand-thumb">
                        <img src="{{asset('upload/images/brand/thumb/'.$brand->logo)}}" >
                    </div>
                    <div class="desc-listcategoreis" >
                        <span style="font-weight: bold;font-size: 16px">{{$brand->name}}</span><br/>
                        <span>{{ count($brand->products)}} Products</span>
                           
                    </div>
                    </a>
                </div>
            </div>
            @endforeach
           
        </div>
    </div>
      
@endsection

@section('js')

@endsection