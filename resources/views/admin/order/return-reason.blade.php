@extends('layouts.admin-master')
@section('title', 'Order cancel reason list')
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
                        <h4 class="text-themecolor">Return Reason List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Return reason</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>

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
                                                <th>OrderId</th>
                                                <th>Reason Title</th>
                                                <th>Products</th>
                                                <th>Status</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead> 
                                        <tbody id="positionSorting">
                                            @foreach($requestList as $reason)
                                            <tr id="item{{$reason->id}}">
                                                <td>{{ $reason->order_id }}</td>
                                                <td>{{$reason->reason}}</td>
                                                <td>
                                                    @php
                                                    $productList = \App\Models\Product::whereIn('id', explode(',',$reason->products))->get();
                                                    @endphp
                                                    @foreach($productList as $item)
                                                        <li>{{ $item->title }}</li>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-switch">
                                                      <input  name="status" onclick="satusActiveDeactive('return_requests', {{$reason->id}})"  type="checkbox" {{($reason->status == 1) ? 'checked' : ''}}  type="checkbox" class="custom-control-input" id="status{{$reason->id}}">
                                                      <label style="padding: 5px 12px" class="custom-control-label" for="status{{$reason->id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                   @if($reason->order->order_status!=='return')
                                                    <button type="button" onclick="edit('{{$reason->id}}')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> Approve</button>
                                                    @else
                                                       <span class="badge badge-secondary">{{$reason->order->order_status}}</span>
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
                        <h4 class="modal-title">Add Order Cancel Reason</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <form action="{{route('orderCancelReason.store')}}" enctype="multipart/form-data" method="POST" class="floating-labels">
                                {{csrf_field()}}
                                <div class="form-body">
                                   
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="reason">Order Cancel Reason</label>
                                                <input required="" name="reason" id="reason" value="{{old('reason')}}" type="text" class="form-control">
                                                @if ($errors->has('reason'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('reason') }}
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
                                                <button type="submit" name="submitType" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Save cancel reason</button>
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

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update cancel reason</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>      <div class="modal-body form-row" id="edit_form"></div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name="submitType" value="edit" class="btn btn-sm btn-success">Update</button>
                    </div>
                  </div>

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
            var  url = '{{route("order.return.approve.form", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#edit_form").html(data);
                    }
                }, 
                // ID = Error display attribute id name
                @include('common.ajaxError', ['ID' => 'edit_form'])

            });
    }

</script>

@endsection
