<div class="form-group" >
	<strong><i class="fa fa-user"></i></strong> {{$get_shipping->name}}
</div>

<div class="form-group" >
    <strong><i class="fa fa-envelope"></i></strong> {{$get_shipping->email}}
</div>
<div class="form-group" >
    <strong><i class="fa fa-phone"></i></strong> {{$get_shipping->phone}}
</div>
<div class="form-group" >
    <strong><i class="fa fa-map-marker"></i> </strong> &nbsp;
     {{ $get_shipping->address }},
    @if($get_shipping->get_area) {{$get_shipping->get_area->name}}, @endif
    @if($get_shipping->get_city) {{$get_shipping->get_city->name}}, @endif
    @if($get_shipping->get_state) {{$get_shipping->get_state->name}} @endif
</div>