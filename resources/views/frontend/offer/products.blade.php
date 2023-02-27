@foreach($offer_products as $product)
<div class="product-layout col-lg-2 col-md-2 col-sm-4 col-xs-6">
    <div class="product-item-container">
        <div class="left-block">
            <div class="product-image-container">
                <a href="{{ route('product_details', $product->slug) }}?offer={{$offer->slug}}" >
                <img src="{{asset('upload/images/product/thumb/'. $product->feature_image)}}" class="img-1 img-responsive">
                </a>
                @if($product->stock <= 0)
                <div class="box-label">
                <span class="label-sale">Sold Out</span>
                </div>
                @endif
            </div>
        </div> 
        <div class="right-block">
            <div class="caption">
                <h4><a href="{{ route('product_details', $product->slug) }}?offer={{$offer->slug}}">{{Str::limit($product->title, 40)}}</a></h4>
                <div class="total-price clearfix">
                    <div class="price price-left">
                         <label for="ratting5">{{\App\Http\Controllers\HelperController::ratting(round($product->reviews->avg('ratting'), 1))}}</label><br/>
                        <?php
                        $selling_price = $product->selling_price;
                        $discount = $product->discount;
                        $discount_type = $product->discount_type;
                        
                        if($discount_type == '%'){
                            $price = $selling_price - ( $discount * $selling_price) / 100; 
                        }elseif($discount_type == 'fixed'){
                            $price = $discount;
                            $discount = $selling_price - $discount;
                            //make persentage
                            $discount = round(((($selling_price-$discount) - $selling_price)/$selling_price) * 100);
                          
                        }else{
                            $price = $selling_price - $discount;
                            //make persentage
                            $discount = round(((($selling_price-$discount) - $selling_price)/$selling_price) * 100);
                        }
                        ?>

                       @if($discount)
                            <span class="price-new">{{Config::get('siteSetting.currency_symble')}}{{ $price }}</span>
                            <span class="price-old">{{Config::get('siteSetting.currency_symble')}}{{ round($selling_price) }}</span>
                        @else
                            <span class="price-new">{{Config::get('siteSetting.currency_symble')}}{{$selling_price}}</span>
                        @endif
                        </div>
                        @if($discount)
                        <div class="price-sale price-right">
                            <span class="discount">
                              @if($discount_type == '%')-@endif{{$discount}}%
                            <strong>OFF</strong>
                          </span>
                        </div>
                        @endif
                </div>
            </div>
            @if(now() >= $offer->start_date)
            <div class="button-group">
           
                <span class="quickview iframe-link visible-lg btn-button" data-toggle="tooltip" title="" data-fancybox-type="iframe" href="{{route('quickview', $product->slug)}}?type=quickview&offer={{$offer->slug}}" data-original-title="Quickview "> <i class="fa fa-search"></i> </span>
            
                <button class=" btn-button" type="button" data-toggle="tooltip" title="" onclick="addToCart('{{$product->id,}}', '{{$offer->slug}}')" data-original-title="Add to Cart"><i class="fa fa-cart-plus"></i> </button>

                <button class="wishlist btn-button" type="button"  title="Add to Wish List" @if(Auth::check()) onclick="addToWishlist({{$product->id}})" data-toggle="tooltip" @else data-toggle="modal" data-target="#so_sociallogin" @endif data-original-title="Add to Wish List"><i class="fa fa-heart-o"></i></button>

                <button class="compare btn-button" type="button" title="Compare this Product" data-toggle="tooltip" onclick="addToCompare({{$product->id}})" data-original-title="Compare this Product"><i class="fa fa-retweet"></i></button>
            </div>
            @endif
        </div>
    </div>
</div>
@endforeach
