@extends('layouts.admin-master')
@section('title', $reseller->shop_name.' | Profile')
@section('css')

    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <link href="{{asset('assets')}}/node_modules/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
    <link href="{{asset('css')}}/pages/bootstrap-switch.css" rel="stylesheet">

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
                                <li class="breadcrumb-item"><a href="javascript:void(0)">vendor</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                            <a href="{{route('vendor.list')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-angle-left"></i> Back</a>
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
                                <center> <img src="{{asset('upload/vendors')}}/{{( $reseller->logo) ? $reseller->logo : 'default.png'}}" class="img-circle" width="150" />
                                    <h4 class="card-title m-t-10">{{$reseller->shop_name}}</h4>
                                    <h6 class="card-subtitle">{{$reseller->shop_dsc}}</h6>
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-6"><a title="User status" href="javascript:void(0)" class="link"><i class="fa fa-check"></i> <font class="font-medium">{{($reseller->status == 1) ? 'Active' : 'Deactive'}} </font></a></div>
                                        <div class="col-6"><a title="Total Tickets " href="javascript:void(0)" class="link"><i class="fa fa-clipboard-list"></i> <font class="font-medium">{{Config::get('siteSetting.currency_symble'). $reseller->balance}}</font></a></div>
                                    </div>
                                </center>
                                <hr/>
                                <small class="text-muted">Mobile</small>
                                <h6>{{$reseller->mobile}}</h6> 
                                <small class="text-muted">Email</small>
                                <h6>{{$reseller->email}}</h6> 

                                <small class="text-muted">Member Since </small>
                                <h6>{{Carbon\Carbon::parse($reseller->created_at)->format(Config::get('siteSetting.date_format'))}}</h6> 
                                <small class="text-muted p-t-30 db">Birthday</small>
                                <h6>{{ Carbon\Carbon::parse($reseller->birthday)->format(Config::get('siteSetting.date_format'))}}</h6> 
                                <p> @if($reseller->gender) Gender: {{ $reseller->gender }} @endif 
                                    @if($reseller->blood)  Blood: {{ $reseller->blood }} @endif
                                </p>
                                <small class="text-muted p-t-30 db">Address</small>
                                <h6>{{ $reseller->address }} 
                                    @if($reseller->get_area){{ $reseller->get_area->name}} @endif
                                    @if($reseller->get_city) {{$reseller->get_city->name}} @endif
                                    @if($reseller->get_state){{ $reseller->get_state->name }} @endif</h6>
                                
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
                            
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#products" role="tab"><i class="fa fa-user"></i> Products</a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#orders" role="tab"><i class="fa fa-user"></i> Order</a> </li>
                               <!--  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab"> <i class="fa fa-chart-line"></i> Reports</a> </li> -->
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="products" role="tabpanel">
                                    <div class="card-body">
                                        <label class="title_head">
                                            Products
                                        </label>
                                        <div class="row">
                                            
                                            <div class="col-md-12 col-xs-6 b-r">
                                                <div class="table-responsive">
                                                   <table  class="table display table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>Category</th>
                                                                <th>Stock</th>
                                                                <th>Sales</th>
                                                                <th>Price</th>
                                                                <th>Approved</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>


                                                            @if(count($products)>0)
                                                                
                                                                @foreach($products as $product)
                                                                <tr>
                                                                    <td><a target="_blank" href="{{ route('product_details', $product->slug) }}"> <img src="{{asset('upload/images/product/thumb/'.$product->feature_image)}}" alt="Image" width="50"> {{Str::limit($product->title, 40)}}</a> </td>
                                                                   <td>{{$product->get_category->name}}</td>

                                                                    <td>{{($product->stock) ? $product->stock : 0 }}</td>
                                                                    <td>{{ $product->sales }}</td>
                                                                    <td>{{Config::get('siteSetting.currency_symble')}}{{$product->purchase_price}}</td>
                                                                    <td>
                                                                        <div class="bt-switch">
                                                                            <input  onchange="approveUnapprove('products', '{{$product->id}}')" type="checkbox" {{($product->status != 'unapprove') ? 'checked' : ''}} data-on-color="success" data-off-color="danger" data-on-text="InApproved" data-off-text="UnApproved"> 
                                                                       
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                    <div class="btn-group">
                                                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            Action
                                                                        </button>
                                                                        <div class="dropdown-menu">
                                                                            <a target="_blank" class="dropdown-item text-inverse" title="View product" data-toggle="tooltip" href="{{ route('product_details', $product->slug) }}"><i class="ti-eye"></i> View Product</a>
                                                                            <a class="dropdown-item" title="Edit product" data-toggle="tooltip" href="{{ route('admin.product.edit', $product->slug) }}"><i class="ti-pencil-alt"></i> Edit</a>
                                                                           
                                                                            <a title="Highlight product (Ex. Best Seller, Top Rated etc.)" onclick="producthighlight({{ $product->id }})" class="dropdown-item"  href="javascript:void(0)"><i class="ti-pin-alt"></i> Highlight</a>
                                                                           
                                                                            <span title="Delete" data-toggle="tooltip"><button   data-target="#delete" onclick='deleteConfirmPopup("{{route("admin.product.delete", $product->id)}}")'  data-toggle="modal" class="dropdown-item" ><i class="ti-trash"></i> Delete Product</button></span>
                                                                        </div>
                                                                    </div>                                                  
                                                                    </td>

                                                                </tr>
                                                               @endforeach
                                                            @else <tr><td colspan="8"> <h1>No products found.</h1></td></tr> @endif

                                                        </tbody>
                                                    </table>

                                                  
                                                </div>
                                            </div>
                                            
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane" id="orders" role="tabpanel">
                                    <div class="card-body">
                                        <label class="title_head">
                                            Order list
                                        </label>
                                        <div class="row">
                                            
                                            <div class="col-md-12 col-xs-6 b-r">
                                                <div class="table-responsive">
                                                   <table class="table display table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Order ID</th>
                                                                <th>Order Date</th>
                                                                <th>Qty</th>
                                                                <th>Total</th>
                                                                <th>Payment Method</th>
                                                                <th>Delivery Status</th>
                                                               
                                                            </tr>
                                                        </thead>
                                                        <tbody>


                                                            @if(count($orders)>0)
                                                                @foreach($orders as $order)
                                                                <tr>
                                                                    <td>{{$order->order_id}}</td>
                                                                   <td>{{\Carbon\Carbon::parse($order->created_at)->format(Config::get('siteSetting.date_format'))}}
                                                                    <p style="font-size: 12px;margin: 0;padding: 0">{{\Carbon\Carbon::parse($order->created_at)->diffForHumans()}}</p>
                                                                   </td>
                                                                   <td>{{ $order->quantity }}</td>
                                                                    <td>{{$order->currency_sign . ($order->total_price)  }}</td>

                                                                   
                                                                    <td> <span class="label label-{{($order->payment_method=='pending') ? 'danger' : 'success' }}">{{ str_replace( '-', ' ', $order->payment_method) }}</span>
                                                                    @if($order->payment_info)
                                                                    <br/><strong>Tnx_id:</strong> <span> {{$order->tnx_id}}</span><br/>
                                                                    <span><strong>Info:</strong> {{$order->payment_info}}</span>
                                                                    @endif
                                                                    </td>
                                                                    <td> 
                                                                        @if($order->shipping_status == 'delivered')
                                                                        <span class="label label-success"> {{ str_replace('-', ' ', $order->shipping_status)}} </span>@elseif($order->shipping_status == 'accepted')
                                                                        <span class="label label-warning"> {{ str_replace('-', ' ', $order->shipping_status)}} </span>
                                                                        @elseif($order->shipping_status == 'cancel')
                                                                        <span class="label label-danger"> {{ str_replace('-', ' ', $order->shipping_status)}} </span>
                                                                        @elseif($order->shipping_status == 'ready-to-ship')
                                                                        <span class="label label-primary"> {{ str_replace('-', ' ', $order->shipping_status)}} </span>
                                                                        @else
                                                                        <span class="label label-info"> Pending </span>
                                                                        @endif
                                                                    </td>

                                                                </tr>
                                                               @endforeach
                                                            @else <tr><td colspan="8"> <h1>No orders found.</h1></td></tr> @endif

                                                        </tbody>
                                                    </table>
                                                    <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                                                           {{$orders->appends(request()->query())->links()}}
                                                          </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of total {{$orders->total()}} entries ({{$orders->lastPage()}} Pages)</div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>

                                    </div>
                                </div>
                                
                                <div class="tab-pane" id="settings" role="tabpanel">
                                    
                                    
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
        <!-- HightLight Modal -->
     
        <div class="modal fade" id="producthighlight_modal" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Hightlight Product</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            
                            <div class="form-body">
                               <div id="highlight_form"></div>
                               
                            </div>

                        </div>
                    </div>
                </div>
            </div>
          </div>
        
        @include('admin.modal.delete-modal')
@endsection

@section('js')
    <script type="text/javascript">
        function order_details(id){
            $('#order_details').html('<div class="loadingData"></div>');
            $('#getOrderDetails').modal('show');
           
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


        function producthighlight(id){
        $('#highlight_form').html('<div class="loadingData"></div>');
        $('#producthighlight_modal').modal('show');
        var  url = '{{route("product.highlight", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#highlight_form").html(data);
                }
            },
            // $ID = Error display id name
            @include('common.ajaxError', ['ID' => 'highlight_form'])

        });
    }

        //change status by id
        function highlightAddRemove(section_id, product_id){
            var  url = '{{route("highlightAddRemove")}}';
            $.ajax({
                url:url,
                method:"get",
                data:{section_id:section_id, product_id:product_id},
                success:function(data){
                    if(data.status){
                        toastr.success(data.msg);
                    }else{
                        toastr.error(data.msg);
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
     <!-- bt-switch -->
    <script src="{{asset('assets')}}/node_modules/bootstrap-switch/bootstrap-switch.min.js"></script>
    <script type="text/javascript">
    $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();
    var radioswitch = function() {
        var bt = function() {
            $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioState")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", !1)
            })
        };
        return {
            init: function() {
                bt()
            }
        }
    }();
    $(document).ready(function() {
        radioswitch.init()
    });
    </script>


@endsection

