@extends('layouts.frontend')
@section('title', 'Order History | '. Config::get('siteSetting.site_name') )
@section('css')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
   <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <style type="text/css">
            .icon-box i{font-size: 4rem}
    .ml-auto, .mx-auto {
        margin-left: auto!important;
    }
    #content .card{border-radius: 5px; }
    .user-box{padding: 15px;    margin-bottom: 10px;}
    .card-title, .icon-box{color: #fff}
    .user-box a{    font-size: 3rem !important; color: #fff}
    #user-dashboard{padding-top: 15px;}
    #user-dashboard section{background: #fff;margin-bottom: 10px;padding: 10px 0;}
    </style>
@endsection
@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <ul class="breadcrumb-cate">
              <li><a href="{{url('/')}}"><i class="fa fa-home"></i> </a></li>
              <li><a href="#">Shipping address</a></li>
            </ul>
        </div>
    </div>
    <!-- Main Container  -->
    <div class="container">
        <div class="row">
            @include('users.inc.sidebar')
            <!--Middle Part Start-->
            <div id="content" class="col-md-9 sticky-content">
                
                @if(Session::has('success'))
                <div class="alert alert-success">
                  <strong>Success! </strong> {{Session::get('success')}}
                </div>
                @endif
                @if(Session::has('error'))
                <div class="alert alert-danger">
                  <strong>Error! </strong> {{Session::get('error')}}
                </div>
                @endif
                
                 <button style="float: right;margin-bottom: 5px;" class="btn btn-primary" title="Add new shipping address" data-toggle="modal" data-target="#shippingModal"><i  class="fa fa-plus"> </i> Add New Address</button>
                <br/>
                <div class="table-responsive" >
                    <table style="width: 100%" id="config-table" class="table display table-bordered table-striped no-wrap">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td class="text-left">Name</td>
                                <td class="text-left">Mobile</td>
                                <td class="text-left">Email</td>
                                <td class="text-left" style="min-width:100px;">Address</td>
                                <td class="text-left">Area</td>
                                <td class="text-center">City</td>
                                <td class="text-center">State</td>
                                <td class="text-center">Address_Name</td>
                                <td class="text-right">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shipping_addresses as $index => $shipping)
                            <tr id="item{{$shipping->id}}">
                                <td class="text-left"> {{$index+1}}</td>
                                <td class="text-left"> {{$shipping->name}}</td>
                                <td class="text-left"> {{$shipping->phone}}</td>
                                <td class="text-left"> {{$shipping->email}}</td>
                                <td class="text-left"> {!! $shipping->address !!}</td>
                                <td class="text-left"> @if($shipping->get_area) {{$shipping->get_area->name}} @endif</td>
                                <td class="text-left"> @if($shipping->get_city) {{$shipping->get_city->name}} @endif</td>
                                <td class="text-left">@if($shipping->get_state) {{$shipping->get_state->name}} @endif </td>
                                <td><span class="label label-warning">{{$shipping->address_name}}</span></td>
                                <td class="text-center">
                                    <a  href="javascript:void(0)" class="btn btn-info  btn-xs" type="button" onclick="edit('{{$shipping->id}}')"  data-toggle="modal" data-target="#edit" > <i class="fa fa-edit"></i> Edit</a><a  href="javascript:void(0)" class="btn btn-danger btn-xs" style="background:red;margin-top: 3px;" title="delete" onclick="deleteConfirmPopup('{{route("shippingAddress.delete", $shipping->id)}}')"><i class="fa fa-trash"></i> Delete</a>
                                    
                                </td>
                            </tr>
                            
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <!--Middle Part End-->  
        </div>
    </div>
    <!-- //Main Container -->
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
                                                <input type="text" value="{{old('shipping_email')}}" name="shipping_email"placeholder="E-Mail *" id="input-payment-email" class="form-control">
                                            </div>
                                            <div class="form-group" style="width: 49%; float: right;">
                                                <span class="required">Phone Number</span>
                                                <input type="text"  required value="{{old('shipping_phone')}}" name="shipping_phone" placeholder="Phone Number *" id="input-payment-telephone" class="form-control">
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
                                                <span class="required" >Area</span>
                                                <select name="shipping_area" required id="show_area" class="form-control select2">
                                                    <option value=""> Select first city </option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group ">
                                                <span class="required">Address</span>
                                                <input type="text" value="{{old('ship_address')}}" required name="ship_address" placeholder="Enter Address" id="input-payment-address" class="form-control">
                                            </div>
                                            <div class="actions-toolbar">
                                                <div class="primary">
                                                    <button type="button" data-dismiss="modal" class="btn btn-primary" name="send" id="send2"><span>Cancel</span></button>

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

        <!-- update Modal -->
        <div class="modal fade" id="edit" style="display: none;">
            <div class="modal-dialog">
                <form action="{{route('shippingAddress.update')}}" method="post">
                {{ csrf_field() }}
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Shipping address upadate</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row" id="edit_form"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-success">Update</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    <!-- delete Modal -->
    @include('modal.delete-modal')
@endsection     
@section('js')
    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <script>
    // responsive table
        $('#config-table').DataTable({
            responsive: true,
            ordering: false
        });
    </script>
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

    <script type="text/javascript">

    $(".select2").select2();
    </script>
    <script type="text/javascript">
        function get_city(id, type=''){
           
        var  url = '{{route("get_city", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#show_city"+type).html(data);
                  
                    $("#show_city"+type).focus();
                    $("#show_area"+type).html('<option>Select Area</option>');
                    $(".select2").select2();
                }else{
                    $("#show_city"+type).html('<option>City not found</option>');
                    $("#show_area"+type).html('<option>Select Area</option>');
                }
            }
        });
    }    

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
                    $("#show_area"+type).html('<option>Area not found</option>');
                }
            }
        });
    }  


   
    function edit(id){
        $('#edit_form').html('<div class="loadingData"></div>');
        var  url = '{{route("shippingAddress.edit", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#edit_form").html(data);
                    $(".select2").select2();
                }
            },
            // $ID Error display id name
            @include('common.ajaxError', ['ID' => 'edit_form'])

        });
    } 

    function deleteConfirmPopup(route, item='') {
            $('#deleteModal').modal('show');
            document.getElementById('deleteItemRoute').value = route;
            //hide delete item
            document.getElementById('item').value = item;
        }

        function deleteItem(route) {
           
            //separate id from route
            var id = route.split("/").pop();
            
            $.ajax({
                url:route,
                method:"get",
                success:function(data){
                    if(data.status){
                        $("#item"+id).hide();
                        toastr.success(data.msg);
                    }else{
                        toastr.error(data.msg);
                    }
                }
            });
        }
    </script>
@endsection     


