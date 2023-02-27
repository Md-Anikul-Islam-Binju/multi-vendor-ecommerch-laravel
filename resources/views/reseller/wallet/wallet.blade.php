@extends('layouts.frontend')
@section('title', 'Wallet History | '. Config::get('siteSetting.site_name') )
@section('css')
   	<link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <style type="text/css">
    #content .card{border-radius: 5px; border: 1px solid #ccc;margin-bottom: 5px;}
    	.form-group { margin-bottom: 5px; }
    .icon-box i{font-size: 4rem}
    .ml-auto, .mx-auto {
        margin-left: auto!important;
    }
    .label-default{background: #fff;}
    .user-box{padding: 10px; text-align: center;   margin-bottom: 10px;}
    .card-title, .icon-box{color: #000}
    .user-box a{    font-size: 2rem !important; color: #000}
    #user-dashboard{padding-top: 15px;}
    #user-dashboard section{background: #fff;margin-bottom: 10px;padding: 10px 0;}
    </style>
@endsection
@section('content')
	@php $withdrawStatus = App\Models\SiteSetting::where('type', 'customer_withdraw_configure')->where('status', 1)->first(); @endphp
	<div class="breadcrumbs">
	  <div class="container">
	      <ul class="breadcrumb-cate">
	          <li><a href="{{url('/')}}"><i class="fa fa-home"></i> </a></li>
	          <li><a href="#">Wallet History</a></li>
	      </ul>
	  </div>
	</div>
	<!-- Main Container  -->
	<div class="container">
		
		<div class="row">
			@include('reseller.inc.sidebar')
			<!--Middle Part Start-->
			<div id="content" style="background: transparent;" class="col-md-9 sticky-content">
				
				@if(Session::has('success'))
                <div class="alert alert-success">
                  <strong>Success! </strong> {{Session::get('success')}}
                </div>
                @endif
                @if(Session::has('error'))
                <div class="alert alert-danger">
                  <strong>Error! </strong> {{Session::get('error')}}
                </div>
                @endif
				
				<section class="row">
		            <div class="col-md-3 col-xs-6">
		                <div class="card label-default">
		                    <div class="user-box">
		                        <div class="d-flex   no-block align-items-center">
		                            <a href="{{route('reseller.walletHistory')}}" class="link ml-auto">{{ config('siteSetting.currency_symble') . Auth::guard('reseller')->user()->wallet_balance}}</a>
		                        </div>
		                        <h5 class="card-title">Current Balance</h5> 
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-3 col-xs-6">
		                <div class="card label-default">
		                    <div class="user-box">
		                        <div class="d-flex  no-block align-items-center">
		                            <a href="{{route('reseller.walletHistory')}}/?withdraw=pending" class="link ml-auto">{{config('siteSetting.currency_symble') . $wallets->where('type', 'withdraw')->whereIn('status', ['pending','accepted'])->sum('amount')}}</a>
		                            <h5 class="card-title">Pending withdrawal</h5> 
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-3 col-xs-6">
		                <div class="card label-default">
		                    <div class="user-box">
		                        <div class="d-flex   no-block align-items-center">
		                            <a href="{{route('reseller.walletHistory')}}/?withdraw=paid" class="link ml-auto">{{config('siteSetting.currency_symble') . $wallets->where('type', 'withdraw')->where('status', 'paid')->sum('amount')}}</a>
		                        </div>
		                        <h5 class="card-title">Total withdraw</h5> 
		                    </div>
		                </div>
		            </div>
		            
		            @if($withdrawStatus)
		            <div class="col-md-3 col-xs-6">
		                <div class="card label-info" style="cursor: pointer;">
		                    <div class="user-box" data-toggle="modal" data-target="#withdraw_request">
		                        <div class="d-flex no-block align-items-center">
		                            <a href="javascript:void(0)" class="link ml-auto"><i class="fa fa-reply-all"></i></a>
		                        </div>
		                         <h5 class="card-title">Send Withdraw Request</h5> 
		                    </div>
		                </div>
		            </div>
		            @endif
		        </section>
		      	<h4>Wallet history</h4>
				<div class="table-responsive" style="background: #fff;padding: 5px;">
					<table  id="config-table" style="width: 100%" class="table display table-bordered table-striped no-wrap">
						<thead>
							<tr>
								<td class="text-left">SL</td>
								<td class="text-left">Date</td>
								<td class="text-left">Type</td>
								<td class="text-left">Amount</td>
								<td class="text-left">Commission</td>
								<td class="text-left">Payment Info</td>
								<td class="text-center">Status</td>
							</tr>
						</thead>
						<tbody>
							
							@if(count($wallets)>0)
						        @foreach($wallets as $index => $wallet)
						        <tr>
						        	<td>{{ $index+1 }}</td>
						           	<td>{{\Carbon\Carbon::parse($wallet->created_at)->format(Config::get('siteSetting.date_format'))}}
						           ({{\Carbon\Carbon::parse($wallet->created_at)->format('h:i:s A')}})
										<small>[{{ $wallet->notes }}]</small>
						           </td>
						             <td>{{ $wallet->type }}</td>
						            <td>
                                     @if($wallet->amount<0 || $wallet->type == 'withdraw' || $wallet->type == 'returnCharge')  <span class="label label-danger">
                                      - {{Config::get('siteSetting.currency_symble').  str_replace('-', '', $wallet->amount) }}</span>
                                    @else
                                    <span class="label label-info">
                                       {{Config::get('siteSetting.currency_symble'). str_replace('+', '', $wallet->amount) }}</span>
                                    @endif
                                	</td>
                                	<td>{{Config::get('siteSetting.currency_symble'). $wallet->commission}}</td>
						            <td><span class="label label-info">Pay Method: {{ ($wallet->paymentGateway) ?  $wallet->paymentGateway->method_name : $wallet->payment_method }}</span><br/>
                                   
                                    @if($wallet->account_no) {{$wallet->account_no}} <br/> @endif 
                                    @if($wallet->transaction_details)  {{$wallet->transaction_details}} @endif
                                    </td>
						           	
						            <td>@if($wallet->status == 'paid') <span class="label label-success"> {{$wallet->status}}</span> @elseif($wallet->status == 'received') <span class="label label-primary"> {{$wallet->status}} </span> @elseif($wallet->status == 'cancel') <span class="label label-danger"> {{$wallet->status}} </span> @else <span class="label label-warning"> {{$wallet->status}} </span> @endif</td>
						        </tr>
						       @endforeach
						    @endif
							
						</tbody>
					</table>
				</div>

			</div>
			<!--Middle Part End-->
			
		</div>
	</div>
	<!-- //Main Container -->
	@if($withdrawStatus)
	<!-- withdraw request Modal -->
	<div class="modal fade" id="withdraw_request" role="dialog" style="display: none;">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Send Withdraw Request</h4>
                    <button type="button" style="margin-top: -25px;" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row">
                	
                	@if(Session::has('success'))
	                <div class="alert alert-success">
	                  <strong>Success! </strong> {{Session::get('success')}}
	                </div>
	                @endif
	                @if(Session::has('error'))
	                <div class="alert alert-danger">
	                  <strong>Error! </strong> {{Session::get('error')}}
	                </div>
	                @endif
                    <div class="card-body">
                    	@if(Auth::guard('reseller')->user()->wallet_balance >= $withdraw_configure->value2)
                        <form action="{{route('reseller.withdraw_request')}}" method="POST" data-parsley-validate>
                            {{csrf_field()}}
                            <div class="form-body">

                                <div class="row justify-content-mfd-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="required" for="method_name">Withdraw Amount</label>
                                            <input required="" name="amount" min="{{$withdraw_configure->value2}}" id="amount" value="{{old('amount')}}" type="number" placeholder="Example {{Config::get('siteSetting.currency_symble'). $withdraw_configure->value2}}" class="form-control">
                                             <i style="color: black">Minimum withdraw amount {{Config::get('siteSetting.currency_symble'). $withdraw_configure->value2}}</i>
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
                                        <div class="form-group">
                                            <label class="required" for="password">Password</label>
                                            <input type="password" required name="password" id="password"  placeholder="Enter password" autocomplete="false" class="form-control">
                                             @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('password') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12"><label style="line-height: 1" for="agree">
<!--                                    	<input type="checkbox" id="agree" required name="agree"> If you withdraw wallet balance,  {{ $withdraw_configure->value }}% commission will be deducted.</label>-->
                                        <div class="modal-footer">
                                            <button type="submit" name="submitType" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Send Request</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @else
                        <p style="color: red">Insufficient your wallet balance</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection		
@section('js')
   	<script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>

     <script>
    // responsive table
        $('#config-table').DataTable({
            responsive: true,
            ordering: false,

        });

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


