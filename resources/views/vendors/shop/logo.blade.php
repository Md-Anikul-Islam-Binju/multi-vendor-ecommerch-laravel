@extends('vendors.partials.vendor-master')
@section('title', 'Logo & Banner Setting')
@section('css')
<link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .dropify_image{
            position: absolute;top: -12px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
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
                <div class="row page-titles">
                
                    <div class="col-md-12 align-self-center ">
                        <div class="d-fl ">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Update</a></li>
                                <li class="breadcrumb-item active">Logo & Banner</li>
                            </ol>
                        </div>
                    </div>
                </div>
               
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="container">
                        <div class="col-md-12">
                            <div class="card card-body">
                                <form action="{{route('vendor.logo-banner')}}" enctype="multipart/form-data" method="post">
                                @csrf
                            
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <label class="dropify_image">Shop Logo</label>
                                            <input type="file" data-default-file="{{asset('upload/vendors/logo/'.Auth::guard('vendor')->user()->logo)}}" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg png gif"  data-max-file-size="2M"  name="logo" id="input-file-events">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group"> 
                                            <label class="dropify_image">Shop Banner</label>
                                            <input type="file" class="dropify" accept="image/*" data-type='image' data-default-file="{{asset('upload/vendors/banner/'.Auth::guard('vendor')->user()->banner)}}" data-allowed-file-extensions="jpg jpeg png gif" name="banner" id="input-file-events">
                                        </div>
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