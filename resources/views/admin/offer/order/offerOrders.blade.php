@extends('layouts.admin-master')
@section('title', 'Order lists')
@section('css-top')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/stylish-tooltip.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <link href="{{asset('assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
    <style type="text/css">
    <style type="text/css">
        .payment-method, .customer{
            max-width: 150px !important; font-size: 12px;text-align: center;
        }
        .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn){max-width: 100px;}
        #orderListArea{max-height: 350px; overflow-y: auto;}
        hr{padding: 3px;margin: 5px;}
        .order_details{padding:5px;}
        .table td, .table th{padding: 5px 8px;}
            .bootstrap-tagsinput{
            width: 100% !important;
            padding: 5px;
        }
    </style>

    <!-- page CSS -->
    <link href="{{asset('assets')}}/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    
@endsection
@section('content')
            <?php 
                $all = $pending = $offerPendingOrder = $accepted = $readyToship = $on_delivery = $delivered = $cancel = 0;
                foreach($orderCount as $order_status){
      
                    if($order_status->order_status == 'pending'){ $pending +=1 ; }
                    if($order_status->order_status == 'accepted'){ $accepted +=1 ; }
                    if($order_status->order_status == 'ready-to-ship'){ $readyToship +=1 ; }
                    if($order_status->order_status == 'on-delivery'){ $on_delivery +=1 ; }
                    if($order_status->order_status == 'delivered'){ $delivered +=1 ; }
                    if($order_status->order_status == 'cancel'){ $cancel +=1 ; }
                }
                $all = $pending+$offerPendingOrder+$accepted+ $readyToship +$on_delivery+ $delivered +$cancel;

            ?>
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Total Order ({{ $all }})</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            
                            <a class="btn btn-info btn-sm d-none d-lg-block m-l-15" href="{{ route('admin.offerOrder', $offer->slug) }}"><i class="fa fa-eye"></i> Order lists</a>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
               
                
                <div class="row">
                    <!-- Column -->
                    
                    <!-- Column -->
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pending Order</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-primary"><i class="fa fa-shipping-fast"></i></span>
                                <a href="{{route('admin.offerOrder', [$offer->slug, 'pending'])}}" class="link display-5 ml-auto">{{$pending}}</a>
                                
                            </div>
                        </div>
                    </div>
                    </div>
                    
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Accept Order</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-primary"><i class="fa fa-shipping-fast"></i></span>
                                <a href="{{route('admin.offerOrder', [$offer->slug, 'accepted'])}}" class="link display-5 ml-auto">{{$accepted}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ready To Ship</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-primary"><i class="fa fa-list-ol"></i></span>
                                <a href="{{route('admin.offerOrder', [$offer->slug, 'ready-to-ship'])}}" class="link display-5 ml-auto">{{$readyToship}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">On Delivery</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-info"><i class="fa fa-shipping-fast"></i></span>
                                <a href="{{route('admin.offerOrder', [$offer->slug, 'on-delivery'])}}" class="link display-5 ml-auto">{{$on_delivery}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Cancel</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-danger"><i class="fa fa-times"></i></span>
                                <a href="{{route('admin.offerOrder', [$offer->slug, 'cancel'])}}" class="link display-5 ml-auto">{{$cancel}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Complete</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-success"><i class="fa fa-handshake"></i></span>
                                <a href="{{route('admin.offerOrder', [$offer->slug, 'delivered'])}}" class="link display-5 ml-auto">{{$delivered}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" style="margin-bottom: 2px;">

                            <form action="{{route('admin.offerOrder', $offer->slug)}}" method="get">

                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Order Id</label>
                                                    <input name="order_id" value="{{ Request::get('order_id')}}" type="text" placeholder="W-1269345456" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Customer</label>
                                                    <input name="customer" value="{{ Request::get('customer')}}" type="text" placeholder="name or mobile or email" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Order Status  </label>
                                                    <select name="status" class="form-control">
                                                        <option value="">Select Status</option>
                                                        <option value="pending" {{ (Request::get('status') == 'pending') ? 'selected' : ''}} >Pending</option>
                                                        <option value="accepted" {{ (Request::get('status') == 'accepted') ? 'selected' : ''}}>Accepted</option>
                                                        <option value="ready-to-ship" {{ (Request::get('status') == 'ready-to-ship') ? 'selected' : ''}}>Ready to ship</option>
                                                        <option value="on-delivery" {{ (Request::get('status') == 'on-delivery') ? 'selected' : ''}}>On Delivery</option>
                                                        <option value="delivered" {{ (Request::get('status') == 'delivered') ? 'selected' : ''}}>Delivered</option>
                                                        <option value="cancel" {{ (Request::get('status') == 'cancel') ? 'selected' : ''}}>Cancel</option>
                                                        <option value="all" {{ (Request::get('status') == "all") ? 'selected' : ''}}>All</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">From Date</label>
                                                    <input name="from_date" value="{{ Request::get('from_date')}}" type="date" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">End Date</label>
                                                    <input name="end_date" value="{{ Request::get('end_date')}}" type="date" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="control-label">.</label>
                                                   <button type="submit" class="form-control btn btn-success"><i style="color:#fff; font-size: 20px;" class="ti-search"></i> </button>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-12">
                        <div class="card">
                            
                            <h3>
                                @if(Route::current()->getName() == 'order.search')
                                    Total Record: ({{count($offerOrders)}})
                                @endif
                            </h3>
                            <div class="table-responsive">
                               <table  class="table display table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Customer</th>
                                            <th>Order ID</th>
                                            <th>Order Date</th>
                                            <th>Qty</th>
                                            <th>Total_Order</th>
                                            <th>Shipping cost</th>
                                            <th>Status</th>
                                            <th>Invoice</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($offerOrders)>0)
                                            @foreach($offerOrders as $order)
                                            <tr id="{{$order->order_id}}">
                                                <td>{{ $order->billing_name }}
                                                <p style="font-size: 12px;margin: 0;padding: 0">{{ $order->billing_phone }}</p></td>
                                                <td>{{$order->order_id}}</td>
                                               <td>{{\Carbon\Carbon::parse($order->order_date)->format(Config::get('siteSetting.date_format'))}}
                                                <p style="font-size: 12px;margin: 0;padding: 0">{{\Carbon\Carbon::parse($order->order_date)->diffForHumans()}}</p>
                                               </td>
                                               
                                                <td>{{$order->all_qty}}</td>
                                                <td>{{$order->total_order }}</td>

                                                <td>@if($order->shipping_cost != null) <span class="label label-success">paid</span> @else <span class="label label-danger">pending </span>@endif </td>
                                                
                                            <td> 
                                                    <span class="mytooltip tooltip-effect-2">
                                                        @if($order->order_status == 'delivered')
                                                        <span class="label label-success"> {{ str_replace('-', ' ', $order->order_status)}} </span>

                                                        @elseif($order->order_status == 'accepted')
                                                        <span class="label label-warning"> {{ str_replace('-', ' ', $order->order_status)}} </span>

                                                        @elseif($order->order_status == 'ready-to-ship')
                                                        <span class="label label-ready-ship"> {{ str_replace('-', ' ', $order->order_status)}} </span>
                                                        @elseif($order->order_status == 'return')
                                                        <span class="label label-return"> {{ str_replace('-', ' ', $order->order_status)}} </span>

                                                        @elseif($order->order_status == 'cancel')
                                                        <a href="javascript:void()" class="mytooltip">
                                                            <span class="label label-danger"> {{ str_replace('-', ' ', $order->order_status)}} 
                                                            </span>
                                                            @if(count($order->orderCancelReason)>0)
                                                                <br/>Reason  
                                                                @foreach($order->orderCancelReason as $reason)
                                                                <span class="tooltip-content3">{{$reason->reason}} {{$reason->reason_details}}</span>
                                                                @endforeach
                                                            
                                                            @endif
                                                        </a>
                                                        @elseif($order->order_status == 'on-delivery')
                                                        <span class="label label-primary"> {{ str_replace('-', ' ', $order->order_status)}} </span>

                                                        @else
                                                        <span class="label label-info"> Pending </span>
                                                        @endif
                                                        @php $updateStatus = $order->orderNotify->where('type', '=', 'orderStatus'); @endphp
                                                        @if(count($updateStatus)>0)
                                                        <span class="tooltip-content clearfix">
                                                            <span class="tooltip-text">
                                                                @foreach($updateStatus as $notifyNo => $statusNotify)
                                                                    @if($statusNotify->notify)
                                                                    <p style="font-size: 10px;padding: 0;margin: 0">{{$notifyNo+1}}. By {{($statusNotify->staff) ? $statusNotify->staff->name : 'Customer' }} => {{ucwords($statusNotify->notify)}} <br/><i class="fa fa-clock">  {{\Carbon\Carbon::parse($statusNotify->created_at)->format(Config::get('siteSetting.date_format') .' | '.' h:i A')}}</i></p>
                                                                    @endif
                                                                @endforeach
                                                            </span> 
                                                        </span>
                                                        @endif
                                                    </span>
                                                </td>
                                            <td><a target="_blank" class="dropdown-item" href="{{route('admin.offerOrderInvoice', [$offer->slug, $order->username])}}" class="text-inverse" title="View Order Invoice" data-toggle="tooltip"><i class="ti-printer"></i> Invoice</a>
                                            </td>
                                            
                                            <td><a href="javascript:void(0)" class="dropdown-item" onclick="order_details('{{ route("admin.getOfferOrderDetails", [Request::route('offer_slug'), $order->username])}}', '{{$order->order_id}}')" title=" View order details" data-toggle="tooltip" class="text-inverse p-r-10" ><i class="ti-eye"></i> Details</a></td>

                                            </tr>
                                           @endforeach
                                        @else <tr><td colspan="8"> <h1>No orders found.</h1></td></tr> @endif
                                    </tbody>
                                </table>
                            </div>
                        
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                 <div class="row">
                   <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                       {{$offerOrders->appends(request()->query())->links()}}
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing {{ $offerOrders->firstItem() }} to {{ $offerOrders->lastItem() }} of total {{$offerOrders->total()}} entries ({{$offerOrders->lastPage()}} Pages)</div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
       
        <div class="modal fade" id="getOrderDetails" style="display: none;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header" style="padding: 5px 15px;">
                        <h4 class="modal-title" id="myLargeModalLabel">Order Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body" id="order_details"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- ordr cancel Modal -->
        <div id="orderCancel" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="icon-box">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <h4 class="modal-title">Are you sure?</h4>
                        <p>Do you really want to cancel order?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                        <button type="button" value="" id="orderCancelRoute" onclick="orderCancel(this.value)" data-dismiss="modal" class="btn btn-danger">Order Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('js')

    <script type="text/javascript">
        function order_details(url, order_id){
            $('#order_details').html('<div class="loadingData"></div>');
            $('#getOrderDetails').modal('show');
          
            $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){

                    $("#order_details").html(data);
                    $("#tagsinput").tagsinput();
                    $('.selectpicker').selectpicker();
                    $('#'+order_id).css("background-color", "rgb(0 255 231 / 14%)");

                }
            }
        });
    }

    // when invoic btn click order details modal hide 
    function orderModalhide(){
        $('#getOrderDetails').modal('hide');
    }

    //on click select all products
    $('#checkAllOrder').on('click', function() {
    
        if (this.checked == true){
            $('#order_details').find('.order_id').prop('checked', true);
        }
        else{
            $('#order_details').find('.order_id').prop('checked', false);
        }
    });

    function changeShippingMethod(shipping_method_id, order_id) {

        var link = '{{route("admin.shippingMethod")}}';
       
        $.ajax({
            url:link,
            method:"get",
            data:{'shipping_method_id': shipping_method_id, 'order_id': order_id},
            success:function(data){
                if(data.status){
                    toastr.success(data.message);
                }else{
                    toastr.error(data.message);
                }
            }

        });
    }    

    // add order info exm( shipping cost, comment) 
    function addedOrderInfo(field, order_id) {

        var link = '{{route("admin.addedOrderInfo")}}';
        var field_data = $('#'+field).val();
        
        $.ajax({
            url:link,
            method:"get",
            data:{field:field,field_data:field_data, order_id:order_id},
            success:function(data){
                if(data.status){
                    toastr.success(data.message);
                }else{
                    toastr.error(data.message);
                }
            }

        });
    }
     
    //order status change
    function changeOrderStatus(status, order_id) {

        if (confirm("Are you sure "+status+ " this order.?")) {

            var link = '{{route("admin.changeOrderStatus")}}';

            $.ajax({
                url:link,
                method:"get",
                data:{'status': status, 'order_id': order_id},
                success:function(data){
                    if(data.status){
                        if(status == 'cancel'){
                            $('#'+order_id).css("background-color", "rgb(255 0 0 / 17%)");
                        }else{
                            $('#'+order_id).css("background-color", "rgb(0 255 231 / 14%)");
                        }
                        
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }
                }

            });
        }
        return false;
    }
 
    // product attribute set 
    function addedAttribute(order_id, product_id){
        var attributes = $('#attributes'+order_id).val();
        if(attributes){
            $.ajax({ 
                url:"{{route('admin.orderAttribute.update')}}",
                method:"get",
                data:{ order_id:order_id,product_id:product_id,productAttributes:attributes },
                success:function(data){
                    if(data.status){
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }
                    
                },
                error: function(jqXHR, exception) {
                    toastr.error('Internal server error.');
                   
                }
            });
        }
    }   



    </script>
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
        <script>
    // responsive table
        $('#config-table').DataTable({
            responsive: true, searching: false, paging: false, info: false, ordering: false
        });
    </script>

    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
 
    <script src="{{asset('assets')}}/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="{{asset('assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script type="text/javascript">
      
    function getExtraOrder(url){
        
        $.ajax({
            url:url,
            type:'get',
            data:$('#addExtraOrder').serialize(),
            success:function(data){
                if(data){
                    $('#showAddExtraOrder').prepend(data);
                     $('.selectpicker').selectpicker();
                }else{
                    toastr.error('Order not found.');
                }
              }
            });
        }
        $('#orderInvoice').click()
        // Enter form submit preventDefault for tags
        $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
          if(e.keyCode == 13) {
            e.preventDefault();
            return false;
          }
        });

        $(".select2").select2();
    </script>
    <script>
        $(function () {
            $('.selectpicker').selectpicker();
        });
    </script>
@endsection
