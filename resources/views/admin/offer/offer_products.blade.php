@extends('layouts.admin-master')
@section('title', 'Offer Product list')

@section('css-top')

    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
   
@endsection
@section('css')
      <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
  
    <style type="text/css">
        .dropify-wrapper{  height: 100px !important; }
        #showProductArea{max-height: 400px; overflow-y: auto;}
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
                        <h4 class="text-themecolor">Offer Product</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript::void(0)">Offer</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <a href="{{route('admin.offer')}}" class="btn btn-info btn-sm d-lg-block m-l-15"><i class="fa fa-eye"></i> Offer List</a>
                            <button id="productModal" type="button" class="btn btn-info btn-sm d-lg-block m-l-15"><i class="ti-pin-alt"></i> Add More Product</button>
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
                    <div class="col-lg-12">
                        <div class="card" style="margin-bottom: 2px;">

                            <form action="" method="get">

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
                                                    <select name="seller" required style="width:100%" id="seller"  class="select2 form-control custom-select">
                                                       <option value="all">Seller All</option>
                                                       @foreach($sellers as $seller)
                                                       <option  @if(Request::get('seller') == $seller->id) selected @endif value="{{$seller->id}}">{{$seller->shop_name}}</option>
                                                       @endforeach
                                                   </select>
                                               </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <select name="brand" required style="width:100%" id="brand"  class="select2 form-control custom-select">
                                                       <option value="all">All Brand</option>
                                                       @foreach($brands as $brand)
                                                       <option @if(Request::get('brand') == $brand->id) selected @endif value="{{$brand->id}}">{{$brand->name}}</option>
                                                       @endforeach
                                                   </select>
                                               </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    
                                                    <select name="status" class="form-control">
                                                        <option value="all" {{ (Request::get('status') == "all") ? 'selected' : ''}}>All Status</option>
                                                        <option value="active" {{ (Request::get('status') == 'active') ? 'selected' : ''}}>Active</option>
                                                        <option value="pending" {{ (Request::get('status') == 'pending') ? 'selected' : ''}}>Inactive</option>
                                                        <option value="visible" {{ (Request::get('status') == 'visible') ? 'selected' : ''}}>Visible</option>
                                                        <option value="invisible" {{ (Request::get('status') == 'invisible') ? 'selected' : ''}}>Invisible</option>
                                                        <option value="sold-out" {{ (Request::get('status') == 'sold-out') ? 'selected' : ''}}>Sold out</option>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <select class="form-control" name="show">
                                                        <option @if(Request::get('show') == 15) selected @endif value="15">15</option>
                                                        <option @if(Request::get('show') == 25) selected @endif value="25">25</option>
                                                        <option @if(Request::get('show') == 50) selected @endif value="50">50</option>
                                                        <option @if(Request::get('show') == 100) selected @endif value="100">100</option>
                                                        <option @if(Request::get('show') == 255) selected @endif value="250">250</option>
                                                        <option @if(Request::get('show') == 500) selected @endif value="500">500</option>
                                                        <option @if(Request::get('show') == 750) selected @endif value="750">750</option>
                                                        <option @if(Request::get('show') == 1000) selected @endif value="1000">1000</option>
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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                           
                            <div class="table-responsive">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Photo</th>
                                            <th>Title</th>
                                            <th>Seller</th>
                                            <th>Sale_Price</th>
                                            <th>Seller_Rate</th>
                                            <th>Order</th>
                                            <th>Total_Price</th>
                                            <th>Offer_Price</th>
                                            <th>Stock</th>
                                            <th>Visible</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead> 
                                    <tbody id="positionSorting" data-table='offer_products'>
                                        @if(count($offer->offer_products)>0)
                                        @foreach($offer_products as $offer_product)
                                            @if($offer_product->product)

                                            <tr id="item{{$offer_product->id}}">
                                                <td> <img src="{{asset('upload/images/product/thumb/'.$offer_product->product->feature_image)}}" alt="Image" width="50"> </td>
                                                <td>
                                                    <a target="_blank" href="{{ route('product_details', $offer_product->product->slug) }}"> {{Str::limit($offer_product->product->title, 40)}}</a>
                                                </td>
                                               
                                                <td><a target="_blank" @if($offer_product->product->vendor) href="{{ route('admin.vendor.profile', $offer_product->product->vendor->slug) }}" @endif> {{ ($offer_product->product->vendor) ? $offer_product->product->vendor->shop_name : '' }}</a>
                                                </td>
                                                <td>{{Config::get('siteSetting.currency_symble')}}{{$offer_product->product->selling_price}} </td>
                                                <td><input style="width: 70%;padding: 5px;" type="number" class="form-control" value="{{ $offer_product->seller_rate }}" id="seller_rate{{$offer_product->id}}" placeholder="Price"><button style="padding: 9px 5px;" class="btn btn-sm btn-info" onclick="setProductPrice('{{$offer_product->id}}')" type="button"> Set </button></td>
                                                <td>
                                                    @php 
                                                    $totalOrder = ($offer_product->offer_orders) ?  count($offer_product->offer_orders) : 0; @endphp
                                                    <input type="hidden" id="totalOrder{{$offer_product->id}}" value="{{$totalOrder}}">
                                                    <a href="{{route('admin.offerOrderProducts', [$offer->slug, $offer_product->product->slug]) }}"><span style="font-size: 15px;" class="label label-success"> {{ $totalOrder }}</span></a>
                                                </td>
                                                <td>{{Config::get('siteSetting.currency_symble')}}<span id="totalPrice{{$offer_product->id}}">{{$offer_product->seller_rate * $totalOrder}}</span>
                                                </td>

                                                <td>{{Config::get('siteSetting.currency_symble')}}{{$offer_product->offer_discount}}</td>
                                                <td>{!!($offer_product->offer_quantity > 0) ? $offer_product->offer_quantity : '<span style="width: 68px" class="label label-danger">Stock Out</span>' !!}</td>
                                                
                                                <td> 
                                                   <div class="custom-control custom-switch">
                                                      <input  name="invisible" onclick="satusActiveDeactive('offer_products', '{{$offer_product->id}}', 'invisible')"  type="checkbox" {{($offer_product->invisible == 0) ? 'checked' : ''}}  type="checkbox" class="custom-control-input" id="invisible{{$offer_product->id}}">
                                                      <label style="padding: 5px 12px" class="custom-control-label" for="invisible{{$offer_product->id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($offer_product->approved == '1')
                                                    <div class="custom-control custom-switch">
                                                      <input  name="status" onclick="satusActiveDeactive('offer_products', {{$offer_product->id}})"  type="checkbox" {{($offer_product->status == 1 || $offer_product->status == 'active') ? 'checked' : ''}}  type="checkbox" class="custom-control-input" id="status{{$offer_product->id}}">
                                                      <label style="padding: 5px 12px" class="custom-control-label" for="status{{$offer_product->id}}"></label>
                                                    </div>
                                                    @else
                                                        <span class="label label-warning"> Un Approved </span>
                                                    @endif
                                                </td>
                                                
                                                <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="ti-settings"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                       
                                                        <a class="dropdown-item" onclick="edit_modal({{$offer_product->id}})" title="Edit product" data-toggle="tooltip" href="javascript:void(0)"><i class="ti-pencil-alt"></i> Edit Offer</a>
                                                       
                                                        <span title="Remove product" data-toggle="tooltip"><button   data-target="#delete" onclick='deleteConfirmPopup("{{route("admin.offerProduct.remove", $offer_product->id)}}")'  data-toggle="modal" class="dropdown-item" ><i class="ti-trash"></i> Remove Product</button></span>
                                                    </div>
                                                </div>                                                  
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        @else <tr><td colspan="15">No Products Found.</td></tr>@endif
                                        
                                    </tbody>
                                </table>
                            </div>
                        
                        </div>
                    </div>
                </div>

                 <div class="row">
                   <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                       {{$offer_products->appends(request()->query())->links()}}
                      </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing {{ $offer_products->firstItem() }} to {{ $offer_products->lastItem() }} of total {{$offer_products->total()}} entries ({{$offer_products->lastPage()}} Pages)</div>
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
                        <h4 class="modal-title">Added Product</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                                <form action="{{route('admin.offerMultiProductStore')}}" id="checkMarkProducts" method="post">
                                @csrf
                                <input type="hidden" value="{{$offer->id}}" name="offer_id">
                                <div class="form-body">
                                    <!--/row-->
                                    <div class="row">
                                        
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
                                                        <th>Old_Price</th>
                                                        <th>New_Price</th>
                                                        <th>Type</th>
                                                        <th>Quantity</th>
                                                        <th>Invisible</th>
                                                        <th>Added</th>
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
        <div class="modal fade" id="edit_modal" role="dialog" style="display: none;">
            <div class="modal-dialog">
                <form action="{{route('admin.offerProduct.update')}}"  method="post">
                      {{ csrf_field() }}
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update offer product</h4>
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
    <script src="{{asset('assets')}}/node_modules/jqueryui/jquery-ui.min.js"></script>
    <!-- This is data table -->
    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

    <!-- end - This is for export functionality only -->
    <script>
        $(".select2").select2();

        $(function () {
            $('#myTable').dataTable({
                "ordering": false,
                 "paging": false,"info":false
            });
        });
      
    </script>

    <script type="text/javascript">


    // set seller price rate for offer 
    function setProductPrice(id) {
      
        var link = '{{route("admin.setProductPrice", ":id")}}';
        var link = link.replace(":id", id);
        var seller_rate = $('#seller_rate'+id).val();
        var total_sale = $('#totalOrder'+id).val();
        var totalPrice = seller_rate * total_sale;
        $.ajax({
            url:link,
            method:"get",
            data:{seller_rate:seller_rate,id:id},
            success:function(data){
                if(data.status){
                    document.getElementById("totalPrice"+id).innerHTML = totalPrice;
                    toastr.success(data.message);
                }else{
                    toastr.error(data.message);
                }
            }

        });
    }

        //edit offer
        function edit_modal(id){
           
            $('#edit_form').html('<div class="loadingData"></div>');
            $('#edit_modal').modal('show');
            var  url = '{{route("admin.offerProduct.edit", ":id")}}';
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
        $('#productModal').on('click', function(){
            $('#offerModel').modal('show');
            getAllProducts();
        });

        // get product by search
        function getAllProducts(page=null){
            $('#showAllProducts').html('<tr><td colspan="9"><div class="loadingData"></div></td></tr>');
            var  url = '{{route("offer.getAllProducts")}}';
            var seller = $('#seller').val();
            var brand = $('#brand').val();
            var category = $('#category').val();
            var product = $('#product').val();
          
            var offer_id = '{{$offer->id}}';
           
            $.ajax({
                url:url,
                method:"get",
                data:{product:product,category:category,brand:brand,seller:seller,page:page,offer_id:offer_id},
                success:function(data){
                    
                    if(data){
                        $("#showAllProducts").html(data);
                       
                    }else{
                        $("#showAllProducts").html('<tr><td colspan="9">No product found.</td></tr>');
                    }
                },
                error: function(jqXHR, exception) {
                    toastr.error('Internal server error.');
                    $("#showAllProducts").html('<tr><td style="color:red" colspan="9">Internal server error.</td></tr>');
            }
            });
        }
        //paginate 
        $(document).on('click', 'td .pagination a', function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getAllProducts(page);
        });

        //single product added
        function addProduct(product_id) {
            var offer_id = '{{$offer->id}}';
            // var discount_type = $('#discount_type'+product_id).val();
        
            var offer_discount = $('#discount'+product_id).val();
           
            var quantity = $('#quantity'+product_id).val();
            var invisible = null;
            if ($('#invisible'+product_id).is(':checked')) {
                invisible = 'checked';
            }
          
            $.ajax({
                url:'{{route("admin.offerSingleProductStore")}}',
                type:'get',
                data:{offer_id:offer_id,offer_discount:offer_discount,product_id:product_id,quantity:quantity,quantity,invisible:invisible,'_token':'{{csrf_token()}}'},
                success:function(data){
                    if(data.status){
                        toastr.success(data.msg);
                    }else{
                        toastr.error(data.msg);
                    }
                }
            });
        }

        $('.checkMarkProducts').click(function(){
            $.ajax({
                url:'{{route("admin.offerMultiProductStore")}}',
                type:'post',
                data:$('#checkMarkProducts').serialize(),
                success:function(data){
                    if(data.status == 'success'){
                        toastr.success(data.msg);
                        location.reload();
                    }else{
                        toastr.error(data.msg);
                    }
                }
            });
        });


        //on click select all products
        $('#checkAll').on('click', function() {
            if (this.checked == true){
                $('#showAllProducts').find('.product_id').prop('checked', true);
            }
            else{
                $('#showAllProducts').find('.product_id').prop('checked', false);
            }
        });

  
        function remove_product(id){
            $('#product'+id).remove();
        }   

        // if occur error open model
        @if($errors->any())
            $("#{{Session::get('submitType')}}").modal('show');
        @endif
    </script>

@endsection
