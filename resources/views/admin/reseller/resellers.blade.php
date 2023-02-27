@extends('layouts.admin-master')
@section('title', 'Seller list')
@section('css')

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
                    <h4 class="text-themecolor">Seller List</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Seller</a></li>
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
                <div class="col-lg-12">
                    <div class="card" style="margin-bottom: 2px;">

                        <form action="{{route('vendor.list')}}" method="get">

                            <div class="form-body">
                                <div class="card-body">
                                    <div class="row">
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" value="{{ Request::get('shop_name')}}" placeholder="Shop name" name="shop_name" class="form-control">
                                           </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select name="location" required id="location" style="width:100%" id="location"  class="select2 form-control custom-select">
                                                   <option value="all">All Location</option>
                                                   @foreach($locations as $location)
                                                   <option @if(Request::get('location') == $location->id) selected @endif value="{{$location->id}}">{{$location->name}}</option>
                                                   @endforeach
                                               </select>
                                           </div>
                                        </div>


                                        <div class="col-md-2">
                                            <div class="form-group">
                                                
                                                <select name="status" class="form-control">
                                                    <option value="all" {{ (Request::get('status') == "all") ? 'selected' : ''}}>All Status</option>
                                                    <option value="pending" {{ (Request::get('status') == 'pending') ? 'selected' : ''}} >Pending</option>
                                                    <option value="active" {{ (Request::get('status') == 'active') ? 'selected' : ''}}>active</option>
                                                    <option value="inactive" {{ (Request::get('status') == 'inactive') ? 'selected' : ''}}>Inactive</option>
                                                    <option value="reject" {{ (Request::get('status') == 'reject') ? 'selected' : ''}}>Reject</option>
                                                   
                                                    
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

                    <div class="card ">
                        <div class="card-body">
                           
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Shop Name</th>
                                            <th>Owner Name</th>
                                            <th>Since</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Products</th>
                                            <th>Orders</th>
                                            <th>Wallet</th>
                                            <th>Activation</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        @foreach($vendors as $index => $vendor)
                                        <tr id="item{{$vendor->id}}">
                                            <td>{{(($vendors->perPage() * $vendors->currentPage() - $vendors->perPage()) + ($index+1) )}}</td>
                                            <td><img src="{{asset('upload/vendors/'. $vendor->logo)}}" alt="" width="50"> {{$vendor->shop_name}}</td>
                                            <td>{{$vendor->vendor_name}}</td>
                                            <td>{{\Carbon\Carbon::parse($vendor->created_at)->format(Config::get('siteSetting.date_format'))}}</td>
                                            <td>{{$vendor->mobile}}</td>
                                            <td>{{$vendor->email}}</td>
                                            <td>{{ ($vendor->allproducts) ? count($vendor->allproducts) : 0 }}</td>
                                            <td>{{ ($vendor->allorders) ? count($vendor->allorders) : 0 }}</td>
                                            <td>{{Config::get('siteSetting.currency_symble') . $vendor->balance}}</td>
                                            <td>
                                                <div class="bt-switch">
                                                    <input  onchange="satusActiveDeactive('resellers', '{{$vendor->id}}')" type="checkbox" {{($vendor->status == 'active') ? 'checked' : ''}} data-on-color="success" data-off-color="danger" data-on-text="Actived" data-off-text="Deactive">
                                                </div>
                                            </td>
                                            <td>
                                                @if($vendor->status == 'active')
                                                <span class="label label-success">{{$vendor->status}}</span>
                                                @elseif($vendor->status == 'pending')
                                                <span class="label label-danger">{{$vendor->status}}</span>
                                                @else
                                                <span class="label label-warning">{{$vendor->status}}</span>
                                                @endif
                                            </td>
                                          
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="ti-settings"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                       
                                                        <a class="dropdown-item" title="View Reseller Profile" data-toggle="tooltip" href="{{ route('reseller.profile', [$vendor->id]) }}"><i class="ti-eye"></i> View Profile</a>
                                                        <a class="dropdown-item" title="View Reseller Profile" data-toggle="tooltip" href="{{ route('reseller.wallet', [$vendor->id]) }}"><i class="ti-eye"></i> Manage Wallet</a>

                                                        <a class="dropdown-item" target="_blank" title="Secret login in the seller panel" data-toggle="tooltip" href="{{route('admin.resellerSecretLogin', encrypt($vendor->id))}}"><i class="ti-lock"></i> Reseller Panel</a>

                                                       <!--  <a class="dropdown-item" title="Edit profile" data-toggle="tooltip" href="{{ route('vendor.edit', $vendor->id) }}"><i class="ti-pencil-alt"></i> Edit</a> -->
                                                       
                                                      
                                                        <!-- <span title="Delete" data-toggle="tooltip"><button   data-target="#delete" onclick='deleteConfirmPopup("{{ route("vendor.delete", $vendor->id) }}")'  data-toggle="modal" class="dropdown-item" ><i class="ti-trash"></i> Delete vendor</button></span> -->

                                                        <button title="Password Reset" data-toggle="tooltip" onclick='PasswordReset("{{ $vendor->id }}")' class="dropdown-item" ><i class="fa fa-retweet"></i> Password Reset</button>


                                                    </div>
                                                </div>                                          
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
            <div class="row">
               <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                   {{$vendors->appends(request()->query())->links()}}
                  </div>
                <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing {{ $vendors->firstItem() }} to {{ $vendors->lastItem() }} of total {{$vendors->total()}} entries ({{$vendors->lastPage()}} Pages)</div>
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
    <div class="modal fade" id="add" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create vendor</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row">
                    <div class="card-body">
                        <form action="{{route('vendor.store')}}" enctype="multipart/form-data" method="POST" class="floating-labels">
                            {{csrf_field()}}
                            <div class="form-body">
                                <!--/row-->
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Vendor Name</label>
                                            <input  name="name" id="name" value="{{old('name')}}" required="" type="text" class="form-control">
                                        </div>
                                    </div>
                                 
                                </div>
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="form-group"> 
                                            <label class="dropify_image">Feature Image</label>
                                            <input  type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="2M"  name="phato" id="input-file-events">
                                        </div>
                                        @if ($errors->has('phato'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('phato') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row justify-content-md-center">
                                   <div class="col-md-12">
                                        <div class="form-group">
                                            <label style="background: #fff;top:-10px;z-index: 1" for="notes">Details</label>
                                            <textarea name="notes" class="form-control" placeholder="Enter details" id="notes" rows="2">{{old('notes')}}</textarea>
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
    <div class="modal fade" id="edit" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <form action="{{route('vendor.update')}}" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update vendor</h4>
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
    <!-- reset password Modal -->
    <div class="modal fade" id="PasswordReset" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <form action="{{route('admin.resetPassword')}}" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
            <input type="hidden" id="userId" name="id">
            <input type="hidden" name="table" value="resellers">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Password Reset</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row">
                    <div class="col-md-12">
                        <label for="password"><span style="font-weight: bold">Enter new password</span></label>
                        <input type="text" required id="password" name="password" placeholder="Enter password" class="form-control">
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success">Password Reset</button>
                </div>
              </div>
            </form>
        </div>
    </div>

@endsection
@section('js')

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


    <script type="text/javascript">

    function edit(id){
        $('#edit_form').html('<div class="loadingData"></div>');
        var  url = '{{route("vendor.edit", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#edit_form").html(data);
                    $('.dropify').dropify();
                }
            },
            // $ID Error display id name
            @include('common.ajaxError', ['ID' => 'edit_form'])

        });
    }
    function PasswordReset(userId) {
       $('#PasswordReset').modal('show');
       $('#userId').val(userId);
    }

</script>
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
     <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

    });
    </script>

@endsection
