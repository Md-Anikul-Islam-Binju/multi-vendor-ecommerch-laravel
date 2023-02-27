@extends('vendors.partials.vendor-master')
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
                        <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i
                                class="fa fa-plus-circle"></i> Add brand</button>
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
                                            <th>Brand Name</th>
                                            <th>Logo</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        @foreach($get_data as $data)
                                        <tr id="item{{$data->id}}">
                                            <td>{{$data->name}}</td>
                                            <td><img width="70" src="{{ asset('upload/images/brand/thumb/'.$data->logo)}}" alt=""></td>
                                            <td>{{ ($data->get_category) ? $data->get_category->name : 'All Category'}}</td>
                                           
                                            <td> {!! ($data->status == 1) ? '<span class="label label-success">active</span>' : '<span class="label label-danger">pending</span>' !!}</td>

                                            <td>
                                                
                                                <button type="button" onclick="edit('{{$data->id}}')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> Edit</button>
                                                @if($data->status != 1)
                                                <button data-target="#delete"  onclick="deleteConfirmPopup('{{route("vendor.brand.delete", $data->id)}}')" class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> Delete</button>
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
    <div class="modal fade" id="add" role="dialog"  style="display: none;">
        <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create Product brand</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('vendor.brand.store')}}" enctype="multipart/form-data" method="POST" class="floating-labels">
                    {{csrf_field()}}
                    <div class="modal-body form-row">

                        <div class="card-body">
                            
                                <div class="form-body">
                                   
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Brand Name</label>
                                                <input  name="name" id="name" value="{{old('name')}}" required="" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <span for="name">Select Categroy</span>
                                                <select  required name="category_id" class="select2 form-control custom-select ">
                                                    <option value="0">All Category</option>
                                                    @foreach($get_category as $category)
                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                        <!-- get subcategory -->
                                                        @if(count($category->get_subcategory)>0)
                                                         
                                                            @foreach($category->get_subcategory as $subcategory)
                                                            
                                                                <option value="{{$subcategory->id}}">--{{$subcategory->name}}</option>
                                                           
                                                            @endforeach
                                                        @endif
                                                        <!-- end subcategory -->
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <span for="name">Brand Logo</span>
                                                <input type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  name="phato">
                                                <p class="upload-info">Logo Size: 95px*95px</p>
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
    <div class="modal fade" id="edit"  style="display: none;">
        <div class="modal-dialog">
            <form action="{{route('vendor.brand.update')}}"  enctype="multipart/form-data" method="post">
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

   <script>
        $(function () {
           $('#myTable').DataTable({"ordering": false});
        });
    </script>

    <script type="text/javascript">

        function edit(id){
          
            var  url = '{{route("vendor.brand.edit", ":id")}}';
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
