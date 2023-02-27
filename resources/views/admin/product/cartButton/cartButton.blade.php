@extends('layouts.admin-master')
@section('title', 'Cart Button list')
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">

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
                    <h4 class="text-themecolor">Cart Button List</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Cart Button</a></li>
                            <li class="breadcrumb-item active">list</li>
                        </ol>
                        <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i
                                class="fa fa-plus-circle"></i> Add New Name</button>
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
                                            <th>Button Name</th>
                                            <th>Is default</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead> 
                                    <tbody id="positionSorting" data-table="cart_buttons">
                                        @foreach($cartButtons as $cartButton)
                                        <tr id="item{{$cartButton->id}}">
                                            <td>{{$cartButton->btn_name}}</td>
                                            <td>{{($cartButton->is_default) ? 'YES' : 'NO'}}</td>
                                            <td>
                                                <div class="custom-control custom-switch">
                                                  <input  name="status" onclick="satusActiveDeactive('refund_reasons', {{$cartButton->id}})"  type="checkbox" {{($cartButton->status == 1) ? 'checked' : ''}}  type="checkbox" class="custom-control-input" id="status{{$cartButton->id}}">
                                                  <label style="padding: 5px 12px" class="custom-control-label" for="status{{$cartButton->id}}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" onclick="edit('{{$cartButton->id}}')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> Edit</button>
                                                @if($cartButton->is_default != 1)
                                                <button data-target="#delete" onclick='deleteConfirmPopup("{{route("cartBtn.delete", $cartButton->id)}}")' class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> Delete</button>
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
                    <h4 class="modal-title">Add Cart Button Name</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row">
                    <div class="card-body">
                        <form action="{{route('cartBtn.store')}}" enctype="multipart/form-data" method="POST" class="floating-labels">
                            {{csrf_field()}}
                            <div class="form-body">
                               
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="required" for="btn_name">Cart Button Name</label>
                                            <input required="" name="btn_name" id="btn_name" value="{{old('btn_name')}}" type="text" class="form-control">
                                            @if ($errors->has('btn_name'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('btn_name') }}
                                            </span>
                                        @endif
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
                                            <button type="submit" name="submitType" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Save Now</button>
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
            <form action="{{route('cartBtn.update')}}" enctype="multipart/form-data"  method="post">
                  {{ csrf_field() }}
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Cart Button Name</h4>
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
    <!-- This is data table -->
    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <script>
        $(function () {
            $('#myTable').DataTable({"ordering": false});
        });

    </script>

    <script type="text/javascript">

        function edit(id){
            $('#edit_form').html('<div class="loadingData"></div>');
            var  url = '{{route("cartBtn.edit", ":id")}}';
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
                // ID = Error display attribute id name
                @include('common.ajaxError', ['ID' => 'edit_form'])

            });
        }

    </script>

@endsection
