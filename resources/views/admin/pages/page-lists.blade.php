@extends('layouts.admin-master')
@section('title', 'Page list')
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
                        <h4 class="text-themecolor">Page List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Page</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <a href="{{route('page.create')}}" class="btn btn-info d-none d-lg-block m-l-15"><i
                                    class="fa fa-plus-circle"></i> Create New Page</a>
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
                                                <th>Page Title</th>
                                                <th>Page Link</th>
                                                <th>Display In</th>
                                                <th>Is Default</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead> 
                                        <tbody id="positionSorting" data-table="pages">
                                            @foreach($pages as $data)
                                            <tr id="item{{$data->id}}">
                                                <td>{{$data->title}}</td>

                                                <td>
                                                    <a href="{{url(($data->slug == 'homepage') ? '/' :  $data->slug)}}" target="_blank">Copy Link <i class="fas fa-external-link-alt"></i> </a>
                                                   </td>
                                                <td>
                                                    @if($data->top_header == 1) Top Header Menu <br/> @endif
                                                    @if($data->main_header == 1) Main Header Menu<br/> @endif
                                                    @if($data->footer == 1) Footer Menu @endif
                                                </td>
                                                <td>@if($data->is_default ==1)<span class="label label-warning">Default</span>@else<span class="label label-info">Custom</span>@endif</td>
                                                <td>
                                                    <div class="custom-control custom-switch" style="padding-left: 3.25rem;">
                                                      <input name="status" onclick="satusActiveDeactive('pages', {{$data->id}})"  type="checkbox" {{($data->status == 1) ? 'checked' : ''}} class="custom-control-input" id="status{{$data->id}}">
                                                      <label class="custom-control-label" for="status{{$data->id}}"></label>
                                                    </div>
                                                </td>
                                                 
                                                <td>
                                                    <a href="{{ route('page.edit', $data->slug)}}"  class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> Edit</a>
                                                    @if($data->is_default !=1)
                                                    <button data-target="#delete" onclick='deleteConfirmPopup("{{route("page.delete", $data->id)}}")' class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> Delete</button>
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

       @include('admin.modal.delete-modal')

@endsection
@section('js')
    <script src="{{asset('assets')}}/node_modules/jqueryui/jquery-ui.min.js"></script>
    <!-- This is data table -->
    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
   <script>
        $(function () {
           $('#myTable').dataTable({
                "ordering": false
            });
        });
        
        function copyURI(evt) {
            evt.preventDefault();
            navigator.clipboard.writeText(evt.target.getAttribute('href')).then(() => {
             alert('link copy success');
            }, () => {
              /* clipboard write failed */
            });
        }

        </script>

    <script type="text/javascript">
        //change status by id
        function satusActiveDeactive(table, id, field = null){
            var  url = '{{route("statusChange")}}';
            $.ajax({
                url:url,
                method:"get",
                data:{table:table,field:field,id:id},
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
   
@endsection
