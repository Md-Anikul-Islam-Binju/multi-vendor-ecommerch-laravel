
@extends('layouts.frontend')
@section('title', 'Shipping Review')
@section('css')
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{asset('frontend/css/themecss/so_onepagecheckout.css')}}" rel="stylesheet">
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
                    <form action="{{ route('reseller.orderConfirm', $resellerCustomer->id) }}" data-parsley-validate name="order_form" id="order_form" method="post" class="form-horizontal form-shipping">
                        @csrf
                         
                        <div class="checkout-content checkout-register">
                            <fieldset>
                                <h2 class="secondary-title">Shipping Address </h2>
                                <div class="checkout-shipping-form">
                                    <div class="box-inner">
                                      
                                        <div style="display: block; padding-left: 15px;">                                            
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
                                        @include('reseller.order_summery')
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
        const qty = $('#qtyTotal' + id).val();
        const customerPrice = $('#customerPrice' + id).val();

        if(parseInt(qty) && qty>0){
            $.ajax({
                url:"{{route('cart.update')}}",
                method:"get",
                data:{ id:id,qty:qty,customerPrice:customerPrice},
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

</script>

@endsection