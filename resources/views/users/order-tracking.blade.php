@extends('layouts.frontend')
@section('title', 'Track Your Order | '. Config::get('siteSetting.site_name') )
@section('css')

@endsection
@section('content')

<!-- Main Container  -->
<div class="breadcrumbs">
    <div class="container">
        
        <ul class="breadcrumb-cate">
            <li><a href="{{url('/')}}"><i class="fa fa-home"></i> </a></li>
            <li>Track Your Order</li>
        </ul>
    </div>
</div>

<!-- Main Container  -->
<div class="main-container container">
    
    <div class="row justify-content-md-center">
    
        <div class="col-md-6" style="text-align: center;">
            <img src="{{ asset('frontend/image/track-your-order.png')}}"><br/>
            <form action="{{ route('orderTracking') }}" method="get">
            <input placeholder="Enter Your Order Id" required type="text" style="width: 80%;" name="order_id"><br/> <br/>
            <button class="btn btn-warning"><i class="fa fa-search"></i> Track Now</button>
            </form>
        </div>
         <div class="col-md-6" style="text-align: center;">
             <img src="{{ asset('frontend/image/order-track.jpg')}}"><br/>
        </div>
    </div>
</div>
  
 
@endsection

@section('js')

@endsection