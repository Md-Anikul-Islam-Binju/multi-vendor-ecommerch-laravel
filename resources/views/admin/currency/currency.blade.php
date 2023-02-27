@extends('layouts.admin-master')
@section('title', 'Currency list')

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
                        <h4 class="text-themecolor">Currency List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Currency</a></li>
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
                                                <th>Currency Name</th>
                                                <th>Currency code</th>
                                                <th>Currency symbol</th>
                                                <th>Exchange rate</th>
                                                <th>Default Currency</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead> 
                                        <tbody id="positionSorting" data-table="currencies">
                                            @foreach($currencies as $currency)
                                            <tr id="item{{$currency->id}}">
                                                <td>{{$currency->name}}</td>
                                                <td>{{$currency->code}}</td>
                                                <td>{{$currency->symbol}}</td>
                                                <td>{{$currency->exchange_rate}}</td>
                                                <td>
                                                    <div class="custom-control custom-switch">
                                                      <input  name="default" onclick="currencyDefaultSet('{{$currency->id}}')"  type="checkbox" {{($currency->default == 1) ? 'checked' : ''}}  type="checkbox" class="custom-control-input" id="default{{$currency->id}}">
                                                      <label style="padding: 5px 12px" class="custom-control-label" for="default{{$currency->id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-switch">
                                                      <input  name="status" onclick="satusActiveDeactive('currencies', {{$currency->id}})"  type="checkbox" {{($currency->status == 1) ? 'checked' : ''}}  type="checkbox" class="custom-control-input" id="status{{$currency->id}}">
                                                      <label style="padding: 5px 12px" class="custom-control-label" for="status{{$currency->id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" onclick="edit('{{$currency->id}}')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> Edit</button>
                                                    <button data-target="#delete" onclick="deleteConfirmPopup('{{route("currency.delete", $currency->id)}}')" class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> Delete</button>
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
        <!-- update Modal -->
        <div class="modal fade" id="add" role="dialog"   style="display: none;">
            <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Currency</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <form action="{{route('currency.store')}}" method="POST" >
                                {{csrf_field()}}
                                <div class="form-body">
                                     <div class="row form-group">
                                            <label class="col-md-2 control-label" for="name">Name</label>
                                            <div class="col-md-10">
                                                <input type="text" placeholder="Name" id="name" name="name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <label class="col-md-2 control-label" for="symbol">Symbol</label>
                                            <div class="col-md-10">
                                                <input type="text" placeholder="Symbol" id="symbol" name="symbol" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <label class="col-md-2 control-label" for="code">Code</label>
                                            <div class="col-md-10">
                                                <input type="text" placeholder="Code" id="code" name="code" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <label class="col-md-2 control-label" for="exchange_rate">Exchange Rate</label>
                                            <div class="col-md-10">
                                                <input type="number" step="0.01" min="0" placeholder="Exchange Rate" id="exchange_rate" name="exchange_rate" class="form-control" required>
                                            </div>
                                        </div>
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="head-label">
                                                <label class="switch-box" style="top:-12px;">Status</label>
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
        <div class="modal fade" id="edit" role="dialog"   style="display: none;">
            <div class="modal-dialog">
                <form action="{{route('currency.update')}}"  method="post">
                      {{ csrf_field() }}
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Currency</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row" >
                        <div class="card-body" id="edit_form"></div>
                    </div>
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

    <!-- end - This is for export functionality only -->
    <script>
        $(document).ready( function() {
            $('#myTable').dataTable({
                "ordering": false
            });
        })
    </script>

    <script type="text/javascript">
    
        function edit(id){
            var  url = '{{route("currency.edit", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#edit_form").html(data);
                    }
                }
            });
        }
            
    </script>

    <script type="text/javascript">
        //change status by id
        function currencyDefaultSet(id){
            var  url = '{{route("currency.defaultSet")}}';
            $.ajax({
                url:url,
                method:"get",
                data:{id:id},
                success:function(data){
                    if(data.status){
                        toastr.success(data.msg);
                    }else{
                        toastr.error(data.msg);
                    }
                }
            });
        }
    </script>   

@endsection
