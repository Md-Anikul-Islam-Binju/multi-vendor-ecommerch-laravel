<div class="price price-left">
    <label for="ratting5">
       {{\App\Http\Controllers\HelperController::ratting(round($product->reviews->avg('ratting')))}}
    </label><br/>
    <?php  
        $selling_price = $product->selling_price;
        $discount = ($product->discount) ? $product->discount : null;
        $discount_type = $product->discount_type;
        if($discount){
            $calculate_discount = App\Http\Controllers\HelperController::calculate_discount($selling_price, $discount, $discount_type );
        }
    ?>

    @if(Auth::guard('reseller')->check())
        <span class="price-new" style="border: 1px solid red; padding: 5px; border-radius: 30px">{{Config::get('siteSetting.currency_symble')}}{{$product->reseller_price}}</span>
    @else
        @if($discount)
            <span class="price-new">{{Config::get('siteSetting.currency_symble')}}{{ $calculate_discount['price'] }}</span>
            <span class="price-old">{{Config::get('siteSetting.currency_symble')}}{{$selling_price}}</span>
        @else
            <span class="price-new">{{Config::get('siteSetting.currency_symble')}}{{$selling_price}}</span>
        @endif
    @endif

</div>

@if($discount)
<div class="price-sale price-right">
    <span class="discount">
      @if($discount_type == '%')-@endif{{$calculate_discount['discount']}}%
    <strong>OFF</strong>
  </span>
</div>
@endif