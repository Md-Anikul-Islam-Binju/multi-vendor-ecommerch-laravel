@extends('vendors.partials.vendor-master')
@section('title', 'Transaction History')
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
                        <h4 class="text-themecolor">Transaction History</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">


                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <div class="row">
                    
                    <!-- Column -->
                    <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Balance</h5>
                            <div class="d-flex  no-block align-items-center">
                                <span class="display-5 text-purple"><i class="fa fa-donate"></i></span>
                                <a href="javscript:void(0)" class="link display-5 ml-auto">{{Config::get('siteSetting.currency_symble').$total}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Widthraw Amount</h5>
                            <div class="d-flex  no-block align-items-center">
                                <span class="display-5 text-info"><i class="fa fa-donate"></i></span>
                                <a href="javscript:void(0)" class="link display-5 ml-auto">{{Config::get('siteSetting.currency_symble'). $withdraw}}</a>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Available Withdrawal</h5>
                            <div class="d-flex  no-block align-items-center">
                                <span class="display-5 text-success"><i class="fa fa-donate"></i></span>
                                <a href="javscript:void(0)" class="link display-5 ml-auto">{{Config::get('siteSetting.currency_symble'). ($total - $withdraw)}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pending Amount</h5>
                            <div class="d-flex  no-block align-items-center">
                                <span class="display-5 text-danger"><i class="fa fa-donate"></i></span>
                                <a href="javscript:void(0)" class="link display-5 ml-auto">0</a>
                            </div>
                        </div>
                    </div>
                    </div>

                </div>
               
                <div class="row">
                   
                    <!-- Column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    
                                    <div class="table-responsive">
                                       <table id="config-table" class="table display table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Transaction Date</th>
                                                    <th>Transaction Type</th>
                                                    <th>Transaction Number</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>


                                                @if(count($transactions)>0)
                                                    @foreach($transactions as $transaction)
                                                    <tr>
                                                       <td>{{\Carbon\Carbon::parse($transaction->created_at)->format(Config::get('siteSetting.date_format'))}}
                                                       ({{\Carbon\Carbon::parse($transaction->created_at)->diffForHumans()}})
                                                       </td>
                                                        <td>{{$transaction->type}}</td>
                                                        <td>{!!($transaction->item_id) ? $transaction->item_id : '<span style="color:red;"> Pending</span>' !!}</td>
                                                        <td> <span class="label label-primary">{{Config::get('siteSetting.currency_symble'). $transaction->grand_total }}</span></td>
                                                       
                                                       <td>@if($transaction->status == 'paid') <span class="label label-success"> {{$transaction->status}}</span> @elseif($transaction->status == 'cancel') <span class="label label-danger"> {{$transaction->status}} </span> @else <span class="label label-info"> {{$transaction->status}} </span> @endif</td>
                                                    </tr>
                                                   @endforeach
                                                @else <tr><td colspan="8"> <h1>No transaction found.</h1></td></tr> @endif

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
                       {{$transactions->appends(request()->query())->links()}}
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of total {{$transactions->total()}} entries ({{$transactions->lastPage()}} Pages)</div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
   
    @endsection
 