@extends('vendors.partials.vendor-master')
@section('title', 'Payment Setting')
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
                        <h4 class="text-themecolor">Payment Setting</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center"></div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                               
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    @php $p = 1; @endphp
                                    @foreach($paymentgateways as $paymentgateway)
                                    <li class="nav-item"> <a class="nav-link @if($p == 1) active @endif" data-toggle="tab" href="#payment{{$paymentgateway->id}}" role="tab" aria-selected="true"><span class="hidden-sm-up"><img width="80" alt="{{ $paymentgateway->method_name }}" src="{{asset('upload/images/payment/'.$paymentgateway->method_logo)}}"> </span> </a> </li>
                                    @php $p++; @endphp
                                    @endforeach
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabcontent-border">
                                    @php $p = 1; @endphp
                                    @foreach($paymentgateways as $paymentgateway)

                                    <div class="tab-pane @if($p == 1) active @endif p-20" id="payment{{$paymentgateway->id}}" role="tabpanel">

                                        @if($paymentgateway->method_slug == 'bank')
                                        <form action="{{ route('vendor.paymentSetting') }}" method="post">
                                            @csrf 
                                            <input type="hidden" name="payment_id" value="{{$paymentgateway->id}}">
                                            <input type="hidden" name="id" @if($paymentgateway->paymentInfo)value="{{$paymentgateway->paymentInfo->id}}" @endif>
                                            {!!$paymentgateway->method_info!!}
                                            <div class="form-group row">
                                                <label class="col-md-2 text-right col-form-label" for="acc_name">Bank Account Name</label>
                                                <div class="col-md-8">
                                                    <input type="text" @if($paymentgateway->paymentInfo)value="{{$paymentgateway->paymentInfo->acc_name}}" @endif placeholder="Enter account name" name="acc_name" required="" id="acc_name" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2 text-right col-form-label" for="acc_no">Bank Account Number</label>
                                                <div class="col-md-8">
                                                    <input type="text" @if($paymentgateway->paymentInfo)value="{{$paymentgateway->paymentInfo->acc_no}}" @endif placeholder="Enter account number" name="acc_no" required="" id="acc_no" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2 text-right col-form-label" for="bank_name">Bank Name</label>
                                                <div class="col-md-8">
                                                    <input type="text" @if($paymentgateway->paymentInfo)value="{{$paymentgateway->paymentInfo->bank_name}}" @endif placeholder="Enter bank name" name="bank_name" required="" id="bank_name" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2 text-right col-form-label" for="branch_name">Branch Name</label>
                                                <div class="col-md-8">
                                                    <input type="text" @if($paymentgateway->paymentInfo)value="{{$paymentgateway->paymentInfo->branch_name}}" @endif placeholder="Enter branch name" name="branch_name" required="" id="branch_name" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2 text-right col-form-label" for="routing_no">Bank Routing Number</label>
                                                <div class="col-md-8">
                                                    <input type="text" @if($paymentgateway->paymentInfo)value="{{$paymentgateway->paymentInfo->routing_no}}" @endif placeholder="Enter routing number" name="routing_no" required="" id="routing_no" class="form-control" >
                                                </div>
                                            </div>
                                            @if($paymentgateway->paymentInfo)
                                            <div class="form-group row">
                                                <label class="col-md-2 text-right col-form-label" for="status">Status</label>
                                                <div class="col-md-8">
                                                   @if($paymentgateway->paymentInfo->status == 'active')
                                                   <span class="label label-success">{{$paymentgateway->paymentInfo->status }}</span>
                                                   @else
                                                   <span class="label label-danger">{{$paymentgateway->paymentInfo->status }}</span>
                                                   @endif
                                                </div>
                                            </div>
                                            @endif
                                            <div class="form-group row justify-content-md-center">
                                                <div class="col-md-8 pull-right">
                                                    <button type="submit" name="submit" value="save" class="btn btn-success"> <i class="fa fa-save"></i> {{$paymentgateway->method_name}} Setting</button>
                                                   
                                                    <button type="reset" class="btn waves-effect waves-light btn-secondary">Reset</button>
                                                </div>
                                            </div>
                                        </form>

                                        @elseif($paymentgateway->method_slug == 'bkash' || $paymentgateway->method_slug == 'rocket')
                                        <form action="{{ route('vendor.paymentSetting') }}" method="post">
                                            @csrf 
                                            <input type="hidden" name="payment_id" value="{{$paymentgateway->id}}">
                                            <input type="hidden" name="id" @if($paymentgateway->paymentInfo)value="{{$paymentgateway->paymentInfo->id}}" @endif>
                                            {!!$paymentgateway->method_info!!}
                                            <div class="form-group row">
                                                <label class="col-md-2 text-right col-form-label" for="acc_name"> Account Name</label>
                                                <div class="col-md-8">
                                                    <input type="text" @if($paymentgateway->paymentInfo)value="{{$paymentgateway->paymentInfo->acc_name}}" @endif placeholder="Enter account name" name="acc_name" required="" id="acc_name" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2 text-right col-form-label" for="acc_no"> Account Number</label>
                                                <div class="col-md-8">
                                                    <input type="text" @if($paymentgateway->paymentInfo)value="{{$paymentgateway->paymentInfo->acc_no}}" @endif placeholder="Enter account number" name="acc_no" required="" id="acc_no" class="form-control" >
                                                </div>
                                            </div>
                                            @if($paymentgateway->paymentInfo)
                                            <div class="form-group row">
                                                <label class="col-md-2 text-right col-form-label" for="status">Status</label>
                                                <div class="col-md-8">
                                                   @if($paymentgateway->paymentInfo->status == 'active')
                                                   <span class="label label-success">{{$paymentgateway->paymentInfo->status }}</span>
                                                   @else
                                                   <span class="label label-danger">{{$paymentgateway->paymentInfo->status }}</span>
                                                   @endif
                                                </div>
                                            </div>
                                            @endif
                                            <div class="form-group row justify-content-md-center">
                                                <div class="col-md-8 pull-right">
                                                    <button type="submit" name="submit" value="save" class="btn btn-success"> <i class="fa fa-save"></i> {{$paymentgateway->method_name}} Setting</button>
                                                   
                                                    <button type="reset" class="btn waves-effect waves-light btn-secondary">Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                        @else

                                        <form action="{{ route('vendor.paymentSetting') }}" method="post">
                                            @csrf 
                                            <input type="hidden" name="payment_id" value="{{$paymentgateway->id}}">
                                            <input type="hidden" name="id" @if($paymentgateway->paymentInfo)value="{{$paymentgateway->paymentInfo->id}}" @endif>
                                            {!!$paymentgateway->method_info!!}
                                            <div class="form-group row">
                                                <label class="col-md-2 text-right col-form-label" for="acc_name"> Account Name</label>
                                                <div class="col-md-8">
                                                    <input type="text" @if($paymentgateway->paymentInfo)value="{{$paymentgateway->paymentInfo->acc_name}}" @endif placeholder="Enter account name" name="acc_name" required="" id="acc_name" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2 text-right col-form-label" for="acc_no"> Account Number</label>
                                                <div class="col-md-8">
                                                    <input type="text" @if($paymentgateway->paymentInfo)value="{{$paymentgateway->paymentInfo->acc_no}}" @endif placeholder="Enter account number" name="acc_no" required="" id="acc_no" class="form-control" >
                                                </div>
                                            </div>
                                            @if($paymentgateway->paymentInfo)
                                            <div class="form-group row">
                                                <label class="col-md-2 text-right col-form-label" for="status">Status</label>
                                                <div class="col-md-8">
                                                   @if($paymentgateway->paymentInfo->status == 'active')
                                                   <span class="label label-success">{{$paymentgateway->paymentInfo->status }}</span>
                                                   @else
                                                   <span class="label label-danger">{{$paymentgateway->paymentInfo->status }}</span>
                                                   @endif
                                                </div>
                                            </div>
                                            @endif
                                            <div class="form-group row justify-content-md-center">
                                                <div class="col-md-8 pull-right">
                                                    <button type="submit" name="submit" value="save" class="btn btn-success"> <i class="fa fa-save"></i> Update Setting</button>
                                                   
                                                    <button type="reset" class="btn waves-effect waves-light btn-secondary">Reset</button>
                                                </div>
                                            </div>
                                        </form>

                                        @endif
                                    </div>
                                    @php $p++; @endphp
                                    @endforeach
                                    
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
  
    @endsection
 