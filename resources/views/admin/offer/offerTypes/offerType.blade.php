@extends('layouts.admin-master')
@section('title', 'Offer type list')
@section('css-top')
  <link href="{{asset('assets')}}/node_modules/jquery-asColorPicker-master/dist/css/asColorPicker.css" rel="stylesheet" type="text/css" />
  @endsection
  @section('css')
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
    .asColorPicker_open{z-index: 9999999;border:1px solid #ccc;}
               
        .dropify-wrapper{  height: 120px !important; }
        #showProductArea{max-height: 450px; overflow-y: auto;}
        .discount_type{padding: 8px 3px; border: 1px solid #ccc; border-radius: 5px;}
        .image_size{font-size: 11px;}
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
                        <h4 class="text-themecolor">Offer type List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Offer type</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i
                                    class="fa fa-plus-circle"></i> Add New type</button>
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
                                <i class="drag-drop-info">Drag & drop sorting position</i>
                            
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Offer Type</th>
                                                <th>Sub title</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead> 
                                        <tbody id="positionSorting" data-table="offer_types">
                                            @foreach($offerTypes as $index => $offerType)
                                            <tr id="item{{$offerType->id}}">
                                                <td>{{ $index+1 }}</td>
                                                <td><img src="{{asset('upload/images/offer/'. $offerType->image)}}" width="50" height="50"> {{$offerType->title}}</td>
                                                <td>{{$offerType->sub_title}}</td>
                                                <td>

                                                    <div class="custom-control custom-switch" >
                                                      <input name="status" onclick="satusActiveDeactive('offer_types', {{$offerType->id}})"  type="checkbox" {{($offerType->status == 1) ? 'checked' : ''}} class="custom-control-input" id="status{{$offerType->id}}">
                                                      <label class="custom-control-label" for="status{{$offerType->id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" onclick="edit('{{$offerType->id}}')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> Edit</button>
                                                    @if($offerType->is_default != 1)
                                                    <button data-target="#delete" onclick='deleteConfirmPopup("{{route("offerType.delete", $offerType->id)}}")' class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> Delete</button>
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
        <div class="modal fade" id="add" role="dialog" style="display: none;">
            <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add new offer type</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <form action="{{route('offerType.store')}}" enctype="multipart/form-data" method="POST" >
                                {{csrf_field()}}
                                <div class="form-body">
                                   
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="title">Offer Title</label>
                                                <input required="" name="title" id="title" value="{{old('title')}}" type="text" class="form-control">
                                                @if ($errors->has('title'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('title') }}
                                                </span>
                                            @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="sub_title">Sub Title</label>
                                                <input name="sub_title" id="sub_title" value="{{old('sub_title')}}" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Bacground Color</label>
                                                <input name="background_color" type="text" value="#ccc" class="gradient-colorpicker form-control ">
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <div class="form-group">
                                                <label for="name">Text Color</label>
                                                <input name="text_color" value="#000000" class="gradient-colorpicker form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-group"> 
                                                <label class="required" class="dropify_image">Image</label>
                                                <input type="file" required class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="5M"  name="image" id="input-file-events">
                                                <i class="image_size">Image Size:400px * 250px </i>
                                            </div>
                                            @if ($errors->has('image'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('image') }}
                                                </span>
                                            @endif
                                        </div>
                                    
                                        <div class="col-md-8 col-6">
                                            <div class="form-group"> 
                                                <label class="dropify_image">Banner Image</label>
                                                <input  type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="10M"  name="banner" id="input-file-events">
                                                <i class="image_size">Image Size:1200px * 300px </i>
                                            </div>
                                            @if ($errors->has('banner'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('banner') }}
                                                </span>
                                            @endif
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
                                                <button type="submit" name="submitType" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Add new type</button>
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
        <div class="modal fade" id="edit" role="dialog"  style="display: none;">
            <div class="modal-dialog">
                <form action="{{route('offerType.update')}}" enctype="multipart/form-data"  method="post">
                      {{ csrf_field() }}
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update offer type</h4>
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
    <script src="{{asset('assets')}}/node_modules/jqueryui/jquery-ui.min.js"></script>
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
            var  url = '{{route("offerType.edit", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#edit_form").html(data);
                        $('.dropify').dropify();
                        $(".gradient-colorpicker").asColorPicker({
                            mode: 'gradient'
                        });
                    }
                }, 
                // ID = Error display attribute id name
                @include('common.ajaxError', ['ID' => 'edit_form'])

            });

    }

    </script>
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
     <script>
    $(document).ready(function() { // Basic
        $('.dropify').dropify();
    });
    </script>
        <!-- Color Picker Plugin JavaScript -->
    <script src="{{asset('assets')}}/node_modules/jquery-asColor/dist/jquery-asColor.js"></script>
    <script src="{{asset('assets')}}/node_modules/jquery-asGradient/dist/jquery-asGradient.js"></script>
    <script src="{{asset('assets')}}/node_modules/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
    <script>
    $(".gradient-colorpicker").asColorPicker({
        mode: 'gradient'
    });
    </script>
@endsection
