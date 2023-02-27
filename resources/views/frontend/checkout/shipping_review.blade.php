@extends('layouts.frontend')
@section('title', 'Shipping Review')
@section('css')
   {{-- <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" /> --}}
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{asset('frontend')}}/css/themecss/so_onepagecheckout.css" rel="stylesheet">
    <style type="text/css">

        .shipping-address-list {margin: 0px 0 10px 0;
        border-bottom: 1px solid #e0e0e0;
        padding: 5px 0;}
        .shipping-address-list label{position: relative; width: inherit !important; float: inherit;margin-bottom: -1px !important;min-height: 30px !important;}
        .shipping-address-list input {display: none;}
        .shipping-address-list .active{background: #4267B2;color: #fff;}
        .shipping-address-list li{cursor: pointer; display: inline-block;padding: 8px 10px 0px !important;border: 1px solid #efefef; border-radius: 3px;min-width: 80px;}
        #shipping-new i{padding-right: 10px;font-size: 18px;
        color: #5a75f9;}
        .new-address{float: right; background: #40b13e;border-radius: 3px; padding: 2px 5px; font-size: 12px; line-height: 3; font-weight: 400; padding-right: 5px;  color: #fff; cursor: pointer; text-transform: capitalize;}
        .address_name{  position: absolute;  left: 0; top: -10px; white-space: nowrap;
        }
        .shipping_method{padding-left: 15px;}
    </style>
@endsection
@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <ul class="breadcrumb-cate">
                <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="#">Shipping Review</a></li>
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
                    <form action="{{ route('orderConfirm') }}" data-parsley-validate name="order_form" id="order_form" method="post" class="form-horizontal form-shipping">
                        @csrf
                         
                        <div class="checkout-content checkout-register">
                            <fieldset>
                                <h2 class="secondary-title">Shipping Address <span style="margin: -12px 0;" class="new-address" title="Add new shipping address" data-toggle="modal" data-target="#shippingModal"><i style="background: none;font-size: 14px;width: inherit;height: inherit;margin:0px;line-height: 0;" class="fa fa-plus"> </i> Add New Address</span></h2>
                                <div class="checkout-shipping-form">
                                    <div class="box-inner">
                                        @if(Auth::check())
                                            <ul class="shipping-address-list">
                                                <?php $i= 1;?>
                                               
                                                @foreach($get_shipping as $shipping)
                                                <li @if($i==1) class="active" @endif><label for="confirm_shipping_address{{$i}}">
                                                <input onclick="get_shipping_address(this.value)" type="radio" id="confirm_shipping_address{{$i}}" name="confirm_shipping_address" value="{{$shipping->id}}" @if($i==1) checked="checked" @endif> {{ ($shipping->address_name) ? $shipping->address_name : $shipping->name }} <br/><span class="address_name">  <i class="fa fa-map-marker"></i> Address {{$i}}</span></label>
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
                                                    <strong> <i class="fa fa-map-marker"></i> </strong>  
                                                    {!! $shipping->address !!},
                                                    @if($shipping->get_area) {{$shipping->get_area->name}}, @endif
                                                    @if($shipping->get_city) {{$shipping->get_city->name}}, @endif
                                                    @if($shipping->get_state) {{$shipping->get_state->name}} @endif
                                                </div>
                                                @php break; @endphp
                                                @endforeach
                                            </div>
                                            <strong><i class="fa fa-comment"></i> Add comments about your order</strong>
                                            <textarea style="width: 100%;margin: 0 0 20px;padding:5px;" name="order_notes" rows="2" class="form-control " placeholder="Enter your comments here."></textarea>
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
                                    <table id="order_summary" class="table table-bordered table-hover">
                                        @include('frontend.checkout.order_summery')
                                    </table>
                                    <div style=" display: flex!important;" class="d-flex no-block align-items-center">
                                        <div class="custom-control custom-checkbox">
                                            
                                            <label class="custom-control-label" for="agree"><input form="order_form" type="checkbox" data-parsley-required-message="Terms &amp; Conditions  is required" class="custom-control-input" id="agree" required data-parsley-multiple="agree">  I've read and understood <a target="_blank" href="{{url('terms')}}" style="color: blue">Terms &amp; Conditions </a></label>
                                            <p style="color: red;padding: 0;margin: 0" id="errormsg"></p>
                                        </div>
                                    </div>
                                    <div class="confirm-order" style="margin-top: 0;margin-bottom: 10px;">
                                        <button type="submit" disabled form="order_form" id="submitBtn" style="width: 100%" data-loading-text="Loading..." class="btn btn-success button confirm-button">Process To Pay</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@if(!Auth::check()) 
    <!-- login Modal -->
    @include('users.modal.login')
@endif
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
                <button type="button" value="" id="deleteItemId" onclick="deleteCartItem(this.value, 'checkout')" data-dismiss="modal" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- shipping address Modal -->
<div class="modal fade in" id="shippingModal">
    <div class="modal-dialog block-popup-login">
        <a href="javascript:void(0)" title="Close" class="close close-login fa fa-times-circle" data-dismiss="modal"></a>
        <div style="font-size: 15px;">Add New Shipping Address</div>
             <div class=" col-reg registered-account">
                <div class="block-content">
                    <form class="form form-login" data-parsley-validate action="{{route('shippingRegister')}}" method="post" id="login-form">
                        @csrf
                       <fieldset id="shipping-address">
                            <div class=" checkout-shipping-form">
                                <div class="box-inner">
                                    
                                    <div id="shipping-new" style="display: block; text-align: left;">
                                        
                                        <div class="form-group input-lastname " >
                                            <span class="required">Address Name</span>
                                            <input type="text" required value="{{old('address_name')}}" name="address_name" placeholder="Example: Home, Office" id="input-payment-lastname" class="form-control">
                                        </div>

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

@endsection

@section('js')
{{-- <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">

    $(".select2").select2();
    $('#agree').on("click", function(){
          if ($('#agree').is(':checked')) { $('#submitBtn').prop('disabled', false); }else{
            $('#submitBtn').prop('disabled', true);
          }
    })
    $(document).ready(function() {
        $('#order_form').submit(function(e) {
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
    function deleteCartItem(id, page) {

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


    function get_city(id){
           
        var  url = '{{route("get_city", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#show_city").html(data);
                  
                    $("#show_city").focus();
                    $(".select2").select2();
                }else{
                    $("#show_city").html('<option>City not found</option>');
                }
            }
        });
    }    

    function get_area(id){
           
        var  url = '{{route("get_area", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#show_area").html(data);
                    $("#show_area").focus();
                    $(".select2").select2();
                }else{
                    $("#show_area").html('<option>Area not found</option>');
                }
            }
        });
    }  

</script>


<script type="text/javascript">

    $('.shipping-address-list li').click(function() {
        $(this).addClass('active').siblings().removeClass('active');
    });

    @if($get_shipping)
        get_shipping_address({{$get_shipping[0]->id}});
    @endif

    function get_shipping_address(id){
        $("#get_shipping_address").html("<div style='height:135px' class='loadingData-sm'></div>");
        var  url = '{{route("getShippingAddress", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data.status){
                    $("#get_shipping_address").html(data.shipping_address);
                    $("#shipping_cost").html(data.shipping_cost);
                    $('#couponAmount').html(data.couponAmount);
                    $('#grandTotal').html(data.grandTotal);
                }
            }
        });
    }  

</script>

@endsection