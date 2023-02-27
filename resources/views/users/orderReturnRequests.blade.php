 @extends('layouts.frontend')
@section('title', 'Order information | '. Config::get('siteSetting.site_name') )
@section('css')
<style type="text/css">
  .table-responsive>.table>tbody>tr>td, .table-responsive>.table>tbody>tr>th, .table-responsive>.table>tfoot>tr>td, .table-responsive>.table>tfoot>tr>th, .table-responsive>.table>thead>tr>td, .table-responsive>.table>thead>tr>th{white-space: initial;}
  .return-request p{margin: 0 !important;}
  .return-conversation{padding: 10px; border-bottom: 1px solid #ccc;}
</style>
@endsection
@section('content')
  <div class="breadcrumbs">
      <div class="container">
          <ul class="breadcrumb-cate">
              <li><a href="{{url('/')}}"><i class="fa fa-home"></i> </a></li>
              <li><a href="#">Order Return</a></li>
          </ul>
      </div>
  </div>
  <!-- Main Container  -->
  <div class="container">
  	
  	
  	<div class="row">
      @include('users.inc.sidebar')
  		<!--Middle Part Start-->
  		<div id="content" class="col-md-9 sticky-content return-request">
       
        @if(count($returnRequests)>0)
        <h2 class="title"> Return Request Lists</h2>
  		  <div class="table-responsive">
            <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left">Order Id</td>
                <td class="text-left">Product</td>
                <td class="text-center">Return Type</td>
                <td class="text-center">Return Reason</td>
                <td class="text-center">Status</td>
                <td class="text-center">Date</td>
                <td class="text-center"></td>
              </tr>
            </thead>
            <tbody>
              @foreach($returnRequests as $returnRequest)                   
              <tr>
                <td class="text-center">{{$returnRequest->order_id}}</td>
                <td class="text-left">
                  <img width="50" src="{{ asset('upload/images/product/thumb/'.$returnRequest->feature_image) }}">
                   <a href="{{route('product_details', $returnRequest->slug)}}">{{Str::limit($returnRequest->title, 50)}}</a><br>
                      @foreach(json_decode($returnRequest->attributes) as $key=>$value)
                      <small> {{$key}} : {{$value}} </small>
                      @endforeach
                </td>
                <td class="text-center">{{$returnRequest->return_type}}</td>
                <td class="text-center"> {{$returnRequest->return_reason}} </td>
                <td class="text-center" style="width: 90px;"> 
                  @if($returnRequest->refund_status == 'approved')
                  <span class="label label-success">Approved</span>
                  @elseif($returnRequest->refund_status == 'reject')
                   <span class="label label-danger">Reject</span>
                  @else
                  <span class="label label-info">Pending</span>
                  @endif
                <td>{{Carbon\Carbon::parse($returnRequest->created_at)->format(Config::get('siteSetting.date_format') . ' h:m:i A')}}</td>
                <td><a href="{{route('user.orderReturn', [$returnRequest->order_id, $returnRequest->slug])}}"> <i class="fa fa-eye"></i> </a> </td>
              </tr>
             @endforeach
            </tbody>
          
            </table>
        </div>
        @else
         <div style="text-align: center;">
            <i style="font-size: 80px;" class="fa fa-reply-all"></i>
            <h1>You have no return request.</h1>
          
        </div>
        @endif
  		</div>
  		<!--Middle Part End-->
  	
  	</div>
  </div>
  <!-- //Main Container -->
@endsection