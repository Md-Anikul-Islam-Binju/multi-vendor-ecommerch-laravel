@extends('layouts.admin-master')
@section('title', 'Order lists')
@section('css')
<link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/stylish-tooltip.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <style type="text/css">
        .payment-method, .customer{ max-width: 150px !important; font-size: 12px; }
        .label-return{background: #ff6226;}
        .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn){max-width: 100px;}
        #orerControll .form-control{padding: 3px;}

    </style>
    <!-- page CSS -->
    <link href="{{asset('assets')}}/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
@endsection
@section('content')
    <?php 
        $all = $pending = $offerPendingOrder = $accepted = $readyToship = $on_delivery = $return = $delivered = $cancel = 0;
        foreach($orderCount as $order_status){
            if($order_status->order_status == 'pending'){
                if($order_status->offer_id != null){
                    $offerPendingOrder +=1 ; 
                }else{
                    $pending +=1 ; 
                }
            }
            if($order_status->order_status == 'accepted'){ $accepted +=1 ; }
            if($order_status->order_status == 'ready-to-ship'){ $readyToship +=1 ; }
            if($order_status->order_status == 'on-delivery'){ $on_delivery +=1 ; }
            if($order_status->order_status == 'delivered'){ $delivered +=1 ; }
            if($order_status->order_status == 'cancel'){ $cancel +=1 ; }
            if($order_status->order_status == 'return'){ $return +=1 ; }
        }
        $all = $pending+$offerPendingOrder+$accepted+$readyToship +$on_delivery+$delivered+$cancel;

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
                    <h4 class="text-themecolor">@if(Auth::guard('admin')->user()->role_id == 'admin') Total Order ({{ $all }}) @else Order History @endif</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <a class="btn btn-info btn-sm d-none d-lg-block m-l-15" href="{{ route('admin.orderList') }}"><i class="fa fa-eye"></i> Order lists</a>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->

            <div class="row">
                <!-- Column -->
                <div class="col-md-2 col-6">
                <div class="card">
                    <div class="card-body" style="padding-left:3px;padding-right: 3px;">
                        <h5 class="card-title">Pending Order</h5>
                        <div class="d-flex no-block align-items-center">
                            <span class="display-5 text-info">R</span>
                            <a href="{{route('admin.orderList', 'pending')}}?offer=regular" class="link display-5 ml-auto">{{$pending}}</a>,
                            <span class="display-5 text-info">O</span>
                            <a href="{{route('admin.orderList', 'pending')}}?offer=offer" class="link display-5 ml-auto">{{$offerPendingOrder}}</a>
                        </div>
                    </div>
                </div>
                </div>
                
                <div class="col-md-2 col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Accept Order</h5>
                        <div class="d-flex no-block align-items-center">
                            <span class="display-5 text-primary"><i class="fa fa-shipping-fast"></i></span>
                            <a href="{{route('admin.orderList', 'accepted')}}" class="link display-5 ml-auto">{{$accepted}}</a>
                        </div>
                    </div>
                </div>
                </div>
                <div class="col-md-2 col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ready To Ship</h5>
                        <div class="d-flex no-block align-items-center">
                            <span class="display-5 text-primary"><i class="fa fa-list-ol"></i></span>
                            <a href="{{route('admin.orderList', 'ready-to-ship')}}" class="link display-5 ml-auto">{{$readyToship}}</a>
                        </div>
                    </div>
                </div>
                </div>
                <!-- Column -->
                <div class="col-md-2 col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">On Delivery</h5>
                        <div class="d-flex no-block align-items-center">
                            <span class="display-5 text-info"><i class="fa fa-shipping-fast"></i></span>
                            <a href="{{route('admin.orderList', 'on-delivery')}}" class="link display-5 ml-auto">{{$on_delivery}}</a>
                        </div>
                    </div>
                </div>
                </div>
                <!-- Column -->
                <div class="col-md-2 col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cancel</h5>
                        <div class="d-flex no-block align-items-center">
                            <span class="display-5 text-danger"><i class="fa fa-times"></i></span>
                            <a href="{{route('admin.orderList', 'cancel')}}" class="link display-5 ml-auto">{{$cancel}}</a>
                        </div>
                    </div>
                </div>
                </div>
                <!-- Column -->
                <div class="col-md-2 col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Complete</h5>
                        <div class="d-flex no-block align-items-center">
                            <span class="display-5 text-success"><i class="fa fa-handshake"></i></span>
                            <a href="{{route('admin.orderList', 'delivered')}}" class="link display-5 ml-auto">{{$delivered}}</a>
                        </div>
                    </div>
                </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card" style="margin-bottom: 2px;">
                        <form action="{{route('admin.orderList')}}" id="orerControll" method="get">
                            <div class="form-body">
                                <div class="card-body" style="padding-bottom: 0;">
                                    <div class="row">
                                        <div class="col-md-2 col-6">
                                            <div class="form-group">
                                                <label class="control-label">Order Id</label>
                                                <input name="order_id" value="{{ Request::get('order_id')}}" type="text" placeholder="W123456789" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-6">
                                            <div class="form-group">
                                                <label class="control-label">Customer</label>
                                                <input name="customer" value="{{ Request::get('customer')}}" type="text" placeholder="name or mobile or email" class="form-control">
                                            </div>
                                        </div>
                                                                                  
                                        <div class="col-md-2 col-6">
                                            <div class="form-group">
                                                <label class="control-label">Offer</label>
                                                <select  z-index: 9!important; name="offer" class="form-control select2">
                                                    <option value="">Select Offer</option>
                                                    @foreach($offers as $offer)
                                                    <option value="{{$offer->id}}" {{ (Request::get('offer') == $offer->id) ? 'selected' : ''}} >{{$offer->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-6">
                                            <div class="form-group">
                                                <label class="control-label"> Status  </label>
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
                                        <div class="col-md-2 col-6">
                                            <div class="form-group">
                                                <label class="control-label">From Date</label>
                                                <input name="from_date" value="{{ Request::get('from_date')}}" type="date" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-6">
                                            <div class="form-group">
                                                <label class="control-label">End Date</label>
                                                <input name="end_date" value="{{ Request::get('end_date')}}" type="date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-6">
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
                        <div class="card-body">
                        <h3>
                            @if(Route::current()->getName() == 'order.search')
                                Total Record: ({{count($orders)}})
                            @endif
                        </h3>
                        <div class="table-responsive">
                            <table class="table display table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order ID</th>
                                        <th style="min-width: 100px;">Date</th>
                                        <th>Customer</th>
                                        <th>Qty</th>
                                        <th style="min-width: 100px;">Price</th>
                                        <th>Pay_method</th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                        <th>Invoice</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($orders)>0)
                                        @foreach($orders as $index => $order)
                                        @php 

                                            $total_price = (($order->user_type==2?$order->customer_total_price:$order->total_price) + $order->shipping_cost) - $order->coupon_discount;
                                            $partailPayment =  ($order->orderPartialPayments) ? ($order->orderPartialPayments->sum('amount')) : 0; @endphp
                                        <tr id="{{$order->order_id}}" @if($order->order_status == 'cancel') style="background:#ff000026" @endif >
                                            <td>{{(($orders->perPage() * $orders->currentPage() - $orders->perPage()) + ($index+1) )}}</td>
                                            <td><span class="label label-{{($order->user_type== 1 ) ? 'info' : 'success' }}">{{ ($order->user_type == 1 ? 'Customer' : 'Reseller') }}</span>
                                                {{$order->order_id}}</td>
                                            <td>{{\Carbon\Carbon::parse($order->order_date)->format(Config::get('siteSetting.date_format'))}}
                                            <p style="font-size: 12px;margin: 0;padding: 0">{{\Carbon\Carbon::parse($order->order_date)->format('h:i:s A')}}</p>
                                           </td>
                                           <td>{{ $order->customer_name }}
                                            <p style="font-size: 12px;margin: 0;padding: 0">{{ $order->billing_phone }}</p></td>
                                            <td>{{$order->total_qty}}</td>
                                            <td>
                                                @if($partailPayment < $total_price && $order->payment_status != 'paid')
                                                <span style="font-size:11px;">
                                                Payable:{{$order->currency_sign}}{{$total_price }}<br/>
                                                Received:{{$order->currency_sign}}{{($partailPayment) ? $partailPayment : 0 }}<br/>
                                                Due:{{$order->currency_sign}}{{($partailPayment) ? $total_price - $partailPayment : $total_price }} </span>
                                                @else Paid:{{$order->currency_sign}}{{$total_price }} @endif
                                                
                                            </td>
                                            <td class ="payment-method"> 
                                                <span class="mytooltip tooltip-effect-2">
                                                <span class="label label-{{($order->payment_method=='pending') ? 'danger' : 'success' }}">{{ str_replace( '-', ' ', $order->payment_method) }}</span>
                                                @if($order->payment_method != 'nagad' && $order->payment_method != 'shurjopay')
                                                @if($order->payment_info)
                                                <span class="tooltip-content clearfix">
                                                <span class="tooltip-text">
                                                    @if($order->tnx_id)
                                                    <strong>Tnx_id:</strong> <span> {{$order->tnx_id}}</span><br/>
                                                    @endif
                                                    {{$order->payment_info}}
                                                </span> 
                                                </span>
                                                @endif
                                                @endif
                                                </span>
                                                @if(Auth::guard('admin')->user()->email == 'neyamulkn2@gmail.com' && ($order->payment_method == 'nagad' || $order->payment_method == 'shurjopay'))
                                                    @if($order->tnx_id)
                                                    <strong>Tnx_id:</strong> <span> {{$order->tnx_id}}</span><br/>
                                                    @endif
                                                    {{$order->payment_info}}
                                                    <a onclick="paymentIssue('{{$order->order_id}}', 'Process To Verify')" class="label label-warning" >Add Payment Issue</a>
                                                @endif
                                            </td>
                                            <td>                                                <a href="javascript:void(0)" class="label btn-xs @if($order->payment_status == 'paid')  label-success @elseif($order->payment_status == 'received') label-info @else label-danger @endif">
                                                @if(Auth::guard('admin')->user()->role_id == 'admin' || in_array(Auth::guard('admin')->user()->id, [22]))
                                                <span class="mytooltip tooltip-effect-2">
                                                <div  @if($order->payment_status != 'paid') onclick="orderPaymentPopup('{{ route("admin.orderPaymentDetails", $order->order_id)}}')"  @endif title="Order payment info" data-toggle="tooltip"  class="text-inverse p-r-10" >{{$order->payment_status}} </div>
                                                @if(count($order->orderNotify)>0)
                                               
                                                <span class="tooltip-content clearfix">
                                                <span class="tooltip-text">
                                                    @foreach($order->orderNotify->where('type', '=', 'orderPayment')  as $notify)
                                                       <p style="font-size: 10px;padding: 0;margin: 0">{{$index+1}}. By {{($notify->notify) ? $notify->staff->name : '' }} => {{$notify->notify}} <br/><i class="fa fa-clock">  {{\Carbon\Carbon::parse($notify->created_at)->format(Config::get('siteSetting.date_format') .' | '.' h:i A')}}</i></p>
                                                    @endforeach
                                                </span> 
                                                </span>
                                                </span>
                                                @endif
                                                @else
                                                    <span >{{$order->payment_status}}</span>
                                                @endif
                                                </a>
                                                
                                            </td>

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
                                            <td><a target="_blank" class="dropdown-item" href="{{route('admin.orderInvoice', $order->order_id)}}" class="text-inverse" title="View Order Invoice" data-toggle="tooltip"><i class="ti-printer"></i> Invoice</a></td>
                                            <td>
                                                @if(Auth::guard('admin')->user()->role_id != 'admin')
                                                <a href="javascript:void(0)" class="dropdown-item" onclick="order_details('{{$order->order_id}}')" title=" View order details" data-toggle="tooltip" class="text-inverse p-r-10" ><i class="ti-eye"></i> Details</a>
                                                @else
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="ti-settings"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a href="javascript:void(0)" class="dropdown-item" onclick="order_details('{{$order->order_id}}')" title=" View order details" data-toggle="tooltip" class="text-inverse p-r-10" ><i class="ti-eye"></i> Details</a>
                                                        <a href="javascript:void(0)" class="dropdown-item" onclick="changeShippingAddress('{{$order->order_id}}')" title="Change Shipping Address" data-toggle="tooltip" class="text-inverse p-r-10" ><i class="fa fa-edit"></i> Shipping Address</a>
                                                        @if($order->order_status=='delivered')
                                                        <a href="javascript:void(0)" class="dropdown-item" onclick="returnOrder('{{$order->id}}')" title="Return Order" data-toggle="tooltip" class="text-inverse p-r-10" ><i class="fa fa-ul"></i> Return Order</a>
                                                        @endif
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
                </div>
                <!-- Column -->
            </div>
            <div class="row">
               <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                   {{$orders->appends(request()->query())->links()}}
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of total {{$orders->total()}} entries ({{$orders->lastPage()}} Pages)</div>
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

    <div class="modal fade" id="changeShippingAddress" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Change Shipping Address</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" id="getShippingAddress"></div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>






    <div class="modal fade" id="returnOrderModal" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Return Order Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" id="returnOrderForm"></div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>














    <div class="modal bs-example-modal-lg" id="orderPaymentModal" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Update payment info.</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                @if(Session::has('error'))
                    <div class="alert alert-danger">
                      {{Session::get('error')}}
                    </div>
                @endif
                <div class="modal-body" id="orderPaymentDetails"></div> 
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="reviewModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Review this product</h4>
                    <button type="button" class="close" data-dismiss="modal" style="margin-top: -25px;">&times;</button>
                </div>
                <form action="{{route('adminReviewInsert')}}"  data-parsley-validate method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body" id="getReviewForm"> </div>

                    <div class="modal-footer">
                       <button type="submit" class="btn btn-success">Publish Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')

    <script type="text/javascript">
        function order_details(id){
            $('#order_details').html('<div class="loadingData"></div>');
            $('#getOrderDetails').modal('show');
            var  url = '{{route("admin.getOrderDetails", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#order_details").html(data);
                    $('.selectpicker').selectpicker();
                    $('#'+id).css("background-color", "rgb(0 255 231 / 14%)");
                }
            }
        });
        }
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

        function changePaymentStatus(status, order_id) {
            if (confirm("Are you sure change payment status "+status+".?")) {
                var link = '{{route("admin.changePaymentStatus")}}';
                $.ajax({
                    url:link,
                    method:"get",
                    data:{'status': status, 'order_id': order_id},
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

        function orderPaymentPopup(link){
            $('#orderPaymentModal').modal('show');
            $('#orderPaymentDetails').html('<div class="loadingData"></div>');
            $.ajax({
                url:link,
                method:"get",
                success:function(data){
                    $('#orderPaymentDetails').html(data);
                }
            });
        }

        function changeOrderStatus(status, order_id) {
            if (confirm("Are you sure "+status+ " this order.?")) {
                const link = '{{route("admin.changeOrderStatus")}}';
                $.ajax({
                    url:link,
                    method:"get",
                    data:{'status': status, 'order_id': order_id},
                    success:function(data){
                        if(data.status){
                            $('#getOrderDetails').modal('hide');
                            toastr.success(data.message);
                        }else{
                            toastr.error(data.message);
                        }
                    }
                });
            }
            return false;
        }        

        function changeProductOrderStatus(status, order_id, product_id) {
            if (confirm("Are you sure "+status+ " this product.?")) {

                var link = '{{route("admin.changeProductOrderStatus")}}';

                $.ajax({
                    url:link,
                    method:"get",
                    data:{'status': status, 'order_id': order_id, 'product_id': product_id},
                    success:function(data){
                        if(data.status){
                            $('#getOrderDetails').modal('hide');
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
        function orderCancelPopup(route) {
            document.getElementById('orderCancelRoute').value = route;
        }

        function orderCancel(route) {
            //separate id from route
            var id = route.split("/").pop();

            $.ajax({
                url:route,
                method:"get",
                success:function(data){
                    if(data.status){
                        $("#ship_status"+id).html('cancel');
                        toastr.success(data.msg);
                    }else{
                        toastr.error(data.msg);
                    }
                }
            });
        }

        function paymentIssue(order_id, payment_status) {
        $.ajax({ 
            url:"{{route('admin.changePaymentStatus')}}",
            method:"post",
            data:{ 'order_id':order_id,'payment_status':payment_status, '_token': '{{csrf_token()}}'},
            success:function(data){
                if(data.status){
                    toastr.success(data.message);
                }else{
                    toastr.error('update failed.');
                }
            }
        });
        return false
    }

        // product attribute set 
        function addedAttribute(order_id, product_id){

            var attributes = $('#attributes'+product_id).val();
           
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

        function changeShippingAddress(id){
            $('#getShippingAddress').html('<div class="loadingData"></div>');
            $('#changeShippingAddress').modal('show');
            var  url = '{{route("admin.changeShippingAddress", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#getShippingAddress").html(data);
                        $(".select2").select2();
                    }
                }
            });
        }


        function returnOrder(id){
            $('#returnOrderForm').html('<div class="loadingData"></div>');
            $('#returnOrderModal').modal('show');
            var  url = '{{route("admin.orderReturn", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#returnOrderForm").html(data);
                        $(".select2").select2();
                    }
                }
            });
        }

        function get_city(id){
        var  url = '{{route("get_city", ":id")}}';
        url = url.replace(':id', id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#show_city").html(data);
                  
                    $("#show_city").focus();
                    $("#show_area").html('<option>Select Area</option>');
                    $(".select2").select2();
                }else{
                    $("#show_city").html('<option>City not found</option>');
                    $("#show_area").html('<option>Select Area</option>');
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
    </script>

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
        function checkField(value, field){
            if(value != ""){
                $.ajax({
                    method:'get',
                    url:"{{ route('checkField') }}",
                    data:{table:'order_payments', field:field, value:value},
                    success:function(data){
                        if(data.status){
                            $('#'+field).html("");
                            
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
        $(function () {
            $('.selectpicker').selectpicker();
        });
    </script>
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

    <script type="text/javascript">

    $(".select2").select2();
    </script>
 
    <script type="text/javascript">
        function reviewModal(order_id, product_id){
            $('#reviewModal').modal('show');
            $("#getReviewForm").html("<div class='loadingData-sm'></div>");
            $.ajax({
                url:'{{route("adminGetReviewForm")}}',
                type:'get',
                data:{order_id:order_id,product_id:product_id},
                success:function(data){
                    if(data){
                       $('#getReviewForm').html(data);
                    }else{
                      toastr.error(data);
                    }
                }
            });
         }
    </script>
@endsection
