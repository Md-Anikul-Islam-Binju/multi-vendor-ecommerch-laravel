<input type="hidden" value="{{$offerProduct->id}}" name="id">

<div class="col-md-12">
    <div class="form-group">
        <label class="required" for="offer_quantity">Quantity</label>
        <input name="offer_quantity" placeholder="Enter quantity" id="offer_quantity" value="{{$offerProduct->offer_quantity}}" type="text" class="form-control">
    </div>
</div>
@if($offer->offer_type == 'regular')
<div class="col-md-12">
    <div class="form-group">
        <label class="required" for="offer_price">Offer Price</label>
        <input name="offer_price" placeholder="Offer Price" id="offer_price" value="{{$offerProduct->offer_price}}" type="text" class="form-control">
    </div>
</div>
@endif


    