@extends('layouts.frontend')
@section('title', $brand->name . ' | Brand | '. Config::get('siteSetting.site_name') )
@section('metatag')

    <!-- Open Graph general (Facebook, Pinterest & Google+) -->
    <meta property="og:description" content="{{$brand->name}}">
    <meta property="og:image" content="{{asset('upload/images/brand/'. $brand->logo)}}">
    <meta property="og:url" content="{{ url()->full() }}">
    <meta property="og:site_name" content="{{Config::get('siteSetting.site_name')}}">
    <meta property="og:locale" content="en">
    <meta property="og:type" content="website">
    <meta property="og:type" content="e-commerce">


@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.range.css') }}">
    <style type="text/css">
      
        #wrapper{background: #fdfdfdc7;}
      
        .ratting label{font-size: 18px;}
        .slider-container{margin-top: 12px;}
        .pagination>li>a, .pagination>li>span{padding: 6px 10px;}
    </style>
@endsection
@section('content')
    <!-- Main Container  -->
    <div class="breadcrumbs">
        <div class="container">
            <ul class="breadcrumb-cate">
                <li><a href="{{url('/')}}"><i class="fa fa-home"></i> </a></li>
                <li>{{$brand->name}}</li>
            </ul>
        </div>
    </div>
    
    <div class="container product-detail">
        <div class="row">
            <aside class="col-md-3 col-sm-4 col-xs-12 content-aside left_column sidebar-offcanvas sticky-content">
             
                <span id="close-sidebar" class="fa fa-times"></span>
                <div class="module so_filter_wrap filter-horizontal">
                    
                    <div class="modcontent">
                        <ul>
                        <li class="row">
                            <div class="col-xs-4">
                            <img width="80" style="padding: 10px;" height="80" src="{{asset('upload/images/brand/thumb/'. $brand->logo)}}">
                            </div>
                            <div class="col-xs-8">
                            <p style="font-size: 20px;font-weight: bold;margin:10px 0 0">{{$brand->name}}</p>
                            <span>{{$products->total()}} products found. </span></div>

                        </li>
                        <li class="so-filter-options" data-option="Search">
                            <div class="so-filter-content-opts" style="padding: 10px;">
                                <div class="so-filter-content-opts-container">
                                    <div class="so-filter-option" data-type="search">
                                        <div class="so-option-container">
                                            <div class="input-group">
                                                <input type="text" placeholder="Search" class="form-control" name="text_search" id="brandKey" value="{!! Request::get('q') !!}">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default common_selector"  type="button" id="submit_text_search"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                      
                        <li class="so-filter-options" data-option="Brand">
                            <div class="so-filter-heading">
                              <div class="so-filter-heading-text">
                                <span>Avg. Ratting</span>
                              </div>
                              
                            </div>
                            <div class="so-filter-content-opts" style="display: block;padding-left: 20px;">
                                <ul class="ratting">
                                    @for($r=5; $r>=1; $r--)
                                    <li>
                                        <input style="display: none;" @if(Request::get('ratting') == $r) checked @endif class="common_selector ratting" type="radio" name="ratting" id="ratting{{$r}}" value="{{$r}}">
                                        <label for="ratting{{$r}}">
                                        <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
                                       
                                        <span class="fa fa-stack"><i class="fa fa-star{{($r<=1) ? '-o' : '' }} fa-stack-2x"></i></span>
                                        <span class="fa fa-stack"><i class="fa fa-star{{($r<=2) ? '-o' : '' }} fa-stack-2x"></i></span>
                                        <span class="fa fa-stack"><i class="fa fa-star{{($r<=3) ? '-o' : '' }} fa-stack-2x"></i></span>
                                        <span class="fa fa-stack"><i class="fa fa-star{{($r<=4) ? '-o' : '' }} fa-stack-2x"></i></span>

                                        </label>
                                    </li>
                                    @endfor
                                </ul>
                            </div>
                        </li>

                        <li class="so-filter-options" data-option="Brand">
                            <div class="so-filter-heading">
                              <div class="so-filter-heading-text">
                                <span>Price</span>
                              </div>
                             
                            </div>
                            <div class="so-filter-content-opts" style="display: block;padding-left: 10px;">
                              <ul>
                               
                                <li>
                                    <input  type="hidden" id="price-range"  class="price-range-slider tertiary" value="@if(Request::get('price')) {{Request::get('price')}} @else 10000 @endif" form="shop_search_form"><br/>
                                    <button id="+'&price='+price" class="btn btn-info btn-sm common_selector">Update your Search</button>
                                </li>
                                
                                </ul>

                                <div class="clear_filter" style="text-align: right;padding: 5px">
                                    <button type="reset" id="resetAll" class="btn btn-default inverse">
                                         Reset All
                                    </button>
                                </div>
                            </div>
                        </li>
                    </ul>
                       
                    </div>
                </div>
            </aside>
            <div id="content" class="col-md-9 col-sm-12 col-xs-12 sticky-content" >
                <div class="clear_filter" style="padding: 5px">
                    <!-- <div class="module banners-effect-9 form-group">
                        <div class="banners">
                            <div>
                              <a href="#"><img src="{{asset('upload/images/brand/')}}"></a>
                            </div>
                        </div>
                    </div> -->
                    <div id="dataLoading"></div>
                    <a href="javascript:void(0)" class="open-sidebar hidden-lg hidden-md"><i class="fa fa-bars"></i>Filter By</a>
                    <div id="filter_product" class="products-category">
                        @include('frontend.products.filter_products')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('frontend')}}/js/themejs/noui.js"></script>

    <script src="{{ asset('frontend/js/jquery.range.min.js') }}"></script>

    <script type="text/javascript">
        (function($) {
            /*-----------
                RANGE
            -----------*/
            $('.price-range-slider').jRange({
                from: 0,
                to: 10000,
                step: 1,
                format: '$%s',
                width: 220,
                showLabels: true,
                showScale: false,
                isRange : true,
                theme: "theme-edragon"
            });
        })(jQuery);
        


        function filter_data(page)
        {
            //enable loader
            document.getElementById('dataLoading').style.display ='block';
            
        
            var concatUrl = '';

            
            var searchKey = $("#brandKey").val();
            if(searchKey != '' ){
                concatUrl += 'q='+searchKey;
            }
           

            var ratting = get_filter('ratting');
            if(ratting != '' ){
                concatUrl += '&ratting='+ratting;
            }

        
            var price = document.getElementById('price-range').value;
            if(price != '' ){
                concatUrl += '&price='+price;
            }

            var perPage = null;
            var showItem = $("#perPage :selected").val();
            if(typeof showItem != 'undefined' || showItem != null){
               perPage = showItem;
               //check weather page null or set 
                if(page == null){
                    //var active = $('.active .page-link').html();
                    var page = 1;
                }
            }

            var sortby = $("#sortby :selected").val();
            if(typeof sortby != 'undefined' && sortby != ''){
                concatUrl += '&sortby='+sortby;
                //check weather page null or set 
                if(page == null){
                    //var active = $('.active .page-link').html();
                    var page = 1;
                }
            }

            if(page != null){concatUrl += '&page='+page;}
         
            var  link = '{{ route("brandProducts", $brand->slug)}}?'+concatUrl;

            history.pushState('brand', '{{$brand->slug}}', link);

            $.ajax({
                url:link,
                method:"get",
                data:{
                    filter:'filter',perPage:showItem
                },
                success:function(data){
                    document.getElementById('dataLoading').style.display ='none';
            
                    if(data){
                        $('#filter_product').html(data);
                   }else{
                        $('#filter_product').html('Not Found');
                   }
                },
                error: function() {
                    document.getElementById('dataLoading').style.display ='none';
                    $('#filter_product').html('<span class="ajaxError">Internal server error.!</span>');
                }

            });
        }

        function get_filter(class_name)
        {

            var filter = [];
            $('.'+class_name+':checked').each(function(){
                filter.push($(this).val());
            });
           
            return filter;
        }

        $('.common_selector').click(function(){
            filter_data();
        });

        function sortproduct(){
            filter_data();
        }
        function showPerPage(){
            filter_data();
        }

        function searchItem(value){
            if(value != ''){ filter_data(); }
        }

        $(document).on('click', '.pagination a', function(e){
            e.preventDefault();

            var page = $(this).attr('href').split('page=')[1];

            filter_data(page);
        });

        $('#resetAll').click(function(){
            $('input:checkbox').removeAttr('checked');
            $('input[type=checkbox]').prop('checked', false);
            $("#brandKey").val('');
            $("#price-range").val('0,10000');
            $('input:radio').removeAttr('checked');
            //call function
            filter_data();
        });
    </script>
@endsection