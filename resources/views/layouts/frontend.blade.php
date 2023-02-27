<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="shortcut icon" type="text/css" href="{{asset('upload/images/logo/'. Config::get('siteSetting.favicon'))}}"/>
  <title>@yield('title')</title>
  @yield('metatag')
  @include('layouts.partials.frontend.css')
  {!! config('siteSetting.header') !!}
</head>
<body class="common-home res layout-6" style="background: {{ config('siteSetting.bg_color') }}; color: {{ config('siteSetting.text_color') }}">

  <div id="wrapper" class="wrapper-fluid banners-effect-5">
  <div id="app">
    <?php 
      if(!Session::has('menus')){
        $menus =  \App\Models\Menu::with(['get_categories'])->orderBy('position', 'asc')->where('status', 1)->get();
        Session::put('menus', $menus);
      }
      $menus = Session::get('menus');
      
      $categories =  \App\Models\Category::where('parent_id', '=', null)->orderBy('orderBy', 'asc')->where('status', 1)->get();
        Session::put('categories', $categories);
      $categories = Session::get('categories');
    ?>
    @php 
        $header = 'layouts.partials.frontend.header'.Config::get('siteSetting.header_no');
        $footer = 'layouts.partials.frontend.footer'.Config::get('siteSetting.footer_no');
    @endphp
    <!-- Header Start -->
    @includeFirst([$header, "layouts.partials.frontend.header1"])
    <div class="mainArea">
      <div id="pageloaderOpend">
        <div style="width:70px;position: absolute; top: 50%; left: 50%;border-radius: 3px; background:#08080894;-webkit-transform: translate(-50%,-50%);-moz-transform: translate(-50%,-50%);-ms-transform: translate(-50%,-50%);-o-transform: translate(-50%,-50%);transform: translate(-50%,-50%);"><img src="{{ asset("frontend/image/loading.gif")}}"></div>
      </div>
      @if(Auth::check()) 
      @include('layouts.partials.frontend.user-sidebar')
      @endif
    <!-- Header End -->
    @yield('content')
    </div>
  </div>
  <!-- Footer Area start -->
  @includeFirst([$footer, "layouts.partials.frontend.footer1"])
  <!--  Footer Area End -->
  </div>
  <div class="modal fade" id="quickviewModal" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header" style="border:none;">
              <button type="button" id="modalClose" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body form-row" id="quickviewProduct"></div>
      </div>
    </div>
  </div>
  <div class="modal fade in" id="video_pop"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content" >
         <div class="modal-body">        
            <button style="background: #bdbdbd;color:#f90101;opacity: 1;padding: 0 5px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
             </button>        
             <!-- 16:9 aspect ratio -->
             <div id="showVideoFrame"></div>                
         </div>        
      </div>
    </div>
  </div>
  @if(!Auth::check()) 
  <!-- login Modal -->
  @include('users.modal.login')
  @endif
  <div class="back-to-top hidden-top"><i class="fa fa-angle-up"></i></div>

  @include('layouts.partials.frontend.scripts')
  {!! config('siteSetting.google_analytics') !!}
  {!! config('siteSetting.google_adsense') !!}
  {!! config('siteSetting.footer') !!}
  <script src="{{ asset('assets/node_modules/select2/dist/js/select2.min.js') }}"></script>

  <script type="text/javascript">
    $(".header-bottom a, .offerType_box a, .navbar-logo a, .vertical-wrapper a, a.offer_box,  .product-item-container a, .caption h4 a, .buyNowBtn, .products-category a, .offer_section a, .bottom-nav a, aside a").click(function () {
        $("#pageloaderOpend").css("display","block").fadeIn(3000);
         setTimeout(function () {
           $("#pageloaderOpend").css("display","none");
        }, 5000);
    });
  
  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
  // Gets the video src from the data-src on each button   
  $('.video-btn').click(function() {
    var videoType = $(this).data( "type" ); 
    var videoSrc = $(this).data( "src" );
    $("#video_pop").css("display","block")
    if(videoType == 'video'){
        $('#showVideoFrame').html('<video id="myVideo" width="100%" controls autoplay><source id="video" src="'+ videoSrc+'" type="video/mp4"></video>');
    }
    if(videoType == 'youtube'){
        $('#showVideoFrame').html( '<iframe width="100%" height="100%" src="'+ videoSrc+'?autoplay=1&rel=0'+'"  frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'); 
    }
  });

  $('.modal .close').click(function(){
  modal.style.display = "none";
  $('#showVideoFrame').html('');
  });

  var modal = document.getElementById('video_pop');
  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
  if (event.target == modal) {
  modal.style.display = "none";
  $('#showVideoFrame').html('');
  }
  }
  // stop playing the video when I close the modal
  $('#video_pop').on('hidden.bs.modal', function (e) {
  $('#showVideoFrame').html('');
  });
  });



  </script>

@stack('js')
</body>
</html>