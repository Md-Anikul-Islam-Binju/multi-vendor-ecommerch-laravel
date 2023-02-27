@extends('layouts.frontend')
@section('title', 'Order information | '. Config::get('siteSetting.site_name') )
@section('css')
	<style type="text/css">
		.order_success{
			text-align: center;
		}
	</style>
@endsection
@section('content')
  <div class="breadcrumbs">
      <div class="container">
          <ul class="breadcrumb-cate">
              <li><a href="{{url('/')}}"><i class="fa fa-home"></i> </a></li>
              <li><a href="#">Order Infomation</a></li>
          </ul>
      </div>
  </div>
	<!-- Main Container  -->
	<div class="main-container container">
		
		<div class="row">
		
			<!--Middle Part Start-->
			<div id="content" class="col-md-12">


				<div class="order_success">
					<div>
					<i class="fa fa-check-circle" style="font-size: 125px;color: #16a20d;"></i></div>
					<h3>Thank you for shopping at {{Config::get('siteSetting.site_name')}}!</h3>
					<p style="padding:0px;margin: 0px;">Your Order Tracking Id:<a href="{{ route('orderTracking') }}?order_id={{$order['order_id']}}"> {{$order['order_id']}}</a></p>
					We'll email you an order confirmation with details and tracking info.
				</div>
				<h2 class="title">Order Information</h2>

				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<td colspan="2" class="text-left">Order Details</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="width: 50%;" class="text-left"> <b>Order ID:</b> #{{$order['order_id']}}
								<br>
								<b>Order Date:</b> {{Carbon\Carbon::parse($order['order_date'])->format('M d, Y')}}</td>
							<td style="width: 50%;" class="text-left">
								<b>Shipping Status::</b> {{ $order['order_status'] }} <br>
								<b>Payment Status:</b> {{$order['payment_status']}} <br>
								<b>Payment Method:</b> {{$order['payment_method']}} <br>
								
								
							</td>
						</tr>
					</tbody>
				</table>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<td style="width: 50%; vertical-align: top;" class="text-left">Payment Address</td>
							<td style="width: 50%; vertical-align: top;" class="text-left">Shipping Address</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="text-left">{{$order['billing_name']}}
								<br>{{$order['billing_email']}}
								<br>{{$order['billing_phone']}}
								<br>
								
								{{$order['billing_address']}}
								@if( $order['get_area']), {{ $order['get_area']['name']}} @endif
								@if($order['get_city']), {{$order['get_city']['name']}}, @endif
								@if($order['get_state']), {{$order['get_state']['name']}} @endif
							
								
							</td>
							<td class="text-left">{{$order['shipping_name']}}
								<br>{{$order['shipping_email']}}
								<br>{{$order['shipping_phone']}}
								<br>
								{{
									$order['shipping_address']. ', '.
									$order['shipping_area']. ', '.
									$order['shipping_city']. ', '.
									$order['shipping_region']
								
								}} 
							</td>
						</tr>
					</tbody>
				</table>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<td class="text-left">Product Name</td>
								<td class="text-right">Quantity</td>
								<td class="text-right">Price</td>
								<td class="text-right">Total</td>
								<td style="width: 20px;"></td>
							</tr>
						</thead>
						<tbody>
							@foreach($order['order_details'] as $item)
                                         
							<tr>
								<td class="text-left">
									 <a href="{{route('product_details', $item['product']['slug'])}}">{{Str::limit($item['product']['title'], 50)}}</a><br>
                                    @foreach(json_decode($item['attributes']) as $key=>$value)
                                    <small> {{$key}} : {{$value}} </small>
                                    @endforeach
								</td>
								
								<td class="text-right">{{$item['qty']}}</td>
								<td class="text-right">{{$order['currency_sign']. $item['price']}}</td>
								<td class="text-right">{{$order['currency_sign']. $item['price']*$item['qty']}}</td>
								
							</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2"></td>
								<td class="text-right"><b>Sub-Total</b>
								</td>
								<td class="text-right">{{$order['currency_sign'] . $order['total_price']}}</td>
								<td></td>
							</tr>
							<tr>
								<td colspan="2"></td>
								<td class="text-right"><b>Shipping Cost(+)</b>
								</td>
								<td class="text-right">{{$order['currency_sign'] . $order['shipping_cost']}}</td>
								<td></td>
							</tr>
							@if($order['coupon_discount'] != null)
							<tr>
								<td colspan="2"></td>
								<td class="text-right"><b>Coupon Discount(-)</b>
								</td>
								<td class="text-right">{{$order['currency_sign'] . $order['coupon_discount']}}</td>
								<td></td>
							</tr>
							@endif
							<tr>
								<td colspan="2"></td>
								<td class="text-right"><b>Total</b>
								</td>
								<td class="text-right">{{$order['currency_sign'] . ($order['total_price'] + $order['shipping_cost'] - $order['coupon_discount'])  }}</td>
								<td></td>
							</tr>
						</tfoot>
					</table>
				</div>
				
				<div class="buttons clearfix">
					<div class="pull-right"><a class="btn btn-primary" href="{{url('/')}}">Back To Shop</a>
					</div>
				</div>
			</div>
			<!--Middle Part End-->
			
		</div>
	</div>
	<!-- //Main Container -->
@endsection
