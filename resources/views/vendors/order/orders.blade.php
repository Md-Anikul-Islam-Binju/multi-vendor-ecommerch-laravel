@extends('vendors.partials.vendor-master')
@section('title', 'Order lists')
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">

    <style type="text/css">
        .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn){max-width: 100px;}
    </style>

    <!-- page CSS -->
    <link href="{{asset('assets')}}/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    
@endsection
@section('content')
                <?php 
                    $all = $pending = $accepted = $ready_to_ship = $on_delivery = $delivered =$cancel = $return = 0;
                    foreach($orderCount as $order_status){
          
                        if($order_status->shipping_status == 'pending'){ $pending +=1 ; }
                        if($order_status->shipping_status == 'accepted'){ $accepted +=1 ; }
                        if($order_status->shipping_status == 'ready-to-ship'){ $ready_to_ship +=1 ; }
                         if($order_status->shipping_status == 'on-delivery'){ $on_delivery +=1 ; }
                        if($order_status->shipping_status == 'delivered'){ $delivered +=1 ; }
                        if($order_status->shipping_status == 'cancel'){ $cancel +=1 ; }
                    }
                    $all = $pending+$accepted +$ready_to_ship+$on_delivery+ $delivered+ $return + $cancel;

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
                        <h4 class="text-themecolor">Total Order({{$all}})</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center"></div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Info box Content -->
                <!-- ============================================================== -->
                            
                
                <div class="row">
                    <!-- Column -->
                    
                    <!-- Column -->
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pending Order</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-info"><i class="fa fa-database"></i></span>
                                <a href="javscript:void(0)" class="link display-5 ml-auto">{{$pending}}</a>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Accept Order</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-primary"><i class="fa fa-list-ol"></i></span>
                                <a href="javscript:void(0)" class="link display-5 ml-auto">{{$accepted}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    
                    <!-- Column -->
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ready to ship</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-warning"><i class="fa fa-hourglass-half"></i></span>
                                <a href="javscript:void(0)" class="link display-5 ml-auto">{{$ready_to_ship}}</a>
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
                                <span class="display-5 text-primary"><i class="fa fa-shipping-fast"></i></span>
                                <a href="javscript:void(0)" class="link display-5 ml-auto">{{$on_delivery}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Delivered</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-success"><i class="fa fa-check-circle"></i></span>
                                <a href="javscript:void(0)" class="link display-5 ml-auto">{{$delivered}}</a>
                            </div>
                        </div>
                    </div>
                    </div><div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Cancel</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-danger"><i class="fa fa-window-close"></i></span>
                                <a href="javscript:void(0)" class="link display-5 ml-auto">{{$cancel}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" style="margin-bottom: 2px;">

                            <form action="{{route('vendor.orderList')}}" method="get">

                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Order Id</label>
                                                    <input name="order_id" value="{{ Request::get('order_id')}}" type="text" placeholder="W-1269345456" class="form-control">
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

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">From Date</label>
                                                    <input name="from_date" value="{{ Request::get('from_date')}}" type="date" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
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
                                        Total Record: ({{count($orders)}})
                                    @endif
                                </h3>
                                <div class="table-responsive">
                                   <table id="config-table" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Order Date</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                                <th>Payment Method</th>
                                                <th>Status</th>
                                                <th>Invoice</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if(count($orders)>0)
                                                @foreach($orders as $order)
                                                <tr>
                                                    <td>{{$order->order_id}}</td>
                                                   <td>{{\Carbon\Carbon::parse($order->created_at)->format('M d, Y')}}
                                                    <p style="font-size: 12px;margin: 0;padding: 0">{{\Carbon\Carbon::parse($order->created_at)->diffForHumans()}}</p>
                                                   </td>

                                                    <td>{{$order->quantity}}</td>
                                                    <td>{{$order->currency_sign . ($order->total_price)  }}</td>

                                                    <td> <span class="label label-primary font-weight-100">{{ str_replace( '-', ' ', $order->payment_method) }}</span></td>
                                                   
                                                    <td> 
                                                        @if($order->shipping_status == 'delivered')
                                                        <span class="label label-success"> {{ str_replace('-', ' ', $order->shipping_status)}} </span>@elseif($order->shipping_status == 'accepted')
                                                        <span class="label label-warning"> {{ str_replace('-', ' ', $order->shipping_status)}} </span>@elseif($order->shipping_status == 'on-delivery')
                                                        <span class="label label-warning"> {{ str_replace('-', ' ', $order->shipping_status)}} </span>
                                                        @elseif($order->shipping_status == 'cancel')
                                                        <span class="label label-danger"> {{ str_replace('-', ' ', $order->shipping_status)}} </span>
                                                        @elseif($order->shipping_status == 'ready-to-ship')
                                                        <span class="label label-primary"> {{ str_replace('-', ' ', $order->shipping_status)}} </span>
                                                        @else
                                                        <span class="label label-info"> Pending </span>
                                                        @endif
                                                    </td>
                                                    <td> <a class="dropdown-item" href="{{route('vendor.orderInvoice', $order->order_id)}}" target="_blank" class="text-inverse" title="View Order Invoice" data-toggle="tooltip"><i class="ti-printer"></i> Invoice</a></td>
                                                    <td>
                                                    @if($order->shipping_charge == null)
                                                    <a href="javascript:void(0)" class="dropdown-item" onclick="order_details('{{$order->order_id}}')" title=" View order details" data-toggle="tooltip" class="text-inverse p-r-10" > <i class="ti-eye"></i> Order Details</a>
                                                    <span class="label label-danger">Shipping cost pending </span>
                                                    @else
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                             <i class="ti-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu">

                                                            <a href="javascript:void(0)" class="dropdown-item" onclick="order_details('{{$order->order_id}}')" title=" View order details" data-toggle="tooltip" class="text-inverse p-r-10" > View Details</a>

                                                            <a href="javascript:void(0)" class="dropdown-item"  onclick="changeOrderStatus('accepted', '{{$order->order_id}}')" title="Accept this product" >Accepted</a>
                                                            <a href="javascript:void(0)" class="dropdown-item"  onclick="changeOrderStatus('ready-to-ship', '{{$order->order_id}}')" title="Accept this product" >Ready To Ship</a>
                                                            <span title="Cancel Order" data-toggle="tooltip">
                                                            <!-- <button data-target="#orderCancel"  data-toggle="modal" class="dropdown-item" onclick="orderCancelPopup('{{$order->order_id}}')"> Cancel Order</button> -->
                                                            </span>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    </td>

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
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <div class="row">
                       <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                           {{$orders->appends(request()->query())->links()}}
                          </div>
                        <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of total {{$orders->total()}} entries ({{$orders->lastPage()}} Pages)</div>
                    </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <div class="modal bs-example-modal-lg" id="getOrderDetails" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
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
       
        <div class="modal fade" id="orderCancel" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Order Cancel</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <form action="{{route('vendor.orderCancel')}}" method="POST" class="floating-labels">
                                {{csrf_field()}}
                                <input type="hidden" name="order_id" id="order_id" value="">
                                <input type="hidden" name="product_id" id="product_id" value="">
                                <div class="form-body">
                                   
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="reason">Order Cancel Reason</label>
                                                <select required name="cancel_reason" class="form-control">
                                                    <option value="">Select canel reason</option>
                                                @foreach($cancelReasons as $reason)
                                                    <option value="{{ $reason->reason }}">{{ $reason->reason }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="reason_details">Write Reason Details</label>
                                                <textarea class="form-control" id="reason_details" placeholder="Write Order Reason Details" name="reason_details"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="submitType" value="add" class="btn btn-danger"> <i class="fa fa-check"></i> Cancel Order</button>
                                            
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        
    @endsection
    @section('js')

    <script type="text/javascript">
        function order_details(id){
            $('#order_details').html('<div class="loadingData"></div>');
            $('#getOrderDetails').modal('show');
            var  url = '{{route("getVendorOrderDetails", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){

                    $("#order_details").html(data);
                }
                }
            });
        }

    function changeOrderStatus(status, order_id, product_id=null) {

        if (confirm("Are you sure "+status+ " this order.?")) {

            var link = '{{route("vendor.changeOrderStatus")}}';

            $.ajax({
                url:link,
                method:"get",
                data:{'status': status, 'order_id': order_id, 'product_id': product_id},
                success:function(data){
                    if(data){
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }
                }

            });
        }
        return false;
    }

    //order cancel

    function orderCancelPopup(order_id, product_id=null) {
        $('#orderCancel').modal('show');
        $('#order_id').val(order_id);
        $('#product_id').val(product_id);
        
    }
    </script>
    <!-- This page plugins -->
    <!-- ============================================================== -->
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
 
    <script>
        $(function () {
      
            $('.selectpicker').selectpicker();
            
        });
    </script>
@endsection
