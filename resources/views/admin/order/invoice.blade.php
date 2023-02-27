@extends('layouts.admin-master')
@section('title', 'Invoice ')
@section('css')
<style type="text/css">
    b, strong { font-weight: 700;}

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
                    <h4 class="text-themecolor">Invoice</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        
                        <a href="{{route('admin.orderList')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-eye"></i> Order list</a>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->

            @if($order->user_type ==2)
            <div class="container">
                <div class="card card-body printableArea" style="position: relative;">
                    <h3 style="position:absolute;z-index: 999; transform: rotate(335deg);top: 36%;left: 25%;color: {{ ($order->payment_status == 'paid') ? '#f5f5f56e' : '#fbbcbc21'}};text-transform: uppercase;font-weight: bold; font-size: 8em;">{{$order->payment_status}}[Customer]</h3>
                    <h3><b>INVOICE NO: </b> <span class="pull-right">#{{$order->order_id}}</span></h3>
                    <hr>
                    <div class="row">
                        @if(Auth::guard('admin')->user()->role_id == 'admin' || in_array(Auth::guard('admin')->user()->id, [22,25]) )
                        <div class="col-md-12">
                            <div class="pull-left" style="float: left;">
                                <div style="width:160px; height: 55px;">
                                    @if($order->user_type==2)
                                        @if(file_exists('upload/vendors/logo/'.$order->reseller->logo))
                                            <img style="height: 100%; width: 100%;" src="{{asset('upload/vendors/logo/'.$order->reseller->logo)}}" title="Home" alt="reseller logo">
                                        @else
                                            <img style="height: 100%; width: 100%;" src="{{asset('upload/images/logo/logo-with-tagline.png')}}" title="Home" alt="Logo">
                                        @endif

                                    @else
                                        <img style="height: 100%; width: 100%;" src="{{asset('upload/images/logo/logo-with-tagline.png')}}" title="Home" alt="Logo">
                                    @endif

                                </div>
                            </div>
                            <div class="pull-right text-right">
                                <address>
                                {{$order->reseller->address}}<br/>
                                Phone: {{$order->reseller->mobile}}<br/>
                                Email: {{$order->reseller->email}}
                                </address>
                            </div>
                             <hr>
                        </div>
                       
                        <div class="col-md-12">

                            <div class="pull-left" style="float: left;max-width: 60%">
                                <address>
                                    {{$order->shipping_name}}
                                    @if($order->shipping_email)<br>{{$order->shipping_email}}@endif
                                    <br>{{$order->shipping_phone}}
                                    <br>
                                    {!!
                                        $order->shipping_address. ', '.
                                        $order->shipping_area. ', '.
                                        $order->shipping_city. ', '.
                                        $order->shipping_region
                                    
                                    !!}
                                    @if($order->order_notes)<br><b style="font-weight: bold;">Notes: </b>{{$order->order_notes}}@endif
                                </address>
                            </div>
                            <div class="pull-right text-right">
                                <address>
                                <strong>Order ID:</strong> #{{$order->order_id}} <br>
                                <b>Order Date:</b> {{Carbon\Carbon::parse($order->order_date)->format('M d, Y')}}<br>
                                <b>Payment Status:</b> {{str_replace( '-', ' ',$order->payment_status) }} <br>
                                @if($order->shipping_method)<b>Shipping Method:</b> {{ $order->shipping_method->name }}@endif
                                </address>
                            </div>
                        </div>
                        @endif
                    </div>
                   
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" style="clear: both;">
                                <table class="table table-hover" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th style="text-align: right;">Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $total = $minusPrice = 0; ?>
                                        @foreach($order->order_details as $index => $item)
                                        @if(Auth::guard('admin')->user()->role_id == 'admin')
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td style="line-height: 0px">

{{--                                                <img src="{{asset('upload/images/product/'.$item->product->feature_image)}}" width="48" height="38" >--}}

                                                @if($item->attributes)
                                                    @foreach($item->product->get_variations as $variant)
                                                        @if($variant->attribute_name == explode('"', $item->attributes)[1])
                                                            @foreach($variant->allVariationValues as $pv)
                                                                @if( $pv->attributeValue_name == explode('"', $item->attributes)[3])

                                                                    <img width="50" src="{{asset('upload/images/product/varriant-product/thumb/'.$pv->image)}}" class="img-thumbnail">
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <img width="50" src="{{asset('upload/images/product/thumb/'.$item->image)}}" class="img-thumbnail">
                                                            @break
                                                        @endif

                                                    @endforeach
                                                @else
                                                    <img width="50" src="{{asset('upload/images/product/thumb/'.$item->image)}}" class="img-thumbnail">
                                                @endif












                                                {{ $item->product->title }}
                                            @if($item->attributes) @foreach(json_decode($item->attributes) as $key=>$value)
                                            <small>@if($key) {{$key}} : @endif {{$value}} </small>
                                            @endforeach
                                            @endif
                                            </td>
                                            <td> {{$order->currency_sign. $item->customer_price}}</td>
                                            <td>{{$item->qty}}</td>
                                            <td style="text-align: right;">{{$order->currency_sign. $item->customer_price*$item->qty}}</td>
                                          </tr> 
                                        @else
                                        
                                       
                                        @if( $item->shipping_status != 'cancel' && $item->shipping_status != 'return' && $item->shipping_status != 'delivered')
                                          <tr>
                                            <td>{{$index+1}}</td>
                                            <td style="line-height: 0px"><img src="{{asset('upload/images/product/'.$item->product->feature_image)}}" width="48" height="38" > {{ $item->product->title }}
                                            @if($item->attributes) @foreach(json_decode($item->attributes) as $key=>$value)
                                            <small>@if($key) {{$key}} : @endif {{$value}} </small>
                                            @endforeach
                                            @endif
                                            </td>
                                            <td> {{$order->currency_sign. $item->price}}</td>
                                            <td>{{$item->qty}}</td>
                                            <td style="text-align: right;">{{$order->currency_sign. $item->price*$item->qty}}</td>
                                          </tr> 
                                          @else
                                          <?php $minusPrice += $item->price*$item->qty; ?>
                                          @endif
                                        @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot style="text-align: right;">
                                        <tr>
                                            <td colspan="3"></td>
                                            <td><b>Sub-Total</b>
                                            </td>
                                            <td >{{$order->currency_sign . ($order->customer_total_price -  $minusPrice)}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td ><b>Shipping Cost(+)</b>
                                            </td>
                                            <td>{{$order->currency_sign}}{{ ($order->shipping_cost) ? $order->shipping_cost : 0}}</td>
                                        </tr>
                                        @if($order['coupon_discount'] != null)
                                        <tr>
                                            <td colspan="3"></td>
                                            <td ><b>Coupon Discount(-)</b>
                                            </td>
                                            <td >{{$order->currency_sign . $order->coupon_discount}}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td colspan="3"></td>
                                            <td ><h3><b>Total</b></h3>
                                            </td>
                                            <td ><h3>{{$order->currency_sign . (($order->customer_total_price + $order->shipping_cost - $order->coupon_discount) -  $minusPrice)  }}</h3></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right no-print">
                    <input id="invoice_id" type="hidden" name="invoice_id" value="{{$order->order_id}}">
                    <input type="hidden" id="all_orders" name="all_orders" value="{{$order->order_id}}">
                    @if(Auth::guard('admin')->user()->role_id == 'admin' || $order->payment_status == 'paid')
                    @if(Auth::guard('admin')->user()->role_id == 'admin' || in_array(Auth::guard('admin')->user()->id, [22,25]) )
                    @if(Auth::guard('admin')->user()->role_id == 'admin' || $order->invoicePrints <= 0 )
                    <button id="print" onclick="invoicePrintBy('{{$order->order_id}}')" class="btn btn-success btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
                    @endif
                    
                    @endif
                    @else
                    <span style="color: red;">Payment Status: {{$order->payment_status}}</span>
                    @endif
                    <p style="color:red"><strong>N.B</strong> Invoice Print ({{$order->invoicePrints}}) time</p>
                </div>
            </div>
            @endif
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <div class="container">
                <div class="card card-body printableArea2" style="position: relative;">
                    <h3 style="position:absolute;z-index: 999; transform: rotate(335deg);top: 36%;left: 25%;color: {{ ($order->payment_status == 'paid') ? '#f5f5f56e' : '#fbbcbc21'}};text-transform: uppercase;font-weight: bold; font-size: 8em;">{{$order->payment_status}}</h3>
                    <h3><b>INVOICE NO: </b> <span class="pull-right">#{{$order->order_id}}</span></h3>
                    <hr>
                    <div class="row">
                        @if(Auth::guard('admin')->user()->role_id == 'admin' || in_array(Auth::guard('admin')->user()->id, [22,25]) )
                            <div class="col-md-12">
                                <div class="pull-left" style="float: left;">
                                    <div style="width:160px; height: 55px;">
                                        @if($order->user_type==2)
                                            @if(file_exists('upload/vendors/logo/'.$order->reseller->logo))
                                                <img style="height: 100%; width: 100%;" src="{{asset('upload/vendors/logo/'.$order->reseller->logo)}}" title="Home" alt="reseller logo">
                                            @else
                                                <img style="height: 100%; width: 100%;" src="{{asset('upload/images/logo/logo-with-tagline.png')}}" title="Home" alt="Logo">
                                            @endif

                                        @else
                                            <img style="height: 100%; width: 100%;" src="{{asset('upload/images/logo/logo-with-tagline.png')}}" title="Home" alt="Logo">
                                        @endif
                                    </div>
                                </div>
                                <div class="pull-right text-right">
                                    <address>
                                        {{Config::get('siteSetting.address')}}<br/>
                                        Phone: {{Config::get('siteSetting.phone')}}<br/>
                                        Email: {{Config::get('siteSetting.email')}}
                                    </address>
                                </div>
                                <hr>
                            </div>

                            <div class="col-md-12">

                                <div class="pull-left" style="float: left;max-width: 60%">
                                    <address>
                                        {{$order->shipping_name}}
                                        @if($order->shipping_email)<br>{{$order->shipping_email}}@endif
                                        <br>{{$order->shipping_phone}}
                                        <br>
                                        {!!
                                            $order->shipping_address. ', '.
                                            $order->shipping_area. ', '.
                                            $order->shipping_city. ', '.
                                            $order->shipping_region

                                        !!}
                                        @if($order->order_notes)<br><b style="font-weight: bold;">Notes: </b>{{$order->order_notes}}@endif
                                    </address>
                                </div>
                                <div class="pull-right text-right">
                                    <address>
                                        <strong>Order ID:</strong> #{{$order->order_id}} <br>
                                        <b>Order Date:</b> {{Carbon\Carbon::parse($order->order_date)->format('M d, Y')}}<br>
                                        <b>Payment Status:</b> {{str_replace( '-', ' ',$order->payment_status) }} <br>
                                        @if($order->shipping_method)<b>Shipping Method:</b> {{ $order->shipping_method->name }}@endif
                                    </address>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" style="clear: both;">
                                <table class="table table-hover" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th style="text-align: right;">Sub Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $total = $minusPrice = 0; ?>
                                    @foreach($order->order_details as $index => $item)
                                        @if(Auth::guard('admin')->user()->role_id == 'admin')
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td style="line-height: 0px">
{{--                                                    <img src="{{asset('upload/images/product/'.$item->product->feature_image)}}" width="48" height="38" >--}}
                                                    @if($item->attributes)
                                                        @foreach($item->product->get_variations as $variant)
                                                            @if($variant->attribute_name == explode('"', $item->attributes)[1])
                                                                @foreach($variant->allVariationValues as $pv)
                                                                    @if( $pv->attributeValue_name == explode('"', $item->attributes)[3])

                                                                        <img width="50" src="{{asset('upload/images/product/varriant-product/thumb/'.$pv->image)}}" class="img-thumbnail">
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <img width="50" src="{{asset('upload/images/product/thumb/'.$item->image)}}" class="img-thumbnail">
                                                                @break
                                                            @endif

                                                        @endforeach
                                                    @else
                                                        <img width="50" src="{{asset('upload/images/product/thumb/'.$item->image)}}" class="img-thumbnail">
                                                    @endif
                                                    {{ $item->product->title }}

                                                    @if($item->attributes) @foreach(json_decode($item->attributes) as $key=>$value)
                                                        <small>@if($key) {{$key}} : @endif {{$value}} </small>
                                                    @endforeach
                                                    @endif
                                                </td>
                                                <td> {{$order->currency_sign. $item->price}}</td>
                                                <td>{{$item->qty}}</td>
                                                <td style="text-align: right;">{{$order->currency_sign. $item->price*$item->qty}}</td>
                                            </tr>
                                        @else


                                            @if( $item->shipping_status != 'cancel' && $item->shipping_status != 'return' && $item->shipping_status != 'delivered')
                                                <tr>
                                                    <td>{{$index+1}}</td>
                                                    <td style="line-height: 0px"><img src="{{asset('upload/images/product/'.$item->product->feature_image)}}" width="48" height="38" > {{ $item->product->title }}
                                                        @if($item->attributes) @foreach(json_decode($item->attributes) as $key=>$value)
                                                            <small>@if($key) {{$key}} : @endif {{$value}} </small>
                                                        @endforeach
                                                        @endif
                                                    </td>
                                                    <td> {{$order->currency_sign. $item->price}}</td>
                                                    <td>{{$item->qty}}</td>
                                                    <td style="text-align: right;">{{$order->currency_sign. $item->price*$item->qty}}</td>
                                                </tr>
                                            @else
                                                <?php $minusPrice += $item->price*$item->qty; ?>
                                            @endif
                                        @endif
                                    @endforeach
                                    </tbody>
                                    <tfoot style="text-align: right;">
                                    <tr>
                                        <td colspan="3"></td>
                                        <td><b>Sub-Total</b>
                                        </td>
                                        <td >{{$order->currency_sign . ($order->total_price -  $minusPrice)}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td ><b>Shipping Cost(+)</b>
                                        </td>
                                        <td>{{$order->currency_sign}}{{ ($order->shipping_cost) ? $order->shipping_cost : 0}}</td>
                                    </tr>
                                    @if($order['coupon_discount'] != null)
                                        <tr>
                                            <td colspan="3"></td>
                                            <td ><b>Coupon Discount(-)</b>
                                            </td>
                                            <td >{{$order->currency_sign . $order->coupon_discount}}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td colspan="3"></td>
                                        <td ><h3><b>Total</b></h3>
                                        </td>
                                        <td ><h3>{{$order->currency_sign . (($order->total_price + $order->shipping_cost - $order->coupon_discount) -  $minusPrice)  }}</h3></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right no-print">
                    <input id="invoice_id" type="hidden" name="invoice_id" value="{{$order->order_id}}">
                    <input type="hidden" id="all_orders" name="all_orders" value="{{$order->order_id}}">
                    @if(Auth::guard('admin')->user()->role_id == 'admin' || $order->payment_status == 'paid')
                        @if(Auth::guard('admin')->user()->role_id == 'admin' || in_array(Auth::guard('admin')->user()->id, [22,25]) )
                            @if(Auth::guard('admin')->user()->role_id == 'admin' || $order->invoicePrints <= 0 )
                                <button id="print2" onclick="invoicePrintBy('{{$order->order_id}}')" class="btn btn-success btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
                            @endif

                        @endif
                    @else
                        <span style="color: red;">Payment Status: {{$order->payment_status}}</span>
                    @endif
                    <p style="color:red"><strong>N.B</strong> Invoice Print ({{$order->invoicePrints}}) time</p>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
@endsection

@section('js')
    <script src="{{asset('js/pages/jquery.PrintArea.js')}}" type="text/JavaScript"></script>
    <script>
    $(document).ready(function() {
        $("#print").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea").printArea(options);
        });

        $("#print2").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea2").printArea(options);
        });
    });

    function invoicePrintBy(order_id) {
    
            var link = '{{route("admin.invoicePrintBy", ":order_id")}}';
            link = link.replace(':order_id', order_id);
            var invoice_id = $('#invoice_id').val();
            var all_orders = $('#all_orders').val();
          
            $.ajax({
                url:link,
                method:"get",
                data:{invoice_id:invoice_id,all_orders:all_orders},
                success:function(data){
                    console.log(data);
//                    $('#print').remove();
                }
            });
        } 
    </script>
@endsection