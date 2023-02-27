<input type="hidden" name="order_id" value="{{$order_id}}">
<input type="hidden" name="product_id" value="{{$product_id}}">

<div class='rating-box'>
    <label>{{ ($review) ? 'You Are Allready' :  'Please'  }} Rate This Product</label>
     <fieldset>
        <span class="star-cb-group">
          @for($r=5; $r>=1; $r--)
          <input type="radio" @if($review && $review->ratting == $r) checked @endif id="rating-{{$r}}" required data-parsley-required-message = "Please select ratting" name="ratting" value="{{$r}}" /><label for="rating-{{$r}}" title="{{$r}} Star">{{$r}}</label>
          @endfor

          <input type="radio" id="rating-0" required name="ratting" value="0"  class="star-cb-clear" /><label for="rating-0">0</label>
        </span>
    </fieldset>
</div>
<div class="form-group">
    <label>Write Your Review</label>
    <textarea name="review" data-parsley-required-message = "Please Write Your Review" required rows="3" style="resize: vertical;" placeholder="Your review will be displayed on the product detail page" class="form-control">@if($review && $review->review){{ $review->review }}@endif</textarea>
   
</div>
<div class="row">
  <div class="form-group col-md-6">
      <span>Add Image</span>
      <input type="file" name="review_image[]" multiple="multiple" class="form-control">
  </div>
  <div class="form-group col-md-6">
      <span>Add Video</span>
      <input type="file"  name="review_video[]" multiple="multiple" class="form-control">
  </div>
</div>