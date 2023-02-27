@extends('layouts.admin-master')
@section('title', 'Payment gateway list')
@section('css-top')

    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
  
@endsection
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
        <link href="{{asset('assets')}}/node_modules/summernote/dist/summernote-bs4.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" >
        <link href="{{asset('assets')}}/node_modules/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
    <link href="{{asset('css')}}/pages/bootstrap-switch.css" rel="stylesheet">

    <style type="text/css">
        .dropify_image{
            position: absolute;top: -12px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
        }
        .dropify-wrapper{
            height: 100px !important;
        }
        .method_info img{width: 200px}
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
                        <h4 class="text-themecolor">Payment gateway List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Payment gateway</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Add Payment gateway</button>
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Logo</th>
                                                <th>Name</th>
                                                <th>Details</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead> 
                                        <tbody id="positionSorting" data-table="payment_gateways">
                                            @foreach($paymentgateways as $gateway)
                                            <tr id="item{{$gateway->id}}">
                                                <td><img src="{{asset('upload/images/payment/'. $gateway->method_logo)}}" width="90" height="45"></td>
                                                <td>{{$gateway->method_name}}</td>
                                                <td class="method_info"> {!! $gateway->method_info !!}</td>
                                               
                                                <td>
                                                    <div class="custom-control custom-switch" >
                                                      <input name="status" onclick="satusActiveDeactive('payment_gateways', {{$gateway->id}})"  type="checkbox" {{($gateway->status == 1) ? 'checked' : ''}} class="custom-control-input" id="status{{$gateway->id}}">
                                                      <label class="custom-control-label" for="status{{$gateway->id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button title="Edit" type="button" onclick="editMethod('{{$gateway->id}}')"  data-toggle="modal" data-target="#editMethod" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> </button>
                                                    @if($gateway->is_default != 1)
                                                    <button data-target="#delete" title="Delete" onclick='deleteConfirmPopup("{{route("paymentGateway.delete", $gateway->id)}}")' class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> </button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- add Modal -->
        <div class="modal fade" id="add" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Payment gateway</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <form action="{{route('paymentGateway.store')}}" enctype="multipart/form-data" method="POST" >
                                {{csrf_field()}}
                                <input type="hidden" name="method_for" value="payment">
                                <div class="form-body">
                                   
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="method_name">Payment gateway name</label>
                                                <input required="" name="method_name" id="method_name" value="{{old('method_name')}}" type="text" class="form-control">
                                                @if ($errors->has('method_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('title') }}
                                                </span>
                                            @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="method_info">Payment Information</label>
                                                <textarea rows="2" name="method_info" id="method_info"  type="text" style="resize: vertical;" class="summernote form-control">{{old('method_info')}}</textarea>
                                            </div>
                                        </div>
                                     
                                        <div class="col-md-6">
                                            <div class="form-group"> 
                                                <label class="dropify_image">Logo</label>
                                                <input type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg png gif"  data-max-file-size="2M"  name="method_logo" id="input-file-events">
                                                <i style="color: red;font-size: 12px;">Size: 100px * 50px</i>

                                            </div>
                                            @if ($errors->has('method_logo'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('method_logo') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <div class="head-label">
                                                <label class="switch-box">Status</label>
                                                <div  class="status-btn" >
                                                    <div class="custom-control custom-switch">
                                                        <input name="status" checked  type="checkbox" class="custom-control-input" {{ (old('status') == 'on') ? 'checked' : '' }} id="status">
                                                        <label  class="custom-control-label" for="status">Publish/UnPublish</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                   
                                        <div class="col-md-12">
                                            
                                            <div class="modal-footer">
                                                <button type="submit" name="submitType" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Add New Payment gateway</button>
                                                <button type="button" data-dismiss="modal" class="btn btn-inverse">Cancel</button>
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
        <!-- update Modal -->
        <div class="modal fade" id="editMethod" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <form action="{{route('paymentGateway.update')}}" enctype="multipart/form-data"  method="post">
                      {{ csrf_field() }}
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Payment gateway</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row" id="edit_form"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name="submitType" value="edit" class="btn btn-sm btn-success">Update</button>
                    </div>
                  </div>
                </form>
            </div>
        </div>
       <!--  Delete Modal -->
        @include('admin.modal.delete-modal')
@endsection
@section('js')
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

    <!-- This is data table -->
    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
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
   <script>
        $(function () {
            $('#myTable').DataTable({"ordering": false});
        });

    </script>

    <script type="text/javascript">

        function editMethod(id){
           
            $('#edit_form').html('<div class="loadingData"></div>');
            var  url = '{{route("paymentGateway.edit", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){

                        $("#edit_form").html(data);
                        $('.dropify').dropify();
                        $('.summernote').summernote({
                            height: 100, // set editor height
                            minHeight: null, // set minimum height of editor
                            maxHeight: null, // set maximum height of editor
                            focus: false // set focus to editable area after initializing summernote
                        });
                         $(".select2").select2();
                    }
                }, 
                // ID = Error display attribute id name
                @include('common.ajaxError', ['ID' => 'edit_form'])

            });
        }
        //status change
        function satusActiveDeactive(table, id){

            var  url = '{{route("statusChange")}}';
           
            $.ajax({
                url:url,
                method:"get",
                data:{table:table,id:id},
                success:function(data){
                    if(data.status){
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }
                }
            });
        }//status change

      
        function paymentModeChange(id){

            var  url = '{{route("paymentModeChange")}}';
           
            $.ajax({
                url:url,
                method:"get",
                data:{id:id},
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
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
     <script>
    $(document).ready(function() { // Basic
        $('.dropify').dropify();
    });

     $(".select2").select2();
    </script>

    <script src="{{asset('assets')}}/node_modules/summernote/dist/summernote-bs4.min.js"></script>
    <script>
    $(function() {

        $('.summernote').summernote({
            height: 100, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });

        $('.inline-editor').summernote({
            airMode: true
        });

    });

    window.edit = function() {
        $(".click2edit").summernote()
    },
    window.save = function() {
        $(".click2edit").summernote('destroy');
    }

    </script>

@endsection
