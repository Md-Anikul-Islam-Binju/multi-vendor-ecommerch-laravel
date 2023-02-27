
<li class="content-item" @if(count($getCart)>4) style="height: 400px;overflow-y: scroll;" @endif >
    <table class="table table-striped" style="margin-bottom:10px;color:#000">
      <tbody>
       
        @foreach($getCart as $item)
        <?php
        $discount = null;
        $price = $item->price;  
        ?>
        <tr>
          <td class="text-center size-img-cart">
            <a href="{{ route('product_details', $item->slug) }}"><img src="{{asset('upload/images/product/thumb/'.$item->image)}}" title="{{Str::limit($item->title, 100)}}" class="img-thumbnail"></a>
          </td>
          <td class="text-left"><a style="color:#000" href="{{ route('product_details', $item->slug) }}">{{Str::limit($item->title, 22)}}</a>
            @if($item->attributes)
            <br> - @foreach(json_decode($item->attributes) as $key=>$value)
                    <small style="color:#000"> {{$key}} : {{$value}},  </small>
              @endforeach
              @endif
          </td>
          <td class="text-right">x{{$item->qty}}</td>
          <td class="text-right">{{Config::get('siteSetting.currency_symble')}}{{$price}}</td>
          <td class="text-center">
            <button type="button" title="Remove" data-target="#delete" data-toggle="modal" onclick='deleteCartItem("{{route("cart.itemRemove", $item->id)}}")' class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
          </td>
        </tr>
        @endforeach
       
      </tbody>
  </table>

</li>
<li>
    <div class="checkout clearfix">
      <a href="{{ route('cart') }}" class="btn btn-info inverse"> View Cart</a>
      <a href="{{ route('checkout') }}?process=checkout" class="btn btn-success pull-right">Checkout</a>
    </div>
</li>
