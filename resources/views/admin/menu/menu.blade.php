@extends('layouts.admin-master')
@section('title', 'Menu list')

@section('css-top')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
      <link href="{{asset('assets')}}/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/switchery/dist/switchery.min.css" rel="stylesheet" />
    <link href="{{asset('assets')}}/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="{{asset('assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="{{asset('assets')}}/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
    <link href="{{asset('assets')}}/node_modules/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
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
                        <h4 class="text-themecolor">Menu List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Menu</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i
                                    class="fa fa-plus-circle"></i> Add New</button>
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
                                                <th>Menu Name</th>
                                                <th>Source</th>
                                                <th>Menu Path</th>
                                                 <th>Display In</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead> 
                                        <tbody id="positionSorting" data-table="menus">
                                            @foreach($menus as $data)
                                            <tr id="item{{$data->id}}">
                                                <td>{{$data->name}}</td>
                                                <td>{{$data->menu_source}}</td>
                                                <td>
                                                    @if($data->get_categories)
                                                    @foreach($data->get_categories as $category){{$category->name}}, @endforeach 
                                                    @endif

                                                    @php
                                                      $source_id = explode(',', $data->source_id);
                                                      $get_pages =  \App\Models\Page::whereIn('id', $source_id)->get();
                                                     
                                                    @endphp
                                                    @if($get_pages)
                                                    @foreach($get_pages as $page){{$page->title}}, @endforeach
                                                    @endif

                                                </td>
                                                <td>@if($data->top_header == 1) Top Header Menu <br/> @endif
                                                    @if($data->main_header == 1) Main Header Menu<br/> @endif
                                                    @if($data->footer == 1) Footer Menu @endif</td>
                                                <td>
                                                    <div class="custom-control custom-switch" style="padding-left: 3.25rem;">
                                                      <input name="status" onclick="satusActiveDeactive('menus', {{$data->id}})"  type="checkbox" {{($data->status == 1) ? 'checked' : ''}} class="custom-control-input" id="status{{$data->id}}">
                                                      <label class="custom-control-label" for="status{{$data->id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" onclick="edit('{{$data->id}}')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> Edit</button>
                                                    <button title="Delete" data-target="#delete" onclick="deleteConfirmPopup('{{route("menu.delete", $data->id)}}')" class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> </button>
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
                        <h4 class="modal-title">Create New Menu</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <form action="{{route('menu.store')}}" method="POST" >
                                {{csrf_field()}}
                                <div class="form-body">
                                    <!--/row-->
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="name">Menu Name</label>
                                                <input  name="name" id="name" value="{{old('name')}}" required="" type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="menu">Menu Source</label>
                                                <select onchange="getMenuSourch(this.value)" name="menu_type"  required="required" id="menu" class="form-control custom-select">
                                                    <option value="">Select Source</option>
                                                    <option value="category" {{ (old('menu') =='category') ? 'selected' : '' }}> Category</option>
                                                    <option value="page" {{ (old('menu') =='page') ? 'selected' : '' }}>Page</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="showMenuSourch">Source Path</label>
                                                <select required name="source_id[]" id="showMenuSourch" class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Choose">
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!--/row-->
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="menu">Menu Display In</label>
                                                <div class="custom-control custom-checkbox">
                                                    <input  type="checkbox" id="top_header" value="top_header" name="top_header" class="custom-control-input">
                                                    <label class="custom-control-label" for="top_header">Top Header </label>
                                                </div>

                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="main_header" value="main_header" name="main_header" class="custom-control-input">
                                                    <label class="custom-control-label" for="main_header">Main Header</label>
                                                </div>

                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="show_footer" value="footer" name="footer" class="custom-control-input">
                                                    <label class="custom-control-label" for="show_footer">Footer Menu</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="head-label">
                                                <label class="switch-box" style="margin-left: -12px; top:-12px;">Status</label>
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
        <div class="modal fade" id="edit" role="dialog"  tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{route('menu.update')}}"  method="post">
                {{ csrf_field() }}
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Menu</h4>
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

    <script src="{{asset('assets')}}/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
     <script type="text/javascript" src="{{asset('assets')}}/node_modules/multiselect/js/jquery.multi-select.js"></script>
        <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
 
    <!-- end - This is for export functionality only -->
    <script>
        $(".select2").select2();
    </script>

    <!-- end - This is for export functionality only -->
    <script>
        $(document).ready( function() {
            $('#myTable').dataTable({
                "ordering": false
            });
        });
    </script>

    <script type="text/javascript">

    function edit(id){
          
        var  url = '{{route("menu.edit", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#edit_form").html(data);
                    $(".select2").select2();
                }
            }
        });

    }

    // get Menu Sourch
    function getMenuSourch(type, edit=''){

        var  url = '{{route("getMenuSourch", ":type")}}';
        url = url.replace(':type', type);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                
                if(data){
                    $("#showMenuSourch"+edit).html(data);
                    $(".select2").select2();
                }else{
                    $("#showMenuSourch"+edit).html('<option>'+type+' not found</option>');
                }
            }
        });
    }   

    
// if occur error open model
    @if($errors->any())
        $("#{{Session::get('submitType')}}").modal('show');
    @endif
</script>
    <script>
        $(document).ready(function(){
            $( "#positionSorting" ).sortable({
                placeholder : "ui-state-highlight",
                update  : function(event, ui)
                {
                    var ids = new Array();
                    $('#positionSorting tr').each(function(){
                        ids.push($(this).attr("id"));
                    });
                    $.ajax({
                        url:"{{route('positionSorting')}}",
                        method:"get",
                        data:{ids:ids,table:'menus'},
                        success:function(data){
                            toastr.success(data)
                        }
                    });
                }
            });
        });
    </script>
@endsection
