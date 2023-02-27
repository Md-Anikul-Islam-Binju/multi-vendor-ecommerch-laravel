@extends('layouts.frontend')
@section('title', 'Cart Item')
@section('css')
    <style type="text/css">
        .attributes small:not(:last-child):after {
            color: #c7c7c7;
            content: " | ";
            height: 5px;
            width: 5px; 
        }
    </style>
@endsection
@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <ul class="breadcrumb-cate">
                <li><a href="index.html"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="#">Cart</a></li>
            </ul>
        </div>
    </div>
    <div class="container" >
        <div id="dataLoading"></div>
        @if(Session::has('status'))
            <div class="alert alert-success">
              <strong>Success! </strong> {{Session::get('status')}}
            </div>
            @endif
            @if(Session::has('error'))
            <div style="margin-top:5px; margin-bottom: 0;" class="alert alert-danger">
              {{Session::get('error')}}
            </div>
        @endif
        
        <div class="row" id="cart_summary">
            @include('frontend.carts.cart_summary') 
        </div>
    </div>          
    @include('frontend.modal.cartItemRemove')
@endsection

@section('js')

<script type="text/javascript">


    function cartUpdate(id){
        document.getElementById('dataLoading').style.display = 'block';
        var qty = $('#qtyTotal'+id).val();
        if(parseInt(qty) && qty>0){
            $.ajax({
                url:"{{route('cart.update')}}",
                method:"get",
                data:{ id:id,qty:qty,page:'cart_summary' },
                success:function(data){
                    if(data.status == 'error'){
                        toastr.error(data.msg);
                    }else{
                        $('#cart_summary').html(data);
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
            data:{ coupon_code:coupon_code },
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
</script>

@endsection