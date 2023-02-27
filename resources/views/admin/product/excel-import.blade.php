@extends('layouts.admin-master')
@section('title', 'Product list')
@section('css-top')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('css')

    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
    <link href="{{asset('css')}}/pages/bootstrap-switch.css" rel="stylesheet">

    <style type="text/css">
        .dropify_image{
            position: absolute;top: -12px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
        }
        .dropify-wrapper{
            height: 100px !important;
        }
        svg{width: 20px}

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
                    <h4 class="text-themecolor">Total Product </h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Product</a></li>
                            <li class="breadcrumb-item active">list</li>
                        </ol>
                        <a class="btn btn-info d-none d-lg-block m-l-15" href="{{ route('admin.product.upload') }}"><i class="fa fa-plus-circle"></i> Add New Product</a>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->



            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Upload File</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <label for="file">Upload File (xls, CSV, xlsx)</label>
                                <input type="file" name="file" class="form-control">
                                <div class="my-4">
                                    <button type="submit" class="btn btn-success">Upload</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('excel.download') }}">Example File <i class="fa fa-download"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Start Page Content -->
            <div class="row">
                <!-- Column -->

                <!-- Column -->
            </div>
            <div class="row">
           </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>

@endsection
@section('js')
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(".select2").select2();

        function setGallerryImage(id) {

            $('#showGallerryImage').html('<div class="loadingData"></div>');
            var  url = '{{route("product.getGalleryImage", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#showGallerryImage").html(data);
                    }
                },
                // $ID = Error display id name
                @include('common.ajaxError', ['ID' => 'showGallerryImage'])

            });
        }


        function deleteGallerryImage(id) {

            if (confirm("Are you sure delete this image.?")) {

                var url = '{{route("product.deleteGalleryImage", ":id")}}';
                url = url.replace(':id',id);
                $.ajax({
                    url:url,
                    method:"get",
                    success:function(data){
                        if(data){
                            $('#gelImage'+id).hide();
                            toastr.success(data.msg);
                        }else{
                            toastr.error(data.msg);
                        }
                    }
                });
            }
            return false;
        }


        function producthighlight(id){
            $('#highlight_form').html('<div class="loadingData"></div>');
            $('#producthighlight_modal').modal('show');
            var  url = '{{route("product.highlight", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#highlight_form").html(data);
                    }
                },
                // $ID = Error display id name
                @include('common.ajaxError', ['ID' => 'highlight_form'])

            });
        }

        //change status by id
        function highlightAddRemove(section_id, product_id){
            var  url = '{{route("highlightAddRemove")}}';
            $.ajax({
                url:url,
                method:"get",
                data:{section_id:section_id, product_id:product_id},
                success:function(data){
                    if(data.status){
                        toastr.success(data.msg);
                    }else{
                        toastr.error(data.msg);
                    }
                }
            });
        }

    </script>
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
    <script>
        $(document).ready(function() {
            // Basic
            $('.dropify').dropify();
        });
    </script>

    <!-- bt-switch -->
    <script src="{{asset('assets')}}/node_modules/bootstrap-switch/bootstrap-switch.min.js"></script>
    <script type="text/javascript">
        $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();
        var radioswitch = function() {
            var bt = function() {
                $(".radio-switch").on("switch-change", function() {
                    $(".radio-switch").bootstrapSwitch("toggleRadioState")
                }), $(".radio-switch").on("switch-change", function() {
                    $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck")
                }), $(".radio-switch").on("switch-change", function() {
                    $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", !1)
                })
            };
            return {
                init: function() {
                    bt()
                }
            }
        }();
        $(document).ready(function() {
            radioswitch.init()
        });
    </script>
@endsection
