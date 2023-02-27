@extends('layouts.admin-master')
@section('title', 'Otp configuration')
@section('css-top')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('css')
    <link href="{{asset('css')}}/pages/tab-page.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        #generalSetting input, #generalSetting textarea{color: #797878!important}
    </style>
@endsection
@section('content')
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                
                <div class="col-md-12 align-self-center ">
                    <div class="d-fl ">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Otp</a></li>
                            <li class="breadcrumb-item active">Configuration</li>
                        </ol>
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
                <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="title_head"> OTP Configuration </div>
                                <form action="" method="post">
                                @csrf
                                <div class="row justify-content-md-center">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <span for="otp_method">OTP Method</span>
                                            <select name="otp_method" id="otp_method" class="form-control">
                                                <option @if($otp_configure->value == 'metrobd') selected @endif value="metrobd">Metrobd</option>
                                                <option @if($otp_configure->value == 'nexmo') selected @endif value="nexmo">Nexmo</option>
                                                <option @if($otp_configure->value == 'twilio') selected @endif value="twilio">Twilio</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                         <div class="form-group">
                                            <span for="shipping_calculate">OTP will be Used For</span><br/>
                                          @php $user_for = explode(',',$otp_configure->value2); @endphp
                                            <select name="user_for[]" multiple style="width: 100%" class="form-control select2 m-b-10 select2-multiple">
                                                <option @if(in_array('registration', $user_for)) selected @endif value="registration">Registration Confirmation</option>
                                                <option @if(in_array('order_place', $user_for)) selected @endif  value="order_place">Order Placement</option>
                                                <option  @if(in_array('order_status', $user_for)) selected @endif value="order_status">Delivery Status Changing Time</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="cost">`</label>
                                            <button style="color: #fff" type="submit" class="form-control btn btn-success">Active</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"> <a class="nav-link @if(!Session::get('activeTap')) active @endif @if(Session::get('activeTap') == 'metrobd') active @endif" data-toggle="tab" href="#metrobd" role="tab"> <span class="hidden-xs-down">@if($otp_configure->value == 'metrobd') <i class="fa fa-check"></i> @endif Metrobd Credential</span></a> </li>
                                    <li class="nav-item"> <a class="nav-link @if(Session::get('activeTap') == 'twilio') active @endif" data-toggle="tab" href="#twilio" role="tab"> <span class="hidden-xs-down">@if($otp_configure->value == 'twilio') <i class="fa fa-check"></i> @endif Twilio Credential</span></a> </li>
                                    <li class="nav-item"> <a class="nav-link @if(Session::get('activeTap') == 'nexmo') active @endif" data-toggle="tab" href="#nexmo" role="tab"> <span class="hidden-xs-down">@if($otp_configure->value == 'nexmo') <i class="fa fa-check"></i> @endif Nexmo Credential</span></a> </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabcontent-border">
                                	<div class="tab-pane @if(!Session::get('activeTap')) active @endif @if(Session::get('activeTap') == 'metrobd') active @endif" id="metrobd" role="tabpanel">
                                        <div class="p-20">
                                        	<form class="form-horizontal" action="{{ route('env_key_update') }}" method="POST">
							                    
							                    @csrf
							                    
							                    <div class="form-group">
							                        <div class="col-lg-3">
							                            <label class="control-label">{{__('API key')}}</label>
							                        </div>
							                        <div class="col-lg-6">
							                            <input type="text" class="form-control" name="types[METROBD_API_KEY]" value="{{  env('METROBD_API_KEY') }}" placeholder="METROBD API KEY" required>
							                        </div>
							                    </div>
							                    <div class="form-group">
							                        <div class="col-lg-3">
							                            <label class="control-label">{{__('Sender ID')}}</label>
							                        </div>
							                        <div class="col-lg-6">
							                            <input type="text" class="form-control" name="types[METROBD_SENDER_ID]" value="{{  env('METROBD_SENDER_ID') }}" placeholder="METROBD SENDER ID" >
							                        </div>
							                    </div>
							                    
							                   	<div class="form-group">
							                     	<div class="col-lg-6">
						                       		<div class="modal-footer pull-right">
                                                    <button type="submit" name="activeTap" value="metrobd" class="btn btn-success"> <i class="fa fa-save"></i> Update Metrobd setting</button>
                                                	</div>
                                                	</div>
                                                </div>
							                    
							                </form>
                                        </div>
                                    </div>
                                    <div class="tab-pane @if(Session::get('activeTap') == 'twilio') active @endif" id="twilio" role="tabpanel">
                                        <div class="p-20">
                                        	<form class="form-horizontal" action="{{ route('env_key_update') }}" method="POST">
							                   
							                    @csrf
							                    <div class="form-group">
							                        <div class="col-lg-3">
							                            <label class="control-label">{{__('TWILIO SID')}}</label>
							                        </div>
							                        <div class="col-lg-6">
							                            <input type="text" class="form-control" name="types[TWILIO_SID]" value="{{  env('TWILIO_SID') }}" placeholder="TWILIO SID" required>
							                        </div>
							                    </div>
							                    <div class="form-group">
							                        <div class="col-lg-3">
							                            <label class="control-label">{{__('TWILIO AUTH TOKEN')}}</label>
							                        </div>
							                        <div class="col-lg-6">
							                            <input type="text" class="form-control" name="types[TWILIO_AUTH_TOKEN]" value="{{  env('TWILIO_AUTH_TOKEN') }}" placeholder="TWILIO AUTH TOKEN" required>
							                        </div>
							                    </div>
							                    <div class="form-group">
							                        <div class="col-lg-3">
							                            <label class="control-label">{{__('TWILIO VERIFY SID')}}</label>
							                        </div>
							                        <div class="col-lg-6">
							                            <input type="text" class="form-control" name="types[TWILIO_VERIFY_SID]" value="{{  env('TWILIO_VERIFY_SID') }}" placeholder="TWILIO VERIFY SID" >
							                        </div>
							                    </div>
							                    <div class="form-group">
							                        <div class="col-lg-3">
							                            <label class="control-label">{{__('VALID TWILLO NUMBER')}}</label>
							                        </div>
							                        <div class="col-lg-6">
							                            <input type="text" class="form-control" name="types[VALID_TWILLO_NUMBER]" value="{{  env('VALID_TWILLO_NUMBER') }}" placeholder="VALID TWILLO NUMBER" >
							                        </div>
							                    </div>
							                    <div class="form-group">
							                     	<div class="col-lg-6">
						                       		<div class="modal-footer pull-right">
                                                    <button type="submit" name="activeTap" value="twilio" class="btn btn-success"> <i class="fa fa-save"></i> Update Twilio setting</button>
                                                	</div>
                                                	</div>
                                                </div>
							                </form>
                                        </div>
                                    </div>

                                    <div class="tab-pane @if(Session::get('activeTap') == 'nexmo') active @endif" id="nexmo" role="tabpanel">
                                        <div class="p-20">
                                        	<form class="form-horizontal" action="{{ route('env_key_update') }}" method="POST">
						                        
						                        @csrf
						                        <div class="form-group">
						                           
						                            <div class="col-lg-3">
						                                <label class="control-label">{{__('NEXMO KEY')}}</label>
						                            </div>
						                            <div class="col-lg-6">
						                                <input type="text" class="form-control" name="types[NEXMO_KEY]" value="{{  env('NEXMO_KEY') }}" placeholder="NEXMO KEY" required>
						                            </div>
						                        </div>
						                        <div class="form-group">
						                            <div class="col-lg-3">
						                                <label class="control-label">{{__('NEXMO SECRET')}}</label>
						                            </div>
						                            <div class="col-lg-6">
						                                <input type="text" class="form-control" name="types[NEXMO_SECRET]" value="{{  env('NEXMO_SECRET') }}" placeholder="NEXMO SECRET" required>
						                            </div>
						                        </div>
						                        <div class="form-group">
							                     	<div class="col-lg-6">
						                       		<div class="modal-footer pull-right">
                                                    <button type="submit" name="activeTap" value="nexmo" class="btn btn-success"> <i class="fa fa-save"></i> Update Nexmo setting</button>
                                                	</div>
                                                	</div>
                                                </div>
						                    </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
@endsection

@section('js')
 
     <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
   
    <script type="text/javascript">
    	$(".select2").select2();
    </script>
@endsection
