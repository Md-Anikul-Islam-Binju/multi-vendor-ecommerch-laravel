@if(count($allproducts)>0)
    @foreach($allproducts as $product) 
        @php $products_id = $offer->offer_products->pluck('product_id')->toArray();

        $discount = ($product->discount) ? $product->discount : 5; @endphp
        <tr id="product{{  $product->id }}"  @if(in_array($product->id, $products_id)) style="background: #ffe2e2" @endif>
            <td><input type="checkbox" class="product_id" name="product_id[{{  $product->id }}]"></td>
            <td><a style="color: #000" target="_blank" href="{{ route('product_details', $product->slug) }}"><img width="35" src="{{ asset('upload/images/product/thumb/'. $product->feature_image)}}"> {{Str::limit($product->title, 40)}}</a></td>
            <td>{{ Config::get('siteSetting.currency_symble') . $product->selling_price }}</td>
            <td>
                @if($offer->discount > 0)
                    @if($offer->discount_type == 'fixed')
                        {{ Config::get('siteSetting.currency_symble') . $offer->discount }}
                    @elseif($offer->discount_type == '%')
                        {{ Config::get('siteSetting.currency_symble') . ($product->selling_price *  $offer->discount) / 100 }}
                    @elseif($offer->discount_type == 'cash-back')
                        @if($offer->discount_type == '%')
                            {{ Config::get('siteSetting.currency_symble') . ($product->selling_price *  $offer->discount) / 100 }}
                        @else
                            {{ Config::get('siteSetting.currency_symble') . ($product->selling_price - $offer->discount) }}
                        @endif
                    @else
                        {{ Config::get('siteSetting.currency_symble') .( $product->selling_price - $offer->discount) }}
                    @endif
                @else  <input type="text" id="discount{{$product->id}}" class="form-control" placeholder="Enter Discount" name="discount[{{ $product->id }}]" value="{{$discount}}"> @endif
            </td>

            <td>
                @if(!$offer->discount_type)
                <select id="discount_type{{ $product->id}}" class="discount_type" name="discount_type[{{  $product->id }}]">
                <option value="{{Config::get('siteSetting.currency_symble') }}">{{Config::get('siteSetting.currency_symble') }}</option>
                <option selected value="%">%</option>
                </select>
                @else {{$offer->discount_type}} discount @endif
            </td>
            <td><input type="text" class="form-control" value="{{$product->stock}}" id="quantity{{ $product->id }}" name="quantity[{{ $product->id }}]"></td>
            <td><input type="checkbox" id="invisible{{ $product->id }}" value="1" name="invisible[{{ $product->id }}]"></td>
            @if(in_array($product->id, $products_id))
            <td><a href="javascript:void(0)"  class="btn btn-danger btn-sm">Added</a></td>
            @else
             <td><a href="javascript:void(0)"  class="btn btn-success btn-sm" onclick="addProduct({{ $product->id }})">Add</a></td>
            @endif
        </tr>
    @endforeach
    <tr><td colspan="15">{{$allproducts->appends(request()->query())->links()}}</td></tr>

@endif