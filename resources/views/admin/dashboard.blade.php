@extends('layouts.admin-master')
@section('title', 'Dashboard')
@section('css')
    <link href="{{ asset('assets/node_modules') }}/morrisjs/morris.css" rel="stylesheet">
    <!--Toaster Popup message CSS -->
    <link href="{{ asset('css') }}/pages/dashboard1.css" rel="stylesheet">
    <style type="text/css">.round{font-size:25px;}.display-5{font-size: 2rem !important;}</style>
@endsection
@section('content')
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
      <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid dashboard1"><br/>
                @if(Auth::guard('admin')->user()->role_id == 'admin')
                <div class="row">
                    <!-- Column -->
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body bg-success text-center">
                                <h1 class="font-light text-white"> <i class="fa fa-cart-plus"></i> 
                                <a href="{{route('admin.product.list')}}" class="text-white">{{$allProducts}}</a></h1>
                                <h6 class="text-white">Total Products</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body bg-info text-center">
                                <h1 class="font-light text-white"> <i class="fa fa-hourglass-half"></i> 
                                <a href="{{route('admin.product.list', 'pending')}}" class="text-white">{{$pendingProducts}}</a></h1>
                                <h6 class="text-white">UnApporve Products</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body bg-warning text-center">
                                <h1 class="font-light text-white"> <i class="fa fa-database"></i> 
                                <a href="{{route('admin.product.list', 'stock-out')}}" class="text-white">{{$outOfStock}}</a></h1>
                                <h6 class="text-white">Out Of Stock Products</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body bg-danger text-center">
                                <h1 class="font-light text-white"> <i class="fa fa-times"></i> 
                                <a href="{{route('admin.product.list', 'cancel')}}" class="text-white">{{$outOfStock}}</a></h1>
                                <h6 class="text-white">Reject Products</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Column -->
                    <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Orders</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-primary"><i class="fa fa-shipping-fast"></i></span>
                                <a href="{{route('admin.orderList')}}" class="link display-5 ml-auto">{{$allOrders}}</a>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pending Orders</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-info"><i class="fa fa-hourglass-half"></i></span>
                                <a href="{{route('admin.orderList', 'pending')}}" class="link display-5 ml-auto">{{$pendingOrders}}</a>
                            </div>
                        </div>
                    </div>
                    </div>

                    
                    <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Complete Orders</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-success"><i class="fa fa-handshake"></i></span>
                                <a href="{{route('admin.orderList', 'delivered')}}" class="link display-5 ml-auto">{{$completeOrders}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Reject Orders</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-danger"><i class="fa fa-times"></i></span>
                                <a href="{{route('admin.orderList', 'cancel')}}" class="link display-5 ml-auto">{{$rejectOrders}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                @endif
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">{{$pendingSeller}}</h3>
                                        <h5 class="text-muted m-b-0">Pending Seller</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->

                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body ">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="icon-people"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">{{$allSeller}}</h3>
                                        <h5 class="text-muted m-b-0">Total Seller</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="fa fa-user-plus"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">{{$newUser}}</h3>
                                        <h5 class="text-muted m-b-0">Customer 7 Days</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->

                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="fa fa-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0">{{$allUser}}</h3>
                                    <h5 class="text-muted m-b-0">All Customer</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info">0</h3>
                                    <h5 class="text-muted m-b-0">All Ticket</h5></div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-success">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-success">0</h3>
                                    <h5 class="text-muted m-b-0">Blog Post</h5></div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-inverse">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0">0</h3>
                                    <h5 class="text-muted m-b-0">All Subscriber</h5></div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-primary">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-primary">0</h3>
                                    <h5 class="text-muted m-b-0">Withdraw Request</h5></div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Popular Product</h5>
                                <div class="table-responsive">
                                    <table class="table product-overview">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Stock</th>
                                                <th>Price</th>
                                                <th>#</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($popularProducts)>0)
                                            @foreach($popularProducts as $product)
                                            <tr>
                                                <td><a target="_blank" href="{{ route('product_details', $product->slug) }}"> <img src="{{asset('upload/images/product/thumb/'.$product->feature_image)}}" alt="Image" width="42"> {{Str::limit($product->title, 30)}}</a> </td>
                                                 <td>{{($product->stock) ? $product->stock : 0 }}</td>
                                                <td>{{Config::get('siteSetting.currency_symble')}}{{$product->purchase_price}}</td>
                                                 <td><a  href="{{ route('product_details', $product->slug) }}" class="text-inverse p-r-10"><i class="ti-eye"></i></a> </td>
                                            </tr>
                                           @endforeach
                                        @else <tr><td colspan="8"> <h1>No products found.</h1></td></tr> @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Recent Order</h5>
                                <div class="table-responsive ">
                                    <table class="table product-overview">
                                        <thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($recentOrders)>0)
                                                @foreach($recentOrders as $order)
                                                <tr>
                                                    <td>#{{$order->order_id}}<br/>{{\Carbon\Carbon::parse($order->created_at)->format(Config::get('siteSetting.date_format'))}}
                                                    
                                                   </td>
                                                   <td>{{ $order->total_qty }}</td>
                                                    <td>{{$order->currency_sign . ($order->total_price)  }}</td>

                                                    <td> 
                                                        @if($order->order_status == 'delivered')
                                                        <span class="label label-success"> {{ str_replace('-', ' ', $order->order_status)}} </span>@elseif($order->order_status == 'accepted')
                                                        <span class="label label-warning"> {{ str_replace('-', ' ', $order->order_status)}} </span>
                                                        @elseif($order->order_status == 'cancel')
                                                        <span class="label label-danger"> {{ str_replace('-', ' ', $order->order_status)}} </span>
                                                        @elseif($order->order_status == 'ready-to-ship')
                                                        <span class="label label-primary"> {{ str_replace('-', ' ', $order->order_status)}} </span>
                                                        @else
                                                        <span class="label label-info"> Pending </span>
                                                        @endif
                                                    </td>
                                                    <td> <a target="_blank" href="{{route('admin.orderInvoice', $order->order_id)}}" class="text-inverse" title="View Order Invoice" data-toggle="tooltip"><i class="ti-eye"></i></a></td>

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
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
@endsection
@section('js')
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--morris JavaScript -->
    <script src="{{ asset('assets/node_modules') }}/raphael/raphael-min.js"></script>
    <script src="{{ asset('assets/node_modules') }}/morrisjs/morris.min.js"></script>
    <script src="{{ asset('assets/node_modules') }}/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!-- Popup message jquery -->
    <script src="{{ asset('assets/node_modules') }}/toast-master/js/jquery.toast.js"></script>
    <!-- Chart JS -->
    <script src="{{ asset('js') }}/dashboard1.js"></script>
@endsection