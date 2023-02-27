<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li> <a class="waves-effect waves-dark" href="{{route('admin.dashboard')}}" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu">Dashboard</span></a></li>

                <li> <a class="has-arrow waves-effect waves-dark @if(Request::route('attribute_slug')) active @endif" href="javascript:void(0)" aria-expanded="false"><i class="ti-settings"></i><span class="hide-menu">Product Specification </span></a>
                    <ul aria-expanded="false" class="collapse @if(Request::route('attribute_slug')) in @endif">
                        <li><a href="{{route('category')}}">Main Category</a></li>
                        <li><a href="{{route('subcategory')}}">Sub Category</a></li>
                        <li><a href="{{route('subchildcategory')}}">Sub Child Category</a></li>
                        <li><a href="{{route('productAttribute')}}">Product Attributes</a></li>
                        <li><a href="{{route('predefinedFeature')}}">Product Feature</a></li>
                        <li><a href="{{route('brand')}}">Product Brand</a></li>
                    </ul>
                </li>
 
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-cart-plus"></i><span class="hide-menu">Product </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.product.upload')}}">Add New Product</a></li>
                        <li><a href="{{route('admin.product.list')}}">Manage Product</a></li>
                        <li><a href="{{route('admin.product.import')}}">Import Product</a></li>
                    </ul>
                </li>
                @php $pendingOrder = App\Models\Order::where('payment_method', '!=', 'pending')->where('order_status', 'pending')->count(); @endphp
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-shipping-fast"></i><span class="hide-menu">Orders <span class="badge badge-pill badge-cyan ml-auto">{{ $pendingOrder }}</span></span></a>
                    <ul aria-expanded="false" class="collapse">
                         <li><a href="{{route('admin.orderList', 'pending')}}">Pending Orders <span class="badge badge-pill badge-cyan ml-auto">{{ $pendingOrder }}</span></a></li>
                        <li><a href="{{route('admin.orderList')}}">All Orders</a></li>
                        @php $returnList = App\Models\ReturnRequest::query()->where('status',1)->count() @endphp
                        <li><a href="{{route('order.return.list')}}">Order Return Request @if($returnList>0) <span class="badge badge-pill badge-cyan ml-auto">{{ $returnList }}</span> @endif</a></li>
                        <li><a href="{{route('orderCancelReason.list')}}">Order Cancel Reason</a></li>
                    </ul>
                </li>
               
                
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-people-carry"></i><span class="hide-menu"> Offer & Campaign</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.offer')}}">Manage Offer</a></li>
                        <li><a href="{{route('offerType.list')}}">Offer Type</a></li>
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-chart-bar"></i><span class="hide-menu"> Reports</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.order.report')}}">Order report</a></li>

                    </ul>
                </li>

                @if(Auth::guard('admin')->user()->role_id == 'admin')
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-settings"></i><span class="hide-menu">Payment Settings</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('paymentGateway')}}">Purchase Gateway</a></li>
                        <li><a href="{{route('sellerPaymentGateway')}}">Payment Gateway</a></li>
                        <li><a href="{{route('currency.list')}}">Currencies</a></li>

                    </ul>
                </li>
                <li>
                <a class=" has-arrow  waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-email"></i><span class="hide-menu">SMTP &amp; OTP Config </span></a>
                <ul aria-expanded="false" class="collapse">
                <li><a href="{{url('/')}}/admin/smtp/configurations">SMTP settings</a></li>
                <li><a href="{{url('/')}}/admin/otp/configurations">OTP configurations</a></li>

                </ul>
                </li>
                <li>
                <a class=" has-arrow  waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-lock"></i><span class="hide-menu">Module &amp; Role </span></a>
                <ul aria-expanded="false" class="collapse">
                <li><a href="{{url('/')}}/admin/module/list">Modules</a></li>
                <li><a href="{{url('/')}}/admin/role/list">Role &amp; Permission</a></li>

                </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-settings"></i><span class="hide-menu">Shipping Setting</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('shipping_method.list')}}">Shipping Methods</a></li>
                         <li><a href="{{route('shipping_charge')}}">Shipping charge</a></li>
                        <!--<li><a href="{{route('packagings')}}">Packagings</a></li> -->
                    </ul>
                </li>


                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-align-left"></i><span class="hide-menu">Home Page Setting</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.homepageSection')}}">Homepage</a></li>
                        <li><a href="{{route('menu')}}">Menus</a></li>
                        <li><a href="{{route('slider.create')}}">Sliders</a></li>
                        <li><a href="{{route('service.list')}}">Services</a></li>
                        <li><a href="{{route('banner')}}">All Banner</a></li>
                       <!--  <li><a href="javascript:void(0)">Category Section</a></li>
                        <li><a href="javascript:void(0)">Customer Reviews</a></li>
                        <li><a href="javascript:void(0)">Patners</a></li> -->

                    </ul>
                </li>


                <li>
                <a class=" has-arrow  waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-cogs"></i><span class="hide-menu">General Settings </span></a>
                <ul aria-expanded="false" class="collapse">
                <li><a href="{{route('generalSetting')}}">General Setting</a></li>
                <li><a href="{{url('/')}}/admin/site/setting">Site settings</a></li>
                <li><a href="{{route('headerSetting')}}">Header Setting</a></li>
                <li><a href="{{route('footerSetting')}}">Footer Setting</a></li>
                <li><a href="{{url('/')}}/admin/logo/setting">Logo Setting</a></li>
                <li><a href="{{url('/')}}/admin/google/setting">Analytics &amp; Adsense</a></li>
                <li><a href="{{url('/')}}/admin/seo/setting">SEO Setting</a></li>
                <li><a href="{{url('/')}}/admin/social/login/setting">Social Media Login</a></li>
                <li><a href="{{url('/')}}/admin/social/setting">Social Media Link</a></li>
                <li><a href="{{url('/')}}/admin/google/recaptcha">Google eCaptcha</a></li>

                </ul>
                </li>

                 <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-map"></i><span class="hide-menu">Location</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('state')}}">Division</a></li>
                        <li><a href="{{route('city')}}">City</a></li>
                        <li><a href="{{route('area')}}">Area</a></li>
                    </ul>
                </li>
                @endif

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-user"></i><span class="hide-menu">Account Setting</span></a>
                    <ul aria-expanded="false" class="collapse">
                       <li><a href="{{route('admin.profileUpdate')}}">Profile Setting</a></li>
                        <li><a href="{{route('admin.passwordChange')}}">Change Password</a></li>
                    </ul>
                </li>

                {{--@php $sellerRequest = App\Vendor::where('status', 'pending')->count(); @endphp
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="icon-people"></i><span class="hide-menu">Sellers <span class="badge badge-pill badge-cyan ml-auto">{{$sellerRequest}}</span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li> <a href="{{route('vendor.list')}}">Seller List</a></li>
                        <li> <a href="{{route('vendor.list', 'pending')}}">Seller Request <span class="badge badge-pill badge-cyan ml-auto">{{$sellerRequest}}</span></a></li>
                        @if(Auth::guard('admin')->user()->role_id == 'admin')
                        <li><a href="{{route('sellerWithdrawRequest')}}">withdraw request</a></li>
                        <li><a href="{{route('sellerWalletHistory')}}">Transaction history</a></li>
                        <li><a href="{{route('vendor.commission')}}">Seller Commission</a></li>
                        @endif
                      <!--   <li><a href="#">Seller Subscriptions</a></li> -->

                    </ul>
                </li>--}}

                <li>
                    <a href="javascript:void(0)" class="has-arrow waves-effect waves-dark"  aria-expanded="false"><i class="icon-people"></i><span class="hide-menu">ReSellers</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li> <a href="{{route('resellerList')}}">ReSeller List</a></li>
                        <li> <a href="{{route('resellerWithdrawRequest')}}">ReSeller withdraw</a></li>

                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Customers </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('customer.list')}}">Customers</a></li>
                         @if(Auth::guard('admin')->user()->role_id == 'admin')
                        <li><a href="{{route('adminReviewList')}}">Reviews</a></li>
                        <li><a href="{{route('label.list')}}">Label list</a></li>
                        @endif
                    </ul>
                </li>
 
                @if(Auth::guard('admin')->user()->role_id == 'admin' || in_array(Auth::guard('admin')->user()->id, [22]))

                 <li>
                    @php $withdrawRequest = App\Models\Transaction::where('customer_id', '!=', null)->where('status', 'pending')->count(); @endphp

                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-settings"></i><span class="hide-menu">Wallet <span class="badge badge-pill badge-cyan ml-auto">{{ $withdrawRequest }}</span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li> <a href="{{route('customerWalletHistory')}}">Wallet History</a></li>
                        <li> <a href="{{route('customerWithdrawRequest')}}">Withdraw Request <span class="badge badge-pill badge-cyan ml-auto">{{$withdrawRequest}}</span></a></li>
                        @if(Auth::guard('admin')->user()->role_id == 'admin')
                        <li> <a href="{{route('customer.withdrawConfigure')}}">Withdraw Configure</a></li>
                        @endif
                    </ul>

                </li>
                @endif
                @if(Auth::guard('admin')->user()->role_id == 'admin')
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Staff</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <!-- <li><a href="{{route('page.create')}}">Add New Page</a></li> -->
                        <li><a href="{{route('staff.list')}}">Staff list</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-settings"></i><span class="hide-menu">Refund</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.refundRequest', 'pending')}}">Pending Request </a></li>
                        <li><a href="{{route('admin.refundRequest')}}">All Refund Request</a></li>
                        <li><a href="{{route('returnReason')}}">Refund Reason</a></li>
                        <li><a href="{{route('admin.refundConfig')}}">Refund Configuration</a></li>
                    </ul>
                </li>
                @endif


                @if(Auth::guard('admin')->user()->role_id == 'admin')
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-newspaper"></i><span class="hide-menu">Manage Pages</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('page.create')}}">Add New Page</a></li>
                        <li><a href="{{route('page.list')}}">Page list</a></li>
                    </ul>
                </li>

                <li> <a class="waves-effect waves-dark" href="{{route('coupon')}}" aria-expanded="false"><i class="fa fa-people-carry"></i><span class="hide-menu">Manage Coupon</span></a></li>
                @endif
                <li> <a class="waves-effect waves-dark" href="{{ route('adminLogout') }}"  aria-expanded="false"><i class="fa fa-power-off text-success"></i><span class="hide-menu">Log Out</span></a></li>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
