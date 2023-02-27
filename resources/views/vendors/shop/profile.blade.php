@extends('vendors.partials.vendor-master')
@section('title', 'Profile Update')

@section('css')
 <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
        <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <div class="container-fluid">
       
            <!-- Start Page Content -->
            <!-- ============================================================== -->

            <div class="card">
                <div class="card-body">
                    <form action="{{route('vendor.profileUpdate')}}" method="post">
                        @csrf
                        <div class="form-body">
                            <div class="title_head">
                                Update Profile
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-right" for="vendor_name">Name</label>
                                <div class="col-md-6">
                                    <input type="text" value="{{$vendor->vendor_name}}" placeholder="Enter name" name="vendor_name" required="" id="vendor_name" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-right" for="shop_name">Shop Name</label>
                                <div class="col-md-6">
                                    <input type="text" value="{{$vendor->shop_name}}" placeholder="Enter shop name" name="shop_name" required="" id="shop_name" class="form-control" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-right" for="shop_dsc">About Shop</label>
                                <div class="col-md-6">
                                    <textarea style="resize: vertical;" placeholder="Enter About" name="shop_dsc" id="shop_dsc" class="form-control" >{{$vendor->shop_dsc}}</textarea>
                                    <i style="color: red">Max character 250</i>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-right" for="mobile">Mobile</label>
                                 <div class="col-md-6">
                                    <input type="text" value="{{$vendor->mobile}}" placeholder="Enter mobile number" name="mobile" required="" id="mobile" class="form-control" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-right" for="email">Email</label>
                                 <div class="col-md-6">
                                    <input type="text" value="{{$vendor->email}}" placeholder="Enter email number" name="email" required="" id="email" class="form-control" >
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-right" for="state">Division</label>
                                 <div class="col-md-6">
                                    <select name="state" onchange="get_city(this.value)" required id="state" class="form-control select2">
                                        <option value=""> Please Select  </option>
                                        @foreach($states as $state)
                                        <option @if($vendor->state == $state->id) selected @endif value="{{$state->id}}"> {{$state->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-right" for="city">City</label>
                                 <div class="col-md-6">
                                    <select name="city" onchange="get_area(this.value)" required id="city" class="form-control select2">
                                        <option value=""> Please Select  </option>
                                        @foreach($cities as $city)
                                        <option @if($vendor->city == $city->id) selected @endif value="{{$city->id}}"> {{$city->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 text-right" for="area">Area</label>
                                <div class="col-md-6">
                                <select name="area" id="area" class="form-control select2">
                                    <option value=""> Select area </option>
                                    @foreach($areas as $area)
                                    <option @if($vendor->area == $area->id) selected @endif value="{{$area->id}}"> {{$area->name}} </option>
                                    @endforeach
                                </select>
                               </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 text-right" for="area">Address</label>
                                <div class="col-md-6">
                                <input type="text" required data-parsley-required-message = "Address is required" value="{{$vendor->address}}" name="address" placeholder="Enter Address" class="form-control">
                               </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-right" for="email">Holiday Mode</label>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input name="holiday_mode" {{ ($vendor->holiday_mode == 1) ? 'checked' : '' }} type="checkbox" class="custom-control-input" id="holiday_mode">
                                            <label style="padding: 5px 12px" class="custom-control-label" for="holiday_mode">ON / OFF</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                          
                            <div class="form-group row">
                                <div class="col-md-7">
                                    <div class="pull-right text-right">
                                        <button type="submit"  name="submit" value="save" class="btn btn-success"> <i class="fa fa-save"></i> Update Profile</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
               
            </div>

        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->

@endsection

@section('js')
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
   
    <script>
        $(".select2").select2();

        function get_city(id){
         
            var  url = '{{route("get_city", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#city").html(data);
                        $("#city").focus();
                    }else{
                        $("#city").html('<option>City not found</option>');
                    }
                }
            });
        }    

    
        function get_area(id){
               
            var  url = '{{route("get_area", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#area").html(data);
                        $("#area").focus();
                    }else{
                        $("#area").html('<option>Area not found</option>');
                    }
                }
            });
        }  
    </script>


@endsection