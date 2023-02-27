<input type="hidden" value="{{$shipping->id}}" name="id">
<div class="form-group input-lastname " >
    <span class="required">Address Name</span>
    <input type="text" required value="{{$shipping->address_name}}" name="address_name" placeholder="Example: Home, Office" id="input-payment-lastname" class="form-control">
</div>
<div class="form-group input-lastname " >
    <span class="required">Full Name</span>
    <input type="text" required value="{{$shipping->name}}" name="shipping_name" placeholder="Enter Full Name *" id="input-payment-lastname" class="form-control">
</div>
<div class="form-group " style="width: 49%; float: left;">
    <span class="required">Email</span>
    <input type="text" value="{{$shipping->email}}" name="shipping_email"placeholder="E-Mail *" id="input-payment-email" class="form-control">
</div>
<div class="form-group" style="width: 49%; float: right;">
    <span class="required">Phone Number</span>
    <input type="text"  required value="{{$shipping->phone}}" name="shipping_phone" placeholder="Phone Number *" id="input-payment-telephone" class="form-control">
</div>
<div class="form-group" style="width: 49%; float: left;">
<span class="required">Select Your Region</span>
<select name="shipping_region" onchange="get_city(this.value, 'Edit')" required id="input-payment-country" class="form-control ">
    <option value=""> --- Please Select --- </option>
    @foreach($states as $state)
    <option @if($shipping->region == $state->id) selected @endif value="{{$state->id}}"> {{$state->name}} </option>
    @endforeach
</select>
</div>
<div class="form-group " style="width: 49%; float: right;">
    <span class="required">City</span>
    <select name="shipping_city"  onchange="get_area(this.value, 'Edit')"  required id="show_cityEdit" class="form-control select2">
        @foreach($cities as $city)
    	<option @if($shipping->city == $city->id) selected @endif value="{{$city->id}}"> {{$city->name}} </option>
    	@endforeach
    </select>
</div>
<div class="form-group ">
    <span class="required" >Area</span>
    <select name="shipping_area" required id="show_areaEdit" class="form-control select2">
        @foreach($areas as $area)
    	<option @if($shipping->area == $area->id) selected @endif value="{{$area->id}}"> {{$area->name}} </option>
    	@endforeach
    </select>
</div>

<div class="form-group ">
    <span class="required">Address</span>
    <input type="text" value="{{$shipping->address}}" required name="ship_address" placeholder="Enter Address" id="input-payment-address" class="form-control">
</div>
<div class="actions-toolbar">
    <div class="primary">
        <button type="button" data-dismiss="modal" class="btn btn-primary" name="send" id="send2"><span>Cancel</span></button>

        <button type="submit" class="btn btn-success" name="send" id="send2"><span>Save Now</span></button>
    </div>
</div>