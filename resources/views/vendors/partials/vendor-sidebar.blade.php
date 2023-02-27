
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                
                <li> <a class="waves-effect waves-dark" href="{{route('vendor.dashboard')}}" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu">Dashboard</span></a></li> 

                <li> <a class="has-arrow waves-effect waves-dark @if(Request::route('attribute_slug')) active @endif" href="javascript:void(0)" aria-expanded="false"><i class="ti-settings"></i><span class="hide-menu">Product Specification </span></a>
                    <ul aria-expanded="false" class="collapse @if(Request::route('attribute_slug')) in @endif">
                        <li><a href="{{route('vendor.brand')}}">Product Brand</a></li>
                       
                    </ul>
                </li>
                @php $pendingProduct = App\Models\Product::where('status', 'pending')->where('vendor_id', Auth::guard('vendor')->id())->count(); @endphp
                <li> <a class="has-arrow waves-effect waves-dark"  href="javascript:void(0)" aria-expanded="false"><i class="fa fa-cart-plus"></i><span class="hide-menu">Product <span class="badge badge-pill badge-cyan ml-auto">{{ $pendingProduct }}</span> </span></a>
                    <ul aria-expanded="false" class="collapse @if(Request::segment(2) == 'product') in @endif">
                        <li><a href="{{route('vendor.product.upload')}}">Product Upload</a></li>
                        <li> <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Manage Product</a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('vendor.product.list')}}">All Product</a></li>
                                <li><a href="{{route('vendor.product.list', 'pending')}}">Pending Product <span class="badge badge-pill badge-cyan ml-auto">{{ $pendingProduct }}</span></a></li>
                                
                            </ul>
                        </li>
                    </ul>
                </li>
                
                <li> <a class="has-arrow waves-effect waves-dark @if(Request::segment(2) == 'order') active @endif" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-shipping-fast"></i><span class="hide-menu">Orders </span></a>
                    <ul aria-expanded="false" class="collapse @if(Request::segment(2) == 'order') in @endif">
                        <li><a href="{{route('vendor.orderList')}}">All Orders</a></li>
                        <li><a href="{{route('vendor.orderList', 'pending')}}">Pending Orders</a></li>
                        <li><a href="{{route('vendor.orderList', 'accepted')}}">Accepted Orders</a></li>
                        <li><a href="{{route('vendor.orderList', 'ready-to-ship')}}">Ready To Ship</a></li>
                        <li><a href="{{route('vendor.orderList', 'delivered')}}">Delivered Orders</a></li>
                        <li><a href="{{route('vendor.orderList', 'cancel')}}">Cancel Orders</a></li>
                    </ul>
                </li>

               <!--  <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-podcast"></i><span class="hide-menu">Promotions</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#">Campain</a></li>
                        <li><a href="#">Bundles</a></li>
                    </ul>
                </li> -->

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-settings"></i><span class="hide-menu">Account Setting
                </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('vendor.profile')}}">Profile Setting</a></li>
                        <li><a href="{{route('vendor.logo-banner')}}">Logo & Banner</a></li>
                        <li><a href="{{route('vendor.change-password')}}">Change Passowrd</a></li>
                    </ul>
                </li>

                <li><a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-dollar-sign"></i><span class="hide-menu">Finance</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('vendor.paymentSetting')}}">Payment Setting</a></li>
                        <li><a href="{{route('vendor.withdrawHistory')}}">Withdraw Money</a></li>
                         <li><a href="{{route('vendor.transactions')}}">Transactions History</a></li>
                    </ul>
                </li>

              
                <li> <a class="waves-effect waves-dark" href="{{ route('vendorLogout') }}"  aria-expanded="false"><i class="fa fa-power-off text-success"></i><span class="hide-menu">Log Out</span></a></li>
               
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>