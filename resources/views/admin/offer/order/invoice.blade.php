@extends('layouts.admin-master')
@section('title', 'Invoice')
@section('css')
<style type="text/css">
    b, strong {
    font-weight: 700;}
    hr{margin: 3px !important;}
</style>
@endsection
@section('content')
    <!-- ignore cancel order id -->
    @php
    if(Request::route('customer_name'))
        $orderNo = -1;
        foreach($orders as $order){
            $orderNo++;
            if($order->order_status != 'cancel' && Request::route('customer_name') == $order->username){
                break;
            }
        }
    @endphp
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
                        <a href="{{ route('admin.offerOrder', $offer->slug) }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-eye"></i> Order list</a>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
                <div class="container">
                    <div class="card card-body printableArea" style="position: relative;">
                        <h3 style="position:absolute;z-index: 999; transform: rotate(335deg);top: 36%;left: 25%;color: {{ ($order->payment_status == 'paid') ? '#f5f5f56e' : '#fbbcbc21'}};text-transform: uppercase;font-weight: bold; font-size: 8em;">{{$order->payment_status}}</h3>
                        <h3><b>INVOICE NO: </b> <span class="pull-right">#{{$orders[$orderNo]->order_id}}</span></h3>
                        <span>{{$offer->title}}</span>
                        <hr>
                        <div class="row">
                            @if(Auth::guard('admin')->user()->role_id == 'admin' || in_array(Auth::guard('admin')->user()->id, [22,25]) )
                            <div class="col-md-12">
                                <div class="pull-left" style="float: left;">
                                    <div style="width:160px; height: 55px;">
                                        <img style="height: 100%; width: 100%;" src="{{asset('upload/images/logo/'.(Config::get('siteSetting.invoice_logo') ? Config::get('siteSetting.invoice_logo'): Config::get('siteSetting.logo')))}}" title="Home" alt="Logo">
                                    </div>
                                </div>

                                <div class="pull-right text-right">
                                    <address>
                                    {{Config::get('siteSetting.address')}}<br/>
                                    Phone: {{Config::get('siteSetting.phone')}}<br/>
                                    Email: {{Config::get('siteSetting.email')}}
                                    </address>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="pull-left" style="float: left;max-width: 60%">
                                    <address>
                                        {{$orders[$orderNo]->shipping_name}}
                                        @if($orders[$orderNo]->shipping_email)<br>{{$orders[$orderNo]->shipping_email}}@endif
                                        <br>{{$orders[$orderNo]->shipping_phone}}
                                        <br>
                                        Address:- {!!
                                            $orders[$orderNo]->shipping_address. ', '.
                                            $orders[$orderNo]->shipping_area. ', '.
                                            $orders[$orderNo]->shipping_city. ', '.
                                            $orders[$orderNo]->shipping_region
                                        !!}
                                        @if($orders[$orderNo]->order_notes)<br><b style="font-weight: bold;">Notes: </b>{{$orders[$orderNo]->order_notes}}@endif
                                    </address>
                                </div>
                                <div class="pull-right text-right">
                                     <address>
                                    <strong>Order ID:</strong> #{{$orders[$orderNo]->order_id}} <br>
                                    <b>Order Date:</b> {{Carbon\Carbon::parse($orders[$orderNo]->order_date)->format('M d, Y')}}<br>
                                    <b>Payment Status:</b> {{str_replace( '-', ' ',$orders[$orderNo]->payment_status) }} <br>
                                    @if($orders[$orderNo]->shipping_method)<b>Shipping Method:</b> {{ $orders[$orderNo]->shipping_method->name }} <br>@endif
                                     </address>
                                </div>
                            </div>
                            @endif
                        </div>
                       
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" style=" clear: both;">
                                    <table class="table table-hover" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Order</th>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th style="text-align: right;">Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $all_orders = []; $total_price = $shipping_cost =  0; $i =1; ?>
                                            @foreach($orders as $order)
                                               @foreach($order->order_details as $order_detail)
                                                @if($order_detail->shipping_status != 'cancel')
                                                  <tr>
                                                    <td>{{$i++}}</td>
                                                    <td style="font-size: 14px;text-transform:capitalize">
                                                        @php if(!in_array($order->order_id, $all_orders)){
                                                        array_push($all_orders, $order->order_id);
                                                        } @endphp
                                                       
                                                        {{$order->order_id}}<br/>
                                                        {{ucfirst(strtolower($order->shipping_name))}}<br/>
                                                         {{ucfirst(strtolower($order->shipping_phone))}}
                                                    </td>
                                                    <td>
                                                        <img src="{{asset('upload/images/product/'.$order_detail->product->feature_image)}}" width="40" > {{ $order_detail->product->title }} <br>
                                                        @if($order_detail->attributes) @foreach(json_decode($order_detail->attributes) as $key=>$value)
                                                        <small> {{ $value }} </small>
                                                        @endforeach
                                                        @endif
                                                    </td>
                                                    <td>{{$order->currency_sign. $order_detail->price}}</td>
                                                    <td>{{$order_detail->qty}}</td>
                                                    <td style="text-align: right;">{{$order->currency_sign. $order_detail->price*$order_detail->qty}}</td>
                                                  </tr> 
                                                  @endif

                                                  @php 
                                                    $total_price += $order_detail->price;
                                                  @endphp
                                                @endforeach
                                                @php
                                                    $shipping_cost += $order->shipping_cost;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                        <tfoot style="text-align: right;">
                                            <tr>
                                                <td colspan="4"></td>
                                                <td ><b>Sub-Total</b>
                                                </td>
                                                <td >{{$orders[$orderNo]->currency_sign . $total_price}}</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td ><b>Shipping Cost(+)</b>
                                                </td>
                                                <td >{{$orders[$orderNo]->currency_sign . $shipping_cost}}</td>
                                                <td></td>
                                            </tr>
                                            
                                            <tr>
                                                <td colspan="4"></td>
                                                <td ><h3><b>Total</b></h3>
                                                </td>
                                                <td ><h3>{{$orders[$orderNo]->currency_sign . ($total_price + $shipping_cost)  }}</h3></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                       
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right no-print">
                         <input id="invoice_id" type="hidden" name="invoice_id" value="{{ $orders[$orderNo]->order_id }}">
                        <input type="hidden" id="all_orders" name="all_orders" value="{{implode(',',$all_orders)}}">
                        @if(Auth::guard('admin')->user()->role_id == 'admin' || $orders[$orderNo]->payment_status == 'paid')

                            @if(Auth::guard('admin')->user()->role_id == 'admin' || in_array(Auth::guard('admin')->id(), [22,25]))

                            @if(Auth::guard('admin')->user()->role_id == 'admin' || $orders[$orderNo]->invoicePrints <= 0 )
                            
                            <button id="print" onclick="invoicePrintBy('{{$orders[$orderNo]->order_id}}')" class="btn btn-success btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
                            @endif
                        @else
                        <span style="color: red;">Payment Status: {{$orders[$orderNo]->payment_status}}</span>
                        @endif
                        <p style="color:red"><strong>N.B</strong> Invoice Print ({{$orders[$orderNo]->invoicePrints}}) time</p>
                            @endif
                    </div>
                </div>
            
            <!-- ============================================================== -->
            <!-- End PAge Content -->
       
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
                    $('#print').remove();
                }
            });
        }
    </script>
@endsection