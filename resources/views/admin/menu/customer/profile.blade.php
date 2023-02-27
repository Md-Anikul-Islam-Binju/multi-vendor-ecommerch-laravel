@extends('layouts.admin-master')
@section('title', $customer->name.' | Profile')
@section('css')

    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">

    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">

    .dropify-wrapper{
        height: 100px !important;
    }
    .title_head{
        width: 100%; margin-top: 5px; background: #8d8f90; color:#fff; padding: 10px;
    }

</style>
@endsection

@section('content')

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
                        <h4 class="text-themecolor">Profile</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Customer</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                            <a href="{{route('customer.list')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-angle-left"></i> Back</a>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-xlg-3 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <center> <img src="{{asset('upload/users/avatars/'.$customer->phato)}}" class="img-circle" width="150" />
                                    <h4 class="card-title m-t-10">{{$customer->name}}</h4>
                                    <h6 class="card-subtitle">{{$customer->user_dsc}}</h6>
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-6"><a title="User status" href="javascript:void(0)" class="link"><i class="fa fa-check"></i> <font class="font-medium">{{($customer->status == 1) ? 'Active' : 'Deactive'}} </font></a></div>
                                        <div class="col-6"><a title="Total Tickets " href="javascript:void(0)" class="link"><i class="fa fa-clipboard-list"></i> <font class="font-medium">{{Config::get('siteSetting.currency_symble'). $customer->wallet_balance}}</font></a></div>
                                    </div>
                                </center>
                                <hr/>
                                <small class="text-muted">Mobile</small>
                                <h6>{{$customer->mobile}}</h6> 
                                <small class="text-muted">Email</small>
                                <h6>{{$customer->email}}</h6> 

                                <small class="text-muted">Member Since </small>
                                <h6>{{Carbon\Carbon::parse($customer->created_at)->format(Config::get('siteSetting.date_format'))}}</h6> 
                                <small class="text-muted p-t-30 db">Birthday</small>
                                <h6>{{ Carbon\Carbon::parse($customer->birthday)->format(Config::get('siteSetting.date_format'))}}</h6> 
                                <p>Gender: {{ $customer->gender }}, Blood: {{ $customer->blood }}</p>
                                <small class="text-muted p-t-30 db">Address</small>
                                <h6>{{ $customer->address }} 
                                    @if($customer->get_area){{ $customer->get_area['name']}} @endif
                                    @if($customer->get_city) {{$customer->get_city['name']}} @endif
                                    @if($customer->get_state){{ $customer->get_state['name'] }} @endif</h6>
                                
                                <br/>
                                <button class="btn btn-circle btn-secondary"><i class="fab fa-facebook-f"></i></button>
                                <button class="btn btn-circle btn-secondary"><i class="fab fa-twitter"></i></button>
                                <button class="btn btn-circle btn-secondary"><i class="fab fa-youtube"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-9 col-xlg-9 col-md-9">
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-tab" role="tablist">
                            
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile" role="tab"><i class="fa fa-user"></i> Order</a> </li>
                               <!--  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab"> <i class="fa fa-chart-line"></i> Reports</a> </li> -->
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                
                                <div class="tab-pane active" id="profile" role="tabpanel">
                                    <div class="card-body">
                                        <label class="title_head">
                                            Order list
                                        </label>
                                        <div class="row">
                                            
                                            <div class="col-md-12 col-xs-6 b-r">
                                                <div class="table-responsive">
                                                   <table id="config-table" class="table display table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Order ID</th>
                                                                <th>Order Date</th>
                                                                <th>Qty</th>
                                                                <th>Total</th>
                                                                <th>Payment Method</th>
                                                                <th>Payment Status</th>
                                                                <th>Delivery Status</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>


                                                            @if(count($customer->orders)>0)
                                                                @foreach($customer->orders as $order)
                                                                <tr>
                                                                    <td>{{$order->order_id}}</td>
                                                                   <td>{{\Carbon\Carbon::parse($order->order_date)->format(Config::get('siteSetting.date_format'))}}
                                                                    <p style="font-size: 12px;margin: 0;padding: 0">{{\Carbon\Carbon::parse($order->order_date)->diffForHumans()}}</p>
                                                                   </td>

                                                                    <td>{{$order->total_qty}}</td>
                                                                    <td>{{$order->currency_sign . ($order->total_price + $order->shipping_cost - $order->coupon_discount)  }}</td>

                                                                    <td> <span class="label label-{{($order->payment_method=='pending') ? 'danger' : 'success' }}">{{ str_replace( '-', ' ', $order->payment_method) }}</span>
                                                                    @if($order->payment_info)
                                                                    <br/><strong>Tnx_id:</strong> <span> {{$order->tnx_id}}</span><br/>
                                                                    <span><strong>Info:</strong> {{$order->payment_info}}</span>
                                                                    @endif
                                                                    </td>
                                                                     <td>
                                                                        <span class="label label-{{ ($order->payment_status == 'paid') ? 'success' : 'danger' }}">{{$order->payment_status}}</span>
                                                                        
                                                                     </td>

                                                                    <td>
                                                                        <span class="label label-{{ ($order->order_status == 'delivered') ? 'success' : 'danger' }}">{{$order->payment_status}}</span>
                                                                        
                                                                    </td>
                                                                    <td>

                                                                    <div class="btn-group">
                                                                        <button type="button" class="btn btn-defualt dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            Action
                                                                        </button>
                                                                        <div class="dropdown-menu">

                                                                            <a href="javascript:void(0)" class="dropdown-item" onclick="order_details('{{$order->order_id}}')" title=" View order details" data-toggle="tooltip" class="text-inverse p-r-10" ><i class="ti-eye"></i> View Details</a>

                                                                            <a class="dropdown-item" href="{{route('admin.orderInvoice', $order->order_id)}}" class="text-inverse" title="View Order Invoice" data-toggle="tooltip"><i class="ti-printer"></i> Order Invoice</a>

                                                                        </div>
                                                                    </div>
                                                                    
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
                                </div>
                                <div class="tab-pane" id="settings" role="tabpanel">
                                    
                                    <div class="card-body">
                                        <label class="title_head">
                                        <i class="fa fa-reports"></i>User Reports
                                    </label>
                                        <form class="form-horizontal form-material">
                                            <div class="form-group">
                                                <label class="col-md-12">Full Name</label>
                                                <div class="col-md-12">
                                                    <input type="text" placeholder="Johnathan Doe" class="form-control form-control-line">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-email" class="col-md-12">Email</label>
                                                <div class="col-md-12">
                                                    <input type="email" placeholder="johnathan@admin.com" class="form-control form-control-line" name="example-email" id="example-email">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">Password</label>
                                                <div class="col-md-12">
                                                    <input type="password" value="password" class="form-control form-control-line">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">Phone No</label>
                                                <div class="col-md-12">
                                                    <input type="text" placeholder="123 456 7890" class="form-control form-control-line">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">Message</label>
                                                <div class="col-md-12">
                                                    <textarea rows="5" class="form-control form-control-line"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-12">Select Country</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control form-control-line">
                                                        <option>London</option>
                                                        <option>India</option>
                                                        <option>Usa</option>
                                                        <option>Canada</option>
                                                        <option>Thailand</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button class="btn btn-success">Update Profile</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
              
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
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
   
@endsection

@section('js')
    <script type="text/javascript">
        function order_details(id){
            $('#order_details').html('<div class="loadingData"></div>');
            $('#getOrderDetails').modal('show');
            var  url = '{{route("getOrderDetails", ":id")}}';
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
    </script>
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>

   
     <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

    });
    </script>
       <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
        <script>
    // responsive table
        $('#config-table').DataTable({
            responsive: true,
             ordering: false
        });
    </script>

@endsection

