<!DOCTYPE html>
<html lang="en">
   
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <!-- Mobile specific metas
            ============================================ -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <!-- Favicon
            ============================================ -->
        <link rel="shortcut icon" type="text/css" href="{{asset('frontend')}}/ico/favicon-16x16.png"/>
        <!-- Basic page needs
            ============================================ -->
        <title>@yield('title')</title>
        @yield('metatag')
        
        @include('layouts.partials.frontend.css')
        
        <!-- Google web fonts
            ============================================ -->
      <!--   <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet" type="text/css"> -->

    </head>
    <body class="common-home res layout-4">
        <div id="wrapper" class="wrapper-fluid banners-effect-3">
            <div id="app">

            <!-- Header Start -->
            @include('layouts.partials.frontend.header')
            @if(Request::is('/'))
            <div style="width: 100%;height: 100%;display: block;position: relative;">
            <div id="homepageLoading"></div>
            @endif
            <!-- Header End -->
            @yield('content')
            </div>
            <!-- Footer Area start -->
            @include('layouts.partials.frontend.footer')
            <!--  Footer Area End -->
            </div>
        </div>
        <div class="modal fade" id="quickviewModal" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" id="modalClose" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row" id="quickviewProduct"></div>
                    
                </div>
            </div>
          </div>
        @if(!Auth::check()) 
            <!-- login Modal -->
            @include('users.modal.login')
        @endif
        <div class="back-to-top"><i class="fa fa-angle-up"></i></div>
        @include('layouts.partials.frontend.scripts')
    </body>
</html>