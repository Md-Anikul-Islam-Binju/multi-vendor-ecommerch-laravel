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
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                   @foreach($order->order_details as $item)
                      
                      <tr>
                        <td><img src="{{asset('upload/images/product/'.$item->product->feature_image)}}" width="48" height="38" ></td>
                        <td> {{Str::limit($item->product->title, 50)}}<br>
                        @foreach(json_decode($item->attributes) as $key=>$value)
                        <small> {{$key}} : {{$value}} </small>
                        @endforeach</td>
                        
                        <td>{{$order->currency_sign. $item->price}}</td>
                        <td>{{$item->qty}}</td>
                        <td style="text-align: right;">{{$order->currency_sign. $item->price*$item->qty}}</td>
                      </tr> 
                    @endforeach
                   
                </tbody>
                <tfoot style="text-align: right;">
                    <tr>
                        <td colspan="3"></td>
                        <td ><b>Sub-Total</b>
                        </td>
                        <td >{{$order->currency_sign . $order->total_price}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td ><b>Shipping Cost(+)</b>
                        </td>
                        <td >{{$order->currency_sign . $order->shipping_cost}}</td>
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
                        <td ><h3>{{$order->currency_sign . ($order->total_price + $order->shipping_cost - $order->coupon_discount)  }}</h3></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>