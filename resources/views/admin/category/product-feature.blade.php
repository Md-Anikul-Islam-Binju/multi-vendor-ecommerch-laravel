@extends('layouts.admin-master')
@section('title', 'Product Feature list')
@section('css-top')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />

@endsection
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
                        <h4 class="text-themecolor">Product Feature List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Product Feature</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i
                                    class="fa fa-plus-circle"></i> Add Feature</button>
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
                                                <th>Feature Name</th>
                                                <th>Category</th>
                                                <th>Required</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($get_data as $data)
                                            <tr id="item{{$data->id}}">
                                                <td>{{$data->name}}</td>
                                                <td>{{ ($data->get_category) ? $data->get_category->name : 'All Category'}}</td>

                                                <td>{!! ($data->is_required == 1) ? "<span class='label label-danger'>Required</span>" : '<span class="label label-info">N/A</span>' !!}
                                                </td>

                                                <td>{!! ($data->status == 1) ? "<span class='label label-info'>Active</span>" : '<span class="label label-danger">Deactive</span>' !!}
                                                </td>
                                                <td>
                                                    
                                                    <button type="button" onclick="edit('{{$data->id}}')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> Edit</button>
                                                    <button data-target="#delete" onclick="deleteConfirmPopup('{{ route("predefinedFeature.delete",$data->id) }}')" class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> Delete</button>
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
        <div class="modal fade" id="add" role="dialog"   style="display: none;">
            <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create Product Feature</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{route('predefinedFeature.store')}}" enctype="multipart/form-data" method="POST">
                        {{csrf_field()}}
                        <div class="modal-body form-row">

                            <div class="card-body">

                                    <div class="form-body">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Product Feature Name</label>
                                                    <input  name="name" id="name" value="{{old('name')}}" required="" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Select Categroy</label>
                                                    <select  required name="category_id" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                                        <option value="all">All Category</option>
                                                        @foreach($get_category as $category)
                                                            <option @if(Session::get('autoSelectId') == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                                                            <!-- get subcategory -->
                                                            @if(count($category->get_subcategory)>0)
                                                             <optgroup label="--Sub category--">
                                                                @foreach($category->get_subcategory as $subcategory)

                                                                    <option @if(Session::get('autoSelectId') == $subcategory->id) selected @endif value="{{$subcategory->id}}">--{{$subcategory->name}}</option>

                                                                    <!-- get sub childcategory -->
                                                                    @if(count($subcategory->get_subcategory)>0)
                                                                      <optgroup label="---Sub child category---">
                                                                        @foreach($subcategory->get_subcategory as $subchildcategory)

                                                                            <option @if(Session::get('autoSelectId') == $subchildcategory->id) selected @endif value="{{$subchildcategory->id}}"> &nbsp;---{{$subchildcategory->name}}</option>

                                                                        @endforeach
                                                                     </optgroup>
                                                                    @endif
                                                                    <!-- end sub childcatgory -->
                                                                @endforeach
                                                                </optgroup>
                                                            @endif
                                                            <!-- end subcategory -->
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    
                                                    <input  name="is_required" id="is_required" type="checkbox" > <label for="is_required"> Is Requird</label>
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
        <div class="modal fade" id="edit" role="dialog"   style="display: none;">
            <div class="modal-dialog">
                <form action="{{route('predefinedFeature.update')}}"  enctype="multipart/form-data" method="post">
                      {{ csrf_field() }}
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Product Feature</h4>
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
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <!-- This is data table -->
    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
   <script>
        $(".select2").select2();
        $(function () {
            $('#myTable').DataTable();
        });

    </script>

    <script type="text/javascript">

        function edit(id){
            $('#edit_form').html('<div class="loadingData"></div>');
            var  url = '{{route("predefinedFeature.edit", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#edit_form").html(data);
                        $(".select2").select2();
                    }
                },
                // $ID Error display id name
                @include('common.ajaxError', ['ID' => 'edit_form'])

            });

        }

   

</script>



@endsection
