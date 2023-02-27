@extends('layouts.admin-master')
@section('title', Request::get('status') ? ucwords(Request::get('status')) .' order report-('. Carbon\Carbon::parse(now())->format('d-M-Y').')' : 'Order report-('. Carbon\Carbon::parse(now())->format('d-M-Y').')')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/stylish-tooltip.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <style type="text/css">
        .payment-method, .customer{
            max-width: 150px !important; font-size: 12px;text-align: center;
        }
        .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn){max-width: 100px;}
    </style>

    <!-- page CSS -->
    <link href="{{asset('assets')}}/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    
@endsection
@section('content')

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
                        <h4 class="text-themecolor">Order Report</h4>
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
                    <div class="col-lg-12">
                        <div class="card" style="margin-bottom: 2px;">

                            <form action="" method="get">

                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row">
                                            
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Customer</label>
                                                    <input name="customer" value="{{ Request::get('customer')}}" type="text" placeholder="name or mobile or email" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Offers </label>
                                                    <select name="offer" class="form-control">

                                                        <option value="all" {{ (Request::get('offer') == "all") ? 'selected' : ''}}>All Offer</option>

                                                        @foreach($offers as $offer)
                                                        <option value="{{$offer->id}}" {{ (Request::get('offer') == $offer->id) ? 'selected' : ''}}>{{$offer->title}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Order Status  </label>
                                                    <select name="status" class="form-control">
                                                        <option value="all" {{ (Request::get('status') == "all") ? 'selected' : ''}}>All Status</option>
                                                        <option value="pending" {{ (Request::get('status') == 'pending') ? 'selected' : ''}} >Pending</option>
                                                        <option value="accepted" {{ (Request::get('status') == 'accepted') ? 'selected' : ''}}>Accepted</option>
                                                        <option value="on-delivery" {{ (Request::get('status') == 'ready-to-ship') ? 'selected' : ''}}>Ready to ship</option>
                                                        <option value="on-delivery" {{ (Request::get('status') == 'on-delivery') ? 'selected' : ''}}>On Delivery</option>
                                                        <option value="delivered" {{ (Request::get('status') == 'delivered') ? 'selected' : ''}}>Delivered</option>
                                                        <option value="cancel" {{ (Request::get('status') == 'cancel') ? 'selected' : ''}}>Cancel</option>
                                                        
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
                                                    <label class="control-label">Show </label>
                                                    <select name="show" class="form-control" style="padding: 3px;">

                                                        <option value="25" {{ (Request::get('show') == "25") ? 'selected' : ''}}>25</option>
                                                        <option value="50" {{ (Request::get('show') == "50") ? 'selected' : ''}}>50</option>
                                                        <option value="100" {{ (Request::get('show') == "100") ? 'selected' : ''}}>100</option>
                                                        <option value="250" {{ (Request::get('show') == "250") ? 'selected' : ''}}>250</option>
                                                        <option value="500" {{ (Request::get('show') == "500") ? 'selected' : ''}}>500</option>
                                                        <option value="750" {{ (Request::get('show') == "750") ? 'selected' : ''}}>750</option>
                                                        <option value="1000" {{ (Request::get('show') == "1000") ? 'selected' : ''}}>1000</option>
                                                        <option value="5000" {{ (Request::get('show') == "5000") ? 'selected' : ''}}>5000</option>

                                                    </select>
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
                               <table id="example23" class="table display table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Product Name</th>
                                            <th>Customer Name</th>
                                            <th>Mobile</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Shipping Cost</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($orders)>0)
                                            @foreach($orders as $index => $order)
                                            <tr @if($order->order_status == 'cancel') style="background:#ff000026" @endif>
                                                <td>{{ $index+1 }}</td>
                                                <td>
                                                    {{$order->order_id}}
                                                    @if(Auth::guard('admin')->user()->email == 'neyamulkn2@gmail.com') <br/>
                                                    <a href="javascript:void(0)" class="btn btn-success" onclick="addedOrderInfo('is_voucher', '{{$order->order_id}}' )"> Add Voucher </a>
                                                    @endif
                                                </td>
                                               <td>{{\Carbon\Carbon::parse($order->order_date)->format('d-M-Y')}} </td>
                                               <td> @foreach($order->order_details as $item)
                                                    @if($item->product)<img src="{{asset('upload/images/product/'.$item->product->feature_image)}}" width="48" height="38" >  {{Str::limit($item->product->title, 80)}} <br> @else <p style="color:red">Product not found.</p>  @endif  @if($item->attributes)  
                                                    @foreach(json_decode($item->attributes) as $key=>$value)
                                                    <small> {{$key}} : {{$value}} </small>
                                                    @endforeach
                                                    @endif
                                                    @endforeach
                                                </td>
                                               <td>{{ $order->customer_name }}</td>
                                               <td>{{ ($order->billing_phone) ? $order->billing_phone : $order->shipping_phone }}</td>
                                                <td>{{$order->total_qty}}</td>
                                                <td>{{$order->currency_sign . ($order->total_price + $order->shipping_cost - $order->coupon_discount)  }}</td>
                                                <td>@if($order->shipping_cost != null) <span class="label label-success">paid</span> @else <span class="label label-danger">pending </span>@endif 
                                            </td>
                                            
                                           
                                            <td> 
                                                @if($order->order_status == 'delivered')
                                                <span class="label label-success"> {{ str_replace('-', ' ', $order->order_status)}} </span>

                                                @elseif($order->order_status == 'accepted')
                                                <span class="label label-warning"> {{ str_replace('-', ' ', $order->order_status)}} </span>

                                                @elseif($order->order_status == 'ready-to-ship')
                                                <span class="label label-ready-ship"> {{ str_replace('-', ' ', $order->order_status)}} </span>

                                                @elseif($order->order_status == 'cancel')
                                                <a href="javascript:void()" class="mytooltip">
                                                    <span class="label label-danger"> {{ str_replace('-', ' ', $order->order_status)}} 
                                                    </span>
                                                    
                                                </a>
                                                @elseif($order->order_status == 'on-delivery')
                                                <span class="label label-primary"> {{ str_replace('-', ' ', $order->order_status)}} </span>

                                                @else
                                                <span class="label label-info"> Pending </span>
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
     
    @endsection
    @section('js')


    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>

        <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
        <script>
    // responsive table
        $('#config-table').DataTable({
            responsive: true, searching: false, paging: false, info: false, ordering: false
        });

        // add order info exm( shipping cost, comment) 
        function addedOrderInfo(field, order_id) {

            var link = '{{route("admin.addedOrderInfo")}}';
           
            $.ajax({
                url:link,
                method:"get",
                data:{field:field,order_id:order_id},
                success:function(data){
                    if(data.status){
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }
                }

            });
        }
    </script>

    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
 
    <script src="{{asset('assets')}}/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
 
    <script>
        $(function () {
      
            $('.selectpicker').selectpicker();
            
        });


        $('#example23').DataTable({
                dom: 'Bfrtip',paging: false, info: false, ordering: false,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
    </script>
@endsection
