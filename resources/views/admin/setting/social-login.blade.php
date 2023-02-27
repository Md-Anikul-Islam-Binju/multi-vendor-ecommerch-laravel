@extends('layouts.admin-master')
@section('title', 'Social media login')

@section('css')
<link href="{{asset('css')}}/pages/tab-page.css" rel="stylesheet" type="text/css" />
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)">General</a></li>
                            <li class="breadcrumb-item active">Setting</li>
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
                                <div class="title_head"> Social media login configuration</div>
                               
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                   
                                    <li class="nav-item"> <a class="nav-link  @if(!Session::get('activeTap')) active @endif @if(Session::get('activeTap') == 'facebook') active @endif " data-toggle="tab" href="#facebook" role="tab"><i class="ti-facebook"></i>  Facebook Setting</a> </li>
                                    <li class="nav-item"> <a class="nav-link @if(Session::get('activeTap') == 'google') active @endif " data-toggle="tab" href="#google" role="tab"><i class="ti-google"></i>  Google Setting</a> </li>
                                    <li class="nav-item"> <a class="nav-link @if(Session::get('activeTap') == 'twitter') active @endif " data-toggle="tab" href="#twitter" role="tab"><i class="ti-twitter"></i>  Twitter Setting</a> </li>
                                   
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabcontent-border">
                                   
                                    <div class="tab-pane @if(!Session::get('activeTap')) active @endif @if(Session::get('activeTap') == 'facebook') active @endif " id="facebook" role="tabpanel">
                                        <div class="p-20">
                                            <form action="{{route('env_key_update')}}"  method="post" data-parsley-validate>
                                                @csrf
                                                <div class="form-body">
                                                    
                                                    <div class="">
                                                        <div class="form-group row justify-content-md-center ">
                                                            <div class="col-md-4">
                                                                <label class="col-form-label" for="client_id"> Facebook client id</label>
                                                                <input type="text" value="{{  env('FACEBOOK_CLIENT_ID') }}" placeholder="Enter client id" name="types[FACEBOOK_CLIENT_ID]" id="client_id" class="form-control" >
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="col-form-label" for="client_secret">Facebook client secret</label>
                                                                <input type="text" value="{{  env('FACEBOOK_CLIENT_SECRET') }}" placeholder="Enter client secret" name="types[FACEBOOK_CLIENT_SECRET]" id="client_secret" class="form-control" >
                                                            </div>
                                                        </div>
                                                            
                                                    </div><hr>
                                                    <div class="form-actions pull-right">
                                                        <button type="submit" name="activeTap" value="facebook" class="btn btn-success"> <i class="fa fa-save"></i> Update facebook setting</button>
                                                       
                                                        <button type="reset" class="btn waves-effect waves-light btn-secondary">Reset</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="tab-pane @if(Session::get('activeTap') == 'google') active @endif " id="google" role="tabpanel">
                                        <div class="p-20">
                                            <form action="{{route('env_key_update')}}"  method="post" data-parsley-validate>
                                                @csrf
                                                <div class="form-body">
                                                    
                                                    <div class="">
                                                        <div class="form-group row justify-content-md-center ">
                                                            <div class="col-md-4">
                                                                <label class="col-form-label" for="client_id"> Google client id</label>
                                                                <input type="text" value="{{  env('GOOGLE_CLIENT_ID') }}" placeholder="Enter client id" name="types[GOOGLE_CLIENT_ID]" id="client_id" class="form-control" >
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="col-form-label" for="client_secret">Google client secret</label>
                                                                <input type="text" value="{{  env('GOOGLE_CLIENT_SECRET') }}" placeholder="Enter client secret" name="types[GOOGLE_CLIENT_SECRET]" id="client_secret" class="form-control" >
                                                            </div>
                                                        </div>
                                                            
                                                    </div><hr>
                                                    <div class="form-actions pull-right">
                                                        <button type="submit" name="activeTap" value="google" class="btn btn-success"> <i class="fa fa-save"></i> Update google setting</button>
                                                       
                                                        <button type="reset" class="btn waves-effect waves-light btn-secondary">Reset</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="tab-pane @if(Session::get('activeTap') == 'twitter') active @endif " id="twitter" role="tabpanel">
                                        <div class="p-20">
                                            <form action="{{route('env_key_update')}}"  method="post" data-parsley-validate>
                                                @csrf
                                                <div class="form-body">
                                                    
                                                    <div class="">
                                                        <div class="form-group row justify-content-md-center ">
                                                            <div class="col-md-4">
                                                                <label class="col-form-label" for="client_id"> Twitter client id</label>
                                                                <input type="text" value="{{  env('TWITTER_CLIENT_ID') }}" placeholder="Enter client id" name="types[TWITTER_CLIENT_ID]" id="client_id" class="form-control" >
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="col-form-label" for="client_secret">Twitter client secret</label>
                                                                <input type="text" value="{{  env('TWITTER_CLIENT_SECRET') }}" placeholder="Enter client secret" name="types[TWITTER_CLIENT_SECRET]" id="client_secret" class="form-control" >
                                                            </div>
                                                            
                                                        </div>
                                                            
                                                    </div><hr>
                                                    <div class="form-actions pull-right">
                                                        <button type="submit" name="activeTap" value="twitter" class="btn btn-success"> <i class="fa fa-save"></i> Update facebook setting</button>
                                                       
                                                        <button type="reset" class="btn waves-effect waves-light btn-secondary">Reset</button>
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
