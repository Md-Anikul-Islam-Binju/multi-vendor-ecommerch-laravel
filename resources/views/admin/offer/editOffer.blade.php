    <input type="hidden" value="{{$offer->id}}" name="id">

    <div class="col-md-12">
        <div class="form-group">
            <label class="required" for="title">Offer Title</label>
            <input  name="title" placeholder="Offer title" id="title" value="{{$offer->title}}" required="" type="text" class="form-control">
        </div>
    </div>
    
    <div class="col-md-4 col-12">
        <div class="form-group">
            <label class="required" for="offer_type">Offer Type</label>
            <select required name="offer_type" class="form-control">
                @foreach($offerTypes as $offerType)
                <option @if($offer->offer_type == $offerType->slug) selected @endif value="{{$offerType->slug}}">{{$offerType->title}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4 col-6">
        <div class="form-group">
            <label class="required" for="discount">Discount</label>
            <input type="text" required value="{{ $offer->discount }}"  name="discount" id="discount" placeholder = 'Enter discount' class="form-control" >
        </div>
    </div>
    <div class="col-md-4 col-6" style="padding-left: 0">
        <div class="form-group">
            <label class="required" for="discount_type">Type</label>
            <select required name="discount_type" class="form-control">
                <option @if($offer->discount_type == 'fixed') selected @endif value="fixed">Fixed Price {{Config::get('siteSetting.currency_symble')}}</option>
                <option @if($offer->discount_type == '%') selected @endif value="%">Percentage %</option>
                <option @if($offer->discount_type == Config::get('siteSetting.currency_symble')) selected @endif value="{{Config::get('siteSetting.currency_symble')}}"> Discount Price %</option>
            </select>
        </div>
    </div>
        <div class="col-md-4">
        <div class="form-group">
            <label class="required" for="name">Prefix Id</label>
            <input name="prefix_id" required class="form-control" type="text" placeholder="Example: WK, WM" value="{{$offer->prefix_id}}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="required" for="name">Start Date</label>
            <input name="start_date" required class="form-control" type="datetime-local" value="{{ Carbon\Carbon::parse($offer->start_date)->format('Y-m-d\TH:i:s')}}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label class="required" for="name">End Date</label>
            <input name="end_date" required class="form-control" type="datetime-local" value="{{ Carbon\Carbon::parse($offer->end_date)->format('Y-m-d\TH:i:s')}}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Bacground Color</label>
            <input name="background_color" type="text" value="{!!$offer->background_color!!}" class="form-control gradient-colorpicker">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Text Color</label>
            <input name="text_color" value="{{$offer->text_color}}" class="form-control gradient-colorpicker" type="text">
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="details">Details</label>
            <textarea name="details" id="details" placeholder="Describe Offer Details" class="summernote form-control">{{$offer->notes}}</textarea>
        </div>
    </div>

    <div class="col-md-4 col-6">
        <div class="form-group"> 
            <label class="dropify_image">Thumbnail Image</label>
            <input type="file" data-default-file="{{asset('upload/images/offer/thumbnail/'.$offer->thumbnail)}}" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="5M"  name="thumbnail" id="input-file-events">
            <i class="image_size">Image Size:600px * 250px </i>
        </div>
        @if ($errors->has('thumbnail'))
            <span class="invalid-feedback" role="alert">
                {{ $errors->first('thumbnail') }}
            </span>
        @endif
    </div>
    <div class="col-md-8 col-6">
        <div class="form-group"> 
            <label class="dropify_image">Banner Image</label>
            <input  type="file" data-default-file="{{asset('upload/images/offer/banner/'.$offer->banner)}}" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="10M"  name="banner" id="input-file-events">
            <i class="image_size">Image Size:1200px * 300px </i>
        </div>
        @if ($errors->has('banner'))
            <span class="invalid-feedback" role="alert">
                {{ $errors->first('banner') }}
            </span>
        @endif
    </div>
   
    <div class="col-md-3 col-6">
        <div class="form-group">
            <div class="checkbox2">
              <input type="radio" @if($offer->allow_item != 'specific') checked @endif required name="allow_item" id="allProducts-edit" value="all">
              <label class="required" for="allProducts-edit">Not Specific Products</label>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-6">
        <div class="form-group">
            <div class="checkbox2">
              <input type="radio"  @if($offer->allow_item == 'specific') checked @endif name="allow_item" id="specific_offer-edit" value="specific-edit">
              <label for="specific_offer-edit">Allow Specific Offer Items</label>
            </div>
        </div>
    </div>

    <div class="col-md-12" id="specific_offer_item-edit" style="display: {{($offer->allow_item == 'specific') ? 'block' : 'none'}}; ">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Select Seller</label>
                    <select multiple name="seller[]" id="seller" class="form-control select2 custom-select">
                        @foreach($sellers as $seller)
                        <option @if($offer->seller_id == $seller->id) selected @endif value="{{$seller->id}}"> {{$seller->shop_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    <label>Select Category</label>
                    <select multiple name="category[]" id="category" class="form-control custom-select select2">
                        @foreach($categories as $category)
                        <option @if($offer->category_id == $category->id) selected @endif value="{{$category->id}}"> {{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Select Brand</label>
                    <select multiple name="brand[]" id="brand" class="form-control custom-select select2">
                        @foreach($brands as $brand)
                        <option @if($offer->brand_id == $brand->id) selected @endif value="{{$brand->id}}"> {{$brand->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2"><label >Allow location</label><select multiple name="allow_location[]" id="allow_location" class="select2 form-control custom-select">@foreach($regions as $region) 
                <option @if($offer->allow_location == $region->id) selected @endif value="{{$region->id}}">{{$region->name}}</option> 
            @endforeach 
        </select></div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <div class="checkbox2">
                <input type="checkbox" @if($offer->shipping_method) checked @endif id="ship_time-edit" value="1">
                <label class="required" for="ship_time-edit">Allow Shipping Charge</label>
            </div>
        </div>
        <div id="ship_time_display-edit"  style="display: {{ ($offer->shipping_method) ? 'block' : 'none' }};">

            <div class="form-group">
                <div class="checkbox2 shipping-method">
                    <label for="free_shipping-edit"><input data-parsley-required-message = "Shipping is required" type="radio" @if($offer->shipping_method == 'free') checked @endif name="shipping_method" id="free_shipping-edit" value="free">
                    Free Shipping</label>

                    <label for="flate_shipping-edit"><input type="radio" name="shipping_method" id="flate_shipping-edit" @if($offer->shipping_method == 'flate') checked @endif value="flate">
                    Flate Shipping</label>
                    <label for="location_shipping-edit">
                    <input type="radio" @if($offer->shipping_method == 'location') checked @endif name="shipping_method" id="location_shipping-edit" value="location">
                    Location-based shipping</label>

                    <label for="qunatity_shipping-edit">
                    <input type="radio" @if($offer->shipping_method == 'qunatity') checked @endif name="shipping_method" id="qunatity_shipping-edit" value="qunatity">
                    Quantity-based shipping</label>
                </div>
            </div>
            <div class="row" id="shipping-field-edit">
                
            @if($offer->shipping_method == 'free')
                <div class="col-md-3"><span>Estimated Shipping Time</span><input class="form-control" name="shipping_time" value="{{$offer->shipping_time}}" placeholder="Exm: 3-4 days" type="text"></div>
            @elseif($offer->shipping_method == 'flate')
                <div class="col-md-3"><span class="required">Shipping Cost</span><input class="form-control" name="shipping_cost" placeholder="Exm: 50" min="1" value="{{ $offer->shipping_cost }}" type="number"></div><div class="col-md-3"><span>Estimated Shipping Time</span><input class="form-control" value="{{$offer->shipping_time}}" name="shipping_time" placeholder="Exm: 3-4 days" type="text"></div>
            @elseif($offer->shipping_method == 'qunatity')
                <div class="col-md-3"><span class="required">Shipping cost</span><input class="form-control" value="{{ $offer->shipping_cost }}" required name="shipping_cost" placeholder="Exm: 60" min="1" type="number"></div><div class="col-md-3"><span class="required">Quantity</span><input class="form-control" required name="order_qty_above" placeholder="Exm: 2" value="{{ $offer->order_qty_above }}" min="1" type="number"></div><div class="col-md-3"><span>Discount shipping cost</span><input class="form-control" name="discount_shipping_cost" value="{{ $offer->discount_shipping_cost }}" placeholder="Exm: 30" type="text"></div><div class="col-md-3"><span>Estimated Shipping Time</span><input class="form-control" name="shipping_time" value="{{$offer->shipping_time}}" placeholder="Exm: 3-4 days" type="text"></div>
            @elseif($offer->shipping_method == 'location')
                <div class="col-md-3"><span class="required">Select Specific Region</span><select required name="ship_region_id" id="ship_region_id" class="select2 form-control custom-select"><option value="">select Region</option> @foreach($regions as $region) <option @if($offer->ship_region_id == $region->id) selected @endif value="{{$region->id}}">{{$region->name}}</option> @endforeach </select></div><div class="col-md-2"><span class="required">Shipping Cost</span><input class="form-control" name="shipping_cost" value="{{ $offer->shipping_cost }}" placeholder="Exm: 50" min="1" type="number"></div><div class="col-md-3"><span>Others region cost</span><input class="form-control" value="{{ $offer->other_region_cost }}" name="other_region_cost" placeholder="Exm: 55" min="1" type="number"></div><div class="col-md-3"><span>Estimated Shipping Time</span><input class="form-control" name="shipping_time" placeholder="Exm: 3-4 days" value="{{$offer->shipping_time}}" type="text"></div>
            @else @endif
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="link" >Custom Link</label>
            <input name="link" value="{{ $offer->link }}" placeholder="Redirect Another Page link" id="link" class="form-control" type="url">
        </div>
    </div>

    <div class="col-md-12 mb-12">
        <div class="form-group">
            <label class="switch-box">Status</label>
            <div  class="status-btn" >
                <div class="custom-control custom-switch">
                    <input name="status" {{($offer->status == 1) ?  'checked' : ''}}   type="checkbox" class="custom-control-input" id="status-edit">
                    <label  class="custom-control-label" for="status-edit">Publish/UnPublish</label>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">

        $("#allProducts-edit").change(function() {
            if(this.checked) { $("#specific_offer_item-edit").hide(); }
            else { $("#specific_offer_item-edit").show(); }
        });

        $("#specific_offer-edit").change(function() {
            if(this.checked) { $("#specific_offer_item-edit").show(); }
            else { $("#specific_offer_item-edit").hide(); }
        });

        //shipping 
       

        $("#ship_time-edit").change(function() {
            if(this.checked) { $("#ship_time_display-edit").show(); }
            else { $("#ship_time_display-edit").hide(); $("#shipping-field-edit").html('');}
        });

        $("#free_shipping-edit").change(function() {
            if(this.checked) { $("#shipping-field-edit").html('<div class="col-md-3"><span>Estimated Shipping Time</span><input class="form-control" name="shipping_time" value="{{$offer->shipping_time}}" placeholder="Exm: 3-4 days" type="text"></div>'); }
            else { $("#shipping-field-edit").html(''); }

        });
       $("#flate_shipping-edit").change(function() {
            if(this.checked) { $("#shipping-field-edit").html('<div class="col-md-3"><span class="required">Shipping Cost</span><input class="form-control" name="shipping_cost" placeholder="Exm: 50" min="1" value="{{ $offer->shipping_cost }}" type="number"></div><div class="col-md-3"><span>Estimated Shipping Time</span><input class="form-control" value="{{$offer->shipping_time}}" name="shipping_time" placeholder="Exm: 3-4 days" type="text"></div>'); }
            else { $("#shipping-field-edit").html(''); }
        });

        $("#qunatity_shipping-edit").change(function() {
           if(this.checked) { $("#shipping-field-edit").html('<div class="col-md-3"><span class="required">Shipping cost</span><input class="form-control" value="{{ $offer->shipping_cost }}" required name="shipping_cost" placeholder="Exm: 60" min="1" type="number"></div><div class="col-md-3"><span class="required">Quantity</span><input class="form-control" required name="order_qty_above" placeholder="Exm: 2" value="{{ $offer->order_qty_above }}" min="1" type="number"></div><div class="col-md-3"><span>Discount shipping cost</span><input class="form-control" name="discount_shipping_cost" value="{{ $offer->discount_shipping_cost }}" placeholder="Exm: 30" type="text"></div><div class="col-md-3"><span>Estimated Shipping Time</span><input class="form-control" name="shipping_time" value="{{$offer->shipping_time}}" placeholder="Exm: 3-4 days" type="text"></div>'); }
            else { $("#shipping-field-edit").html(''); }
        });

        $("#location_shipping-edit").change(function() {
            if(this.checked) { $("#shipping-field-edit").html('<div class="col-md-3"><span class="required">Select Specific Region</span><select required name="ship_region_id" id="ship_region_id" class="select2 form-control custom-select"><option value="">select Region</option> @foreach($regions as $region) <option @if($offer->ship_region_id == $region->id) selected @endif value="{{$region->id}}">{{$region->name}}</option> @endforeach </select></div><div class="col-md-2"><span class="required">Shipping Cost</span><input class="form-control" name="shipping_cost" value="{{ $offer->shipping_cost }}" placeholder="Exm: 50" min="1" type="number"></div></div><div class="col-md-3"><span>Others region cost</span><input class="form-control" value="{{ $offer->other_region_cost }}" name="other_region_cost" placeholder="Exm: 55" min="1" type="number"></div><div class="col-md-3"><span>Estimated Shipping Time</span><input class="form-control" name="shipping_time" placeholder="Exm: 3-4 days" value="{{$offer->shipping_time}}" type="text"></div>');
                
                $(".select2").select2();

            }
            else { $("#shipping-field-edit").html(''); }
        });

    </script>

