<style type="text/css">
  /* reveiw css*/
    .star-cb-group {
      /* remove inline-block whitespace */
      font-size: 0;
      /* flip the order so we can use the + and ~ combinators */
      unicode-bidi: bidi-override;
      direction: rtl;
      /* the hidden clearer */
    }
    .star-cb-group * {
      font-size: 3rem;
    }
    .star-cb-group > input {
      margin-left: -10px;
        opacity: 0
    }
    .star-cb-group > input + label {
      /* only enough room for the star */
      display: inline-block;
      width: 1em;
      white-space: nowrap;
      cursor: pointer;
    }
    .star-cb-group > input + label:before {
      display: inline-block;
      text-indent: -9999px;
      content: "☆";
      color: #888;
    }
    .star-cb-group > input:checked ~ label:before, .star-cb-group > input + label:hover ~ label:before, .star-cb-group > input + label:hover:before {
      content: "★";
      color: #ffa500;
      text-shadow: 0 0 1px #333;
    }
    .star-cb-group > .star-cb-clear + label {
      text-indent: -9999px;
      width: .5em;
      margin-left: -.5em;
    }
    .star-cb-group > .star-cb-clear + label:before {
      width: .5em;
    }
    .star-cb-group:hover > input + label:before {
      content: "☆";
      color: #888;
      text-shadow: none;
    }
    .star-cb-group:hover > input + label:hover ~ label:before, .star-cb-group:hover > input + label:hover:before {
      content: "★";
      color: #ffa500;
      text-shadow: 0 0 1px #333;
    }

    .rating-success{display:none;
        text-align: center;
        font-size: 20px;
        padding: 30px 0;}
    .rating-success.active{display:block}

    .rating-form input.text-field{display:block;width:100%;line-height:25px;font-size:14px;padding:0 10px;border:solid 1px #c1c1c1;}

    .rating-form #review{width:100%;padding:0 10px;line-height:25px;font-size:14px;height:100px;border:solid 1px #c1c1c1;}

    .rating-form #submit{width:100px;line-height:30px;font-size:14px;border-radius:0;-webkit-appearance:none;background: #467379;color: white;border:none;outline:none;}

    .error{padding-left:20px;color:red;font-size:12px;}
</style>
<input type="hidden" name="order_id" value="{{$order_id}}">
<input type="hidden" name="product_id" value="{{$product_id}}">

<div class='rating-box'>
    <label>{{ ($review) ? 'You Are Allready' :  'Please'  }} Rate This Product</label>
     <fieldset>
        <span class="star-cb-group">
          @for($r=5; $r>=1; $r--)
          <input type="radio" @if($review && $review->ratting == $r) checked @endif id="rating-{{$r}}" required data-parsley-required-message = "Please select ratting" name="ratting" value="{{$r}}" /><label for="rating-{{$r}}" title="{{$r}} Star"></label>
          @endfor

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