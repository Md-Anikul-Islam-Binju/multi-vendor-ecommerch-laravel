@yield('css-top')
<link rel="stylesheet" href="{{asset('frontend')}}/css/bootstrap/css/bootstrap.min.css">
<link href="{{asset('frontend')}}/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="{{asset('frontend')}}/js/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{asset('frontend')}}/js/owl-carousel/owl.carousel.css" rel="stylesheet">
<link href="{{asset('frontend')}}/css/themecss/lib.css" rel="stylesheet">
<link href="{{asset('frontend')}}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet">
<link href="{{asset('frontend')}}/js/minicolors/miniColors.css" rel="stylesheet">
<link href="{{asset('frontend')}}/js/slick-slider/slick.css" rel="stylesheet">
<!-- Theme CSS
     ============================================ -->
<link href="{{asset('frontend')}}/css/themecss/so_sociallogin.css" rel="stylesheet">
<link href="{{asset('frontend')}}/css/themecss/so_searchpro.css" rel="stylesheet">
<link href="{{asset('frontend')}}/css/themecss/so_megamenu.css" rel="stylesheet">
<link href="{{asset('frontend')}}/css/themecss/so-listing-tabs.css" rel="stylesheet">
<link href="{{asset('frontend')}}/css/themecss/so-newletter-popup.css" rel="stylesheet">
<link href="{{asset('frontend')}}/css/footer/footer2.css" rel="stylesheet">
<link href="{{asset('frontend')}}/css/header/header62.css" rel="stylesheet">
<link id="color_scheme" href="{{asset('frontend')}}/css/home6.css" rel="stylesheet">
<link href="{{asset('frontend')}}/css/responsive.css" rel="stylesheet">
<link href="{{asset('frontend')}}/css/quickview/quickview.css" rel="stylesheet">
<link href="{{asset('frontend')}}/css/custom.css" rel="stylesheet">
<link href="{{ asset('frontend/css/toastr.css') }}"  rel="stylesheet">

<style type="text/css">
    #homepageLoading
    {
        z-index: 999999; 
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        text-align: center;
        min-height: 200px;
        position: fixed;
        background: #ffffffe0 url('{{ asset("assets/images/loading.gif")}}') no-repeat center; 
    }    

    #pageLoading
    {
        z-index: 999999; 
        width: 100%;
        height: 100%;
        top: 0%;
        left: 0%;
        text-align: center;
        min-height: 200px;
        position: absolute;
        background: url('{{ asset("assets/images/loading.gif")}}') no-repeat center; 
        background: #ffffffe0 url('{{ asset("assets/images/loading.gif")}}') no-repeat center; 
    }
    #loadingData
    {
        z-index: 999999; 
        width: 100%;
        height: 100%;
        min-height: 100px;
        display: none;
        position: fixed;
        background: url('{{ asset("assets/images/loading.gif")}}') no-repeat center; 
    }
    .loadingData-sm
    {
        z-index: 9999; 
        width: 100%;
        height: 20px;
        background: url('{{ asset("assets/images/loader.gif")}}') no-repeat center; 
    }
    #process
    {
        display: none;
        width: 100%;
        position: absolute;
        height: 100%;
        background: url('{{ asset("assets/images/process.gif")}}') no-repeat center; 
    }
</style>
@yield('css')