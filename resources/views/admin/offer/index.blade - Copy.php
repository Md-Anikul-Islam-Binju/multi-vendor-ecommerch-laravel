@extends('layouts.admin-master')
@section('title', 'Offer list')

@section('css-top')

    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
  
@endsection
@section('css')
      <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/summernote/dist/summernote-bs4.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .select2-container--default .select2-selection--multiple .select2-selection__rendered{height: 100px!important}
        .dropify-wrapper{  height: 100px !important; }
        #showProductArea{max-height: 450px; overflow-y: auto;}
        .discount_type{padding: 8px 3px; border: 1px solid #ccc; border-radius: 5px;}
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
                        <h4 class="text-themecolor">Offer List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Offer</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <button id="createOffer" type="button" class="btn btn-info d-none d-lg-block m-l-15"><i
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
                                                <th>Thumbnail</th>
                                                <th>Title</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Featured</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead> 
                                        <tbody id="positionSorting">
                                            @foreach($offers as $data)
                                            <tr  id="item{{$data->id}}">
                                                <td><img src="{{ asset('upload/images/offer/thumbnail/'.$data->thumbnail) }}" width="50px"> </td>
                                                <td><a href="{{ route('offer.details', $data->slug) }}"> {{$data->title}} </a></td>
                                                
                                                <td>{{ Carbon\Carbon::parse($data->start_date)->format('d M, Y H:m:i A') }}</td>
                                                <td>{{ Carbon\Carbon::parse($data->end_date)->format('d M, Y H:m:i A') }}</td>
                                               <td>
                                                   <div class="custom-control custom-switch">
                                                      <input  name="featured" onclick="satusActiveDeactive('offers', '{{$data->id}}', 'featured')"  type="checkbox" {{($data->featured == 1) ? 'checked' : ''}}  type="checkbox" class="custom-control-input" id="featured{{$data->id}}">
                                                      <label style="padding: 5px 12px" class="custom-control-label" for="featured{{$data->id}}"></label>
                                                    </div>
                                               </td>
                                                <td>
                                                    <div class="custom-control custom-switch" style="padding-left: 3.25rem;">
                                                      <input name="status" onclick="satusActiveDeactive('offers', {{$data->id}})"  type="checkbox" {{($data->status == 1) ? 'checked' : ''}} class="custom-control-input" id="status{{$data->id}}">
                                                      <label class="custom-control-label" for="status{{$data->id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" onclick="edit('{{$data->id}}')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> Edit</button>
                                                    <button title="Delete" data-target="#delete" onclick="deleteConfirmPopup('{{route("admin.offer.delete", $data->id)}}')" class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> </button>
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
        <div class="modal fade" id="offerModel" role="dialog" style="display: none;">
            <div class="modal-dialog modal-lg">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create offer</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <form action="{{route('admin.offer.store')}}" method="POST" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-body">
                                    <!--/row-->
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="title">Offer Title</label>
                                                <input  name="title" id="title" value="{{old('title')}}" required="" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="details">Details</label>
                                                <textarea name="details" id="details" class="summernote form-control"></textarea>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="required" for="name">Start Date</label>
                                                <input name="start_date" required class="form-control" type="datetime-local" value="{{now()}}" id="example-datetime-local-input">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="required" for="name">End Date</label>
                                                <input name="end_date" required class="form-control" type="datetime-local" value="{{now()}}" id="example-datetime-local-input">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="required" for="name">Bacground Color</label>
                                                <input name="background_color" value="#ffffff" class="form-control" onfocus="(this.type='color')">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="required" for="name">Text Color</label>
                                                <input name="text_color" value="#000000" class="form-control" onfocus="(this.type='color')">
                                            </div>
                                        </div>

                                            <div class="col-md-4 col-6">
                                                <div class="form-group"> 
                                                    <label class="dropify_image">Thumbnail Image</label>
                                                    <input type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="2M"  name="thumbnail" id="input-file-events">
                                                    <i class="image_size">Image Size:250px * 250px </i>
                                                </div>
                                                @if ($errors->has('thumbnail'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('thumbnail') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <div class="form-group"> 
                                                    <label class="dropify_image">Banner Image</label>
                                                    <input  type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="2M"  name="banner" id="input-file-events">
                                                    <i class="image_size">Image Size:1400px * 400px </i>
                                                </div>
                                                @if ($errors->has('banner'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('banner') }}
                                                    </span>
                                                @endif
                                            </div>
                                           <!-- <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="link" >Custom Link</label>
                                                    <input name="link" id="link" class="form-control" type="url">
                                                </div>
                                            </div> -->
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                               
                                                <select onchange="getAllProducts()" id="seller" class="form-control select2 custom-select">
                                                    <option value="">Select seller</option>
                                                    @foreach($sellers as $seller)
                                                    <option value="{{$seller->id}}" {{ (old('seller') == $seller->id) ? 'selected' : '' }}> {{$seller->shop_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                               
                                                <select onchange="getAllProducts()" id="brand" class="form-control custom-select select2">
                                                    <option value="all">All brand</option>
                                                    @foreach($brands as $brand)
                                                    <option value="{{$brand->id}}"> {{$brand->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                               
                                                <select onchange="getAllProducts()" id="category" class="form-control custom-select select2">
                                                    <option value="all">All category</option>
                                                    @foreach($categories as $category)
                                                    <option value="{{$category->id}}" {{ (old('category') == $category->id) ? 'selected' : '' }}> {{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="product" class="form-control" placeholder="Product name">
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group"><button type="button" onclick="getAllProducts()" class="btn btn-info"><i class="fa fa-search"></i></button></div>
                                        </div>

                                        
                                        <div class="col-md-12" id="showProductArea">
                                          <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" id="checkAll" name=""></th>
                                                        <th>Product</th>
                                                        <th>Price</th>
                                                        <th>Discount</th>
                                                        <th>Type</th>
                                                        <th>Invisible</th>
                                                    </tr>
                                                </thead> 
                                                <tbody id="showAllProducts"></tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row justify-content-md-center">
                                        
                                        <div class="col-md-12">
                                            
                                            <div class="modal-footer">
                                                <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Add</button>
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
        <div class="modal fade" id="edit" role="dialog" style="display: none;">
            <div class="modal-dialog">
                <form action="{{route('admin.offer.update')}}"  method="post">
                      {{ csrf_field() }}
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update offer</h4>
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

        <!-- delete Modal -->
        @include('admin.modal.delete-modal')

@endsection
@section('js')

    <!-- This is data table -->
    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>

    <!-- end - This is for export functionality only -->
    <script>
        $(".select2").select2();

        $(function () {
            $('#myTable').dataTable({
                "ordering": false
            });
        });
         // Basic
        $('.dropify').dropify();

    </script>

    <script type="text/javascript">

        //edit offer
        function edit(id){
              
            var  url = '{{route("admin.offer.edit", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#edit_form").html(data);
                        $(".select2").select2();
                    }
                }
            });
        }


        //open offer modal
        $('#createOffer').on('click', function(){
            $('#offerModel').modal('show');
            getAllProducts();
        });

        // get product by search
        function getAllProducts(page=null){
            $('#showAllProducts').html('<tr><td colspan="6"><div class="loadingData"></div></td></tr>');
            var  url = '{{route("offer.getAllProducts")}}';
            var seller = $('#seller').val();
            var brand = $('#brand').val();
            var category = $('#category').val();
            var product = $('#product').val();
           
            $.ajax({
                url:url,
                method:"get",
                data:{product:product,category:category,brand:brand,seller:seller,page:page},
                success:function(data){
                    
                    if(data){
                        $("#showAllProducts").html(data);
                       
                    }else{
                        $("#showAllProducts").html('<tr><td colspan="6">No product found.</td></tr>');
                    }
                }
            });
        }
        //paginate 
        $(document).on('click', '.pagination a', function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getAllProducts(page);
        });


        //on click select all products
        $('#checkAll').on('click', function() {
            if (this.checked == true)
                $('#showAllProducts').find('.product_id').prop('checked', true);
            else
                $('#showAllProducts').find('.product_id').prop('checked', false);
        });

  
        function remove_product(id){
            $('#product'+id).remove();
        }   

        // if occur error open model
        @if($errors->any())
            $("#{{Session::get('submitType')}}").modal('show');
        @endif
    </script>


    <script src="{{asset('assets')}}/node_modules/summernote/dist/summernote-bs4.min.js"></script>
    <script>
        $(function() {

            $('.summernote').summernote({
                height: 100, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: false // set focus to editable area after initializing summernote
            });

            $('.inline-editor').summernote({
                airMode: true
            });

        });

        window.edit = function() {
            $(".click2edit").summernote()
        },
        window.save = function() {
            $(".click2edit").summernote('destroy');
        }

    </script>
@endsection
