<thead>
	<tr>
		<th class="text-left name" colspan="2">Product</th>
		<th class="text-center">Price</th>
		<th class="text-center quantity">Quantity</th>
		<th class="text-right total">Total</th>
	</tr>
</thead>
<tbody>
	<?php $total = $total_shipping_cost = 0; $totalWeight=0;?>
    @foreach($cartItems as $item)
        <?php 
           
            $price = $item->price;
            $total += $price*$item->qty;
            //calculate shipping cost
            if(config('siteSetting.shipping_method') == 'product_wise_shipping'){
                $shipping_cost = $item->get_product->shipping_cost;
                //check product_wise_shipping shipping method type
                if($item->get_product->shipping_method == 'location'){
                    if ($item->get_product->ship_region_id !=  Session::get('ship_region_id')) {
                        $shipping_cost = $item->get_product->other_region_cost;
                    }
                }
            }else{
                $shipping_cost =  \App\Http\Controllers\HelperController::shippingCharge();
            }
             //check calculate type
            if(config('siteSetting.shipping_calculate') == 'per_product'){
                $total_shipping_cost +=  $shipping_cost;
            }elseif (config('siteSetting.shipping_calculate') == 'weight_based'){


				//print_r($item->get_product);
				$itemWeight = \App\Models\Product::findOrFail($item->get_product->id)->weight;
				//\Brian2694\Toastr\Facades\Toastr::success($itemWeight);
				if ($itemWeight==0 || $itemWeight <0){
					$totalWeight+=1 * $item->qty;
				}else{
					$totalWeight+=$itemWeight * $item->qty;
				}


			}else{
                if($shipping_cost > $total_shipping_cost) {
                    $total_shipping_cost = $shipping_cost;
                }
            }
        ?>
	<tr id='carItem{{$item->id}}'>
		<td class="text-left name"> <a href="{{route('product_details', $item->slug)}}"><img width="70" src="{{asset('upload/images/product/thumb/'.$item->image)}}" class="img-thumbnail"></a> </td>

        <td class="text-left attributes"><a href="{{route('product_details', $item->slug)}}">{{ Str::limit($item->title, 50)}}</a>
        	@if($item->attributes)<br>
            @foreach(json_decode($item->attributes) as $key=>$value)
            <small> {{$key}} : {{$value}} </small>
            @endforeach
            @endif
        </td>
		<td class="text-center">{{Config::get('siteSetting.currency_symble')}}<span class="amount">{{$price}}</span></td>

{{--		<td class="text-left quantity">--}}
{{--			<div class="input-group">--}}
{{--				<input type="text" min="1" id="qtyTotal{{$item->id}}" onchange="cartUpdate({{$item->id}})" name="qtybutton" value="{{$item->qty}}" size="1" class="form-control">--}}
{{--				<span class="input-group-btn">--}}
{{--					<span title="Remove Item" data-target="#delete" data-toggle="modal" onclick='cartDeleteConfirm("{{$item->id}}")' style="color:red" class="btn-delete" data-original-title="Remove"><i class="fa fa-trash-o"></i></span>--}}
{{--					--}}
{{--					<span data-toggle="tooltip" title="" data-product-key="317" onclick="cartUpdate({{$item->id}})" class="btn-update" data-original-title="Update"><i class="fa fa-refresh"></i></span>--}}
{{--				</span>--}}
{{--			</div>--}}
{{--		</td>--}}


		<td class="text-left">
			<div class="input-group btn-block" style="max-width: 200px;">
				<input type="number" min="1" style="margin-right: 15px;" id="qtyTotal{{$item->id}}" onchange="cartUpdate({{$item->id}})" name="qtybutton" value="{{$item->qty}}" class="form-control">
				<span class="input-group-btn">
					<span title="Remove Item" data-target="#delete" data-toggle="modal" onclick='cartDeleteConfirm("{{$item->id}}")' style="color:red" class="btn-delete" data-original-title="Remove"><i class="fa fa-trash-o"></i></span>
{{--                        <button style="padding: 7px;" type="button" onclick ="cartUpdate({{$item->id}})" data-toggle="tooltip" title="" class="btn btn-primary" data-original-titl--}}
{{--						="Update"><i class="fa fa-refresh"></i></button>--}}
				</span>
			</div>
		</td>



		<td class="text-right total">{{Config::get('siteSetting.currency_symble')}}<span id="subtotal{{$item->id}}">{{$price*$item->qty}}</td>
	</tr>
	@endforeach

<?php
$check = \App\Http\Controllers\HelperController::dhakaCityCheck(4);

$roundWeight = ceil($totalWeight);
if ($check){
	if ($roundWeight>1){
		$extra = $roundWeight - 1;
		$extraCost = $extra * 30;
		$total_shipping_cost = $extraCost + 80;
	}else{
		$total_shipping_cost += 80;
	}

}else{
	if ($roundWeight>1){
		$extra = $roundWeight - 1;
		$extraCost = $extra * 30;
		$total_shipping_cost+= $extraCost + 150;
	}else{
		$total_shipping_cost+= 150;
	}
}
Toastr::warning("total weight: $totalWeight, cost: $total_shipping_cost");

?>
</tbody>
<tfoot>
	<tr>
		<td colspan="4" class="text-right"><strong>Sub-Total:</strong></td>
		<td class="text-right">{{Config::get('siteSetting.currency_symble')}}<span id="cartTotal">{{$total}}</span></td>
		</tr>

		<tr>
		<td colspan="4" class="text-right"><strong>VAT (0%):</strong></td>
		<td class="text-right">$0.00</td>
		</tr>
		<tr>
		<td colspan="4" class="text-right"><strong>Shipping cost(+):</strong></td>
		<td class="text-right">+{{Config::get('siteSetting.currency_symble')}}<span id="shipping_cost">{{$total_shipping_cost}}</span></td>
		</tr>
		<?php $coupon_discount = (Session::get('couponType') == '%') ? ( $total * Session::get('couponAmount')) : Session::get('couponAmount'); ?>

		<tr id="couponSection"  style="display: {{Session::get('couponAmount') ? 'table-row' : 'none'}}">
		<td class="text-right" colspan="4"><strong>Coupon Discount(-):</strong></td>
		<td class="text-right">-{{Config::get('siteSetting.currency_symble')}}<span id="couponAmount">{{ $coupon_discount }}</span> </td>
		</tr>
		

		@if(!Auth::guard('reseller')->check())
		<tr>
			<td colspan="2"></td>
			<td>
                
                <form action="#" id="couponForm" method="get">
                	<div class="input-group">
	                <input type="text" required name="coupon_code" id="coupon_code" value="{{Session::get('couponCode')}}" placeholder="Enter your coupon here" class="form-control">
	                <span class="input-group-btn" style="display: block;">
	                        <input style="padding: 7px;" type="submit" value="Apply Coupon" id="couponBtn" data-loading-text="Loading..." class="btn btn-primary">
	                    </span>
	                </div>
                </form>
                </td>
		</tr>
		@endif
		<tr>
		<td colspan="4" class="text-right"><strong>Total:</strong></td>
		<td class="text-right">{{Config::get('siteSetting.currency_symble')}}<span  id="grandTotal">{{ $total + $total_shipping_cost - $coupon_discount }}</td>
		</tr>
</tfoot>
