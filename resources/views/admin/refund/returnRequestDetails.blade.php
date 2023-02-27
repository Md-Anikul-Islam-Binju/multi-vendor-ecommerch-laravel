@extends('layouts.admin-master')
@section('title', 'Refund Details ')
@section('css')
<style type="text/css">
    b, strong {
    font-weight: 700;
}
</style>
@endsection
@section('content')
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor"><a href="{{ url()->previous() }}"> <i class="fa fa-angle-left"></i> Invoice NO #{{$refundDetails->order_id}}</a></h4>
                    </div>
                     @if($refundDetails->refund_status == 'pending')
                     <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                         
                            <a href="{{ route('admin.refundRequestApproved', [$refundDetails->id, 'approved']) }}"  class="btn btn-info m-l-15"><i class="fa fa-check"></i> Approved</a>
                            <a href="{{ route('admin.refundRequestApproved', [$refundDetails->id, 'reject']) }}"  class="btn btn-danger  m-l-15"><i class="fa fa-times"></i> Reject</a>
                           
                        </div>
                    </div>
                     @endif
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="container">
                       
                        <div class="col-md-12">
                            <div class="card card-body">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="pull-left" style="float: left;">
                                            <address>
                                                <strong>Request Send ON : </strong> {{Carbon\Carbon::parse($refundDetails->created_at)->format('d M, Y h:m:i A')}}<br>
                                               <strong>Request Reason: </strong> {{$refundDetails->return_reason}}<br>
                                               <strong>Request Type: </strong> {{$refundDetails->return_type}}<br>
                                           
                                                <strong>Request Status: </strong>  
                                                    @if($refundDetails->refund_status == 'approved')
                                                      <span class="label label-success">Approved</span>
                                                      @elseif($refundDetails->refund_status == 'reject')
                                                       <span class="label label-danger">Reject</span>
                                                      @else
                                                      <span class="label label-info">Pending</span>
                                                      @endif<br>
                                            </address>
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="pull-right text-right">
                                           
                                            <b>Order Date:</b> {{Carbon\Carbon::parse($refundDetails->order_date)->format('M d, Y')}}<br>
                                            <b>Name:</b> {{$refundDetails->billing_name}}<br/>
                                            <b>Mobile:</b>{{$refundDetails->billing_phone}}<br/>
                                            <b>Email:</b>{{$refundDetails->billing_email}}<br/>
                                            <b>Payment Status:</b> {{str_replace( '-', ' ',$refundDetails->payment_status) }} <br>
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive" style="margin-top: 5px; clear: both;">
                                            <table class="table display table-bordered table-striped"style="width: 100%">
                                                <thead>
                                                  <tr>
                                                    <td class="text-left">Product</td>
                                                    <td class="text-center">Price</td>
                                                    <td class="text-center">Quantity</td>
                                                    <td class="text-center">Total</td>
                                                    <td class="text-center">Order Status</td>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                                           
                                                  <tr>
                                                    <td class="text-left">
                                                      <img width="50" src="{{ asset('upload/images/product/thumb/'.$refundDetails->feature_image) }}">
                                                       <a href="{{route('product_details', $refundDetails->slug)}}">{{Str::limit($refundDetails->title, 50)}}</a><br>
                                                          @foreach(json_decode($refundDetails->attributes) as $key=>$value)
                                                          <small> {{$key}} : {{$value}} </small>
                                                          @endforeach
                                                    </td>
                                                    <td class="text-center">{{ $refundDetails->currency_sign . $refundDetails->refund_amount}}</td>
                                                    <td class="text-center" style="width: 90px;"> {{$refundDetails->qty}} </td>

                                                    <td class="text-center">{{ $refundDetails->currency_sign . $refundDetails->refund_amount * $refundDetails->qty}}</td>
                                                    <td class="text-center" style="width: 90px;"> <span class="label label-info">{{ $refundDetails->shipping_status }}</span></td>
                                                  
                                                  </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <legend>Additonal Information</legend>
                  
                                        @foreach($refundDetails->refundConversations as $conversation)
                                        <div class="return-conversation">
                                          <p>{{ $conversation->explain_issue }}</p>
                                          @if($conversation->image)
                                          <img width="100" src="{{ asset('upload/images/refund_image/'.$conversation->image) }}"> 
                                          @endif
                                        </div>

                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
           
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
@endsection

@section('js')

@endsection