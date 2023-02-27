const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
// backend scripts
mix.styles([

    'resources/scripts/css/toastr.css',
    'resources/scripts/css/pages/floating-label.css'
], 'public/css/app.css');

// mix.js('resources/js/app.js', 'public/js/laravel-echo.js');

mix.scripts([
    'resources/scripts/node_modules/jquery/jquery-3.2.1.min.js',
    'resources/scripts/node_modules/popper/popper.min.js',
    'resources/scripts/node_modules/bootstrap/dist/js/bootstrap.min.js',
    'resources/scripts/node_modules/jqueryui/jquery-ui.min.js',
    'resources/scripts/js/perfect-scrollbar.jquery.min.js',
    'resources/scripts/js/waves.js',
    'resources/scripts/js/sidebarmenu.js',
    'resources/scripts/node_modules/sticky-kit-master/dist/sticky-kit.min.js',
    'resources/scripts/node_modules/sparkline/jquery.sparkline.min.js',
    'resources/scripts/js/toastr.js',
    'resources/scripts/js/parsley.min.js',
], 'public/js/app.js');

//end backend scripts

//start frontend scripts


mix.styles([
    'resources/scripts/frontend/css/bootstrap/css/bootstrap.min.css',
    'resources/scripts/frontend/css/font-awesome/css/font-awesome.min.css',
    'resources/scripts/frontend/js/datetimepicker/bootstrap-datetimepicker.min.css',
    'resources/scripts/frontend/js/owl-carousel/owl.carousel.css',
    'resources/scripts/frontend/css/themecss/lib.css',
    'resources/scripts/frontend/js/jquery-ui/jquery-ui.min.css',
    'resources/scripts/frontend/js/minicolors/miniColors.css',
    'resources/scripts/frontend/css/themecss/so_sociallogin.css',
    'resources/scripts/frontend/css/themecss/so_searchpro.css',
    'resources/scripts/frontend/css/themecss/so_megamenu.css',
    'resources/scripts/frontend/css/themecss/so-categories.css',
    'resources/scripts/frontend/css/themecss/so-listing-tabs.css',
    'resources/scripts/frontend/css/themecss/so-category-slider.css',
    'resources/scripts/frontend/css/themecss/so-newletter-popup.css',
  
    'resources/scripts/frontend/css/home6.css',
    'resources/scripts/frontend/css/responsive.css',
    'resources/scripts/frontend/css/quickview/quickview.css',
    'resources/scripts/frontend/css/toastr.css',
    'resources/scripts/node_modules/typeahead.js-master/dist/typehead-min.css'
], 'public/frontend/css/style.min.css');

mix.scripts([
    'resources/scripts/frontend/js/jquery-2.2.4.min.js',
    'resources/scripts/frontend/js/bootstrap.min.js',
    'resources/scripts/frontend/js/themejs/so_megamenu.js',
    'resources/scripts/frontend/js/owl-carousel/owl.carousel.js',
    'resources/scripts/frontend/js/slick-slider/slick.js',
    'resources/scripts/frontend/js/themejs/libs.js',
    'resources/scripts/frontend/js/unveil/jquery.unveil.js',
    'resources/scripts/frontend/js/dcjqaccordion/jquery.dcjqaccordion.2.8.min.js',
    'resources/scripts/frontend/js/datetimepicker/moment.js',
    'resources/scripts/frontend/js/datetimepicker/bootstrap-datetimepicker.min.js',
    'resources/scripts/frontend/js/jquery-ui/jquery-ui.min.js',
    'resources/scripts/frontend/js/modernizr/modernizr-2.6.2.min.js',
    'resources/scripts/frontend/js/minicolors/jquery.miniColors.min.js',
    'resources/scripts/frontend/js/jquery.nav.js',
    'resources/scripts/frontend/js/quickview/jquery.magnific-popup.min.js',
    'resources/scripts/frontend/js/themejs/application.js',
    'resources/scripts/frontend/js/themejs/addtocart.js',
    'resources/scripts/js/toastr.js',
    'resources/scripts/node_modules/typeahead.js-master/dist/typeahead.bundle.min.js',
    'resources/scripts/frontend/js/parsley.min.js',
], 'public/frontend/js/app.js');

//end frontend


if(mix.inProduction()){
	mix.version();
}
