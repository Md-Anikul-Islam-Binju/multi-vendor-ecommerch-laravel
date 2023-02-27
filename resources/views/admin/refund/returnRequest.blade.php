@extends('layouts.admin-master')
@section('title', 'Order Return Request')
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">

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
                        <h4 class="text-themecolor">Return Request List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Return Request</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <a href="{{ route('returnReason') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Add Request Reason </a>
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
                    <div class="col-12">
                    <form action="{{route('admin.refundRequest')}}" method="get">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Refund Status  </label>
                                <select name="status" class="form-control">
                                    <option value="all" {{ (Request::get('status') == "all") ? 'selected' : ''}}>All</option>
                                    <option value="pending" {{ (Request::get('status') == 'approved') ? 'selected' : ''}} >Pending</option>
                                    <option value="approved" {{ (Request::get('status') == 'approved') ? 'selected' : ''}}>Approved</option>
                                   
                                    <option value="reject" {{ (Request::get('status') == 'reject') ? 'selected' : ''}}>Reject</option>
                                    
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
                    </form>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                          <tr>
                                            <td class="text-left">Order Id</td>
                                            <td class="text-center">Date</td>
                                            <td class="text-left">Product</td>
                                            <td class="text-left">Customer</td>
                                            <td class="text-center">Return Type</td>
                                            <td class="text-center">Return Reason</td>
                                            <td class="text-center">Status</td>
                                           
                                            <td class="text-center"></td>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($returnRequests as $returnRequest)                   
                                          <tr>
                                            <td class="text-center">{{$returnRequest->order_id}}</td>
                                             <td>{{Carbon\Carbon::parse($returnRequest->created_at)->format('d M, Y h:m:i A')}}</td>
                                            <td class="text-left">
                                              <img width="50" src="{{ asset('upload/images/product/thumb/'.$returnRequest->feature_image) }}">
                                               <a href="{{route('product_details', $returnRequest->slug)}}">{{Str::limit($returnRequest->title, 50)}}</a>
                                                @if($returnRequest->attributes)<br>
                                                  @foreach(json_decode($returnRequest->attributes) as $key=>$value)
                                                  <small> {{$key}} : {{$value}} </small>
                                                  @endforeach
                                                @endif
                                            </td>
                                            <td class="text-center">{{$returnRequest->name}}</td>
                                            <td class="text-center">{{$returnRequest->return_type}}</td>
                                            <td class="text-center"> {{$returnRequest->return_reason}} </td>
                                            <td class="text-center" style="width: 90px;"> 
                                              @if($returnRequest->refund_status == 'approved')
                                              <span class="label label-success">Approved</span>
                                              @elseif($returnRequest->refund_status == 'reject')
                                               <span class="label label-danger">Reject</span>
                                              @else
                                              <span class="label label-info">Pending</span>
                                              @endif
                                            </td>
                                           
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-defualt dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu">

                                                        <a href="{{ route('admin.refundRequestDetails', $returnRequest->id)}}"  title="View refund details" data-toggle="tooltip" class="dropdown-item" ><i class="ti-eye"></i> Refund Details</a>
                                                        @if($returnRequest->refund_status == 'pending')
                                                        <span title="Approved Refund" data-toggle="tooltip">
                                                            <button data-target="#refundRequestApproved"  data-toggle="modal" class="dropdown-item" onclick="refundRequestApproved('{{ route("admin.refundRequestApproved", [$returnRequest->id, "approved"]) }}' )"><i class="fa fa-check"></i> Approved Refund</button>
                                                        </span> 

                                                        <span title="Reject Refund" data-toggle="tooltip">
                                                            <button data-target="#refundRequestApproved"  data-toggle="modal" class="dropdown-item" onclick="refundRequestApproved('{{ route("admin.refundRequestApproved", [$returnRequest->id, "reject"]) }}')"><i class="fa fa-times"></i> Reject Refund</button>
                                                        </span>
                                                        @endif

                                                        <a class="dropdown-item" href="{{route('admin.orderInvoice', $returnRequest->order_id)}}" class="text-inverse" title="View Order Invoice" data-toggle="tooltip"><i class="ti-printer"></i> Order Invoice</a>
                                                    </div>
                                                </div>
                                            </td>
                                          </tr>
                                         @endforeach
                                        </tbody>
                                      
                                        </table>
                                </div>
                            </div>
                        </div>

                    </div>
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
        <div id="refundRequestApproved" class="modal fade">
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
                        <p>Do you really want to change status?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                        <a href="" id="refundRoute" class="btn btn-danger" style="color: #fff">Confirm</a>
                    </div>
                </div>
            </div>
        </div>
        
@endsection
@section('js')
    <!-- This is data table -->
    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
   <script>
        $(function () {
            $('#myTable').DataTable({"ordering": false});
        });

        function refundRequestApproved(route) {
            $("#refundRoute").attr("href", route);
        }

    </script>




@endsection
