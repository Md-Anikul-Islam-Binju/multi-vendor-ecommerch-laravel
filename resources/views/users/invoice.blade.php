@extends('layouts.frontend')
@section('title', 'Invoice #'. $order->order_id)
@section('css')
<style type="text/css">
    b, strong {
    font-weight: 700;
}
table th{text-align: left;text-transform: capitalize;background: transparent!important; }
</style>
@endsection
@section('content')

    <div class="row">
        <div class="container">
            @include('users.inc.sidebar')
            
            <div id="content" class="col-md-9 sticky-content">

                <div class="card card-body printableArea" style="position: relative;">
                    <h3 style="position:absolute;z-index: 999; transform: rotate(335deg);top: 36%;left: 25%;color: {{ ($order->payment_status == 'paid') ? '#f5f5f56e' : '#fbbcbc21'}};text-transform: uppercase;font-weight: bold; font-size: 8em;">{{$order->payment_status}}</h3>
                        <h3><b>INVOICE NO: </b> <span >#{{$order->order_id}}</span></h3>
                    <hr>
                    <div class="row">
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
                    </div>
                    <hr>
                    <div class="row">
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
                                <b>Order Date:</b> {{Carbon\Carbon::parse($order->order_date)->format('M d, Y')}}<br> <b>Order Status:</b> {{ str_replace( '-', ' ', $order['order_status']) }} <br>
                                
                                <b>Payment Method:</b> {{str_replace( '-', ' ',  $order->payment_method) }} <br>
                                @if($order->shipping_method)<b>Shipping Method:</b> {{ $order->shipping_method->name }} <br>@endif
                              	 </address>
                            </div>
                        </div>
                        <div class="col-md-12">
                                <table class="table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th style="text-align: right;">Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $total = 0; ?>
                                       @foreach($order->order_details as $item)
                                          
                                          <tr>
                                            <td><img src="{{asset('upload/images/product/'.$item->product->feature_image)}}" width="45">
                                            {{ $item->product->title }} <br>
                                            @if($item->attributes) @foreach(json_decode($item->attributes) as $key=>$value)
                                            <small> @if($key) {{$key}} : @endif {{$value}} </small>
                                            @endforeach
                                            @endif
                                        </td>
                                            <td>{{$item->qty}}</td>
                                            <td>{{$order->currency_sign. $item->price}}</td>
                                            <td style="text-align: right;">{{$order->currency_sign. $item->price*$item->qty}}</td>
                                          </tr> 
                                        @endforeach
                                       
                                    </tbody>
                                    <tfoot style="text-align: right;">
                                        <tr>
                                            <td colspan="2"></td>
                                            <td ><b>Sub-Total</b>
                                            </td>
                                            <td >{{$order->currency_sign . $order->total_price}}</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td ><b>Shipping Cost(+)</b>
                                            </td>
                                            <td>{{$order->currency_sign}}{{ ($order->shipping_cost) ? $order->shipping_cost : 0}}</td>
                                            
                                        </tr>
                                        @if($order['coupon_discount'] != null)
                                        <tr>
                                            <td colspan="2"></td>
                                            <td ><b>Coupon Discount(-)</b>
                                            </td>
                                            <td >{{$order->currency_sign . $order->coupon_discount}}</td>
                                           
                                        </tr>
                                        @endif
                                        <tr>
                                            <td colspan="2"></td>
                                            <td ><h3><b>Total</b></h3>
                                            </td>
                                            <td ><h3>{{$order->currency_sign . ($order->total_price + $order->shipping_cost - $order->coupon_discount)  }}</h3></td>
                                            
                                        </tr>
                                    </tfoot>
                                </table>
                        </div>
                    </div>
                </div>

                <div class="text-right no-print">
                    <input id="invoice_id" type="hidden" name="invoice_id" value="{{$order->order_id}}">
                    <input type="hidden" id="all_orders" name="all_orders" value="{{$order->order_id}}">
                    <button id="print" onclick="invoicePrintBy('{{$order->order_id}}')" class="btn btn-success btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->

           
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
                    
                }
            });
        }
       
    </script>
@endsection