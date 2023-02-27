@extends('layouts.admin-master')
@section('title', $section->title)

@section('css-top')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/jquery-asColorPicker-master/dist/css/asColorPicker.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
@endsection
@section('css')
    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .dropify-wrapper{height: 120px;}
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
                        <h4 class="text-themecolor">{{$section->title}} List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">{{$section->title}}</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Add New Item</button>
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
                                    <table  class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Sub Title</th>
                                                <th>Image</th>
                                                <th>Link</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="positionSorting" data-table="homepage_section_items">
                                            @foreach($sectionItems as $item)
                                            <tr style="background:{{$item->background_color}};color: {{$item->text_color}}" id="item{{$item->id}}">
                                                <td>
                                                    {{$item->item_title}}
                                                   
                                                </td>
                                                <td>{{$item->item_sub_title}}</td>
                                                <td> <img src="{{ asset('upload/images/homepage/'.$item->thumb_image) }} " width="40" alt=""></td>
                                                <td>{{$item->custom_url}}</td>
                                                <td>
                                                    <div class="custom-control custom-switch" style="padding-left: 3.25rem;">
                                                      <input name="status" onclick="satusActiveDeactive('homepage_section_items', {{$item->id}})"  type="checkbox" {{($item->status == 'active') ? 'checked' : ''}} class="custom-control-input" id="status{{$item->id}}">
                                                      <label class="custom-control-label" for="status{{$item->id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" onclick="edit('{{$item->id}}')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> Edit</button>
                                                    @if($item->is_default != 1)
                                                    <button title="Delete" data-target="#delete" onclick="deleteConfirmPopup('{{route("admin.homepageSectionItem.remove", $item->id)}}')" class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> </button>
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

        <!-- update Modal -->
        <div class="modal fade" id="edit" role="dialog" style="display: none;">
            <div class="modal-dialog">
                <form action="{{route('admin.homepageSectionItem.update')}}" data-parsley-validate method="post" enctype="multipart/form-data">
                      {{ csrf_field() }}
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update {{$section->title}}</h4>
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
        <!-- add Modal -->
        <div class="modal fade" id="add">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create {{$section->title}}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <form action="{{route('admin.homepageSectionItem.store')}}" method="POST" enctype="multipart/form-data" data-parsley-validate>
                                {{csrf_field()}}
                                <input type="hidden" value="{{$section->id}}" name="section_id">
                                <input type="hidden" value="{{$section->section_type}}" name="section_type">
                                <div class="form-body">
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Section Title</label>
                                                <input placeholder="Enter Title" name="item_title" id="name" value="{{old('item_title')}}" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sub_title">Sub Title</label>
                                                <input  name="item_sub_title" placeholder="Enter sub title" id="sub_title" value="{{old('item_sub_title')}}" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group"> 
                                                <label class="dropify_image">Image</label>
                                                <input required type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="10M"  name="thumb_image" id="input-file-events">
                                                <i class="info">Recommended size: 150px*150px</i>
                                            </div>
                                            @if ($errors->has('thumb_image'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('thumb_image') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="name">Custom Url</label>
                                                <input name="custom_url" required class="form-control" >
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="head-label">
                                                <label class="switch-box">Status</label>
                                                <div  class="status-btn" >
                                                    <div class="custom-control custom-switch">
                                                        <input name="status" checked  type="checkbox" class="custom-control-input" {{ (old('status') == 'on') ? 'checked' : '' }} id="status">
                                                        <label  class="custom-control-label" for="status">Publish/UnPublish</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
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
        <!-- delete Modal -->
        @include('admin.modal.delete-modal')

@endsection
@section('js')
    
    <script src="{{asset('assets')}}/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
     <script type="text/javascript" src="{{asset('assets')}}/node_modules/multiselect/js/jquery.multi-select.js"></script>
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <!-- Color Picker Plugin JavaScript -->
    <script src="{{asset('assets')}}/node_modules/jquery-asColor/dist/jquery-asColor.js"></script>
    <script src="{{asset('assets')}}/node_modules/jquery-asGradient/dist/jquery-asGradient.js"></script>
    <script src="{{asset('assets')}}/node_modules/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
    <script>

    // Colorpicker
  
    $(".gradient-colorpicker").asColorPicker({
        mode: 'gradient'
    });

    $(".select2").select2();
    </script>

    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();
       
    });
    </script>
    <script type="text/javascript">

    function edit(id){
        $('#edit_form').html('<div class="loadingData"></div>');
        var  url = '{{route("admin.homepageSectionItem.edit", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#edit_form").html(data);
                    $(".select2").select2();
                     $('.dropify').dropify();
                    $(".gradient-colorpicker").asColorPicker({
                        mode: 'gradient'
                    });
                }
            },
            // $ID Error display id name
            @include('common.ajaxError', ['ID' => 'edit_form'])
        });

    }

    // get category Sourch
    function getSubcateogry(category_id, edit=''){

        var  url = '{{route("admin.getSubChildcategory")}}';
        if(category_id != ''){
            $.ajax({
                url:url,
                method:"get",
                data:{category_id:category_id},
                success:function(data){

                    if(data){
                        $("#"+edit+"showSubcateogry").html(data);
                        $(".select2").select2();
                    }else{
                        $("#"+edit+"showSubcateogry").html('<option>Category not found</option>');
                    }
                }
            });
        }else{
            $("#"+edit+"showSubcateogry").html('<option>Category not found</option>');
        }
    }


        // if occur error open model
        @if($errors->any())
            $("#{{Session::get('submitType')}}").modal('show');
        @endif
    </script>

@endsection
