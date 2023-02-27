<!-- ignore cancel order id -->
@php
    $orderNo = -1;
    foreach($orders as $order){
        $orderNo++;
        if($order->order_status != 'cancel'){
            break;
        }
    }
@endphp
<div class="row">
    <div class="col-4 col-md-2">
        <label class="text-right">Shipping Method</label>
    </div>
    <div class="col-8 col-md-4">
        <select class="form-control" id="order_status" onchange="changeShippingMethod(this.value, '{{$orders[$orderNo]->order_id}}')">
            <option>Select Shipping Method</option>
            @foreach($shipping_methods as $shipping_method)
            <option value="{{$shipping_method->id}}" @if($shipping_method->id ==  $orders[$orderNo]->shipping_method_id) selected @endif >{{$shipping_method->name}}</option>
            @endforeach
        </select>
    </div>
</div>
<hr/>

<div class="row">
   
    <div class="col-md-12">
        <div class="pull-left" style="float: left;max-width: 60%">
            <address>
                {{$orders[$orderNo]->shipping_name}}
                @if($orders[$orderNo]->shipping_email)<br>{{$orders[$orderNo]->shipping_email}}@endif
                <br>{{$orders[$orderNo]->shipping_phone}}
                <br>
                {!!
                    $orders[$orderNo]->shipping_address. ', '.
                    $orders[$orderNo]->shipping_area. ', '.
                    $orders[$orderNo]->shipping_city. ', '.
                    $orders[$orderNo]->shipping_region
                
                !!}
                @if($orders[$orderNo]->order_notes)<br><b style="font-weight: bold;">Notes: </b>{{$orders[$orderNo]->order_notes}}@endif
            </address>
        </div>
        <div class="pull-right text-right">
            <strong>Order ID:</strong> #{{$orders[$orderNo]->order_id}} <br>
            <b>Order Date:</b> {{Carbon\Carbon::parse($orders[$orderNo]->order_date)->format('M d, Y')}}<br> <b>Order Status:</b> {{ str_replace( '-', ' ', $orders[$orderNo]->order_status) }} <br>
            <b>Payment Status:</b> {{str_replace( '-', ' ',$orders[$orderNo]->payment_status) }} <br>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card" style="margin-bottom: 5px;">
            <form action="{{route('admin.offerOrderInvoice', [$offer_slug, $username])}}" target="_blank" method="get" name="addExtraOrder" id="addExtraOrder">
                <div class="form-body">
                   
                    <div class="row">
                        <div class="col-md-4">
                            <label class="control-label">Order ID</label>
                            <input name="order_id" value="{{ Request::get('order_id')}}" data-role="tagsinput" id="tagsinput" type="text" placeholder="Search Order Id" class="form-control">
                            <span style="font-size: 12px;color:red;font-weight: initial;">Add multi order id separated by comma[,]</span>
                        </div>
                        <!-- <div class="col-md-3">
                          
                            <label class="control-label">Customer</label>
                            <input name="customer" value="{{ Request::get('customer')}}" type="text" placeholder="Customer mobile or email" class="form-control">
                     
                        </div> -->
                        <div class="col-md-3">
                           
                            <label class="control-label">Order Status  </label>
                            <select name="status" class="form-control">
                                <option value="">Select Status</option>
                                <option value="pending" {{ (Request::get('status') == 'pending') ? 'selected' : ''}} >Pending</option>
                                <option value="accepted" {{ (Request::get('status') == 'accepted') ? 'selected' : ''}}>Processing</option>
                                <option value="ready-to-ship" {{ (Request::get('status') == 'ready-to-ship') ? 'selected' : ''}}>Ready to ship</option>
                                <option value="on-delivery" {{ (Request::get('status') == 'on-delivery') ? 'selected' : ''}}>On Delivery</option>
                                <option value="all" {{ (Request::get('status') == "all") ? 'selected' : ''}}>All</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="control-label">.</label>
                              <input type="hidden" name="addExtraOrder" value="search">
                            <button type="button" onclick="getExtraOrder('{{route("admin.getOfferOrderDetails", [$offer_slug, $username])}}')" class="form-control btn btn-success"><i style="color:#fff; font-size: 20px;" class="ti-search"></i> Search </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-12"  id="orderListArea">
        <div class="table-responsive" style="margin-top: 5px; clear: both;">
            <table class="table table-hover" style="width: 100%">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAllOrder"></th>
                        <th>Order</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th style="text-align: right;">Price</th>
                        <th style="text-align: right;">Shipping_Cost</th>
                        <th style="text-align: right;">Order Status</th>
                    </tr>
                </thead>
                <tbody id="showAddExtraOrder">
                   
                    <?php $total_price = $shipping_cost =  0; $i = 1; $attribute = ''; ?>
                    @foreach($orders as $order)
                       @foreach($order->order_details as $order_detail)
                        @php $attribute = ''; @endphp
                        <tr id="order_id{{ $order_detail->order_id }}" @if($order->order_status == 'cancel') style="background:#ff000026" @endif>
                            <td><input type="checkbox" class="order_id" name="order_id[{{ $order_detail->order_id }}]"> {{$i++}}</td>
                            <td style="font-size: 12px">
                                {{$order->order_id}}<br/>
                                {{ucfirst(strtolower($order->shipping_name))}}<br/>
                                {{ucfirst(strtolower($order->shipping_phone))}}
                            </td>
                            <td><img src="{{asset('upload/images/product/'.$order_detail->product->feature_image)}}" width="50"> {{ $order_detail->product->title }} <br>
                            @if($order_detail->attributes) @foreach(json_decode($order_detail->attributes) as $key=>$value)
                            @php $attribute .= $value; @endphp
                            @endforeach
                            @endif
                            @if($order->order_status != 'delivered') 
                            <input style="width: 80%" type="text" class="form-control" value="{{ $attribute }}" id="attributes{{$order->order_id}}" placeholder="Exm: color:red, size:30"><button style="padding: 9px 10px;" class="btn btn-sm btn-info" onclick="addedAttribute('{{$order->order_id}}', '{{$order_detail->product_id}}')" type="button"> Set </button>  @endif
                            </td>
                            <td>{{$order->currency_sign. $order_detail->price}}</td>
                            <td>{{$order_detail->qty}}</td>
                            <td style="text-align: right;">{{$order->currency_sign. $order_detail->price*$order_detail->qty}}</td>
                            <td>
                                @if($order->shipping_cost != null) <span class="label label-success">paid</span> @else <span class="label label-danger">pending </span>@endif
                            </td>
                            <td>
                                <select name="status" class="selectpicker"  data-style="btn-sm @if($order->order_status == 'delivered') btn-success @elseif($order->order_status == 'accepted') btn-warning 
                                    @elseif($order->order_status == 'ready-to-ship') btn-info
                                    @elseif($order->order_status == 'cancel')  btn-danger @elseif($order->order_status == 'on-delivery') btn-primary @else btn-info @endif " id="order_status" onchange="changeOrderStatus(this.value, '{{$order->order_id}}')">
                                    <option value="pending" @if($order->order_status == 'pending') selected @endif>Pending</option>
                                    <option value="accepted" @if($order->order_status == 'accepted') selected @endif>Accepted</option>
                                    <option value="ready-to-ship" @if($order->order_status == 'ready-to-ship') selected @endif>Ready to ship</option>
                                    @if(Auth::guard('admin')->user()->role_id == 'admin' || in_array(Auth::guard('admin')->id(), [22,25]))
                                    <option value="on-delivery" @if($order->order_status == 'on-delivery') selected @endif>On Delivery</option>
                                    <option value="delivered" @if($order->order_status == 'delivered') selected @endif>Delivered</option>
                                   @endif
                                   <option value="cancel"  @if($order->order_status == 'cancel') selected @endif >Cancel</option>
                                </select>
                            </td>
                          </tr> 
                          @php 
                            $total_price += $order_detail->price;
                          @endphp
                        @endforeach
                        @php 
                            $shipping_cost += $order->shipping_cost;
                          @endphp
                    @endforeach
                </tbody>
                <tfoot style="text-align: right;">
                    <tr>
                        <td colspan="4"></td>
                        <td ><b>Sub-Total</b>
                        </td>
                        <td >{{$orders[$orderNo]->currency_sign . $total_price}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td ><b>Shipping Cost({{$orders[$orderNo]->currency_sign}})</b>
                        </td>
                        <td> <input type="number" style="text-align: right;" class="form-control" id="shipping_cost" placeholder="Enter Amount" value="{{($shipping_cost > 0 ) ? $shipping_cost : null}}" name="shipping_cost"> <i style="color: red;font-size: 12px;">Enter Shipping Cost</i>
                        </td>
                        <td style="text-align: left;"><button style="padding: 9px 10px;" class="btn btn-sm btn-info" onclick="addedOrderInfo('shipping_cost', '{{ $orders[$orderNo]->order_id }}')" type="button"> Update </button> 
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td ><b>Comment</b>
                        </td>
                        <td><input type="text" style="text-align: right;" class="form-control" id="comment" placeholder="Write Comment" name="comment">
                        </td>
                        <td style="text-align: left;">
                            <span class="mytooltip tooltip-effect-2">
                                <button style="padding: 9px 10px;" class="btn btn-sm btn-info" onclick="addedOrderInfo('comment', '{{ $orders[$orderNo]->order_id }}')" type="button">Comment</button>
                                <span class="tooltip-content clearfix">
                                <span class="tooltip-text" style="line-height: 15px;">
                                    {!! $orders[$orderNo]->comment !!}
                                </span>
                                </span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td ><h3><b>Total</b></h3>
                        </td>
                        <td ><h3>{{$orders[$orderNo]->currency_sign . ($total_price + $shipping_cost)  }}</h3></td>
                        <td></td>
                    </tr>
                </tfoot>
               
            </table>
        </div>
    </div>
</div>
<div style="text-align: right;"> <button type="submit" onclick="orderModalhide()"class="text-inverse" form="addExtraOrder" title="View Order Invoice"><i class="ti-printer"></i> Print Order Invoice</button></div>