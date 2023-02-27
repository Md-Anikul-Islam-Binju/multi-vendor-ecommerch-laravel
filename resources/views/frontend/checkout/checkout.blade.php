@extends('layouts.frontend')
@section('title', 'Checktout')
@section('css')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
 	<link href="{{asset('frontend')}}/css/themecss/so_onepagecheckout.css" rel="stylesheet">
    <style type="text/css">
    	#submitBtn{width: 100%}
    </style>
@endsection
@section('content')
	<div class="breadcrumbs">
	    <div class="container">
		    <ul class="breadcrumb-cate">
		        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
		        <li><a href="#">Checkout</a></li>
		    </ul>
	    </div>
	</div>
	<!-- Main Container  -->
	<div class="container">
		<div class="row">
			<div id="content" class="col-sm-12">
				<div id="dataLoading"></div>
				@if(Session::has('alert'))
				<div class="alert alert-danger">
				  {{Session::get('alert')}}
				</div>
				@endif
				<div class="so-onepagecheckout layout1 row">
					<div class="col-left col-lg-6 col-md-6 col-sm-6 col-xs-12 sticky-content">
						<form action="{{ route('shippingRegister') }}" name="shipping_form" id="shipping_form" data-parsley-validate method="post" class="form-horizontal form-shipping">
						@csrf
						@if(!Auth::check())
						<div class="checkout-content login-box">
							<h2 class="secondary-title">Create an Account or Login</h2>
							<div class="box-inner">

								<div class="radio">
									<label> <input type="radio" name="account" id="guest" value="guest">Guest Checkout </label>
								</div>

								<div class="radio">
									<label> <input type="radio" data-dismiss="modal" id="register" name="account" value="register" checked="checked">Customer Account</label>
								</div>

								<div class="radio">
									<label><input type="radio" data-toggle="modal" data-target="#so_sociallogin"  name="account" value="login">Returning Customer</label>
								</div>
							</div>
						</div>
						@endif
						<div class="checkout-content checkout-register">
			
							@if(!Auth::check())
							<fieldset id="account">
								<h2 class="secondary-title">Billing Details</h2>
								<div class=" box-inner">
									
									<div class="form-group input-firstname required" >
										<span>Full Name</span>
										<input type="text" name="name" required value="{{old('name')}}" placeholder="First Name *" id="fullname_required" class="form-control">
									</div>

									<div class="form-group required" style="width: 49%; float: left;">
										<span>Phone Number</span>
										<input type="text" required name="mobile" value="{{old('mobile')}}" placeholder="Phone Number *" pattern="/(01)\d{9}/" onkeyup ="checkField(this.value, 'mobile', 'mobile')" data-parsley-required-message = "Phone is required"  id="mobile_required" class="form-control">
										<span id="mobile"></span>
									</div>
									
									<div class="form-group required" style="width: 49%; float: right;">
										<span>Email (Optional)</span>
										<input type="email" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}" value="{{old('email')}}" name="email" onkeyup ="checkField(this.value, 'email', 'email')" placeholder="E-Mail" id="email_required" class="form-control">
										<span id="email"></span>
									</div>

									

									<div class="form-group required">
										<span>Select Your Shipping Cost Division Wise</span>
										<select name="region" onchange="get_city(this.value)" required id="input-payment-country" class="form-control">
											<option value=""> --- Please Select --- </option>
											@foreach($states as $state)
											<option value="{{$state->id}}"> {{$state->name}} </option>
											@endforeach
										</select>
									</div>

{{--									<div class="form-group required">--}}
{{--										<span>City</span>--}}
{{--										<select name="city" onchange="get_area(this.value)"  required id="show_city" class="form-control select2">--}}
{{--											<option value=""> Select first Region </option>--}}
{{--										</select>--}}
{{--									</div>--}}


{{--									<div class="form-group">--}}
{{--										<span>Area</span>--}}
{{--										<select name="area" id="show_area" class="form-control select2">--}}
{{--											<option value=""> Select first city </option>--}}
{{--										</select>--}}
{{--									</div>--}}
									
									<div class="form-group required">
										<span class="required">Address</span>
										<input type="text" value="{{old('address')}}" required name="address" placeholder="Enter Address" id="input-payment-address" class="form-control">
									</div>
									
									<div id="password" style="display: block;">
									
										<div class="form-group required" style="width: 49%; float: left;">
											<span>Password</span>
											<input required type="password" name="password"  data-parsley-required-message= "Password is required" placeholder="Password *" minlength="6" id="userpassword" class="form-control">
										</div>
										<div class="form-group required" style="width: 49%; float: right;">
											<span>Confirm Password</span>
											<input type="password" required placeholder="Retype password" data-parsley-equalto="#userpassword"  name="password_confirmation" minlength="6" id="password2" class="form-control">
										</div>
									</div>

								</div>
							</fieldset>
							
							<div class="checkbox" style="padding: 0px 20px;">
								<label>
									<input type="checkbox" id="shipping_address" name="shipping_address" value="1" checked="checked"> My billing and shipping addresses are the same.
								</label>
							</div>
							@endif
							<fieldset id="shipping-address" @if(!Auth::check()) style="display: none" @endif>
								<h2 class="secondary-title">Shipping Address</h2>
								<div class=" checkout-shipping-form">
									<div class="box-inner">
										
										<div id="shipping-new" style="display: block">
											
											<div class="form-group input-lastname required" >
												<span>Full Name</span>
												<input type="text" value="{{( Auth::check() ? Auth::user()->name : '' )}}" name="shipping_name" value="" placeholder="Enter Full Name *" id="shipping_name" class="form-control">
											</div>
											<div class="form-group required" style="width: 49%; float: left;">
												<span>Email</span>
												<input type="text" value="{{(Auth::check() ? Auth::user()->email : '')}}" name="shipping_email" value="" placeholder="E-Mail" id="input-payment-email" class="form-control">
											</div>
											<div class="form-group required" style="width: 49%; float: right;">
												<span>Phone Number</span>
												<input type="text"  value="{{(Auth::check() ? Auth::user()->mobile : '')}}" name="shipping_phone" pattern="/(01)\d{9}/" placeholder="Phone Number *" id="shipping_phone" class="form-control">
											</div>
											<div class="form-group required">
											<span>Select Your Region</span>
											<select name="shipping_region" onchange="get_city(this.value, 'shipping')"  id="shipping_region" class="form-control select2">
												<option value=""> --- Please Select --- </option>
												@foreach($states as $state)
												<option value="{{$state->id}}"> {{$state->name}} </option>
												@endforeach
											</select>
											</div>
											<div class="form-group required">
												<span>City</span>
												<select name="shipping_city" onchange="get_area(this.value, 'shipping')"  id="show_cityshipping" class="form-control select2">
													<option value=""> Select first Region </option>
												</select>
											</div>
											<div class="form-group">
												<span>Area</span>
												<select name="shipping_area" id="show_areashipping" class="form-control select2">
													<option value=""> Select first city </option>
												</select>
											</div>
											
											<div class="form-group required">
												<span class="required">Address</span>
												<input type="text" value="{{old('ship_address')}}" name="ship_address" placeholder="Enter Address" id="input-payment-address" class="form-control">
											</div>
											
										</div>
									</div>
								</div>
								
							</fieldset>
						</div>
					</form>
					</div>

					<div class="col-right col-lg-6 col-md-6 col-sm-6 col-xs-12 sticky-content">
						<div class="checkout-content checkout-cart">
							<h2 class="secondary-title">Order Details</h2>
							<div class="box-inner">
								<div class="table-responsive checkout-product">

									<table  id="order_summary" class="table table-bordered table-hover">
										@include('frontend.checkout.order_summery')
									</table>
									<div class="confirm-order">
										<button type="submit" form="shipping_form" id="submitBtn" data-loading-text="Loading..." class="btn btn-success button confirm-button">Placed Order</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


    <!-- delete Modal -->
    <div id="delete" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="icon-box">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 class="modal-title">Are you sure remove product from cart.?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                    <button type="button" value="" id="deleteItemId" onclick="removeCartItem(this.value, 'checkout')" data-dismiss="modal" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
<script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

<script type="text/javascript">

	$(".select2").select2();

    function cartUpdate(id){
        document.getElementById('dataLoading').style.display = 'block';
        var qty = $('#qtyTotal'+id).val();
        if(parseInt(qty) && qty>0){
            $.ajax({
                url:"{{route('cart.update')}}",
                method:"get",
                data:{ id:id,qty:qty,page:'checkout'},
                success:function(data){
                    if(data.status == 'error'){
                        toastr.error(data.msg);
                    }else{
                        $('#order_summary').html(data);
                        toastr.success('Quantity Update Successful');
                    }
                    document.getElementById('dataLoading').style.display = 'none';
                },
                error: function(jqXHR, exception) {
                    toastr.error('Internal server error.');
                    document.getElementById('dataLoading').style.display = 'none';
                }
            });
        }else{
            toastr.error('Invalid Number.');
            document.getElementById('dataLoading').style.display = 'none';
        }
    }    

   $("#couponForm").submit(function(e) {
        e.preventDefault(); 
        var coupon_code = $('#coupon_code').val();
       
        document.getElementById('dataLoading').style.display = 'block';
        $.ajax({
            url:"{{route('coupon.apply')}}",
            method:"get",
            data:{ coupon_code:coupon_code},
            success:function(data){
                document.getElementById('dataLoading').style.display = 'none';
                if(data.status){
                	document.getElementById('couponSection').style.display = 'table-row';
                    $('#couponAmount').html(data.couponAmount);
                    $('#grandTotal').html(data.grandTotal);
                    toastr.success(data.msg);
                }else{
                    toastr.error(data.msg);
                }
            },
            error: function(jqXHR, exception) {
                toastr.error('Internal server error.');
                document.getElementById('dataLoading').style.display = 'none';
            }
        });
    });


	 //get cart item
	function cartDeleteConfirm(id) {
	    document.getElementById('deleteItemId').value = id;
	}

   // delete cart item
    function removeCartItem(id, page) {

        var link = "{{route('cart.itemRemove', ':id')}}"
        link = link.replace(':id', id);
      
        $.ajax({
            url:link,
            method:"get",
            data:{page:page},
            success:function(data){
                if(data){
                    $('#order_summary').html(data);
                    $('#carItem'+id).hide();
                    toastr.success('Cart item deleted.');
                }else{
                    toastr.error(data.msg);
                }
            }

        });
    }

    @if(old('region'))
    	get_city(old('region'));
    @endif

    function get_city(id, type=''){
       
        var  url = '{{route("checkout.get_city", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data.status){
                    $("#show_city"+type).html(data.allcity);
                    $("#shipping_cost").html(data.shipping_cost);
                    $('#couponAmount').html(data.couponAmount);
                   	$('#grandTotal').html(data.grandTotal);
                    $("#show_city"+type).focus();
                    $(".select2").select2();

                }else{
                    $("#show_city"+type).html('<option>City not found</option>');
                }
            }
        });
    }  	 

    @if(old('city'))
    	get_city(old('city'));
    @endif

    function get_area(id, type=''){
           
        var  url = '{{route("get_area", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#show_area"+type).html(data);
                    $("#show_area"+type).focus();
                    $(".select2").select2();

                }else{
                    $("#show_area"+type).html('<option value="">Area not found</option>');
                }
            }
        });
    }  

</script>

@if(!Auth::check())
<script type="text/javascript">

	$('#register').on('click', function(){
		$('#fullname_required').attr('required', 'required');
		$('#username_required').attr('required', 'required');
		$('#email_required').attr('required', 'required');
		$('#phone_required').attr('required', 'required');
		$('#userpassword').attr('required', 'required');
		$('#password2').attr('required', 'required');
	});
	$('#guest').on('click', function(){

		$('#email_required').removeAttr('required');
		$('#userpassword').removeAttr('required');
		$('#password2').removeAttr('required');
        $('#submitBtn').removeAttr('disabled');
        $('#submitBtn').removeAttr('style', 'cursor:not-allowed');
	});	

	$('#shipping_address').on('click', function(){
		if ($("#shipping_address").is(":checked")) {
			$('#shipping_name').removeAttr('required');
			$('#shipping_email').removeAttr('required');
			$('#shipping_phone').removeAttr('required');
			$('#shipping_region').removeAttr('required');
			$('#show_cityshipping').removeAttr('required');
			$('#show_areashipping').removeAttr('required');
			$('#ship_address').removeAttr('required');
		}else{
			
			$('#shipping_name').attr('required', 'required');
			$('#shipping_email').attr('required', 'required');
			$('#shipping_phone').attr('required', 'required');
			$('#shipping_region').attr('required', 'required');
			$('#show_cityshipping').attr('required', 'required');
			
			$('#ship_address').attr('required', 'required');
		}
	
	});
		
	function checkField(value, field, type=''){
        if ($("#register").is(":checked")) {
		  
	        if(value != ""){
	            $.ajax({
	                method:'get',
	                url:"{{ route('checkField') }}",
	                data:{table:'users', field:field, value:value, type:type},
	                success:function(data){
	                    
	                    if(data.status){
	                        $('#'+field).html("<span style='color:green'><i class='fa fa-check'></i> "+data.msg+"</span>");
	                        
	                        $('#submitBtn').removeAttr('disabled');
	                        $('#submitBtn').removeAttr('style', 'cursor:not-allowed');
	                        
	                    }else{
	                        $('#'+field).html("<span style='color:red'><i class='fa fa-times'></i> "+data.msg+"</span>");
	                        
	                        $('#submitBtn').attr('disabled', 'disabled');
	                        $('#submitBtn').attr('style', 'cursor:not-allowed');
	                        
	                    }
	                },
	                error: function(jqXHR, exception) {
	                    toastr.error('Unexpected error occur.');
	                }
	            });
	        }else{
	            $('#'+field).html("<span style='color:red'>"+field +" is required</span>");
	            
	            $('#submitBtn').attr('disabled', 'disabled');
	            $('#submitBtn').attr('style', 'cursor:not-allowed');
	            
	        }
	    }
    }
</script>
@endif
@endsection