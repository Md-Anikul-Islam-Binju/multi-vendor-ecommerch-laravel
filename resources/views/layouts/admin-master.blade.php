<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="shortcut icon" type="text/css" href="{{asset('upload/images/logo/'. Config::get('siteSetting.favicon'))}}"/>
    <title>@yield('title')</title>
    <script src="{{asset('frontend/js/pace.min.js')}}"></script>
    <!-- /*process bar*/ -->
    <style type="text/css">
    .pace{-webkit-pointer-events:none;pointer-events:none;-webkit-user-select:none;-moz-user-select:none;user-select:none}.pace-inactive{display:none}.pace .pace-progress{background:#07c10d;position:fixed;z-index:2000;top:0;right:100%;width:100%;height:2px}
</style>
    @include('layouts.partials.backend.css')
</head>
<body class="fixed-layout skin-blue-dark" >
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
<!--     <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Please Wait...</p>
        </div>
    </div> -->
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <div id="app">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        @include('layouts.partials.backend.admin-header')
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
      
        @include('layouts.partials.backend.admin-sidebar')

        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
       <!-- ============================================================== -->

        @yield('content')
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer">
            {!! config('siteSetting.copyright_text') !!}
        </footer>
    </div>
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- End Wrapper -->

    <!-- include js files -->
    @include('layouts.partials.backend.scripts')
</body>
</html>
