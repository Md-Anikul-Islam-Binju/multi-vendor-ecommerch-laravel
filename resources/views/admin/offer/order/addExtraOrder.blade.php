

<?php $total_price = $shipping_cost =  0; $i = 1; $attribute = ''; ?>
@foreach($orders as $order)
   @foreach($order->order_details as $order_detail)
    @php $attribute = ''; @endphp
    <tr id="order_id{{ $order_detail->order_id }}" style="background:@if($order->order_status == 'cancel') #ff000026; @else #ffd40040; @endif border:1px solid #fdce03 !important" >
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
        @if($order->order_status != 'cancel') <input style="width: 80%" type="text" class="form-control" value="{{ $attribute }}" id="attributes{{$order->order_id}}" placeholder="Exm: color:red, size:30"><button style="padding: 9px 10px;" class="btn btn-sm btn-info" onclick="addedAttribute('{{$order->order_id}}')" type="button"> Set </button>  @endif
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
                <option value="on-delivery" @if($order->order_status == 'on-delivery') selected @endif>On Delivery</option>
                <option value="delivered" @if($order->order_status == 'delivered') selected @endif>Delivered</option>
               <option value="cancel"  @if($order->order_status == 'cancel') selected @endif >Cancel</option>
            </select>
        </td>
      </tr>
    @endforeach
   
@endforeach
