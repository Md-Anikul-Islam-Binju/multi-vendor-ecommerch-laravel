@extends('layouts.admin-master')
@section('title', 'Product brand list')
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <!-- page css -->
    <link href="{{asset('assets')}}/node_modules/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
    
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
                                <h4 class="card-title">Bootstrap Switch</h4>
                                <div class="row">
                                    <div class="col-lg-12 bt-switch">
                                        <h4>Sizes</h4>
                                        <p class="text-muted font-13">Just add <code>data-size="Size"</code> attribute to the <code>&lt;input type="checkbox"...&gt;</code>. Size values: <code>mini, small, normal, large</code>.</p>
                                        <div class="m-b-30">
                                            <input type="checkbox" checked data-size="mini" />
                                            <input type="checkbox" checked data-size="small" />
                                            <input type="checkbox" checked data-size="normal" />
                                            <input type="checkbox" checked data-size="large" /> </div>
                                        <h4>Colors</h4>
                                        <p class="text-muted font-13">Just add <code>data-on-color="Color"</code> & <code>data-off-color="Color"</code> to the <code>&lt;input type="checkbox"...&gt;</code>. Color values: <code>primary, info, success, warning, danger, default</code>.</p>
                                        <div class="m-b-30">
                                            <input type="checkbox" checked data-on-color="primary" data-off-color="info">
                                            <input type="checkbox" checked data-on-color="info" data-off-color="success">
                                            <input type="checkbox" checked data-on-color="success" data-off-color="warning">
                                            <input type="checkbox" checked data-on-color="warning" data-off-color="danger">
                                            <input type="checkbox" checked data-on-color="danger" data-off-color="default">
                                            <input type="checkbox" checked data-on-color="default" data-off-color="primary"> </div>
                                        <h4>Disabled/Readonly</h4>
                                        <p class="text-muted font-13">Just add <code>disabled</code> or <code>readonly</code> attribute to the <code>&lt;input type="checkbox"...&gt;</code>.</p>
                                        <div class="m-b-30">
                                            <input type="checkbox" checked disabled data-on-color="primary" data-off-color="info">
                                            <input type="checkbox" readonly data-on-color="info" data-off-color="success"> </div>
                                        <h4>With Text</h4>
                                        <p class="text-muted font-13">Just add <code>data-on-text="Text"</code> & <code>data-off-text="Text"</code> to the <code>&lt;input type="checkbox"...&gt;</code>.</p>
                                        <div class="m-b-30">
                                            <input type="checkbox" checked data-on-color="success" data-off-color="info" data-on-text="Yes" data-off-text="No">
                                            <input type="checkbox" checked data-on-color="info" data-off-color="success" data-on-text="1" data-off-text="0"> </div>
                                        <h4>With Long Text</h4>
                                        <p class="text-muted font-13">Just add <code>data-on-text="Long Text"</code> & <code>data-off-text="Long Text"</code> to the <code>&lt;input type="checkbox"...&gt;</code>.</p>
                                        <div class="m-b-30">
                                            <input type="checkbox" checked data-on-color="danger" data-off-color="warning" data-on-text="Showed" data-off-text="Not Showed">
                                            <input type="checkbox" checked data-on-color="warning" data-off-color="danger" data-on-text="Enabled" data-off-text="Disabled"> </div>
                                        <h4>Label Text</h4>
                                        <p class="text-muted font-13">Just add <code>data-on-text="Text"</code> or <code>data-off-text="Text"</code> to the <code>&lt;input type="checkbox"...&gt;</code>.</p>
                                        <div class="m-b-30">
                                            <input type="checkbox" checked data-on-color="danger" data-off-color="success" data-on-text="Radio">
                                            <input type="checkbox" checked data-on-color="success" data-off-color="danger" data-off-text="Waves"> </div>
                                        <h4>With HTML</h4>
                                        <p class="text-muted font-13">Just add <code>data-on-text="HTML Text"</code> & <code>data-off-text="HTML Text"</code> to the <code>&lt;input type="checkbox"...&gt;</code>.</p>
                                        <div class="m-b-30">
                                            <input type="checkbox" checked data-on-color="primary" data-off-color="info" data-on-text="<i class='fas fa-sun'></i>" data-off-text="<i class='fa fa-cloud'></i>">
                                            <input type="checkbox" checked data-on-color="info" data-off-color="success" data-on-text="<i class='fa fa-phone'></i>" data-off-text="<i class='fa fa-envelope'></i>"> </div>
                                        <h4>Radio Buttons</h4>
                                        <p class="text-muted font-13">Just add class <code>radio-switch</code> to the <code>&lt;input type="radio"...&gt;</code>. If you want to change the class name, you have to change jquery according to that.</p>
                                        <div class="m-b-30">
                                            <div class="form-group">
                                                <label for="option1">Option 1</label>
                                                <input id="option1" type="radio" name="radiobt" value="option1" class="radio-switch"> </div>
                                            <div class="form-group">
                                                <label for="option2">Option 2</label>
                                                <input id="option2" type="radio" name="radiobt" value="option2" class="radio-switch"> </div>
                                            <div class="form-group">
                                                <label for="option3">Option 3</label>
                                                <input id="option3" type="radio" name="radiobt" value="option3" class="radio-switch"> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Page Title</th>
                                                <th>Show Header</th>
                                                <th>Show Footer</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            @foreach($pages as $data)
                                            <tr id="item{{$data->id}}">
                                                <td>{{$data->title}}</td>
                                                <td>{!!($data->show_header == 1) ? "<button class='label label-info'>Active</button>" : '<span class="label label-danger">Deactive</span>'!!} 
                                                </td>
                                                <td>

                                                    
                                                    <div class="btn-group">
                                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <button class="dropdown-item text-success" title="View product" data-toggle="tooltip" href=""><i class="ti-eye"></i> Showed</button>
                                                        <button class="dropdown-item text-danger" title="Edit product" data-toggle="tooltip" href=""><i class="fa fa-eye-slash"></i> Not Showed</button>
                                                        
                                                    </div>
                                                    </div>                                                  
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-switch" style="padding-left: 3.25rem;">
                                                      <input name="status" onclick="satusActiveDeactive({{$data->id}})"  type="checkbox" {{($data->status == 1) ? 'checked' : ''}} class="custom-control-input" id="status{{$data->id}}">
                                                      <label class="custom-control-label" for="status{{$data->id}}"></label>
                                                    </div>
                                                </td>
                                                

                                                <td>
                                                    
                                                    <button type="button" onclick="edit('{{$data->id}}')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> Edit</button>
                                                    <button data-target="#delete" onclick="confirmPopup('{{ $data->id }}')" class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> Delete</button>
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

    
        <!-- delete Modal -->
        <div id="delete" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="icon-box">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <h4 class="modal-title">Are you sure?</h4>
                        <p>Do you really want to delete these records? This process cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                        <button type="button" value="" id="itemID" onclick="deleteItem(this.value)" data-dismiss="modal" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>


@endsection
@section('js')
    <!-- This is data table -->
    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
   <script>
        $(function () {
            $('#myTable').DataTable();
        });


         function satusActiveDeactive(id){

            var  url = '{{route("page.status", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data.status == 'publish'){
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }
                }
            });
        }
        function menuStatus(id){

            var  url = '{{route("page.menuStatus", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data.status == 'added'){
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }
                }
            });
        }
    </script>

   <script src="{{asset('assets')}}/node_modules/bootstrap-switch/bootstrap-switch.min.js"></script>
    <script type="text/javascript">
    $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();></script>
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
@endsection
