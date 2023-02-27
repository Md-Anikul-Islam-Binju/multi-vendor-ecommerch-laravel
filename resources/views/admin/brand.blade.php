@extends('layouts.admin-master')
@section('title', 'Brand list')
@section('css-top')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
    <link href="{{asset('css')}}/pages/bootstrap-switch.css" rel="stylesheet">

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
                    <h4 class="text-themecolor">Product brand List</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Product brand</a></li>
                            <li class="breadcrumb-item active">list</li>
                        </ol>
                        <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Add brand</button>
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
                             <i class="drag-drop-info">Drag & drop sorting position</i>
                            <div class="table-responsive">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Brand Name</th>
                                            <th>Logo</th>
                                            <th>Added By</th>
                                            <th>Category</th>
                                            <th>Allow Top Brand</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead> 
                                    <tbody id="positionSorting" data-table="brands">
                                        @foreach($get_data as $index => $data)
                                        <tr id="item{{$data->id}}">
                                            <td>{{(($get_data->perPage() * $get_data->currentPage() - $get_data->perPage()) + ($index+1) )}}</td>
                                            <td>{{$data->name}}</td>
                                            <td><img width="70" src="{{ asset('upload/images/brand/thumb/'.$data->logo)}}"></td>
                                            <td>@if($data->seller) <a href="{{route('admin.vendor.profile', $data->seller->slug) }}"> {{ $data->seller->shop_name }} </a> @else admin @endif</td>
                                            <td>{{ ($data->get_category) ? $data->get_category->name : 'All Category'}}</td>
                                            <td><div class="bt-switch">
                                                <input  onchange="satusActiveDeactive('brands', '{{$data->id}}', 'top')" type="checkbox" {{($data->top == 1) ? 'checked' : ''}} data-on-color="success" data-off-color="danger" data-on-text="Enabled" data-off-text="Disabled"> 
                                               
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-switch">
                                                  <input  name="status" onclick="satusActiveDeactive('brands', {{$data->id}})"  type="checkbox" {{($data->status == 1) ? 'checked' : ''}}  type="checkbox" class="custom-control-input" id="status{{$data->id}}">
                                                  <label style="padding: 5px 12px" class="custom-control-label" for="status{{$data->id}}"></label>
                                                </div>
                                            </td>

                                            <td>
                                                
                                                <button type="button" onclick="edit('{{$data->id}}')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> Edit</button>
                                                <button data-target="#delete" onclick="deleteConfirmPopup('{{route("brand.delete", $data->id)}}')" class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> Delete</button>
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
                    <h4 class="modal-title">Create Product brand</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('brand.store')}}" enctype="multipart/form-data" method="POST">
                    {{csrf_field()}}
                    <div class="modal-body form-row">

                        <div class="card-body">
                            
                                <div class="form-body">
                                   
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input placeholder="Enter user name" name="name" id="name" value="{{old('name')}}" required="" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">User Type</label>
                                                <select  required name="category_id" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                                    <option value="">Select user</option>
                                                    <option value="author">Author</option>
                                                    <option value="translator">Translator</option>
                                                    <option value="editor">Editor</option>
                                                    <option value="publisher">Publisher</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <span for="name">User Details</span>
                                                <textarea placeholder="Enter user details" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <span for="name">User Image</span>
                                                <input type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  name="phato">
                                                <p class="upload-info">Image Size: 95px*95px</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                           <span class="switch-box">Status</span>
                                            <div class="head-label">
                                                <div  class="status-btn" >
                                                    <div class="custom-control custom-switch">
                                                        <input name="status" checked  type="checkbox" class="custom-control-input" {{ (old('status') == 'on') ? 'checked' : '' }} id="status">
                                                        <label  class="custom-control-label" for="status">Publish/UnPublish</label>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                           
                        </div>
                    </div>
                     <div class="modal-footer">
                        <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                        <button type="button" data-dismiss="modal" class="btn btn-inverse">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- update Modal -->
    <div class="modal fade" id="edit" style="display: none;">
        <div class="modal-dialog">
            <form action="{{route('brand.update')}}"  enctype="multipart/form-data" method="post">
                  {{ csrf_field() }}
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Product brand</h4>
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
@endsection
@section('js')
<script src="{{asset('assets')}}/node_modules/jqueryui/jquery-ui.min.js"></script>
    <!-- This is data table -->
    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
        <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(".select2").select2();
    </script>
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
   <script>
        $(function () {
           $('#myTable').DataTable({"ordering": false});
        });
    </script>

    <script type="text/javascript">

        function edit(id){
          
            var  url = '{{route("brand.edit", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#edit_form").html(data);
                        $('.dropify').dropify();
                         $(".select2").select2();
                    }
                }

            });
        }

        // if occur error open model
        @if($errors->any())
            $("#{{Session::get('submitType')}}").modal('show');
        @endif
    </script>
 
@endsection
