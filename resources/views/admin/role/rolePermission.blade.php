@extends('layouts.admin-master')
@section('title', 'Role Permission')
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <style type="text/css">
        .module{background: #f7f7f7; font-weight: bold;}
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
                        <h4 class="text-themecolor">{{ (ucfirst($role->name)) }} : Role Permission</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Role</a></li>
                                <li class="breadcrumb-item active">Permission</li>
                            </ol>
                            <a href="{{ route('role.list') }}" class="btn btn-info btn-sm d-none d-lg-block m-l-15"><i class="fa fa-arrow-left"></i> Back Role List</a>
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

                        <div class="card ">
                            <div class="card-body">
                               
                                <div class="table-responsive">
                                    <form action="{{route('role.permission.store')}}"  method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="role_id"  value="{{$role->id}}" />
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#SL</th>
                                                <th style="width: 135px">Module Name</th>
                                                <th>Sub Module</th>
                                                <th>View <input type="checkbox" id ="is_view"></th>
                                                <th>Add <input type="checkbox" id ="is_add"></th>
                                                <th>Edit <input type="checkbox" id ="is_edit"></th>
                                                <th>Delete <input type="checkbox" id ="is_delete"></th>
                                            </tr>
                                        </thead> 
                                        <tbody id="RolePositionSorting">
                                    @if(count($modules)>0)
                                        @foreach($modules as $index => $module)
                                            <tr class="module"> 
                                                <td style="width: 50px;">{{ $index+1 }}</td>
                                                <td colspan="7">{{$module['module_name']}}  @if(count($module['sub_modules'])>0) <i class="fa fa-arrow-down"> @endif</td> 
                                            </tr>
                                            @if(count($module['sub_modules'])>0)
                                                @foreach($module['sub_modules'] as $submoduleIndex => $submodule)
                                                    @php $permission = $submodule['role_permission']; @endphp
                                                    <tr> 
                                                        <td style="width: 45px;">{{ $index+1 }}. {{ $submoduleIndex+1 }}</td>
                                                        <td style="padding-left: 140px" colspan="2"> {{ $submodule['module_name'] }} <input type="hidden" name="modules[{{$submodule['id']}}]"  value="{{$submodule['id']}}" >
                                                            <input type="hidden" name="permission_id[{{$submodule['id']}}]"  value="{{ (isset($permission['id'])) ? $permission['id'] : ''  }}" >
                                                        </td> 
                                                        <td>@if($submodule['is_view_vissible'])
                                                            <input type="checkbox" @if(isset($permission['is_view']) && $permission['is_view'] == 1) checked @endif value="1" class="is_view" name="is_view[{{$submodule['id']}}]">
                                                            @endif
                                                        </td> 
                                                        <td>@if($submodule['is_add_vissible'])
                                                            <input type="checkbox" @if(isset($permission['is_add']) && $permission['is_add'] == 1) checked @endif value="1" class="is_add" name="is_add[{{$submodule['id']}}]">
                                                            @endif
                                                        </td> 
                                                        <td>@if($submodule['is_edit_vissible'])
                                                            <input type="checkbox" @if(isset($permission['is_edit']) && $permission['is_edit'] == 1) checked @endif value="1" class="is_edit" name="is_edit[{{$submodule['id']}}]">
                                                            @endif
                                                        </td> 
                                                        <td>@if($submodule['is_delete_vissible'])
                                                            <input type="checkbox" @if(isset($permission['is_delete']) && $permission['is_delete'] == 1) checked @endif value="1" class="is_delete" name="is_delete[{{$submodule['id']}}]">
                                                            @endif
                                                        </td> 
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                        </tbody>
                                    </table>
                                    <div class="form-actions pull-right" style="float: right;">
                                        <button type="submit"  name="submit" value="save" class="btn btn-success"> <i class="fa fa-save"></i> Update Permission </button>

                                        <button type="reset" class="btn waves-effect waves-light btn-secondary">Reset</button>
                                        <a href="{{ url()->previous() }}" class="btn waves-effect waves-light btn-secondary">Cancel</a>
                                    </div>
                                    </form>
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

@endsection
@section('js')
    <!-- This is data table -->
    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>

   <script>
       // responsive table
        $('#config-table').DataTable({
            responsive: true,
             ordering: false
        });
    </script>

    <script type="text/javascript">
        //on click select all products
        $('#is_view').on('click', function() {
            if (this.checked == true){
                $(".is_view").prop("checked", true);
            }
            else{
                $(".is_view").prop('checked', false);
            }
        }); $('#is_add').on('click', function() {
            if (this.checked == true){
                $(".is_add").prop("checked", true);
            }
            else{
                $(".is_add").prop('checked', false);
            }
        }); $('#is_edit').on('click', function() {
            if (this.checked == true){
                $(".is_edit").prop("checked", true);
            }
            else{
                $(".is_edit").prop('checked', false);
            }
        }); $('#is_delete').on('click', function() {
            if (this.checked == true){
                $(".is_delete").prop("checked", true);
            }
            else{
                $(".is_delete").prop('checked', false);
            }
        });
    </script>
@endsection
