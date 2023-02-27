@extends('vendors.partials.vendor-master')
@section('title', 'Product list')

@section('css')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
    <link href="{{asset('css')}}/pages/bootstrap-switch.css" rel="stylesheet">

    <style type="text/css">
        .dropify_image{
            position: absolute;top: -12px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
        }
        .dropify-wrapper{
            height: 100px !important;
        }
        svg{width: 20px}
     
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
                        <h4 class="text-themecolor">Product List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Product</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <a class="btn btn-info d-none d-lg-block m-l-15" href="{{ route('vendor.product.upload') }}"><i class="fa fa-plus-circle"></i> Add New Product</a>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Product</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-primary"><i class="fa fa-list-ol"></i></span>
                                <a href="{{route('vendor.product.list')}}" class="link display-5 ml-auto">{{$all_products}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pending</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-info"><i class="fa fa-bolt"></i></span>
                                <a href="{{route('vendor.product.list', 'pending')}}" class="link display-5 ml-auto">{{$pending_products}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Active </h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-success"><i class="fa fa-thumbs-up"></i></span>
                                <a href="{{route('vendor.product.list', 'active')}}" class="link display-5 ml-auto">{{$active_products}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Deactive </h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-warning"><i class="fa fa-thumbs-down"></i></span>
                                <a href="{{route('vendor.product.list', 'deactive')}}" class="link display-5 ml-auto">{{$deactive_products}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                  
                    <!-- Column -->
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Stock out</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-danger"><i class="fa fa-battery-empty"></i></span>
                                <a href="{{route('vendor.product.list', 'stock-out')}}" class="link display-5 ml-auto">{{$stockout_products}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Image Missing</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-danger"><i class="fa fa-bug"></i></span>
                                <a href="{{route('vendor.product.list', 'image-missing')}}" class="link display-5 ml-auto">{{$image_missing}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" style="margin-bottom: 2px;">

                            <form action="{{route('vendor.product.list')}}" method="get">

                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row">
                                            

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input name="title" placeholder="Title" value="{{ Request::get('title')}}" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input name="sku" placeholder="SKU" value="{{ Request::get('sku')}}" type="text" class="form-control">
                                                </div>
                                            </div>


                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <select name="brand" required id="brand" style="width:100%" id="brand"  class="select2 form-control custom-select">
                                                       <option value="all">All Brand</option>
                                                       @foreach($brands as $brand)
                                                       <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                       @endforeach
                                                   </select>
                                               </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    
                                                    <select name="status" class="form-control">
                                                        <option value="all" {{ (Request::get('status') == "all") ? 'selected' : ''}}>All Status</option>
                                                        <option value="pending" {{ (Request::get('status') == 'pending') ? 'selected' : ''}} >Pending</option>
                                                        <option value="active" {{ (Request::get('status') == 'active') ? 'selected' : ''}}>Active</option>
                                                        <option value="deactive" {{ (Request::get('status') == 'deactive') ? 'selected' : ''}}>Deactive</option>
                                                        <option value="reject" {{ (Request::get('status') == 'reject') ? 'selected' : ''}}>Reject</option>
                                                        <option value="stock-out" {{ (Request::get('status') == 'stock-out') ? 'selected' : ''}}>Stock out</option>
                                                        
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="form-group">
                                                   
                                                   <button type="submit" class="form-control btn btn-success"><i style="color:#fff; font-size: 20px;" class="ti-search"></i> </button>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Start Page Content -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive" >
                                    <table  class="table table-striped" >
                                        <thead>
                                            <tr>
                                                <th>Photo</th>
                                                <th>Title</th>
                                                <th>Upload Date</th>
                                                <th>Sales</th>
                                              
                                                <th>Price</th>
                                                <th>Stock</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($products)>0)
                                                @foreach($products as $product)
                                                <tr id="item{{$product->id}}">
                                                    <td> <img src="{{asset('upload/images/product/thumb/'.$product->feature_image)}}" alt="Image" width="60"> </td>
                                                    <td><a target="_blank" href="{{ route('product_details', $product->slug) }}"> {{Str::limit($product->title, 40)}}</a></td>
                                                    
                                                    <td>{{Carbon\Carbon::parse($product->created_at)->format(Config::get('siteSetting.date_format'))}}</td>
                                                   
                                                    <td>{{ $product->sales }}</td>
                                                    
                                                    <td>{{Config::get('siteSetting.currency_symble')}}{{$product->selling_price}}</td>
                                                    <td>{!!($product->stock > 0) ? $product->stock : '<span style="width: 68px" class="label label-danger">Stock Out</span>' !!}</td>
                                                    <td>
                                                        @if($product->status != 'pending')
                                                        <div class="custom-control custom-switch">
                                                          <input  name="status" onclick="satusActiveDeactive('products', {{$product->id}})"  type="checkbox" {{($product->status == 1 || $product->status == 'active') ? 'checked' : ''}}  type="checkbox" class="custom-control-input" id="status{{$product->id}}">
                                                          <label style="padding: 5px 12px" class="custom-control-label" for="status{{$product->id}}"></label>
                                                        </div>
                                                        @else
                                                            <span class="label label-warning"> Pending </span>
                                                        @endif
                                                    </td>
                                                    
                                                    <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item text-inverse" target="_blank" title="View product" data-toggle="tooltip" href="{{ route('product_details', $product->slug) }}"><i class="ti-eye"></i> View Product</a>
                                                            <a class="dropdown-item" title="Edit product" data-toggle="tooltip" href="{{ route('vendor.product.edit', $product->slug) }}"><i class="ti-pencil-alt"></i> Edit</a>
                                                            
                                                            <span title="Manage Gallery Images" data-toggle="tooltip">
                                                            <a onclick="setGallerryImage({{ $product->id }})" data-toggle="modal" data-target="#GallerryImage" class="dropdown-item" href="javascript:void(0)"><i class="ti-image"></i> Gallery Images</a></span>
                                                            <span title="Delete" data-toggle="tooltip"><button   data-target="#delete" onclick='deleteConfirmPopup("{{route("vendor.product.delete", $product->id)}}")'  data-toggle="modal" class="dropdown-item" ><i class="ti-trash"></i> Delete Product</button></span>
                                                        </div>
                                                    </div>                                                  
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else <tr><td>No Products Found.</td></tr>@endif
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-lg-12 text-center">
                                           {{$products->appends(request()->query())->links()}}
                                          </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- Gallery Modal -->
        <div class="modal fade" id="GallerryImage" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Upload Gallery Image</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <form action="{{route('vendor.product.storeGalleryImage')}}" enctype="multipart/form-data" method="POST" class="floating-labels">
                                {{csrf_field()}}
                               
                                <div class="form-body">
                                   
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group"> 
                                                <label class="dropify_image">Select Multiple Image</label>
                                                <input  type="file" multiple class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="5M"  name="gallery_image[]" id="input-file-events">
                                            </div>
                                            @if ($errors->has('gallery_image'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('gallery_image') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-md-12" id="showGallerryImage"></div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Upload</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-inverse">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
          </div>
       
        @include('admin.modal.delete-modal')
@endsection
@section('js')
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

    <script type="text/javascript">
         $(".select2").select2();

    function setGallerryImage(id) {
       
        $('#showGallerryImage').html('<div class="loadingData"></div>');
        var  url = '{{route("vendor.product.getGalleryImage", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#showGallerryImage").html(data);
                }
            },
            // $ID = Error display id name
            @include('common.ajaxError', ['ID' => 'showGallerryImage'])

        });
    }


    function deleteGallerryImage(id) {
       
        if (confirm("Are you sure delete this image.?")) {
           
            var url = '{{route("vendor.product.deleteGalleryImage", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $('#gelImage'+id).hide();
                        toastr.success(data.msg);
                    }else{
                        toastr.error(data.msg);
                    }
                }
            });
        }
        return false;
    }


</script>
   <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
     <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();
    });
    </script>

        <!-- bt-switch -->
    <script src="{{asset('assets')}}/node_modules/bootstrap-switch/bootstrap-switch.min.js"></script>
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
