@extends('layouts.frontend')
@section('title', 'Dashboard | '. Config::get('siteSetting.site_name') )
@section('css')

<style type="text/css">
    #user-dashboard .card{border-radius: 5px; }
    .d-flex {
        display: flex!important;
    }
    .icon-box i{font-size: 4rem}
    .ml-auto, .mx-auto {
        margin-left: auto!important;
    }
    .user-box{padding: 10px; margin-bottom: 10px;}
    .card-title, .icon-box{color: #fff}
    .user-box a{    font-size: 2.5rem !important; color: #fff}
    #user-dashboard{padding-top: 15px;}
    #user-dashboard section{background: #fff;margin-bottom: 10px;padding: 10px 0;}
}
</style>

@endsection
@section('content')

    <!-- Main Container  -->
    <div class="container">
        <div class="row">
            @include('users.inc.sidebar')
            <!--Middle Part Start-->
            <div id="user-dashboard" class="col-md-9 sticky-content">
                <p class="lead">Hello, <strong>{{Auth::user()->name}} </strong> </p>
                <section class="row">
                    <div class="col-md-3 col-xs-6">
                        <div class="card label-info">
                            <div class="user-box">
                                <h5 class="card-title">Total Orders</h5> 
                                <div class="d-flex  no-block align-items-center">
                                    <span class="icon-box"><i class="fa fa-cart-plus"></i></span> 
                                    <a href="{{route('user.orderHistory')}}" class="link ml-auto">{{count($orders)}}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-6">
                        <div class="card label-danger">
                            @php $orderStatus = array_count_values(array_column($orders->toArray(), 'order_status')); @endphp
                            <div class="user-box">
                                <h5 class="card-title">Pending Orders</h5> 
                                <div class="d-flex  no-block align-items-center">
                                    <span class="icon-box"><i class="fa fa-hourglass-half"></i></span> 
                                    <a href="{{route('user.orderHistory', 'pending')}}" class="link ml-auto">{{ array_key_exists('pending', $orderStatus) ? $orderStatus['pending'] : '0' }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="card label-primary">
                            <div class="user-box">
                                <h5 class="card-title">Wallet Balance</h5> 
                                <div class="d-flex  no-block align-items-center">
                                    <span class="icon-box" style="font-size: 4rem;padding: 3px;">{{Config::get('siteSetting.currency_symble')}}</span> 
                                    <a href="{{route('customer.walletHistory')}}" class="link ml-auto">{{$profile->wallet_balance}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="card label-success">
                            <div class="user-box">
                                <h5 class="card-title">Reward Points</h5> 
                                <div class="d-flex  no-block align-items-center">
                                    <span class="icon-box"><i class="fa fa-bookmark"></i></span> 
                                    <a href="javscript:void(0)" class="link ml-auto">{{$profile->reward_points}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="row">
                    <div class="col-md-12">
                        <h2 class="title">Recent Orders</h2>
                        <div class="table-responsive" >
                            <table  id="config-table" class="table display table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <td class="text-left">Order ID</td>
                                        <td class="text-left">Order Date</td>
                                        <td class="text-center">Qty</td>
                                        <td class="text-center">Amount</td>
                                        <td>Payment Method</td>
                                        <td class="text-center">Payment Status</td>
                                        <!-- <td class="text-center">Shipping Cost</td> -->
                                        <td class="text-center">Shipping Status</td>
                                        <td class="text-right">Action</td>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    @if($order->payment_method != 'pending' || $order->offer_id == null)
                                    <tr @if($order->order_status == 'cancel') style="background:#ff000026" @endif>
                                        <td class="text-left"> {{$order->order_id}} </td>
                                        <td class="text-left">{{Carbon\Carbon::parse($order->order_date)->format('M d, Y')}}</td>
                                        <td class="text-center">{{$order->total_qty}}</td>
                                        <td class="text-center">{{$order->currency_sign .$order->total_price}}</td>
                                        <td class="text-center">{{ ucfirst(str_replace('-', ' ', $order->payment_method))}}</td>
                                        
                                        <td class="text-center">{{$order->payment_status}}</td>
                                        <!-- <td class="text-center">
                                        @if($order->shipping_cost == null && $order->offer_id != null)
                                        <a style="margin-top: 5px;" href="{{route('shippingCostPayment', $order->order_id)}}" class="btn btn-danger btn-sm">Pay Shipping Cost</a>
                                        @else {{$order->shipping_cost}} @endif
                                        </td> -->
                                        <td class="text-center" id="ship_status{{$order->order_id}}">@if($order->order_status == 'delivered')
                                        <span class="label label-success"> {{ str_replace('-', ' ', $order->order_status)}} </span>

                                        @elseif($order->order_status == 'accepted')
                                        <span class="label label-warning"> {{ str_replace('-', ' ', $order->order_status)}} </span>

                                        @elseif($order->order_status == 'ready-to-ship')
                                        <span class="label label-default"> {{ str_replace('-', ' ', $order->order_status)}} </span>

                                        @elseif($order->order_status == 'cancel')
                                        <span class="label label-danger"> {{ str_replace('-', ' ', $order->order_status)}} </span>

                                        @elseif($order->order_status == 'on-delivery')
                                        <span class="label label-primary"> {{ str_replace('-', ' ', $order->order_status)}} </span>
                                        @elseif($order->order_status == 'return')
                                        <span class="label label-return"> {{ str_replace('-', ' ', $order->order_status)}} </span>

                                        @else
                                        <span class="label label-info"> Pending </span>
                                        @endif</td>
                                        
                                        <td class="text-center">
                                           <a class="dropdown-item text-inverse" title="View order" data-toggle="tooltip" href="{{route('user.orderDetails', $order->order_id)}}" data-original-title="View"><i class="fa fa-eye"></i> View</a>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
            <!--Middle Part End-->
            
        </div>
    </div>
    <!-- //Main Container -->

@endsection     
@section('js')

<script type="text/javascript">
    function orderCancelPopup(route) {
        document.getElementById('orderCancelRoute').value = route;
    }

    function orderCancel(route) {
        //separate id from route
        var id = route.split("/").pop();
     
        $.ajax({
            url:route,
            method:"get",
            success:function(data){
                if(data.status){
                    $("#ship_status"+id).html('cancel');
                    toastr.success(data.msg);
                }else{
                    toastr.error(data.msg);
                }
            }
        });
    }

</script>

@endsection     


