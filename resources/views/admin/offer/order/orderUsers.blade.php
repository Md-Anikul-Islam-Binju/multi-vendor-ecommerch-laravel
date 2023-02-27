@extends('layouts.admin-master')
@section('title', $product->title)

@section('css-top')

    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
   
@endsection
@section('css')
      <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
  
    <style type="text/css">
        .dropify-wrapper{  height: 100px !important; }
        #showProductArea{max-height: 400px; overflow-y: auto;}
        .discount_type{padding: 8px 3px; border: 1px solid #ccc; border-radius: 5px;}
    </style>
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
                        <h4 class="text-themecolor"> Order Customer List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript::void(0)">Customer</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <a href="{{route('admin.offerProducts', Request::route('offer_slug'))}}" class="btn btn-info btn-sm d-lg-block m-l-15"><i class="fa fa-eye"></i> Back Product List</a>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" style="margin-bottom: 2px;">

                            <form action="" method="get">

                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row">
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input name="customer" placeholder="Customer name or mobile or email" value="{{ Request::get('customer')}}" type="text" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <select name="city" required style="width:100%" id="city"  class="select2 form-control custom-select">
                                                       <option value="all">All Zones</option>
                                                       @foreach($cities as $city)
                                                       <option  @if(Request::get('city') == $city->name) selected @endif value="{{$city->name}}">{{$city->name .'('.$city->total_order.')'}}</option>
                                                       @endforeach
                                                   </select>
                                               </div>
                                            </div>


                                            <div class="col-md-2">
                                                <div class="form-group">
                                                   
                                                    <select name="status" class="form-control">
                                                        <option value="all" {{ (Request::get('status') == "all") ? 'selected' : ''}}>All Status</option>
                                                        <option value="pending" {{ (Request::get('status') == 'pending') ? 'selected' : ''}} >Pending</option>
                                                        <option value="processing" {{ (Request::get('status') == 'processing') ? 'selected' : ''}}>Accepted</option>
                                                        <option value="on-delivery" {{ (Request::get('status') == 'ready-to-ship') ? 'selected' : ''}}>Ready to ship</option>
                                                        <option value="on-delivery" {{ (Request::get('status') == 'on-delivery') ? 'selected' : ''}}>On Delivery</option>
                                                        <option value="delivered" {{ (Request::get('status') == 'delivered') ? 'selected' : ''}}>Delivered</option>
                                                        <option value="cancel" {{ (Request::get('status') == 'cancel') ? 'selected' : ''}}>Cancel</option>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <select class="form-control" name="show">
                                                        <option @if(Request::get('show') == 15) selected @endif value="15">15</option>
                                                        <option @if(Request::get('show') == 25) selected @endif value="25">25</option>
                                                        <option @if(Request::get('show') == 50) selected @endif value="50">50</option>
                                                        <option @if(Request::get('show') == 100) selected @endif value="100">100</option>
                                                        <option @if(Request::get('show') == 255) selected @endif value="250">250</option>
                                                        <option @if(Request::get('show') == 500) selected @endif value="500">500</option>
                                                        <option @if(Request::get('show') == 750) selected @endif value="750">750</option>
                                                        <option @if(Request::get('show') == 1000) selected @endif value="1000">1000</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                   
                                                   <button type="submit" class="form-control btn btn-success"><i style="color:#fff; font-size: 20px;" class="ti-search"></i> </button>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                           
                            <div class="table-responsive">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer</th>
                                            <th>Order</th>
                                            <th>Area</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        @if(count($orderUsers)>0)
                                        @foreach($orderUsers as $index => $orderUser)
                                            
                                            <tr id="item{{$orderUser->id}}">
                                                <td>{{$index+1 }}</td>
                                                <td> 
                                                    {{ $orderUser->name }} <br/>
                                                    {{ $orderUser->shipping_phone }} <br/>
                                                </td>
                                                <td style="width: 155px;"> {{ $orderUser->order_id }} <br>
                                                {{\Carbon\Carbon::parse($orderUser->order_date)->format(Config::get('siteSetting.date_format').' | '.'h:i A')}}
                                                </td>
                                               
                                                <td> {{  $orderUser->shipping_address. ', '.
                                                $orderUser->shipping_area. ', '.
                                                $orderUser->shipping_city. ', '.
                                                $orderUser->shipping_region }}
                                                </td>
                                                <td> 
                                                @if($orderUser->order_status == 'delivered')
                                                <span class="label label-success"> {{ str_replace('-', ' ', $orderUser->order_status)}} </span>

                                                @elseif($orderUser->order_status == 'accepted')
                                                <span class="label label-warning"> {{ str_replace('-', ' ', $orderUser->order_status)}} </span>

                                                @elseif($orderUser->order_status == 'ready-to-ship')
                                                <span class="label label-ready-ship"> {{ str_replace('-', ' ', $orderUser->order_status)}} </span>

                                                @elseif($orderUser->order_status == 'cancel')
                                                <span class="label label-danger"> {{ str_replace('-', ' ', $orderUser->order_status)}} </span>

                                                @elseif($orderUser->order_status == 'on-delivery')
                                                <span class="label label-primary"> {{ str_replace('-', ' ', $orderUser->order_status)}} </span>

                                                @else
                                                <span class="label label-info"> Pending </span>
                                                @endif
                                            </td>
                                            </tr>
                                           
                                            @endforeach
                                        @else <tr><td colspan="15">No Products Found.</td></tr>@endif
                                        
                                    </tbody>
                                </table>
                            </div>
                        
                        </div>
                    </div>
                </div>

                 <div class="row">
                   <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                       {{$orderUsers->appends(request()->query())->links()}}
                      </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing {{ $orderUsers->firstItem() }} to {{ $orderUsers->lastItem() }} of total {{$orderUsers->total()}} entries ({{$orderUsers->lastPage()}} Pages)</div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
       
        <!-- delete Modal -->
        @include('admin.modal.delete-modal')

@endsection
@section('js')

    <!-- This is data table -->
    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

    <!-- end - This is for export functionality only -->
    <script>
        $(".select2").select2();

        $(function () {
            $('#myTable').dataTable({
                "ordering": false,
                 "paging": false,"info":false
            });
        });
   
 

        // if occur error open model
        @if($errors->any())
            $("#{{Session::get('submitType')}}").modal('show');
        @endif
    </script>

@endsection
