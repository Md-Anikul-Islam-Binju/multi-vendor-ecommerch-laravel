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
            height: 150px !important;
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

                        $refund = App\Models\SiteSetting::where('type', 'refund_request')->first();
                        ?>
                        <div class="col-md-12">
                            <div class="card card-body">
                               
                                <form action="{{ route('siteSettingUpdate') }}" method="post" >
                                    @csrf
                                    <input type="hidden" name="type" value="refund_request">
                                    <div class="form-group">

                                        <label class="required" for="title">Set Refund Allowed Days</label><br/>
                                        <input style="width: 300px" required="" name="value" min="0" id="title" value="{{ $refund->value }}" type="number" placeholder="Example 7 days" class="form-control">
                                    </div>

                                    <div class="form-group">
                                       <p class="switch-box">Refund Request Status </p>
                                        
                                        <label for="active"> <input type="radio" name="status" value="1"  {{ ($refund->status == '1') ? 'checked' : '' }} id="active">
                                        Active</label> 
                                        <label for="DeActive"> <input type="radio" name="status" value="0"  {{ ($refund->status == '0') ? 'checked' : '' }} id="DeActive">
                                        DeActive</label>
                                        
                                    </div>
                                    <!-- <div class="form-group"> 
                                        <label class="">Refund Sticker</label>
                                        <input data-default-file="{{asset('upload/images/refund_image/'. App\Models\SiteSetting::where('type', 'refund_sticker')->first()->refund_sticker)}}" type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg png gif"  data-max-file-size="2M"  name="refund_sticker" id="input-file-events">
                                    </div> -->

                                    <button type="submit" class="btn btn-info">Update</button>
                                </form>
                                   
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