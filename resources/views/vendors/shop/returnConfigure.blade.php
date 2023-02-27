@extends('layouts.admin-master')
@section('title', 'Refund Configuration ')
@section('css')
<link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .dropify_image{
            position: absolute;top: -12px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
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
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor"><a href="{{ url()->previous() }}"> <i class="fa fa-angle-left"></i> Refund Configuration</a></h4>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="container">
                       <?php

                        $refund = App\Models\SiteSetting::where('type', 'refund_request_time')
                        ->orWhere('type', 'allow_refund_request')->get()->toArray();
                        ?>
                        <div class="col-md-12">
                            <div class="card card-body">
                               
                                <div class="row justify-content-md-center">
                                    <div class="col-md-5">
                                        <form action="{{ route('siteSettingUpdate') }}" method="post" >
                                            @csrf
                                            <div class="form-group">

                                                <label class="required" for="title">Set Refund Allowed Days</label><br/>
                                                <input style="width: 300px" required="" name="refund_request_time" id="title" value="{{ $refund[0]['value'] }}" type="text" placeholder="Example 7 days" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-info">Update</button>
                                        </form>
                                    </div>
                                <!--     <div class="col-md-10">
                                       <div class="form-group"> 
                                            <label class="dropify_image">Refund Sticker</label>
                                            <input data-default-file="{{asset('upload/images/refund_image/'. App\Models\SiteSetting::where('type', 'refund_sticker')->first()->refund_sticker)}}" type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg png gif"  data-max-file-size="2M"  name="refund_sticker" id="input-file-events">
                                        </div>
                                    </div> -->

                                    <div class="col-md-6">
                                       <span class="switch-box">Allowed Refund Request  </span>
                                        <div class="head-label">
                                            <div  class="status-btn" >
                                                <div class="custom-control custom-switch">
                                                    <input onclick="siteSettingActiveDeactive('allow_refund_request')"  type="checkbox" class="custom-control-input" {{ ($refund[1]['value'] == '1') ? 'checked' : '' }} id="status">
                                                    <label  class="custom-control-label" for="status">Active/DeActive</label>
                                                </div>
                                            </div>
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

        <script type="text/javascript">
        //change status by id
        function siteSettingActiveDeactive(field){
            var  url = '{{route("siteSettingActiveDeactive")}}';
            $.ajax({
                url:url,
                method:"get",
                data:{field:field},
                success:function(data){
                    if(data.status){
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }
                }
            });
        }
    </script>  
@endsection