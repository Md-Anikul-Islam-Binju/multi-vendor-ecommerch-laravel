@extends('layouts.admin-master')
@section('title', 'Shipping configuration')
@section('css')
    <link href="{{asset('css')}}/pages/tab-page.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .card-subtitle{background:#fff4d5;padding:10px;}
    </style>
@endsection
@section('content')
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                
                <div class="col-md-12 align-self-center ">
                    <div class="d-fl ">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Shipping</a></li>
                            <li class="breadcrumb-item active">Setting</li>
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
                <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="title_head"> Shipping Configuration </div>
                                <form action="{{ route('activeShippingMethod') }}" method="post">
                                    @csrf
                                <div class="row justify-content-md-center">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <span for="shipping_method">Shipping Method</span>
                                            <select name="shipping_method" id="shipping_method" class="form-control">
                                                <option @if(config('siteSetting.shipping_method') == 'free_shipping') selected @endif value="free_shipping">Free Shipping</option>
                                                <option @if(config('siteSetting.shipping_method') == 'flat_shipping') selected @endif value="flat_shipping">Flat Shipping</option>
                                                <option @if(config('siteSetting.shipping_method') == 'product_wise_shipping') selected @endif value="product_wise_shipping">Product Wise Shipping</option>
                                                <option @if(config('siteSetting.shipping_method') == 'location_shipping') selected @endif value="location_shipping">Location-based Shipping</option>
                                                
                                            </select>
                                           
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="shipping_cost">Default Cost </label>
                                            <input  name="shipping_cost" placeholder="Exm: 50" id="cost" value="{{config('siteSetting.shipping_cost')}}" min="0" required="" type="number" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                         <div class="form-group">
                                            <span for="shipping_calculate">Shipping calculate </span>
                                            <select name="shipping_calculate" id="shipping_calculate" class="form-control">
                                                <option @if(config('siteSetting.shipping_calculate') == 'per_product') selected @endif value="per_product">Per Product Cost</option>
                                                <option @if(config('siteSetting.shipping_calculate') == 'highest_cost') selected @endif value="highest_cost">Highest Cost</option>
                                                <option @if(config('siteSetting.shipping_calculate') == 'weight_based') selected @endif value="weight_based">Weight based</option>
                                            </select>
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-2"><span>Estimated Shipping Time</span><input class="form-control" value="{{config('siteSetting.shipping_time')}}" name="shipping_time" placeholder="Exm: 3-4 days" type="text"></div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="cost">`</label>
                                            <button style="color: #fff" type="submit" name="submit" value="add" class="form-control btn btn-success">Active</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"> <a class="nav-link @if(!Session::get('shippingSettingTab')) active @endif @if(Session::get('shippingSettingTab') == 'free_shipping') active @endif" data-toggle="tab" href="#free_shipping" role="tab"> @if(config('siteSetting.shipping_method') == 'free_shipping') <i class="fa fa-check"></i> @endif Free Shipping</a> </li>
                                    <li class="nav-item"> <a class="nav-link @if(Session::get('shippingSettingTab') == 'product_wise_shipping') active @endif" data-toggle="tab" href="#product_wise_shipping" role="tab"> @if(config('siteSetting.shipping_method') == 'product_wise_shipping') <i class="fa fa-check"></i> @endif Product Wise  Shipping</a> </li>

                                    <li class="nav-item"> <a class="nav-link @if(Session::get('shippingSettingTab') == 'flat_shipping') active @endif" data-toggle="tab" href="#flat_shipping" role="tab">  @if(config('siteSetting.shipping_method') == 'flat_shipping') <i class="fa fa-check"></i> @endif Flat Rate Shipping</a> </li>

                                    <li class="nav-item"> <a class="nav-link @if(Session::get('shippingSettingTab') == 'location_shipping') active @endif" data-toggle="tab" href="#location_shipping" role="tab"> @if(config('siteSetting.shipping_method') == 'location_shipping') <i class="fa fa-check"></i> @endif Location-based Shipping</a> </li>

                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabcontent-border">
                                    <div class="tab-pane @if(!Session::get('shippingSettingTab')) active @endif @if(Session::get('shippingSettingTab') == 'free_shipping') active @endif" id="free_shipping" role="tabpanel">
                                        <div class="p-20">
                                           <h6 class="card-subtitle"><strong> Note: </strong> Free shipping is an increasingly-popular option for online shopping,<br/> where customers do not have to pay an additional shipping charge.</h6>
                                        </div>
                                    </div>

                                    <div class="tab-pane @if(Session::get('shippingSettingTab') == 'product_wise_shipping') active @endif" id="product_wise_shipping" role="tabpanel">
                                        <div class="p-20">
                                           <h6 class="card-subtitle"><strong> Note: </strong> Product Wise Shipping Cost calulation: Shipping cost is calculate by addition of each product shipping cost</h6>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane @if(Session::get('shippingSettingTab') == 'flat_shipping') active @endif" id="flat_shipping" role="tabpanel">
                                        <div class="p-20">
                                            <h6 class="card-subtitle"><strong> Note: </strong>Flat Rate Shipping Cost calulation: How many products a customer purchase, doesn\'t matter. Shipping cost is fixed.</h6>
                                            <form action="{{route('shipping_charge.update')}}"  method="post" data-parsley-validate id="flat_shipping">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$flat_shipping ? $flat_shipping->id : null}}">
                                                <div class="form-body">
                                                    <div class="row form-group">
                                                      <div class="col-md-3"><span class="required">Flat Shipping Cost</span><input class="form-control" value="{{ $flat_shipping ? $flat_shipping->shipping_cost : null}}" name="shipping_cost" placeholder="Exm: 50" min="0" type="number"></div> 
                                                  </div>
                                                    <div class="row form-group">
                                                    <div class="col-md-6 modal-footer pull-right">
                                                        <button type="submit" name="shippingSettingTab" value="flat_shipping" class="btn btn-success"> <i class="fa fa-save"></i> Update flat shipping</button>
                                                       
                                                        <button type="reset" class="btn waves-effect waves-light btn-secondary">Reset</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    
                                    <div class="tab-pane @if(Session::get('shippingSettingTab') == 'location_shipping') active @endif" id="location_shipping" role="tabpanel">
                                        <div class="p-20">
                                            <h6 class="card-subtitle">Set Location based shipping cost.</h6>
                                            <form action="{{route('shipping_charge.update')}}"  method="post" data-parsley-validate id="location_shipping">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$location_shipping ? $location_shipping->id : null}}">
                                                <div class="form-body">
                                                    <div class="row form-group justify-content-md-center">
                                                      <div class="col-md-3"><span class="required">Specific Region Name</span>
                                                        <select required name="region_id" id="region_id" class="select2 form-control custom-select">
                                                        <option value="">Select Region</option> 
                                                        @foreach($regions as $region) 
                                                        <option @if($location_shipping && $location_shipping->region_id  == $region->id) selected @endif value="{{$region->id}}">{{$region->name}}</option> @endforeach 
                                                        </select>
                                                        </div>

                                                      <div class="col-md-2"><span class="required">Shipping Cost</span><input required class="form-control" name="shipping_cost" placeholder="Exm: 60" value="{{$location_shipping ? $location_shipping->shipping_cost : null}}" min="0" type="number"></div>

                                                      <div class="col-md-2"><span class="required">Others region cost</span><input class="form-control" required="" name="other_region_cost" value="{{$location_shipping ? $location_shipping->other_region_cost : null}}" placeholder="Exm: 120" min="0" type="number"></div>

                                                      <div class="col-md-2"><span class="required">Others country cost</span><input class="form-control" required="" name="other_country_cost" value="{{$location_shipping ? $location_shipping->other_country_cost : null}}" placeholder="Exm: 120" min="0" type="number"></div>
                                                    </div>

                                                    <div class="modal-footer pull-right">
                                                        <button type="submit" name="shippingSettingTab" value="location_shipping" class="btn btn-success"> <i class="fa fa-save"></i> Update location shipping</button>
                                                       
                                                        <button type="reset" class="btn waves-effect waves-light btn-secondary">Reset</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
@endsection

@section('js')

<script type="text/javascript">
    

    var location_shipping = 1;
    //add dynamic attribute value fields by attribute
    function location_shipping_fields() {

        location_shipping++;
        var objTo = document.getElementById('location_shipping_fields')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "form-group removeclass" + location_shipping);
        var rdiv = 'removeclass' + location_shipping;
        divtest.innerHTML = `<div class="row justify-content-md-center" style="align-items: center">
            <div class="col-md-3"><select required name="region_id" id="region_id" class="select2 form-control custom-select"><option value="">Select Region</option> @foreach($regions as $region) <option @if(Session::get("region_id") == $region->id) selected @endif value="{{$region->id}}">{{$region->name}}</option> @endforeach </select></div>

            <div class="col-md-2"><input class="form-control" name="shipping_cost" value="{{Session::get("shipping_cost")}}" required placeholder="Shipping cost" min="1" type="number"></div>
            <div class="col-1"><button class="btn btn-danger" type="button" onclick="remove_location_shipping_fields(` + location_shipping + `)"><i class="fa fa-times"></i></button></div></div>`;

        objTo.appendChild(divtest)
    }
    //remove dynamic extra field
    function remove_location_shipping_fields(rid) {
        $('.removeclass' + rid).remove();
    }

</script>
@endsection
