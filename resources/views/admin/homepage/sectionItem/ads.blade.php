@extends('backend.layouts.master')
@section('title', 'ads section list')

@section('css-top')
    <link href="{{asset('backend/assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
  
@endsection
@section('css')
    
    <style type="text/css">
        .asColorPicker_open{z-index: 9999999}
       
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
                        <h4 class="text-themecolor">Ads section List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">ads</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Add New</button>
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
                                                <th>Ads</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="positionSorting" data-table="homepage_section_items">
                                            @foreach($sectionItems as $data)
                                            <tr id="item{{$data->id}}">
                                                <td>
                                                    {{$data->item_title}}
                                                    @if($data->item_sub_title)
                                                    <p>{{$data->item_sub_title}}</p>@endif
                                                </td>
                                                <td>
                                                	@if($data->ads_details)
	                                                	<p>{{$data->ads_details->adsType}} ads</p>
	                                                	@if($data->ads_details->adsType == 'image')
	                                                	<img height ="50" src="{{ asset('upload/ads/'.$data->ads_details->image) }}">
	                                                	@endif
	                                                	@if($data->ads_details->adsType == 'others')
	                                                		{{$data->ads_details->add_code}}
	                                                	@endif
                                                	@else <span style="color:red"> Add not found. </span> @endif
                                                </td>
                                                
                                               
                                                <td>
                                                    <div class="custom-control custom-switch" style="padding-left: 3.25rem;">
                                                      <input name="status" onclick="satusActiveDeactive('homepage_section_items', {{$data->id}})"  type="checkbox" {{($data->status == 1) ? 'checked' : ''}} class="custom-control-input" id="status{{$data->id}}">
                                                      <label class="custom-control-label" for="status{{$data->id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    
                                                   
                                                    <button title="Delete" data-target="#delete" onclick="deleteConfirmPopup('{{route("admin.homepageSectionItem.remove", $data->id)}}')" class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> </button>
                                                   
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
                <form action="{{route('admin.homepageSectionItem.update')}}"  method="post">
                      {{ csrf_field() }}
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update ads section</h4>
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
                        <h4 class="modal-title">Add ads section</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <form action="{{route('admin.homepageSectionItem.store')}}" enctype="multipart/form-data" method="POST" >
                                {{csrf_field()}}
                                <input type="hidden" value="{{$section->id}}" name="section_id">
                                <input type="hidden" value="{{$section->section_type}}" name="section_type">
                                <div class="form-body">
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Section Title</label>
                                                <input placeholder="Enter Title" name="item_title" id="name" value="{{old('item_title')}}" required="" type="text" class="form-control">
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
                                                <label class="required" for="adsSourch">Select Ads</label>
                                                <select required onchange="getAdsSourch(this.value)" name="adsSourch" id="adsSourch" class="select2 form-control custom-select">
                                                   <option value="">Select Type</option>
                                                   <option value="new">Add new ads</option>
                                                   <option value="buildIn">Build-in Ads</option>
                                                   
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="showgetAdsSourch"></div>
                                        <div class="col-md-12" id="showAdsType"></div>

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
        @include('backend.modal.delete-modal')

@endsection
@section('js')
    
    <script src="{{asset('backend/assets')}}/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>

    <script src="{{asset('backend/assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

    <script src="{{asset('backend/assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
    
    <script type="text/javascript">
    	$('.dropify').dropify();
    	$(".select2").select2();


    function getAdsSourch(type, edit=''){
    	$('#editshowAdsType').html('');
        $('#showAdsType').html('');
    	var output = '';
        if(type == 'new'){
            output = '<div class="form-group"><label for="adsType required">Select Advertisement Type</label><select name="adsType" onchange=adsTypes(this.value) required="required" id="adsType" class="form-control custom-select"><option value="">Select Type</option><option value="google" > Google Adsense</option><option value="image" >Image Ads</option><option value="others">Others Ads</option></select></div>';
        }else if(type = 'buildIn'){
        	output = '<div class="form-group"> <label class="required" for="ads_id">Select ads</label>  <select required name="ads_id" id="ads_id" class="select2 form-control custom-select"> <option value="">Select ads</option> @foreach($allAds as $ads) <option value="{{$ads->id}}">{{$ads->ads_name}} ({{$ads->adsType}})</option> @endforeach </select> </div>';
        }else{
            output = '';
        }
        if(edit == 'edit'){
            $('#editgetAdsSourch').html(output);
            $('#showgetAdsSourch').html('');
        }else{
            $('#showgetAdsSourch').html(output);
            $('#editgetAdsSourch').html('');
        }
        $(".select2").select2();
    }

    function adsTypes(type, edit=''){

    	var output = '';
        if(type == 'image'){
            output = '<div class="form-group"><label class="dropify_image_area required">Add Images</label> <div class="form-group"> <input required type="file" name="image" id="input-file-now" class="dropify" /> </div> </div><div class="form-group"> <label for="redirect_url">Redirect URL</label>  <input type="text" name="redirect_url"  id="redirect_url" class="form-control" > </div>';
        }else if(type == 'google'){
        	output = '<div class="form-group"> <label class="required" for="add_code">Add code</label> <textarea name="add_code" class=" form-control" rows="5" id="add_code" placeholder="Enter ads code ..."></textarea> </div> ';
        }else if(type == 'others'){
            output = '<div class="form-group"> <label for="add_link required">Add code or link</label> <input type="text" name="add_code" required class=" form-control" id="add_link" placeholder="Enter ads ..."></div><div class="form-group"> <label for="redirect_url">Redirect URL</label>  <input type="text" name="redirect_url"  id="redirect_url" class="form-control" > </div>';
        }else{
        	 output = '';
        }

        if(edit == 'edit'){
            $('#editshowAdsType').html(output);
            $('#showAdsType').html('');
        }else{
            $('#showAdsType').html(output);
            $('#editshowAdsType').html('');
        }

        $('.dropify').dropify();
    }

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

        // if occur error open model
        @if($errors->any())
            $("#{{Session::get('submitType')}}").modal('show');
        @endif
    </script>

@endsection
