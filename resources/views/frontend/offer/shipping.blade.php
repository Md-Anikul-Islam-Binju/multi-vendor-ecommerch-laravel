@extends('layouts.frontend')
@section('title', 'Shipping Address')
@section('css')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />

 	<link href="{{asset('frontend')}}/css/themecss/so_onepagecheckout.css" rel="stylesheet">

    <style type="text/css">

    	#submitBtn{width: 100%}
       .shipping-address-list {margin: 0px 0 10px 0;
        border-bottom: 1px solid #e0e0e0;
        padding: 5px 0;}
        .shipping-address-list label{position: relative; width: inherit !important; float: inherit;margin-bottom: -1px !important;min-height: 30px !important;}
        .shipping-address-list input {display: none;}
        .shipping-address-list .active{background: #4267B2;color: #fff;}
        .shipping-address-list li{cursor: pointer; display: inline-block;padding: 8px 10px 0px !important;border: 1px solid #efefef; border-radius: 3px;min-width: 80px;}
        #shipping-new i{padding-right: 10px;font-size: 18px;
        color: #5a75f9;}
        .new-address{float: right; background: #4267b2;border-radius: 3px; padding: 2px 5px; font-size: 12px; line-height: 3; font-weight: 400; padding-right: 5px;  color: #fff; cursor: pointer; text-transform: capitalize;}
        .address_name{  position: absolute;  left: 0; top: -10px; white-space: nowrap;
        }
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
				@php $shipping_cost = 0; @endphp
				<div class="so-onepagecheckout layout1 row">
					<div class="col-left col-lg-6 col-md-6 col-sm-6 col-xs-12 sticky-content">

						@if(count($get_shipping)>0)

						@php 
							$shipping_cost = $offer->shipping_cost;
							if(count($get_shipping)>0){
								if($offer->shipping_method == 'location'){
					                if ($offer->ship_region_id != $get_shipping[0]->region) {
					                    $shipping_cost = $offer->other_region_cost;
					                }
					            }
					        }
				           
						@endphp
						<form action="{{ route('offer.processToPay') }}" data-parsley-validate name="shipping_form" id="shipping_form" method="post" class="form-horizontal form-shipping">
                       	 	@csrf
                        
	                        <div class="checkout-content checkout-register">
	                            <fieldset>
	                                <h2 class="secondary-title"><i class="fa fa-truck fa-2x"></i>Shipping Address <span class="new-address" title="Add new shipping address" data-toggle="modal" data-target="#shippingModal"><i style="background: none;font-size: 14px;width: inherit;height: inherit;margin:0px;line-height: 0;" class="fa fa-plus"> </i> Add New Address</span></h2>
	                                <div class="checkout-shipping-form">
	                                    <div class="box-inner">
	                                        @if(Auth::check())
	                                            <ul class="shipping-address-list">
	                                                <?php $i= 1;?>
	                                                @foreach($get_shipping as $shipping)
	                                                <li @if($i==1) class="active" @endif><label for="confirm_shipping_address{{$i}}">
	                                                <input onclick="get_shipping_address(this.value)" type="radio" id="confirm_shipping_address{{$i}}" name="confirm_shipping_address" value="{{$shipping->id}}" @if($i==1) checked="checked" @endif> {{$shipping->name}} <br/><span class="address_name">  <i class="fa fa-map-marker"></i> Address {{$i}}</span></label>
	                                                </li>
	                                                <?php $i++;?>
	                                                @endforeach
	                                            </ul>
	                                        @endif
	                                        <div style="display: block; padding-left: 15px;">
	                                            <div id="get_shipping_address">
	                                                @foreach($get_shipping as $shipping)
	                                                <div class="form-group" >
	                                                    <strong><i class="fa fa-user"></i></strong> {{$shipping->name}}
	                                                </div>

	                                                <div class="form-group" >
	                                                    <strong><i class="fa fa-envelope"></i></strong> {{$shipping->email}}
	                                                </div>
	                                                <div class="form-group" >
	                                                    <strong><i class="fa fa-phone"></i></strong> {{$shipping->phone}}
	                                                </div>
	                                                <div class="form-group" >
	                                                    <strong><i class="fa fa-map-marker"></i> </strong>  
	                                                    {!! $shipping->address !!},
	                                                    @if($shipping->get_area) {{$shipping->get_area->name}}, @endif
	                                                    @if($shipping->get_city) {{$shipping->get_city->name}}, @endif
	                                                    @if($shipping->get_state) {{$shipping->get_state->name}} @endif
	                                                </div>
	                                                @php break; @endphp
	                                                @endforeach
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </fieldset>
	                        </div>
	                    </form>
						@else
						<form action="{{ route('offer.shippingAddressInsert') }}" name="shipping_form" id="shipping_form" data-parsley-validate method="post" class="form-horizontal form-shipping">
							@csrf
							<input type="hidden" name="processBuy" value="processBuy">
							<div class="checkout-content checkout-register">
								<fieldset id="shipping-address" @if(!Auth::check()) style="display: none" @endif>
									<h2 class="secondary-title"><i class="fa fa-truck fa-2x"></i>Shipping Address</h2>
									<p style="color: #fb0124; padding: 0px 15px; margin: 0;">আপনার প্রোডাক্ট হোম ডেলিভারি নেওয়ার জন্য একটি  এড্রেস দিন । </p>
									<div class=" checkout-shipping-form">
										<div class="box-inner">
											<div id="shipping-new" style="display: block">
												
												<div class="form-group input-lastname required" >
													<span class="required">Name</span>
													<input type="text" value="{{( Auth::check() ? Auth::user()->name : '' )}}" name="shipping_name" required placeholder="Enter Your Name *" id="shipping_name" class="form-control">
												</div>
												
												<div class="form-group required" style="width: 49%; float: left;">
													<span class="required">Phone Number</span>
													<input required type="text" value="{{(Auth::check() ? Auth::user()->mobile : '')}}" pattern="/(01)\d{9}/" name="shipping_phone" placeholder="Phone Number *" id="shipping_phone" class="form-control">
												</div>
												<div class="form-group required" style="width: 49%; float: right;">
													<span>Email (Optional)</span>
													<input type="text" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}" value="{{(Auth::check() ? Auth::user()->email : '')}}" name="shipping_email" placeholder="E-Mail" id="input-payment-email" class="form-control">
												</div>
												<div class="form-group required">
												<span class="required">Select Your Region</span>
												<select required name="shipping_region" onchange="get_city(this.value, 'shipping')"  id="shipping_region" class="form-control select2">
													<option value=""> --- Please Select --- </option>
													@foreach($states as $state)
													<option value="{{$state->id}}"> {{$state->name}} </option>
													@endforeach
												</select>
												</div>
												<div class="form-group required">
													<span class="required">City</span>
													<select required name="shipping_city" required onchange="get_area(this.value, 'shipping')" id="show_cityshipping" class="form-control select2">
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
													<input required type="text" value="{{old('ship_address')}}" name="ship_address" placeholder="Enter Address" id="input-payment-address" class="form-control">
												</div>
												
											</div>
										</div>
									</div>
									
								</fieldset>
							</div>
						</form>
						@endif
					</div>

					<div class="col-right col-lg-6 col-md-6 col-sm-6 col-xs-12 sticky-content">
						<div class="checkout-content checkout-cart">
							<h2 class="secondary-title"><i class="fa fa-shopping-cart"></i>Offer Details</h2>
							<div class="box-inner">
								<div class="table-responsive checkout-product" style="margin: 0">
									<table  id="order_summary" class="table table-bordered table-hover">
										@include('frontend.offer.order_summery')
									</table>
									<div style=" display: flex!important;" class="d-flex no-block align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            
                                            <label class="custom-control-label" for="agree"><input form="shipping_form" type="checkbox" data-parsley-required-message="Terms &amp; Conditions  is required" class="custom-control-input" id="agree" required data-parsley-multiple="agree">  I've read and understood <a data-toggle="modal" data-target="#termsCondition" href="javascript:void(0)" style="color: blue">Offer Terms &amp; Conditions </a></label>
                                            <p style="color: red;padding: 0;margin: 0" id="errormsg"></p>
                                        </div>
                                    </div>
									<div class="confirm-order" style="margin-top: 0;margin-bottom: 10px">
										<button type="submit" disabled form="shipping_form" id="submitBtn" data-loading-text="Loading..." class="btn btn-success button confirm-button">Process To Payment</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- shipping address Modal -->
	<div id="shippingModal" class="modal fade" role="dialog" style="display: none;">

    <div id="so_sociallogin" class="modal-dialog block-popup-login">
        <a href="javascript:void(0)" title="Close" class="close close-login fa fa-times-circle" data-dismiss="modal"></a>
        <div class="tt_popup_login"><strong>Add New Shipping Address</strong></div>
      
             <div class=" col-reg registered-account">
                <div class="block-content">
                    <form class="form form-login" data-parsley-validate action="{{route('offer.shippingAddressInsert')}}" method="post" id="login-form">
                        @csrf
                       <fieldset id="shipping-address">
                            <div class=" checkout-shipping-form">
                                <div class="box-inner">
                                    
                                    <div id="shipping-new" style="display: block; text-align: left;">
                                        
                                        <div class="form-group input-lastname " >
                                            <span class="required">Full Name</span>
                                            <input type="text" required value="{{old('shipping_name')}}" name="shipping_name" placeholder="Enter Full Name *" id="input-payment-lastname" class="form-control">
                                        </div>
                                        <div class="form-group " style="width: 49%; float: left;">
                                            <span class="required">Email</span>
                                            <input type="text" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}" value="{{old('shipping_email')}}" name="shipping_email"placeholder="E-Mail *" id="input-payment-email" class="form-control">
                                        </div>
                                        <div class="form-group" style="width: 49%; float: right;">
                                            <span class="required">Phone Number</span>
                                            <input type="text" pattern="/(01)\d{9}/" required value="{{old('shipping_phone')}}" name="shipping_phone" placeholder="Phone Number *" id="input-payment-telephone" class="form-control">
                                        </div>
                                        <div class="form-group" style="width: 49%; float: left;">
                                        <span class="required">Select Your Region</span>
                                        <select name="shipping_region" onchange="get_city(this.value)" required id="input-payment-country" class="form-control ">
                                            <option value=""> --- Please Select --- </option>
                                            @foreach($states as $state)
                                            <option value="{{$state->id}}"> {{$state->name}} </option>
                                            @endforeach
                                        </select>
                                        </div>
                                        <div class="form-group " style="width: 49%; float: right;">
                                            <span class="required">City</span>
                                            <select name="shipping_city"  onchange="get_area(this.value)"  required id="show_city" class="form-control select2">
                                                <option value=""> Select first region </option>
                                                
                                            </select>
                                        </div>
                                        <div class="form-group ">
                                            <span >Area</span>
                                            <select name="shipping_area" id="show_area" class="form-control select2">
                                                <option value=""> Select first city </option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group ">
                                            <span class="required">Address</span>
                                            <input type="text" value="{{old('ship_address')}}" required name="ship_address" placeholder="Enter Address" id="input-payment-address" class="form-control">
                                        </div>
                                        <div class="actions-toolbar">
                                            <div class="primary">
                                                <button type="submit" class="btn btn-success" name="send" id="send2"><span>Save Now</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            <div style="clear:both;"></div>
        </div>
    </div>
	</div>

	<div id="termsCondition" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">"কানামাছি" অফার - এর শর্তাবলী</h4>
	      </div>
	      <div class="modal-body">
	        {!! $offer->notes !!}
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>

@endsection

@section('js')
<script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

<script type="text/javascript">
	//check required fieled is filled or not
    $('#agree').on("click", function(){
      if ($('#agree').is(':checked')) { $('#submitBtn').prop('disabled', false); }else{
        $('#submitBtn').prop('disabled', true);
      }
    })
	$(".select2").select2();
	$(document).ready(function() {
	    $('#shipping_form').submit(function(e) {
	        if ($('#agree').is(':checked')) {
                $('#errormsg').html('');
                document.getElementById('dataLoading').style.display = 'block';
            } else {
                $('#errormsg').html('Terms &amp; Conditions  is required');
               e.preventDefault();
               return false;
            }
	    });
	});
    
    @if(old('region'))
    	get_city(old('region'));
    @endif

    function get_city(id, type=''){
        var offer_id = '{{ $offer->id }}';
        var  url = '{{route("offer.getCity", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            data:{offer_id:offer_id},
            success:function(data){
                if(data.status){
                    $("#show_city"+type).html(data.allcity);
                    $("#shipping_cost").html(data.shipping_cost);
                  
                    $('#grandTotal').html(data.grandTotal);
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
<script type="text/javascript">

    $('.shipping-address-list li').click(function() {
        $(this).addClass('active').siblings().removeClass('active');
    });

    function get_shipping_address(id){
        $("#get_shipping_address").html("<div style='height:135px' class='loadingData-sm'></div>");
        var  url = '{{route("offer.getShippingAddress", ":id")}}';
        var offer_id = '{{ $offer->id }}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            data:{offer_id:offer_id},
            success:function(data){
                if(data.status){
                    $("#get_shipping_address").html(data.shipping_addess);
                    $("#shipping_cost").html(data.shipping_cost);
                    $('#grandTotal').html(data.grandTotal);
                }
            }
        });
    }  

</script>
@endsection