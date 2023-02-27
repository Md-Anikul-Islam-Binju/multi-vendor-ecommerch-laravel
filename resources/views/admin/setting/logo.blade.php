@extends('layouts.admin-master')
@section('title', 'Logo Setting')
@section('css')
<link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .dropify_image{
            position: absolute;top: 0px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
        }
        .dropify-wrapper{
            width: 300px !important;
            height: 200px !important;
        }
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
                
                    <div class="col-md-12 align-self-center ">
                        <div class="d-fl ">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">General</a></li>
                                <li class="breadcrumb-item ">Setting</li>
                                <li class="breadcrumb-item active">Logo</li>
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
                        <div class="card card-body">
                            <div class="title_head"> Set Logo </div>
                            <form action="{{route('logoSettingUpdate', $setting->id)}}" enctype="multipart/form-data" method="post" id="generalSetting">
                            @csrf
                        
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group"> 
                                        <label class="dropify_image">Main Logo</label>
                                        <input type="file" data-default-file="{{asset('upload/images/logo/'.$setting->logo)}}" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg png gif"  data-max-file-size="2M"  name="logo" id="input-file-events">

                                    </div>
                                    @if ($errors->has('logo'))
                                        <span class="invalid-feedback" role="alert">
                                            {{ $errors->first('logo') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group"> 
                                        <label class="dropify_image">Invoice Logo</label>
                                        <input type="file" class="dropify" accept="image/*" data-type='image' data-default-file="{{asset('upload/images/logo/'.$setting->invoice_logo)}}" data-allowed-file-extensions="jpg png gif"  data-max-file-size="2M"  name="invoice_logo" id="input-file-events">
                                    </div>
                                    @if ($errors->has('invoice_logo'))
                                        <span class="invalid-feedback" role="alert">
                                            {{ $errors->first('invoice_logo') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group"> 
                                        <label class="dropify_image">Favicon</label>
                                        <input type="file" class="dropify" accept="image/*" data-type='image' data-default-file="{{asset('upload/images/logo/'.$setting->favicon)}}" data-allowed-file-extensions="jpg png gif"  data-max-file-size="2M"  name="favicon" id="input-file-events">
                                    </div>
                                    @if ($errors->has('favicon'))
                                        <span class="invalid-feedback" role="alert">
                                            {{ $errors->first('favicon') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                    <div class="form-actions pull-right">
                                        <button type="submit"  name="submit" value="save" class="btn btn-success"> <i class="fa fa-save"></i> Update Logo</button>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
           
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
@endsection

@section('js')
<script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
     <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();
    });
    </script>

@endsection