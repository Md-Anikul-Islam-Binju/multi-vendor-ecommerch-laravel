@extends('layouts.admin-master')
@section('title', 'Shipping configuration')
@section('css')
    <link href="{{asset('css')}}/pages/tab-page.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        #generalSetting input, #generalSetting textarea{color: #797878!important}
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
                                <div class="row justify-content-md-center">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <span for="location_id">Shipping Method</span>
                                            <select name="location_id" id="showMenuSourch" class="form-control">
                                                <option value="free">Free Shipping</option>
                                                <option value="flat">Flat Shipping</option>
                                                <option value="location">Location-based Shipping</option>
                                                <option value="price">Price-based shipping</option>
                                               
                                            </select>
                                           
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cost">Default Cost</label>
                                            <input  name="cost" placeholder="Exm: 50Tk" id="cost" value="{{old('cost')}}" required="" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3"><span>Estimated Shipping Time</span><input class="form-control" name="shipping_time" placeholder="Exm: 3-4 days" type="text"></div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="cost">`</label>
                                            <button style="color: #fff" type="submit" name="submit" value="add" class="form-control btn btn-success">Active</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"> <a class="nav-link @if(!Session::get('shippingSettingTab')) active @endif @if(Session::get('shippingSettingTab') == 'free_shipping') active @endif" data-toggle="tab" href="#free_shipping" role="tab"><i class="fa fa-check"></i> Free Shipping</a> </li>

                                    <li class="nav-item"> <a class="nav-link @if(Session::get('shippingSettingTab') == 'flat_shipping') active @endif" data-toggle="tab" href="#flat_shipping" role="tab">Flat Rate Shipping</a> </li>

                                    <li class="nav-item"> <a class="nav-link @if(Session::get('shippingSettingTab') == 'location_shipping') active @endif" data-toggle="tab" href="#location_shipping" role="tab">Location-based Shipping</a> </li>

                                    <li class="nav-item"> <a class="nav-link @if(Session::get('shippingSettingTab') == 'basket_shipping') active @endif" data-toggle="tab" href="#basket_shipping" role="tab"> Basket-based shipping</a> </li>

                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabcontent-border">
                                    <div class="tab-pane @if(!Session::get('shippingSettingTab')) active @endif @if(Session::get('shippingSettingTab') == 'free_shipping') active @endif" id="free_shipping" role="tabpanel">
                                        <div class="p-20">
                                           <h6 class="card-subtitle">Free shipping is an increasingly-popular option for online shopping,<br/> where customers do not have to pay an additional shipping charge.</h6>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane @if(Session::get('shippingSettingTab') == 'flat_shipping') active @endif" id="flat_shipping" role="tabpanel">
                                        <div class="p-20">
                                            <h6 class="card-subtitle">Flat rate shipping is a single rate is charged for shipping a package.</h6>
                                            <form action="{{route('shipping_charge.store')}}"  method="post" data-parsley-validate id="flat_shipping">
                                                @csrf
                                                <input type="hidden" name="id" value="">
                                                <div class="form-body">
                                                    <div class="row form-group">
                                                      <div class="col-md-3"><span class="required">Flat Shipping Cost</span><input class="form-control" name="shipping_cost" placeholder="Exm: 50" min="1" type="number"></div> 
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
                                            <form action="{{route('shipping_charge.store')}}"  method="post" data-parsley-validate id="location_shipping">
                                                @csrf
                                                <input type="hidden" name="id" value="">
                                                <div class="form-body">
                                                    <div class="row form-group justify-content-md-center">
                                                      <div class="col-md-3"><span class="required">Region Name</span><select required name="ship_region_id" id="ship_region_id" class="select2 form-control custom-select"><option value="">Select Region</option> @foreach($regions as $region) <option @if(Session::get("ship_region_id") == $region->id) selected @endif value="{{$region->id}}">{{$region->name}}</option> @endforeach </select></div>

                                                      <div class="col-md-2"><span class="required">Shipping Cost</span><input required class="form-control" name="shipping_cost" value="{{Session::get("shipping_cost")}}" placeholder="Exm: 50" min="1" type="number"></div>
                                                      <div class="col-1 nopadding" style="padding-top: 20px">
                                                        <button class="btn btn-success" type="button" onclick="location_shipping_fields();"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                    </div>

                                                    <div id="location_shipping_fields"></div>
                                                    <div class="form-group" style="text-align: center;"><span  style="cursor: pointer;" class="btn btn-info btn-sm" onclick="location_shipping_fields()"><i class="fa fa-plus"></i> Add More </span>
                                                    </div>
                                                    <div class="modal-footer pull-right">
                                                        <button type="submit" name="shippingSettingTab" value="location_shipping" class="btn btn-success"> <i class="fa fa-save"></i> Update location shipping</button>
                                                       
                                                        <button type="reset" class="btn waves-effect waves-light btn-secondary">Reset</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="tab-pane @if(Session::get('shippingSettingTab') == 'basket_shipping') active @endif" id="basket_shipping" role="tabpanel">
                                        <div class="p-20">
                                            <h6 class="card-subtitle">Basket based shipping: The shipping price is based on the total price of the items being purchased.</h6>
                                            <form action="{{route('shipping_charge.store')}}"  method="post" data-parsley-validate id="basket_shipping">
                                                @csrf
                                                <input type="hidden" name="id" value="">
                                                <div class="form-body">

                                                    <div class="row form-group justify-content-md-center">
                                                       <div class="col-md-3"><span class="required">Total basket price (>=)</span><input class="form-control" required name="order_price_above" placeholder="0.00" min="1" type="number"></div>
                                                      <div class="col-md-3"><span class="required">Shipping cost</span><input class="form-control" required name="shipping_cost" placeholder="Exm: 60" type="text"></div>
                                                      <div class="col-1 nopadding" style="padding-top: 20px">
                                                        <button class="btn btn-success" type="button" onclick="basket_shipping_fields();"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                    </div>

                                                    <div id="basket_shipping_fields"></div>
                                                    <div class="form-group" style="text-align: center;"><span  style="cursor: pointer;" class="btn btn-info btn-sm" onclick="basket_shipping_fields()"><i class="fa fa-plus"></i> Add More </span>
                                                    </div>
                                                   
                                                    <div class="modal-footer pull-right">
                                                        <button type="submit" name="shippingSettingTab" value="basket_shipping" class="btn btn-success"> <i class="fa fa-save"></i> Update price shipping</button>
                                                       
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
    
    var product_video = 1;
    //add dynamic attribute value fields by attribute
    function basket_shipping_fields() {

        basket_shipping++;
        var objTo = document.getElementById('basket_shipping_fields')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "form-group removeclass" + basket_shipping);
        var rdiv = 'removeclass' + basket_shipping;
        divtest.innerHTML = `<div class="row justify-content-md-center" style="align-items: center">
           <div class="col-md-3"><input class="form-control" required name="order_price_above" placeholder="Enter price" min="1" type="number"></div>
          <div class="col-md-3"><input class="form-control" class="required" name="shipping_cost" placeholder="Exm: 50" type="text"></div>
            <div class="col-1"><button class="btn btn-danger" type="button" onclick="remove_basket_shipping_fields(` + basket_shipping + `)"><i class="fa fa-times"></i></button></div></div>`;

        objTo.appendChild(divtest)
    }
    //remove dynamic extra field
    function remove_basket_shipping_fields(rid) {
        $('.removeclass' + rid).remove();
    }


    var location_shipping = 1;
    //add dynamic attribute value fields by attribute
    function location_shipping_fields() {

        location_shipping++;
        var objTo = document.getElementById('location_shipping_fields')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "form-group removeclass" + location_shipping);
        var rdiv = 'removeclass' + location_shipping;
        divtest.innerHTML = `<div class="row justify-content-md-center" style="align-items: center">
            <div class="col-md-3"><select required name="ship_region_id" id="ship_region_id" class="select2 form-control custom-select"><option value="">Select Region</option> @foreach($regions as $region) <option @if(Session::get("ship_region_id") == $region->id) selected @endif value="{{$region->id}}">{{$region->name}}</option> @endforeach </select></div>

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
