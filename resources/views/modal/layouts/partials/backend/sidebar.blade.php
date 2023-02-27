
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
                        <li><a href="{{route('product.create')}}">Add New Product</a></li>
                        <li><a href="{{route('product.list')}}">Manage Product</a></li>
                       
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-shipping-fast"></i><span class="hide-menu">Orders</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.orderList')}}">All Orders</a></li>
                        <li><a href="{{route('admin.orderList', 'pending')}}">Pending Orders</a></li>
                        <li><a href="{{route('admin.orderList', 'accepted')}}">Accepted Orders</a></li>
                        <li><a href="{{route('admin.orderList', 'on-review')}}">Processing Orders</a></li>
                        <li><a href="{{route('admin.orderList', 'delivered')}}">Completed Orders</a></li>
                        <li><a href="{{route('admin.orderList', 'cancel')}}">Cancel Orders</a></li>
                    </ul>
                </li>


                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-settings"></i><span class="hide-menu">Location</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('state')}}">State</a></li>
                        <li><a href="{{route('city')}}">City</a></li>
                        <li><a href="{{route('area')}}">Area</a></li>
                        
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-settings"></i><span class="hide-menu">Payment Settings</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('paymentGateway')}}">Payment Gateway</a></li>
                        <li><a href="#">Shipping</a></li>
                        <li><a href="#">Currencies</a></li>
                        <li><a href="#">SMS Setting</a></li>
                        <li><a href="#">Footer Setting</a></li>
                       
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-align-left"></i><span class="hide-menu">Home Page Setting</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.homepageSection')}}">Homepage</a></li>
                        <li><a href="{{route('menu')}}">Menus</a></li>
                        <li><a href="{{route('slider.create')}}">Sliders</a></li>
                        <li><a href="{{route('service.list')}}">Services</a></li>
                      
                        <li> <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Banner Section</a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('banner')}}">All Banner</a></li>
                                <li><a href="javascript:void(0)">Small Banner</a></li>
                                <li><a href="javascript:void(0)">Banner 2 Image per row</a></li>
                                <li><a href="javascript:void(0)">Banner 3 Image per row</a></li>
                                <li><a href="javascript:void(0)">Left-site Large 1 Image Right-site 2 Image </a></li>
                                
                                
                            </ul>
                        </li>
                        <li><a href="javascript:void(0)">Best Seller Section</a></li>
                        <li><a href="javascript:void(0)">Services Section</a></li>
                        <li><a href="javascript:void(0)">Category Section</a></li>
                        <li><a href="javascript:void(0)">Customer Reviews</a></li>
                        <li><a href="javascript:void(0)">Patners</a></li>
                        <li><a href="#">Footer Setting</a></li>
                    </ul>
                </li>

            

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-settings"></i><span class="hide-menu">Settings</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#">General Setting</a></li>
                        <li><a href="#">SMS Setting</a></li>
                        <li><a href="{{route('category')}}">Email Template</a></li>
                        <li><a href="{{route('subcategory')}}">Email Configuration</a></li>
                        
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="icon-people"></i><span class="hide-menu">Vendor</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li> <a href="#">View Vendors</a></li>
                        <li><a href="#">Add Vendors</a></li>
                       
                        <li> <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Vendor Request</a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="javascript:void(0)">All Request</a></li>
                                <li><a href="javascript:void(0)">Pending</a></li>
                                <li><a href="javascript:void(0)">Accepted</a></li>
                                <li><a href="javascript:void(0)">Rejected</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Vendor Subscriptions</a></li>
                       
                    </ul>
                </li>

                

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Customers </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#">View Customers</a></li>
                        <li><a href="#">Transections</a></li>
                        <li><a href="#">Reviews</a></li>
                    
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-user"></i><span class="hide-menu">Manage Staff </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#">Add New Staff</a></li>
                        <li><a href="#">All Staff</a></li>
                        <li><a href="#">Manage Designation</a></li>
                       
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-support"></i><span class="hide-menu">Ticket Manage<span class="badge badge-pill badge-warning ml-auto">3</span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#"><i class="ti-list"></i> All Ticket</a></li>
                      
                        
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-email"></i><span class="hide-menu">Messages <span class="badge badge-pill badge-cyan ml-auto">4</span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#">Mailbox</a></li>
                        <li><a href="app-email-detail.html">Mailbox Detail</a></li>
                        <li><a href="#">Compose Mail</a></li>
                    </ul>
                </li>
             
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-palette"></i><span class="hide-menu">Expenditure</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#">Mailbox</a></li>
                        <li><a href="app-email-detail.html">Mailbox Detail</a></li>
                        <li><a href="#">Compose Mail</a></li>
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-newspaper"></i><span class="hide-menu">Manage Pages</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('page.create')}}">Add New Page</a></li>
                        <li><a href="{{route('page.list')}}">Page View</a></li>
                        
                    </ul>
                </li>

               

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-bar-chart"></i><span class="hide-menu">Reports</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#">Sales Reports</a></li>
                        <li><a href="#">Order Reports</a></li>
                        <li><a href="#">Transection</a></li>
                        <li><a href="#">Compose Mail</a></li>
                    </ul>
                </li>

              

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-server"></i><span class="hide-menu">Stock</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#">Mailbox</a></li>
                        <li><a href="app-email-detail.html">Mailbox Detail</a></li>
                        <li><a href="#">Compose Mail</a></li>
                    </ul>
                </li>

                <li> <a class="waves-effect waves-dark" href="{{route('coupon')}}" aria-expanded="false"><i class="fa fa-people-carry"></i><span class="hide-menu">Manage Coupon</span></a></li>

                <li> <a class="waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-people-carry"></i><span class="hide-menu">Subscriptions</span></a></li>
                
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-shine"></i><span class="hide-menu">Manage Roles</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('role.create')}}">Create Role</a></li>
                        <li><a href="#">Role Permission</a></li>
                       
                    </ul>
                </li>
             
               
                <li> <a class="waves-effect waves-dark" href="{{ route('adminLogout') }}"  aria-expanded="false"><i class="fa fa-power-off text-success"></i><span class="hide-menu">Log Out</span></a></li>
               
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>