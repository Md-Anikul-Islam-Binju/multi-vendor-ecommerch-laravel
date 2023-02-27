@extends('layouts.admin-master')
@section('title', 'Withdraw Request')
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <!-- page CSS -->
    <link href="{{asset('assets')}}/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <style type="text/css">
        p{margin-bottom: 0px;}
       
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
                        <h4 class="text-themecolor">Withdraw Request</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">

                            <a  href="{{route('customerWalletHistory')}}" class="btn btn-info d-lg-block m-l-15"><i class="fa fa-eye"></i> All Transaction</a>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
             
                <div class="row">
                    @php 
                    $paid = $cancel = $pending = $accepted = 0;
                   
                    foreach($withdraw_status as $withdraw){
                        if($withdraw->status == 'pending'){ $pending +=1 ; }
                        if($withdraw->status == 'accepted'){ $accepted +=1 ; }
                        if($withdraw->status == 'paid'){ $paid +=1 ; }
                        if($withdraw->status == 'cancel'){ $cancel +=1 ; }
                    }
                    $all = $pending+$paid+$cancel;

                    @endphp
                    <!-- Column -->
                    <div class="col-md-2 col-6">
                    <div class="card">
                        <div class="card-body" style="padding: 20px 5px">
                            <h5 class="card-title">Available Wallet</h5>
                            <div class="">
                                <a href="javscript:void(0)" class="link display-5 ml-auto">{{Config::get('siteSetting.currency_symble'). $availableBalance}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-2 col-6">
                    <div class="card">
                        <div class="card-body" style="padding:20px 5px">
                            <h5 class="card-title">Total Commission</h5>
                            <div>
                                
                                <a href="{{route('customerWithdrawRequest')}}" class="link display-5 ml-auto">{{Config::get('siteSetting.currency_symble').$commission}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-2 col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pending</h5>
                            <div class="d-flex  no-block align-items-center">
                                <span class="display-5 text-info"><i class="fa fa-donate"></i></span>
                                <a href="{{route('customerWithdrawRequest')}}?status=pending" class="link display-5 ml-auto">{{$pending}}</a>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-md-2 col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Accepted</h5>
                            <div class="d-flex  no-block align-items-center">
                                <span class="display-5 text-primary"><i class="fa fa-donate"></i></span>
                                <a href="{{route('customerWithdrawRequest')}}?status=accepted" class="link display-5 ml-auto">{{Config::get('siteSetting.currency_symble'). $accepted}}</a>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-md-2 col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Complete</h5>
                            <div class="d-flex  no-block align-items-center">
                                <span class="display-5 text-success"><i class="fa fa-donate"></i></span>
                                <a href="{{route('customerWithdrawRequest')}}?status=paid" class="link display-5 ml-auto">{{Config::get('siteSetting.currency_symble'). $paid}}</a>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-md-2 col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Cancel</h5>
                            <div class="d-flex  no-block align-items-center">
                                <span class="display-5 text-danger"><i class="fa fa-donate"></i></span>
                                <a href="{{route('customerWithdrawRequest')}}?status=cancel" class="link display-5 ml-auto">{{Config::get('siteSetting.currency_symble'). $cancel}}</a>
                            </div>
                        </div>
                    </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" style="margin-bottom: 2px;">

                            <form action="{{route('customerWithdrawRequest')}}" method="get">

                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row">
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Customer name or mobile or email</label>
                                                    <input name="name" value="{{ Request::get('name')}}" type="text" placeholder="Enter name or mobile or email" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Status  </label>
                                                    <select name="status" class="form-control">
                                                        <option value="">Select Status</option>
                                                        <option value="pending" {{ (Request::get('status') == 'pending') ? 'selected' : ''}} >Pending</option>
                                                        <option value="accepted" {{ (Request::get('status') == 'accepted') ? 'selected' : ''}} >Accepted</option>
                                                       
                                                        <option value="paid" {{ (Request::get('status') == 'paid') ? 'selected' : ''}}>Paid</option>
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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    
                                    <div class="table-responsive">
                                       <table id="config-table" class="table display table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Customer</th>
                                                    <th>Amount</th>
                                                    <th>Commission</th>
                                                    <th>Payment Info</th>
                                                    <th>Notes</th>
                                                    <th>Added By</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            @if(count($allwithdraws)>0)
                                                @foreach($allwithdraws as $index => $withdraw)
                                                <tr>
                                                    <td>{{(($allwithdraws->perPage() * $allwithdraws->currentPage() - $allwithdraws->perPage()) + ($index+1) )}}</td>
                                                   <td>
                                                    @if($withdraw->customer)<a title="View Customer Profile" data-toggle="tooltip" href="{{ route('customer.profile', $withdraw->customer->username) }}">{{$withdraw->customer->name }} </a><br/>@endif
                                                    {{\Carbon\Carbon::parse($withdraw->created_at)->format(Config::get('siteSetting.date_format'))}}
                                                   ({{\Carbon\Carbon::parse($withdraw->created_at)->diffForHumans()}})
                                                   </td>
                                                   
                                                    <td>
                                                     <span class="label label-info">
                                                      {{Config::get('siteSetting.currency_symble').  str_replace('+', '', $withdraw->amount) }}</span>
                                                    
                                                    </td>
                                                     <td>{{ Config::get('siteSetting.currency_symble'). $withdraw->commission }}</td>
                                                     <td>@if($withdraw->paymentGateway){{$withdraw->paymentGateway->method_name}} 
                                                    <br/>
                                                    @else
                                                    {{$withdraw->payment_method}}
                                                     <br/>
                                                    @endif
                                                   
                                                    @if($withdraw->account_no) Account no : {{$withdraw->account_no}} <br/> @endif
                                                    @if($withdraw->transaction_details) {{$withdraw->transaction_details}} @endif
                                                    </td>
                                                     <td>{{ $withdraw->notes }}</td>
                                                     <td> {{ ($withdraw->addedBy) ? $withdraw->addedBy->name : 'customer' }}</td>
                                                   
                                                    <td>@if($withdraw->status == 'paid') <span class="label label-success"> {{$withdraw->status}}</span> @elseif($withdraw->status == 'cancel') <span class="label label-danger"> {{$withdraw->status}} </span> @elseif($withdraw->status == 'received') <span class="label label-primary"> {{$withdraw->status}} </span> @else <span class="label label-info"> {{$withdraw->status}} </span> @endif</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-defualt btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="ti-settings"></i>
                                                            </button>
                                                            <div class="dropdown-menu">

                                                                <a href="javascript:void(0)" class="dropdown-item" onclick="withdrawMakePaymentPopup('{{ route("admin.withdrawMakePaymentDetails", $withdraw->id)}}')" title="Make Withdraw Payment" data-toggle="tooltip" class="text-inverse p-r-10" >{{config('siteSetting.currency_symble')}} Make payment</a>
                                                              

                                                                <a onclick="withdrawHistory('{{ route("admin.getWithdrawHistory", $withdraw->customer_id) . '?customer='. $withdraw->customer_id }}')" class="dropdown-item" href="javascript:void(0)" class="text-inverse" title="View Withdraw History" data-toggle="tooltip"><i class="ti-eye"></i> Withdraw History</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                               @endforeach
                                            @else <tr><td colspan="8"> <h1>No withdraw found.</h1></td></tr>@endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <div class="row">
                   <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                       {{$allwithdraws->appends(request()->query())->links()}}
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing {{ $allwithdraws->firstItem() }} to {{ $allwithdraws->lastItem() }} of total {{$allwithdraws->total()}} entries ({{$allwithdraws->lastPage()}} Pages)</div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>

        <div class="modal bs-example-modal-lg" id="withdrawDetails" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Withdraw History</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body" id="getWithdrawDetails"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal bs-example-modal-lg" id="withdrawMakePaymentModal"  aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Withdraw request payment status</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body" id="withdrawMakePaymentDetails"></div>
                    
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endsection

    @section('js')
        <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
 
    <script src="{{asset('assets')}}/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    
    <script>
        $(function () {
      
            $('.selectpicker').selectpicker();
            
        });

   
        function withdrawHistory(url){
            $('#getWithdrawDetails').html('<div class="loadingData"></div>');
            $('#withdrawDetails').modal('show');
            
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#getWithdrawDetails").html(data);
                    }
                }
            });
        }
    function withdrawMakePaymentPopup(link){
        $('#withdrawMakePaymentModal').modal('show');
        $('#withdrawMakePaymentDetails').html('<div class="loadingData"></div>');
        $.ajax({
            url:link,
            method:"get",
            success:function(data){
                
                $('#withdrawMakePaymentDetails').html(data);
                
            }
        });
    }

    $("#withdrawMakePfsdaymentForm").submit(function(e){
        e.preventDefault();
        var status = $('#withdrawMakePaymentDetails, #status').val();
        if (confirm("Are you sure "+status+ " this withdraw.?")) {

            var link = '{{route("admin.changeWithdrawStatus")}}';
            var withdraw_id = $('#withdrawMakePaymentDetails, #withdraw_id').val();
            var transaction_details= $('#withdrawMakePaymentDetails, #transaction_details').val();
            
            $.ajax({
                url:link,
                method:"get",
                data:{'status': status,'transaction_details':transaction_details, 'withdraw_id': withdraw_id},
                success:function(data){
                    if(data.status){
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }
                    location.reload();
                }

            });
        }
        return false;
    });
    </script>
    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
        <script>
    // responsive table
        $('#config-table').DataTable({
            responsive: true, searching: false, paging: false, info: false, ordering: false
        });
    </script>

    @endsection
 