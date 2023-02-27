@extends('layouts.frontend')
@section('title', 'Order History')
@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/stylish-tooltip.css') }}">
   <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <style type="text/css">
    	    .icon-box i{font-size: 4rem}
    .ml-auto, .mx-auto {
        margin-left: auto!important;
    }
    .label-return{background: #ff6226;}
    #content .card{border-radius: 5px; }
    .user-box{padding: 10px;    margin-bottom: 10px;}
    .card-title, .icon-box{color: #fff}
    .user-box a{    font-size: 3rem !important; color: #fff}
    #user-dashboard{padding-top: 15px;}
    #user-dashboard section{background: #fff;margin-bottom: 10px;padding: 10px 0;}
    </style>
@endsection
@section('content')
	<div class="breadcrumbs">
		<div class="container">
		  	<ul class="breadcrumb-cate">
		      	<li><a href="{{url('/')}}"><i class="fa fa-home"></i> </a></li>
		      	<li><a href="#">Order History</a></li>
		  	</ul>
		</div>
	</div>
	<!-- Main Container  -->
	<div class="container">
		<?php 
            $all = $pending = $offerPendingOrder = $accepted = $readyToship = $on_delivery = $delivered = $cancel = 0;
            foreach($orders as $order_status){
                if($order_status->payment_method != 'pending' || $order_status->offer_id == null){
                    if($order_status->order_status == 'pending'){ $pending +=1 ; }
                    if($order_status->order_status == 'accepted'){ $accepted +=1 ; }
                    if($order_status->order_status == 'ready-to-ship'){ $readyToship +=1 ; }
                    if($order_status->order_status == 'on-delivery'){ $on_delivery +=1 ; }
                    if($order_status->order_status == 'delivered'){ $delivered +=1 ; }
                    if($order_status->order_status == 'cancel'){ $cancel +=1 ; }
                }
            }
            $all = $pending+$offerPendingOrder+$accepted+ $readyToship +$on_delivery+ $delivered +$cancel;
        ?>
		<div class="row">
			@include('users.inc.sidebar')
			<!--Middle Part Start-->
			<div id="content" class="col-md-9 sticky-content">
				
				@if(Session::has('success'))
                <div class="alert alert-success">
                  <strong>Success! </strong> {{Session::get('success')}}
                </div>
                @endif
                @if(Session::has('error'))
                <div class="alert alert-danger">
                  <strong>Error! </strong> {{Session::get('error')}}
                </div>
                @endif
				<a  href="{{route('user.orderHistory')}}"><h2 style="margin-bottom: 10px;" class="title">Total Order ({{$all}})</h2></a>
				<div class="row">
		            <div class="col-md-2 col-xs-6">
		                <div class="card label-info">
		                    <div class="user-box">
		                        <h5 class="card-title">Pending Orders</h5> 
		                        <div class="d-flex   no-block align-items-center">
		                            <a href="{{route('user.orderHistory', 'pending')}}" class="link ml-auto">{{$pending}}</a>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-2 col-xs-6">
		                <div class="card label-warning">
		                    <div class="user-box">
		                        <h5 class="card-title">Accept Order</h5> 
		                        <div class="d-flex   no-block align-items-center">
		                            <a href="{{route('user.orderHistory', 'accepted')}}" class="link ml-auto">{{$accepted}}</a>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-2 col-xs-6">
		                <div class="card label-default">
		                    <div class="user-box">
		                        <h5 class="card-title">Ready To Ship</h5> 
		                        <div class="d-flex  no-block align-items-center">
		                            <a href="{{route('user.orderHistory', 'ready-to-ship')}}" class="link ml-auto">{{$readyToship}}</a>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-2 col-xs-6">
		                <div class="card label-primary">
		                    <div class="user-box">
		                        <h5 class="card-title">On Delivery</h5> 
		                        <div class="d-flex   no-block align-items-center">
		                            <a href="{{route('user.orderHistory', 'on-delivery')}}" class="link ml-auto">{{$on_delivery}}</a>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-2 col-xs-6">
		                <div class="card label-danger">
		                    <div class="user-box">
		                        <h5 class="card-title">Cancel Order</h5> 
		                        <div class="d-flex  no-block align-items-center">
		                            <a href="{{route('user.orderHistory', 'cancel')}}" class="link ml-auto">{{$cancel}}</a>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-2 col-xs-6">
		                <div class="card label-success">
		                    <div class="user-box">
		                        <h5 class="card-title">Complete Order</h5> 
		                        <div class="d-flex  no-block align-items-center">
		                            <a href="{{route('user.orderHistory', 'delivered')}}" class="link ml-auto">{{$delivered}}</a>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            
		        </div>
		        <br/>
				<div class="table-responsive" >
					<table style="width: 100%" id="config-table" class="table display table-bordered table-striped no-wrap">
						<thead>
							<tr><td>#</td>
								<td class="text-left">Order</td>
								<td class="text-left" style="min-width: 180px;">Product</td>
								<td class="text-center">Qty</td>
								<td class="text-center">Amount</td>
								<td>Pay_Method</td>
								<td class="text-center">Payment Status</td>
								<td class="text-center">Shipping Status</td>
								<td class="text-center">Invoice</td>
								<td class="text-right">Action</td>
							</tr>
						</thead>
						<tbody>
							@foreach($orders as $index => $order)
							@if($order->payment_method != 'pending' || $order->offer_id == null)
							<tr @if($order->order_status == 'cancel') style="background:#ff000026" @endif>
								<td>{{ $index+1 }}</td>
								<td class="text-left"> #{{$order->order_id}}
								<p style="font-size: 11px;color: #797676;" ><i class="fa fa-clock-o"></i> {{Carbon\Carbon::parse($order->order_date)->format(Config::get('siteSetting.date_format'))}}</p></td>
								<td class="text-left">
									@if(count($order->order_details)>0 && $order->order_details[0]->product)  
									<img src="{{asset('upload/images/product/'.$order->order_details[0]->product->feature_image)}}" width="40">
									<a target="_blank" href="{{ route('product_details', $order->order_details[0]->product->slug) }}"> {{Str::limit($order->order_details[0]->product->title, 50)}} </a> 
									@else product not found @endif
								</td>
								<td class="text-center">{{$order->total_qty}}</td>
								<td class="text-center">{{$order->currency_sign . ($order->total_price + $order->shipping_cost - $order->coupon_discount)  }}</td>
								<td class="text-center">
									@if($order->payment_method !='pending')
									<span class="label label-success"> {{ ucfirst(str_replace('-', ' ', $order->payment_method))}}</span> 
                                   
                                    @else
                                    <span style="color: red"> Pending </span><br/>
                                    <a style="margin-top: 5px;" href="{{route('order.paymentGateway', encrypt($order->order_id))}}" class="btn btn-warning btn-xs">Pay Now</a>
                                    @endif
                                </td>

								<td class="text-center"><span class="label label-{{($order->payment_status=='paid' ? 'success' : ($order->payment_status=='received' ? 'warning' : 'danger')) }}">{{$order->payment_status}}</span></td>
								
								<td class="text-center" id="ship_status{{$order->order_id}}">
									@php $updateStatus = $order->orderNotify->where('type', '=', 'orderStatus'); @endphp
									<span class="mytooltip tooltip-effect-2">
										@if($order->order_status == 'delivered')
	                                    <span class="label label-success"> {{ str_replace('-', ' ', $order->order_status)}} </span>

	                                    @elseif($order->order_status == 'accepted')
	                                    <span class="label label-warning"> {{ str_replace('-', ' ', $order->order_status)}} </span>

	                                    @elseif($order->order_status == 'ready-to-ship')
	                                    <span class="label label-default"> {{ str_replace('-', ' ', $order->order_status)}} </span>

	                                    @elseif($order->order_status == 'cancel')
	                                    <span class="label label-danger"> {{ str_replace('-', ' ', $order->order_status)}} </span>

	                                    @elseif($order->order_status == 'on-delivery')
	                                    <span class="label label-primary"> {{ str_replace('-', ' ', $order->order_status)}} </span>
	                                    @elseif($order->order_status == 'return')
	                                    <span class="label label-return"> {{ str_replace('-', ' ', $order->order_status)}} </span>

	                                    @else
	                                    <span class="label label-info"> Pending </span>
	                                    @endif
	                                    @if($order->order_status != 'pending')
	                                    @if(count($order->orderNotify)>0)
                                    	<span class="tooltip-content clearfix">
                                            <span class="tooltip-text">
                                            	
                                                @foreach($updateStatus as $index => $statusNotify)
                                                    @if($statusNotify->notify)
                                                    <p style="font-size: 10px;padding: 0;margin: 0">{{$index+1 .'. '. ucwords($statusNotify->notify)}} <br/><i class="fa fa-clock-o">  {{\Carbon\Carbon::parse($statusNotify->created_at)->format(Config::get('siteSetting.date_format') .' | '.' h:i A')}}</i></p>
                                                    @endif
                                                @endforeach
                                            </span> 
                                        </span>                                        
                                        @endif
                                        @endif
                                    </span>
								</td>
								<td><a target="_blank" class="dropdown-item" href="{{route('user.orderInvoice', $order->order_id)}}" class="text-inverse" title="View Order Invoice" data-toggle="tooltip"><i class="fa fa-print"></i>Invoice</a>
                                            </td>
								<td class="text-center">
									<div class="btn-group">
                                        <button type="button" class="btn btn-xs btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item text-inverse" title="View order" data-toggle="tooltip" href="{{route('user.orderDetails', $order->order_id)}}" data-original-title="View"><i class="fa fa-eye"></i> View Details</a></li>
                                           
                                            @if($order->order_status == 'pending' || $order->order_status == 'accepted')
                                            <li><a title="Cancel Order" onclick="orderCancel('{{ route("user.orderCancelForm", [$order->order_id]) }}')" data-toggle="modal" class="dropdown-item" ><i class="fa fa-trash"></i> Cancel order</a></li>
                                            @endif


                                            @if($order->order_status=='delivered')
												<li><a title="Cancel Order" onclick="orderReturn('{{ route("reseller.return.req", [$order->id]) }}')" data-toggle="modal" class="dropdown-item" > Return Request</a></li>
											@endif
                                        </ul>
                                    </div> 
								</td>
							</tr>
							@endif
							@endforeach
						</tbody>
					</table>
				</div>

			</div>
			<!--Middle Part End-->
			
		</div>
	</div>
	<!-- //Main Container -->
	<!-- canel Modal -->
	<div class="modal fade" id="orderCancel" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Order Cancel</h4>

                    <button type="button" style="margin-top: -25px;" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row">
                	
                    <div class="card-body">
                        <form action="{{route('user.orderCancel')}}" onsubmit="return confirm('{{Auth::user()->name}} Are you sure cancel this order.?');" method="POST" class="floating-labels">
                            {{csrf_field()}}
                            <div class="form-body" id="getCancelForm"> </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!-- canel Modal -->
	<div class="modal fade" id="orderReturn" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Order Cancel</h4>

					<button type="button" style="margin-top: -25px;" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body form-row">

					<div class="card-body">
						<div class="form-body" id="getReturnForm"> </div>
					</div>
				</div>
			</div>
		</div>
	</div>
        
	
@endsection		
@section('js')
   	<script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
	<script type="text/javascript">
	    
	    function orderCancel(url) {
	      	$('#orderCancel').modal('show');
	      	$("#getCancelForm").html("<div style='height:135px' class='loadingData-sm'></div>");
	        $.ajax({
	            url:url,
	            method:"get",
	            success:function(data){
	                if(data){
	                    $("#getCancelForm").html(data);
	                }
	            }
	        });
	    }

		function orderReturn(url) {
			$('#orderReturn').modal('show');
			$("#getReturnForm").html("<div style='height:135px' class='loadingData-sm'></div>");
			$.ajax({
				url:url,
				method:"get",
				success:function(data){
					if(data){
						$("#getReturnForm").html(data);
						$(".js-example-basic-multiple").select2();

					}
				}
			});
		}



	</script>
     <script>
    // responsive table
        $('#config-table').DataTable({
            responsive: true,
            ordering: false
        });
    </script>
@endsection		


