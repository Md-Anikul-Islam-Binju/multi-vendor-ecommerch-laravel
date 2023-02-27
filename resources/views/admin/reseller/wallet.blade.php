@extends('layouts.admin-master')
@section('title', 'Seller list')
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
                    <h4 class="text-themecolor">Seller List</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Seller</a></li>
                            <li class="breadcrumb-item active">list</li>
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
                <div class="col-lg-12">
                    <div class="card" style="margin-bottom: 2px;">


                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">

                    <div class="card ">
                        <div class="card-body">
                            <form action="{{ route('reseller.wallet.update', $reseller->id) }}" method="post">
                                @csrf
                                @method('put')
                               <div class="form-group">
                                   <label for="type">Type</label>
                                   <select name="type" id="type" class="form-control">
                                       <option value="0">Add</option>
                                       <option value="1">Reduce</option>
                                   </select>

                               </div>
                                <label for="amount">Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control">

                                <label for="note">Note</label>
                                <textarea name="note" id="note" cols="10" rows="10" class="form-control"></textarea>

                                <button type="submit" class="btn btn-success">Submit</button>
                            </form>
                           

                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
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
    <!-- update Modal -->
    <div class="modal fade" id="add" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create vendor</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row">
                    <div class="card-body">
                        <form action="{{route('vendor.store')}}" enctype="multipart/form-data" method="POST" class="floating-labels">
                            {{csrf_field()}}
                            <div class="form-body">
                                <!--/row-->
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Vendor Name</label>
                                            <input  name="name" id="name" value="{{old('name')}}" required="" type="text" class="form-control">
                                        </div>
                                    </div>
                                 
                                </div>
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="form-group"> 
                                            <label class="dropify_image">Feature Image</label>
                                            <input  type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="2M"  name="phato" id="input-file-events">
                                        </div>
                                        @if ($errors->has('phato'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('phato') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row justify-content-md-center">
                                   <div class="col-md-12">
                                        <div class="form-group">
                                            <label style="background: #fff;top:-10px;z-index: 1" for="notes">Details</label>
                                            <textarea name="notes" class="form-control" placeholder="Enter details" id="notes" rows="2">{{old('notes')}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="head-label">
                                            <label class="switch-box">Status</label>
                                            <div  class="status-btn" >
                                                <div class="custom-control custom-switch">
                                                    <input name="status" checked  type="checkbox" class="custom-control-input" {{ (old('status') == 'on') ? 'checked' : '' }} id="status">
                                                    <label  class="custom-control-label" for="status">Publish/UnPublish</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
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
    <div class="modal fade" id="edit" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <form action="{{route('vendor.update')}}" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update vendor</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row" id="edit_form"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-success">Update</button>
                </div>
              </div>
            </form>
        </div>
      </div>

    <!-- delete Modal -->
    @include('admin.modal.delete-modal')
    <!-- reset password Modal -->
    <div class="modal fade" id="PasswordReset" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <form action="{{route('admin.resetPassword')}}" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
            <input type="hidden" id="userId" name="id">
            <input type="hidden" name="table" value="resellers">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Password Reset</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row">
                    <div class="col-md-12">
                        <label for="password"><span style="font-weight: bold">Enter new password</span></label>
                        <input type="text" required id="password" name="password" placeholder="Enter password" class="form-control">
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success">Password Reset</button>
                </div>
              </div>
            </form>
        </div>
    </div>

@endsection
@section('js')

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


    <script type="text/javascript">

    function edit(id){
        $('#edit_form').html('<div class="loadingData"></div>');
        var  url = '{{route("vendor.edit", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#edit_form").html(data);
                    $('.dropify').dropify();
                }
            },
            // $ID Error display id name
            @include('common.ajaxError', ['ID' => 'edit_form'])

        });
    }
    function PasswordReset(userId) {
       $('#PasswordReset').modal('show');
       $('#userId').val(userId);
    }

</script>
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
     <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

    });
    </script>

@endsection
