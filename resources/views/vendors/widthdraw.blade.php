@extends('vendors.partials.vendor-master')
@section('title', 'Withdraw History')
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
                        <h4 class="text-themecolor">Withdraw History</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">

                            <button data-toggle="modal" data-target="#withdraw_request" class="btn btn-info d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Send Withdraw Request</button>
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
                                <a href="javscript:void(0)" class="link display-5 ml-auto">{{Config::get('siteSetting.currency_symble'). $total}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Widthraw</h5>
                            <div class="d-flex  no-block align-items-center">
                                <span class="display-5 text-info"><i class="fa fa-donate"></i></span>
                                <a href="javscript:void(0)" class="link display-5 ml-auto">{{Config::get('siteSetting.currency_symble'). $withdraw_amount}}</a>
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
                                <a href="javscript:void(0)" class="link display-5 ml-auto">{{Config::get('siteSetting.currency_symble'). ($total - $withdraw_amount)}}</a>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-md-3">
                    <div class="card" data-toggle="modal" data-target="#withdraw_request">
                        <div class="card-body " style="text-align: center;cursor: pointer;">
                            
                            <div class="align-items-center">
                                <span class="display-5 text-warning"><i class="fa fa-plus-circle"></i></span>
                            </div>
                            <h5 class="card-title">Send Withdraw Request</h5>
                        </div>
                    </div>
                    </div>
                </div>


                <div class="row">
                   
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    
                                    <div class="table-responsive">
                                       <table id="config-table" class="table display table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Withdraw Date</th>
                                                    <th>Payment Method</th>
                                                    <th>Amount</th>
                                                    <th>Details</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            @if(count($allwithdraws)>0)
                                                @foreach($allwithdraws as $withdraw)
                                                <tr>
                                                   <td>{{\Carbon\Carbon::parse($withdraw->created_at)->format(Config::get('siteSetting.date_format'))}}
                                                   ({{\Carbon\Carbon::parse($withdraw->created_at)->diffForHumans()}})
                                                   </td>
                                                    <td>@if($withdraw->paymentGateway){{$withdraw->paymentGateway->method_name}} 
                                                    <br/>
                                                    @else
                                                    {{$withdraw->payment_method}}
                                                     <br/>
                                                    @endif
                                                   
                                                    @if($withdraw->account_no) Account no : {{$withdraw->account_no}} <br/> @endif
                                                    @if($withdraw->transaction_details) {{$withdraw->transaction_details}} @endif
                                                    </td>
                                                    <td> <span class="label label-info">{{Config::get('siteSetting.currency_symble'). $withdraw->amount }}</span></td>
                                                     <td>{{$withdraw->notes }}</td>
                                                   
                                                    <td>@if($withdraw->status == 'paid') <span class="label label-success"> {{$withdraw->status}}</span> @elseif($withdraw->status == 'cancel') <span class="label label-danger"> {{$withdraw->status}} </span> @else <span class="label label-info"> {{$withdraw->status}} </span> @endif</td>
                                                </tr>
                                               @endforeach
                                            @else <tr><td colspan="8"> <h1>No Withdraw found.</h1></td></tr>@endif

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
    <!-- add Modal -->
        <div class="modal fade" id="withdraw_request" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Send Withdraw Request</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <form action="{{route('vendor.withdrawRequest')}}" data-parsley-validate method="POST" >
                                {{csrf_field()}}
                                <div class="form-body">
                                   
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="method_name">Withdraw Amount</label>
                                                <input required="" name="amount" id="amount" value="{{old('amount')}}" type="text" placeholder="Minimun withdraw {{Config::get('siteSetting.currency_symble')}}50" class="form-control">
                                                 <i style="color: red">Minimun withdraw amount {{Config::get('siteSetting.currency_symble')}}50</i>
                                                @if ($errors->has('amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('amount') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="required" for="payment_method">Withdrawal Method</label>
                                            <select id="payment_method" name="payment_method" required="" class="form-control select2 m-b-10" style="width: 100%" >
                                                <option value="">Select Withdrawal Method</option>
                                             @foreach($paymentGateways as $paymentgateway)
                                                <option @if(old('payment_method') == $paymentgateway->id) selected @endif value="{{$paymentgateway->id}}">{{$paymentgateway->method_name}}</option>
                                                @endforeach
                                            </select>
                                             @if ($errors->has('payment_method'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('payment_method') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="AccountNumber">
                                        
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="details">Notes</label>
                                            <textarea rows="1" name="notes" id="notes"  style="resize: vertical;" placeholder="Write your notes" class="form-control">{{old('notes')}}</textarea>
                                        </div>
                                    </div>
                                     
                                        <div class="col-md-12">
                                            
                                            <div class="modal-footer">
                                                <button type="submit" name="submitType" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Send Request</button>
                                                
                                            </div>
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
         $("#payment_method").change(function(){
            var account_no = '';
            if(this.value){
                var method_name = $("#payment_method option:selected").text();
                account_no =  `<div class="form-group">
                    <label class="required" for="account_no">`+ method_name+` account number</label>
                    <input type="text" value="{{old('account_no')}}" required name="account_no" id="account_no"  placeholder="Enter account number" class="form-control">
                     @if ($errors->has('account_no'))
                    <span class="invalid-feedback" role="alert">
                        {{ $errors->first('account_no') }}
                    </span>
                    @endif
                </div>`;
            }
            document.getElementById('AccountNumber').innerHTML = account_no;
        });
    </script>
    @endsection
 