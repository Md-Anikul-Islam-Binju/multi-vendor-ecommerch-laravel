<div class="row">
    <div class="col-md-12">
        <div class="pull-left" style="float: left;">
            <address>
                {{$order->shipping_name}}
                @if($order->shipping_email)<br>{{$order->shipping_email}}@endif
                <br>{{$order->shipping_phone}}
                <br>
                {!!
                    $order->shipping_address. ', '.
                    $order->shipping_area. ', '.
                    $order->shipping_city. ', '.
                    $order->shipping_region
                
                !!}
                @if($order->order_notes)<br><b style="font-weight: bold;">Notes: </b>{{$order->order_notes}}@endif
            </address>
        </div>
        <div class="pull-right text-right">
            <strong>Order ID:</strong> #{{$order->order_id}} <br>
            <b>Order Date:</b> {{Carbon\Carbon::parse($order->order_date)->format('M d, Y')}}<br> <b>Order Status:</b> {{ str_replace( '-', ' ', $order['order_status']) }} <br>
            <b>Payment Status:</b> {{str_replace( '-', ' ',$order->payment_status) }} <br>
            <b>Payment Method:</b> {{str_replace( '-', ' ',  $order->payment_method) }} <br>
            <b>Shipping Method:</b> @if($order->shipping_method){{ $order->shipping_method->name }} @endif<br>
          
        </div>
    </div>
    <div class="col-md-12">
        <div class="table-responsive" style="margin-top: 5px; clear: both;">
            <table class="table table-hover" style="width: 100%">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th style="text-align: right;">Sub Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = $subprice = $shipping_cost = 0; ?>
                   @foreach($order->seller_order_details as $item)
                      @php
                        $subprice += $item->price*$item->qty;
                        $shipping_cost += $item->shipping_charge; 
                      @endphp
                      @if($item->product)
                      <tr>
                        <td><img src="{{asset('upload/images/product/'.$item->product->feature_image)}}" width="48" height="38" >
                        </td>
                        <td>
                        <a target="_blank" href="{{ route('product_details', $item->product->slug) }}" >{{Str::limit($item->product->title, 50)}} </a><br>
                        @if($item->attributes) 
                        @foreach(json_decode($item->attributes) as $key=>$value)
                        <small> {{$key}} : {{$value}} </small>
                        @endforeach
                        @endif
                        </td>
                        
                        <td>{{$order->currency_sign. $item->price}}</td>
                        <td>{{$item->qty}}</td>
                        <td style="text-align: right;">{{$order->currency_sign.$item->price*$item->qty }}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                     Action
                                </button>
                                <div class="dropdown-menu">

                                    <a href="javascript:void(0)" class="dropdown-item"  onclick="changeOrderStatus('accepted', '{{$order->order_id}}', '{{$item->product->id}}')" title="Accept this product" >Accept</a>
                                    <a class="dropdown-item"  onclick="orderCancelPopup('{{$order->order_id}}', '{{$item->product->id}}')" title="Cancel this product">Cancel</a>
                                </div>
                            </div>
                        </td>
                      </tr> 
                      @endif
                    @endforeach
                   
                </tbody>
                <tfoot style="text-align: right;">
                    <tr>
                        <td colspan="3"></td>
                        <td ><b>Sub-Total</b>
                        </td>
                        <td >{{$order->currency_sign . $subprice}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td ><b>Shipping Cost(+)</b>
                        </td>
                        <td >{{$order->currency_sign . $shipping_cost}}</td>
                        <td></td>
                    </tr>
                    @if($order['coupon_discount'] != null)
                    <tr>
                        <td colspan="3"></td>
                        <td ><b>Coupon Discount(-)</b>
                        </td>
                        <td >{{$order->currency_sign . $order->coupon_discount}}</td>
                        <td></td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="3"></td>
                        <td ><h3><b>Total</b></h3>
                        </td>
                        <td ><h3>{{$order->currency_sign . ($subprice + $shipping_cost - $order->coupon_discount)  }}</h3></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>