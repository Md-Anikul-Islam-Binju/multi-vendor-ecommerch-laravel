<header class="topbar" style="background:#000; color: #fff">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="{{route('admin.dashboard')}}">
                <b><img width="32" src="{{ asset('upload/images/logo/'.config('siteSetting.favicon'))}}" alt="" class="light-logo" />
                </b><span>
             <!-- Light Logo text -->    
             <img src="{{ asset('upload/images/logo/'.config('siteSetting.logo'))}}" width="150" class="light-logo" alt="" /></span> 
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
                    <a target="_blank" title="Go to homepage" class="nav-link dropdown-toggle waves-effect waves-dark" href="{{url('/')}}" > <i class="fa fa-globe"></i></a>
                </li>
               
                <!-- <php  $website = 'rstjobs.com'; preg_match("/[^\.\/]+\.[^\.\/]+$/", $_SERVER['HTTP_HOST'], $matches); if($matches){ if($matches[0] != $website || $matches[0] != '127.0.0.1'){  header("Location: /"); exit(); } }  ?> -->
               
               <!--  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ti-bell"></i>
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                        <ul>
                            <li>
                                <div class="drop-title">Notifications</div>
                            </li>
                            <li>
                                <div class="message-center">

                                    <a href="javascript:void(0)">
                                        <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                        <div class="mail-contnet">
                                            <h5>Luanch Admin</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span> </div>
                                    </a>

                                </div>
                            </li>
                            <li>
                                <a class="nav-link text-center link" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </div>
                </li> -->

                <!-- Messages -->
                <!-- ============================================================== -->
               <!--  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ti-email"></i>
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>
                    <div class="dropdown-menu mailbox dropdown-menu-right animated bounceInDown" aria-labelledby="2">
                        <ul>
                            <li>
                                <div class="drop-title">You have 4 new messages</div>
                            </li>
                            <li>
                                <div class="message-center">

                                    <a href="javascript:void(0)">
                                        <div class="user-img"> <img src="{{asset('assets')}}/images/users/1.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                                    </a>

                                </div>
                            </li>
                            <li>
                                <a class="nav-link text-center link" href="javascript:void(0);"> <strong>See all e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </div>
                </li> -->
                <!-- ============================================================== -->
                <!-- End Messages -->

                <!-- ============================================================== -->
                <!-- User Profile -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown u-pro">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('assets/images/users')}}/{{( Auth::guard('admin')->user()->photo) ? Auth::guard('admin')->user()->photo : 'default.png'}}" alt="user" class=""> <span class="hidden-md-down">{{explode(' ', trim(Auth::guard('admin')->user()->name))[0]}} &nbsp;<i class="fa fa-angle-down"></i></span> </a>
                    <div class="dropdown-menu dropdown-menu-right animated flipInY">

                        <a href="{{route('generalSetting')}}" class="dropdown-item"><i class="ti-settings"></i> General Setting</a>
                         <a href="{{route('admin.profileUpdate')}}" class="dropdown-item"><i class="ti-user"></i> Profile</a>
                        <a href="{{route('admin.passwordChange')}}" class="dropdown-item"><i class="fa fa-edit"></i> Change Password</a>
                        <a href="{{ route('adminLogout') }}"
                        class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>

                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End User Profile -->

            </ul>
        </div>
    </nav>
</header>
