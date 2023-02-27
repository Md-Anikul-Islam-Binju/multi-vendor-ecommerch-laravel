 @extends('layouts.frontend')
@section('title', 'Refund information | '. Config::get('siteSetting.site_name') )
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
        @if($checkReturn)
  			<h2 class="title"><a href="{{ route('user.orderDetails', $order_detail->order_id) }}"> <i class="fa fa-angle-left"></i> Return Request Send</a></h2>
  			<p><strong>Request Send ON : </strong> {{Carbon\Carbon::parse($checkReturn->created_at)->format(Config::get('siteSetting.date_format') . ' h:m:i A')}}</p>
         <p><strong>Request Reason: </strong> {{$checkReturn->return_reason}}</p>
        <p><strong>Request Type: </strong> {{$checkReturn->return_type}}</p>
       
        <p><strong>Request Status: </strong>  @if($checkReturn->refund_status == 'approved')
          <span class="label label-success">Approved</span>
          @elseif($checkReturn->refund_status == 'reject')
           <span class="label label-danger">Reject</span>
          @else
          <span class="label label-info">Pending</span>
          @endif
        </p>
        
          <fieldset>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <td class="text-left">Product</td>
                    <td class="text-center">Price</td>
                    <td class="text-center">Quantity</td>
                    <td class="text-center">Order Status</td>
                  </tr>
                </thead>
                <tbody>
                                           
                  <tr>
                    <td class="text-left">
                      <img width="50" src="{{ asset('upload/images/product/thumb/'.$order_detail->feature_image) }}">
                       <a href="{{route('product_details', $order_detail->slug)}}">{{Str::limit($order_detail->title, 50)}}</a><br>
                          @foreach(json_decode($order_detail->attributes) as $key=>$value)
                          <small> {{$key}} : {{$value}} </small>
                          @endforeach
                    </td>
                    <td class="text-center">{{$checkReturn->refund_amount}}</td>
                    <td class="text-center" style="width: 90px;"> {{$checkReturn->qty}} </td>
                    <td class="text-center" style="width: 90px;"> <span class="label label-info">{{ $order_detail->shipping_status }}</span></td>
                  
                  </tr>
                 
                </tbody>
              
                </table>
            </div>
          </fieldset>
  			
  				<fieldset>
  					<legend>Additonal Information</legend>
  				  
            @foreach($checkReturn->refundConversations as $conversation)
            <div class="return-conversation">
              <p>{{ $conversation->explain_issue }}</p>
              @if($conversation->image)
              <img width="100" src="{{ asset('upload/images/refund_image/'.$conversation->image) }}"> @endif
            </div>
            @endforeach
  					<!-- <div class="form-group">
  						<div class="col-sm-8">
                <label for="input-explain" class=" control-label">Please explain the return issue in detail.</label>
  							<textarea required class="form-control" id="input-explain" placeholder="Write Explain return issue." rows="3" name="explain_issue"></textarea>
  						</div>
              <div class="col-sm-5">
                  <label for="return_image" class="control-label">Add Images</label>
                  <input type="file" id="return_image"  multiple name="return_image">
              </div>
  					</div> -->
           
  				</fieldset>
        <!--     <div class="col-sm-8">
      				<div class="buttons clearfix">
      					<div class="pull-left"><a href="{{ route('user.orderDetails', $order_detail->order_id) }}" class="btn btn-default">Cancel</a>
      					</div>
      					<div class="pull-right">
      						<input type="submit" class="btn btn-primary" value="Confirm Return">
      					</div>
      				</div>
          </div> -->
  			
        @else
          <h2 class="title"><a href="{{ route('user.orderDetails', $order_detail->order_id) }}"> <i class="fa fa-angle-left"></i> Send Return Request</a></h2>
          <span><strong>Order Id:</strong> {{$order_detail->order_id}}</span>
          
          <form action="{{ route('user.sendReturn_request') }}" method="post" enctype="multipart/form-data" class="form-horizontal" data-parsley-validate>
            @csrf
            
              <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left">Product</td>
                      <td class="text-center">Price</td>
                      <td class="text-center">Quantity</td>
                      <td class="text-center">Order Status</td>
                    </tr>
                  </thead>
                  <tbody>
                                             
                    <tr>
                      <td class="text-left">
                        <img width="50" src="{{ asset('upload/images/product/thumb/'.$order_detail->feature_image) }}">
                         <a href="{{route('product_details', $order_detail->slug)}}">{{Str::limit($order_detail->title, 50)}}</a><br>
                            @foreach(json_decode($order_detail->attributes) as $key=>$value)
                            <small> {{$key}} : {{$value}} </small>
                            @endforeach
                      </td>
                      <td class="text-center">{{Config::get('siteSetting.currency_symble') . $order_detail->price}}</td>
                      <td class="text-center" style="width: 90px;">
                        <select name="qty" required="" class="form-control">
                          <option value="">Select</option>
                          @for($i=1; $i<=$order_detail->qty; $i++)
                          <option @if($i == $order_detail->qty) selected @endif value="{{$i}}">{{$i}}</option>
                          @endfor
                        </select>
                      </td>
                      <td class="text-center" style="width: 90px;"> <span class="label label-info">{{ $order_detail->shipping_status }}</span></td>
                    
                    </tr>
                   
                  </tbody>
                
                  </table>
              </div>
              <legend>Please complete the form below to request product returns.</legend>
              <input type="hidden" name="order_id" value="{{ $order_detail->order_id }}">
              <input type="hidden" name="product_id" value="{{ $order_detail->product_id }}">
              <input type="hidden" checked="checked" value="refund" name="return_type">
              <div class="row">
                <!-- <div class="col-sm-4">
                  <label>What do you want in return.?</label>
                  <p>
                    <label class="radio-inline">
                      <input type="radio" required checked="checked" value="refund" name="return_type"> Refund
                    </label>
                    <label class="radio-inline">
                      <input type="radio" required value="replacement" name="return_type"> Replacement
                    </label>
                  </p>
                </div> -->
                
                <div class="col-sm-8">
                  <label >What do you want in return.?</label>
                  <select name="return_reason" required class="form-control">
                    <option value="">Select Reason</option>
                    @foreach($reasons as $reason)
                      <option value="{{ $reason->reason }}">{{ $reason->reason }}</option>
                    @endforeach
                  </select>
                </div>
              
                <div class="col-sm-8">
                  <label for="input-explain" class=" control-label">Please explain the return issue in detail.</label>
                  <textarea required class="form-control" id="input-explain" placeholder="Write Explain return issue." rows="3" name="explain_issue"></textarea>
                </div>
                <div class="col-sm-5">
                    <label for="return_image" class="control-label">Add Images</label>
                    <input type="file" id="return_image"  multiple name="return_image">
                </div>
                <div class="col-sm-8">
                  <p><input required type="checkbox" id="refund_policy" name="refund_policy"> <label for="refund_policy"> Only refund allowed as per return policy</label> <a target="_blank" href="{{url('return-policy')}}">View Return Policy</a></p>
                  <div class="buttons clearfix">
                    <div class="pull-left"><a href="{{ route('user.orderDetails', $order_detail->order_id) }}" class="btn btn-info">Cancel</a>
                    </div>
                    <div class="pull-right">
                      <input type="submit" class="btn btn-primary" value="Confirm Return">
                    </div>
                  </div>
                </div>
              </div>
          </form>
        @endif
  		</div>
  		<!--Middle Part End-->
  	
  	</div>
  </div>
  <!-- //Main Container -->
@endsection