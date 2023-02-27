
<form action="{{ route('user.changeShippingAddress', $order->order_id) }}" method="post">
    @csrf
<div class="row">
<div class="col-md-12">
<div class="form-group input-lastname " >
    <span class="required">Full Name</span>
    <input type="text" required value="{{$order->shipping_name}}" name="shipping_name" placeholder="Enter Full Name *" id="input-payment-lastname" class="form-control">
</div>
</div>
<div class="col-md-6">
<div class="form-group ">
    <span class="required">Email</span>
    <input type="text" value="{{$order->shipping_email}}" name="shipping_email"placeholder="E-Mail *" id="input-payment-email" class="form-control">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
    <span class="required">Phone Number</span>
    <input type="text"  required value="{{$order->shipping_phone}}" name="shipping_phone" placeholder="Phone Number *" id="input-payment-telephone" class="form-control">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<span class="required">Select Region</span>
<select name="shipping_region" onchange="get_city(this.value)" required id="input-payment-country" class="form-control ">
    <option value=""> --- Please Select --- </option>
    @foreach($states as $state)
    <option @if($order->shipping_region == $state->name) selected @endif value="{{$state->id}}"> {{$state->name}} </option>
    @endforeach
</select>
</div>
</div>
<div class="col-md-6">
<div class="form-group " >
    <span class="required">City</span>
    <select name="shipping_city"  onchange="get_area(this.value)"  required id="show_city" class="form-control select2">
        @foreach($cities as $city)
    	<option @if($order->shipping_city == $city->name) selected @endif value="{{$city->id}}"> {{$city->name}} </option>
    	@endforeach
    </select>
</div>
</div>
<div class="col-md-12">
<div class="form-group">
    <span class="required">Area</span>
    <select name="shipping_area" required id="show_area" class="form-control select2">
        @foreach($areas as $area)
    	<option @if($order->shipping_area == $area->name) selected @endif value="{{$area->id}}"> {{$area->name}} </option>
    	@endforeach
    </select>
</div>
</div>
<div class="col-md-12">
<div class="form-group">
    <span class="required">Address</span>
    <input type="text" value="{{$order->shipping_address}}" required name="shipping_address" placeholder="Enter Address" id="input-payment-address" class="form-control">
</div>
</div>
</div>
<div class="modal-footer">
 <button type="submit" class="btn btn-success"><span>Update Address</span></button>
</div>
</form>