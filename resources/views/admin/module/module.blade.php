@extends('layouts.admin-master')
@section('title', 'Module list')
@section('css-top')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('css')

    <style type="text/css">
      
        svg{width: 20px}
        .module_section{padding:1px 15px; border-radius: 5px;  background: #fff; margin-bottom: 10px; list-style: none;}
        .action_btn{ margin-top: 5px;}
        .deactive_module{background-color: #e8dada9c;}
        .panel-title>a, .panel-title>a:active{ display:block;padding:12px 0;color:#555;font-size:14px;font-weight:bold;}
        .panel-heading a:after { padding-right: 7px !important;  font-family: 'Font Awesome 5 Free';  content: "\f107"; float: left; }
        .panel-heading.active a:after { padding-left: 7px !important;  -webkit-transform: rotate(180deg); -moz-transform: rotate(180deg); transform: rotate(180deg); padding-right: 0px !important; } 

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
                        <h4 class="text-themecolor">Module Management</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">module</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            
                           <button data-toggle="modal" data-target="#addModuleModal" class="btn btn-sm btn-info d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Add New Module</button>
                           <button data-target="#addSubmoduleModal"  data-toggle="modal" title="Add submodule" class="btn btn-sm btn-success d-none d-lg-block m-l-15"> <i class="ti-plus"></i> Add Sub Module</button>
                          
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->

                <!-- Start Page Content -->
                <div class="row justify-content-md-center">
                    <!-- Column -->
                    @if(count($modules)>0)
                    <div class="col-md-8  col-12 col-md-offset-2"> <i class="drag-drop-info">Drag & drop sorting module position</i></div>
                    <div class="col-md-8  col-12 col-md-offset-2">
                        <div class="table-responsive" >
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <ul id="sectionSositionSorting" data-table="modules" style="padding: 0">
                              
                                @foreach($modules as $secIndex => $module)
                                <li id="itemsection{{$module->id}}" class="module_section @if($module->status == 0) deactive_module @endif"  @if($module->status == 0) title="Deactive this section" @endif >
                                    <div class="panel panel-default">
                                        <div class="row panel-heading @if($secIndex == 0) active @endif" role="tab" >
                                            <div class="col-md-8  col-12">
                                              <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#moduleSection{{ $module->id }}" aria-expanded="true" aria-controls="moduleSection{{ $module->id }}"> {{$secIndex+1}}. {{$module->module_name}}
                                                </a>
                                              </h4>
                                            </div>
                                            <div class="col-md-4 col-12" style="float: right;">
                                                <div class="action_btn">
                                                    <button onclick="moduleEdit({{$module->id}})" title="Edit Section" class="btn btn-info btn-sm"> <i class="ti-pencil-alt"></i> Edit</button>
                                                    <!-- <button title="Delete Section"  data-target="#delete" onclick='deleteConfirmPopup("{{route("admin.module.delete", $module->id)}}", "section")'  data-toggle="modal" class="btn btn-danger btn-sm"> <i class="ti-trash"></i> Delete</button> -->
                                                </div>
                                            </div>
                                        </div>
                                        @if(count($module->sub_modules)>0)
                                        <div id="moduleSection{{ $module->id }}" class="panel-collapse collapse @if($secIndex == 0) in @endif" role="tabpanel">
                                            <div class="panel-body">
                                                <table class="table table-striped" >
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Sub module Title</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       
                                                            @foreach($module->sub_modules as $index => $submodule)
                                                            <tr id="item{{$submodule->id}}">
                                                                <td>{{ $index+1 }}</td>
                                                                <td>{{Str::limit($submodule->module_name, 40)}}</td>
                                                                <td>
                                                                    <div class="custom-control custom-switch">
                                                                      <input name="status" onclick="satusActiveDeactive('sub_modules', {{$submodule->id}})"  type="checkbox" {{($submodule->status == 1) ? 'checked' : ''}}  type="checkbox" class="custom-control-input" id="submodulestatus{{$submodule->id}}">
                                                                      <label style="padding: 5px 12px" class="custom-control-label" for="submodulestatus{{$submodule->id}}"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                <button class="btn btn-info btn-sm" onclick="submoduleEdit({{$submodule->id}})" class="btn btn-success btn-sm" type="button" title="Edit submodule" href="{{ route('admin.module.edit', $submodule->id) }}"><i class="ti-pencil-alt"></i></button>
                                                                
                                                                <button title="Delete submodule" class="btn btn-danger btn-sm" data-target="#delete" onclick="deleteConfirmPopup('{{route("admin.submodule.delete", $submodule->id)}}')" data-toggle="modal"><i class="ti-trash"></i></button>                                          
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                       
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </li>
                                @endforeach
                               
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- Column -->
                </div>            
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
      
        <!-- add Modal -->
        <div class="modal fade" id="addModuleModal" style="display: none;">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add module</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <form action="{{route('admin.module.store')}}" method="post" >
                            {{csrf_field()}}
                            <div class="form-body">
                                <!--/row-->
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="module_name">Module Name</label>
                                            <input placeholder="Write section name" name="module_name" id="module_name" value="{{old('module_name')}}" required="" type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="route">Route Name</label>
                                            <input  name="route" id="route" type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="icon">Module Icon</label>
                                            <input name="icon" id="icon" type="text" class="form-control">
                                        </div>
                                    </div>
                                 
                                    <div class="col-md-12">
                                        <div class="head-label">
                                            <label class="switch-box">Status</label>
                                            <div  class="status-btn" >
                                                <div class="custom-control custom-switch">
                                                    <input name="status" checked  type="checkbox" class="custom-control-input" {{ (old('status') == 'on') ? 'checked' : '' }} id="sectionstatus">
                                                    <label  class="custom-control-label" for="sectionstatus">Publish/UnPublish</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Add Module</button>
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

        <!-- module edit modal -->
        <div class="modal fade" id="moduleEdit" style="display: none;">
            <div class="modal-dialog">
                <form action="{{route('admin.module.update')}}" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit module</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row" id="module_edit_form"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-success">Update Module</button>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="addSubmoduleModal"  style="display: none;">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Sub Module</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        
                        <form action="{{route('admin.submodule.store')}}" method="post">
                            {{csrf_field()}}
                           
                            <div class="form-body">
                                <!--/row-->
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <label for="module_video">Select Module</label>
                                        <div class="form-group">
                                            <select required name="module_id" id="module_id" class="form-control custom-select">
                                                <option value="">Select Module</option>
                                                @foreach($modules as $module)
                                                <option @if(Session::get("module_id") == $module->id) selected @endif value="{{ $module->id }}">{{$module->module_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="required" for="submodule_name">Sub Module name</label>
                                            <input placeholder="Write module name" name="submodule_name" id="submodule_name" value="{{old('submodule_name')}}" required="" type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="route">Route Name</label>
                                            <input  name="route" id="route" type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="sidebar"> <input name="is_hidden_sidebar" id="sidebar" value="1" type="checkbox"  > Hidden is sidebar</label><br/>
                                            <label for="role_permission"> <input name="is_hidden_role_permission" id="role_permission" value="1" type="checkbox"  > Hidden is role permission</label>
                                        </div>
                                    </div>
                                                                    
                                    <div class="col-md-12">
                                        <div class="head-label">
                                            <label class="switch-box">Status</label>
                                            <div class="status-btn" >
                                                <div class="custom-control custom-switch">
                                                    <input name="status" checked  type="checkbox" class="custom-control-input" {{ (old('status') == 'on') ? 'checked' : '' }} id="submoduleStatus">
                                                    <label  class="custom-control-label" for="submoduleStatus">Publish/UnPublish</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Add submodule</button>
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
        
         <!-- submodule edit modal -->
        <div class="modal fade" id="submoduleEdit" style="display: none;">
            <div class="modal-dialog">
                <form action="{{route('admin.submodule.update')}}" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit submodule</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row" id="submodule_edit_form"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-success">Update</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
       
        @include('admin.modal.delete-modal')
@endsection
@section('js')
<script src="{{asset('assets')}}/node_modules/jqueryui/jquery-ui.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

    <script type="text/javascript">

        function moduleEdit(id){
            $('#moduleEdit').modal('show');
            $('#module_edit_form').html('<div class="loadingData"></div>');
            var  url = '{{route("admin.module.edit", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#module_edit_form").html(data);
                    }
                },
                // $ID Error display id name
                @include('common.ajaxError', ['ID' => 'module_edit_form'])
            });
        }         

        function submoduleEdit(id){
            $('#submoduleEdit').modal('show');
            $('#submodule_edit_form').html('<div class="loadingData"></div>');
            var  url = '{{route("admin.submodule.edit", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#submodule_edit_form").html(data);
                    }
                },
                // $ID Error display id name
                @include('common.ajaxError', ['ID' => 'submodule_edit_form'])
            });
        } 

    </script>
    <script type="text/javascript">
        $(".select2").select2();


    //section sorting
    $(document).ready(function(){
        $( "#sectionSositionSorting" ).sortable({
            placeholder : "ui-state-highlight",
            update  : function(event, ui)
            {
                var ids = new Array();
                $('#sectionSositionSorting li').each(function(){
                    var id = $(this).attr("id");
                    id = id.replace('section','item');
                    ids.push(id);
                });
                var table = $(this).attr('data-table');

                $.ajax({
                    url:"{{route('positionSorting')}}",
                    method:"get",
                    data:{ids:ids,table:table},
                    success:function(data){
                        toastr.success(data)
                    }
                });
            }
        });
    });
    

    </script>
 


    <script type="text/javascript">
        $('.panel-collapse').on('show.bs.collapse', function () {
        $(this).siblings('.panel-heading').addClass('active');
      });

      $('.panel-collapse').on('hide.bs.collapse', function () {
        $(this).siblings('.panel-heading').removeClass('active');
      });
    </script>
@endsection
