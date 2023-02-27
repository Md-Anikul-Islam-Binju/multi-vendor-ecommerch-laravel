@extends('layouts.admin-master')
@section('title', 'Coupon list')
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
                        <h4 class="text-themecolor">Coupon List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Coupon</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i
                                    class="fa fa-plus-circle"></i> Add New Coupon</button>
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
                                                <th>Coupon Code</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Quantity</th>
                                                <th>Used</th>
                                                <th>Start Date</th>
                                                <th>Expired Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            @foreach($get_coupons as $coupon)
                                            <tr id="item{{$coupon->id}}">
                                                <td>{{$coupon->coupon_code}}</td>
                                                <td>{{ ($coupon->type == 0) ? "Percentage" : 'Fixed Amount'}}</td>
                                                <td>@if(($coupon->type == 0)) {{$coupon->amount}}% @else{{Config::get('siteSetting.currency_symble')}}{{$coupon->amount}}@endif </td>
                                                <td>@if($coupon->times) {{$coupon->times}} @else Unlimited @endif </td>
                                                <td>{{$coupon->used}}</td>
                                                <td>{{Carbon\Carbon::parse($coupon->start_date)->format(Config::get('siteSetting.date_format'))}} </td>
                                                <td>{{Carbon\Carbon::parse($coupon->expired_date)->format(Config::get('siteSetting.date_format'))}} </td>
                                                
                                                
                                                <td>{!!($coupon->status == 1) ? "<span class='label label-info'>Active</span>" : '<span class="label label-danger">Deactive</span>'!!} 
                                                </td>
                                                <td>
                                                    <button title="Edit" type="button" onclick="edit('{{$coupon->id}}')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> </button>
                                                    <button title="Delete" data-target="#delete" onclick='deleteConfirmPopup("{{route("coupon.delete", $coupon->id)}}")' class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> </button>
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
                        <h4 class="modal-title">Add New Coupon</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <form action="{{route('coupon.store')}}" method="POST" class="floating-labels">
                                {{csrf_field()}}
                                <div class="form-body">
                                   
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="title">Coupon Cpde</label>
                                                <input required="" name="coupon_code" id="title" value="{{old('coupon_code')}}" type="text" class="form-control">
                                                @if ($errors->has('coupon_code'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('coupon_code') }}
                                                </span>
                                            @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="type">Type</label>
                                                <select class="form-control" name="type" id="type" required>
                                                <option >Choose a type</option>
                                                <option value="0">Percentage</option>
                                                <option value="1">Fixed Amount</option>
                                              </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12" id="amountField" style="display: none;">
                                            <div class="form-group">
                                                <label for="amount" id="typeTitle">Amount</label>
                                                <input required=""  name="amount" id="amount" value="{{old('amount')}}"  type="number" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="amount">Quantity</label>
                                                <select class="form-control" id="time">
                                                    <option value="0">Unlimited</option>
                                                    <option value="1">Limited</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="times" style="display: none;">
                                            <div class="form-group">
                                                <label for="value">Number of time</label>
                                                <input class="form-control" name="times" id="value" placeholder="Enter times" type="text" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="required" for="value">Start date</label>
                                                <input required="" class="form-control" name="start_date" placeholder="Enter date" type="date">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="required" for="value">Expired date</label>
                                                <input required="" class="form-control" name="expired_date" placeholder="Enter date" type="date">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label style="background: #fff;top:-10px;z-index: 1" for="notes">Notes</label>
                                                <textarea name="notes" class="form-control" placeholder="Enter details" id="notes" rows="1">{{old('notes')}}</textarea>
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
                                                <button type="submit" name="submitType" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Add New Coupon</button>
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
                <form action="{{route('coupon.update')}}" enctype="multipart/form-data"  method="post">
                      {{ csrf_field() }}
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Coupon</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row" id="edit_form"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name="submitType" value="edit" class="btn btn-sm btn-success">Update</button>
                    </div>
                  </div>
                </form>
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
    $('#type').on('change', function() {
      var val = $(this).val();
      if(val == 0)
      {
        $("#typeTitle").html("Enter Percentage");
        $("#amount").attr("placeholder", "Ex. 10");
        $("#amountField").show();
      }
      else if(val == 1){
        $("#typeTitle").html("Enter Amount");
        $("#amount").attr("placeholder", "Ex. 100");
        $("#amountField").show();
      }
      else{
      $("#amountField").hide();
      $("#amount").val("");      
      }
    });

    $(document).on("change", "#time" , function(){
        var val = $(this).val();
        if(val == 1){
        $("#times").show();
        }
        else{
        $("#value").val("");
        $("#times").hide();    
        }
    });

</script>

    <script type="text/javascript">

        function edit(id){
            $('#edit_form').html('<div class="loadingData"></div>');
            var  url = '{{route("coupon.edit", ":id")}}';
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
