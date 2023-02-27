<header class="topbar" style="background:#000; color: #fff">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <!-- ============================================================== -->
        <!-- Logo --> 
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="{{route('vendor.dashboard')}}">
                <img width="150" height="50" src="{{asset('upload/images/logo/'.Config::get('siteSetting.logo'))}}" alt="homepage" class="dark-logo" />
               
                <!-- Logo text --><span>
                 <!-- dark Logo text -->
                 <img width="150" height="50" src="{{asset('upload/images/logo/'.Config::get('siteSetting.logo'))}}" alt="homepage" class="dark-logo" />
                 <!-- Light Logo text -->    
                 <img width="150" height="50" src="{{asset('upload/images/logo/'.Config::get('siteSetting.logo'))}}" class="light-logo" alt="homepage" /></span> 
             </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto">
                <!-- This is  -->
                <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
                <li class="nav-item">
                    <form class="app-search d-none d-md-block d-lg-block">
                        <input type="text" class="form-control" placeholder="Search & enter">
                    </form>
                </li>
            </ul>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
                <!-- ============================================================== -->
                <!-- Comment -->
                <!-- ============================================================== -->
                <li class="nav-item">
                    <a target="_blank" title="Go to homepage" class="nav-link dropdown-toggle waves-effect waves-dark" href="{{url('/')}}" > <i class="fa fa-globe"></i>
                        
                    </a>
                </li>

        
           
                <!-- ============================================================== -->
                <!-- User Profile -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown u-pro">
                   <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('assets/images/vendors/'.Auth::guard('vendor')->user()->logo)}}" alt="" class=""> <span class="hidden-md-down">{{explode(' ', trim(Auth::guard('vendor')->user()->shop_name))[0]}} &nbsp;<i class="fa fa-angle-down"></i></span> </a>
                    <div class="dropdown-menu dropdown-menu-right animated flipInY">
                        <!--  <a href="{{route('vendor.shop-setting')}}" class="dropdown-item"><i class="ti-settings"></i> Shop Setting</a> -->
                         <a href="{{route('vendor.profile')}}" class="dropdown-item"><i class="ti-user"></i> Profile</a>
                        <a href="{{route('vendor.change-password')}}" class="dropdown-item"><i class="fa fa-edit"></i> Change Password</a>
                        <!-- text-->
                        <a href="{{ route('vendorLogout') }}" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                        
                        <!-- text-->
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End User Profile -->
               
            </ul>
        </div>
    </nav>
</header>