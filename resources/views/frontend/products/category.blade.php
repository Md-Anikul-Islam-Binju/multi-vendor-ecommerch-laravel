@extends('layouts.frontend')
@section('title', $category->name . ' | '. Config::get('siteSetting.site_name') )
@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.range.css') }}">
    <style type="text/css">
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
                @if(Request::route('catslug'))
                <li><a href="{{route('home.category', Request::route('catslug') )}}">{{ Request::route('catslug') }}</a></li>
                @endif
                @if(Request::route('subslug'))
                <li><a href="{{route('home.category', [Request::route('catslug'), Request::route('subslug')] )}}">{{ Request::route('subslug')}}</a></li>
                @endif
                @if(Request::route('childslug'))
                <li>{{Request::route('childslug')}}</li>
                @endif
            </ul>
        </div>
    </div>
    
    <div class="container product-detail">
        <div class="row">
            <aside class="col-md-3 col-sm-4 col-xs-12 content-aside left_column sidebar-offcanvas sticky-content">
                <span id="close-sidebar" class="fa fa-times"></span>
                <div class="module so_filter_wrap filter-horizontal">
                    <h3 class="modtitle"><span>Filter By</span> 
                        <a data-toggle="tooltip"  data-original-title="Clear all filter" title="" style="float: right;text-transform: none;padding: 0px 5px; font-size: 12px;color: red" id="resetAll">
                            Clear All <i class="fa fa-times"></i>
                        </a>
                    </h3>
                    <div class="modcontent">
                        <ul>
                            <li class="so-filter-options" data-option="Size">
                                <div class="so-filter-heading">
                                    <div class="so-filter-heading-text">
                                        <span>Related Categories</span>
                                    </div>
                                    <i class="fa fa-chevron-down"></i>
                                </div>
                                <div class="so-filter-content-opts" style="display: block;">
                                    <div class="mod-content box-category">
                                        <ul class="accordion" id="accordion-category">
                                            <li class="panel">
                                                @if($category)<a href="#">{{$category->name}}</a>@endif
                                                <div style="clear:both">
                                                    <ul>
                                                      @foreach($filterCategories as $filterCategory )
                                                        <?php 
                                                        $parent_category = $subcategory = $childcategory = '';
                                                        if(Request::route('catslug')){
                                                            $parent_category = Request::route('catslug');
                                                            $subcategory = $filterCategory->slug;
                                                        }
                                                        if(Request::route('subslug')){
                                                            $parent_category = Request::route('catslug');
                                                            $subcategory = Request::route('subslug');
                                                            $childcategory = $filterCategory->slug;
                                                        }
                                                          ?>
                                                         <li>
                                                            <a href="{{route('home.category', [$parent_category, $subcategory, $childcategory])}}"> {{$filterCategory->name}}</a>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            @if(count($brands)>0)
                            <li class="so-filter-options" data-option="Brand">
                                <div class="so-filter-heading">
                                    <div class="so-filter-heading-text">
                                        <span>Brand</span>
                                    </div>
                                    <i class="fa fa-chevron-down"></i>
                                </div>
                                <div class="so-filter-content-opts" style="display: block;padding-left: 10px;">
                                  <ul>
                                    @foreach($brands as $brand)
                                    <li>
                                        <input @if(in_array($brand->id , explode(',', Request::get('brand')))) checked @endif class="common_selector brand" value="{{$brand->id}}" id="brand{{$brand->id}}" type="checkbox" />
                                        <label style="margin: 0px;" for="brand{{$brand->id}}" >{{ $brand->name }}</label> 
                                    </li>
                                    @endforeach
                                    </ul>
                                </div>
                            </li>
                            @endif

                            <li class="so-filter-options" data-option="Ratting">
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

                            @foreach($product_variations as $product_variation)
                            <!-- check weather value set or not -->
                            @if(count($product_variation->allVariationValues)>0)
                            <li class="so-filter-options" data-option="{{$product_variation->attribute_name}}">
                                <div class="so-filter-heading">
                                  <div class="so-filter-heading-text">
                                    <span>{{$product_variation->attribute_name}}</span>
                                  </div>
                                  <i class="fa fa-chevron-down"></i>
                                </div>
                                <div class="so-filter-content-opts" style="display: block;padding-left: 20px;">
                                  <ul>
                                    @foreach($product_variation->allVariationValues as $variationValue)
                                    <li>
                                        <input @if(in_array(strtolower($variationValue->attributeValue_name) , explode(',', Request::get(strtolower($product_variation->attribute_name)))) ) checked @endif value="{{strtolower($variationValue->attributeValue_name)}}" class=" {{str_replace(' ', '', $product_variation->attribute_name)}} common_selector" id="attr{{$variationValue->id}}" type="checkbox" />
                                        <label style="margin: 0px;" for="attr{{$variationValue->id}}" >{{ $variationValue->attributeValue_name }}</label>
                                    </li>
                                    @endforeach
                                    </ul>
                                </div>
                            </li>
                            @endif
                            @endforeach
                            <li class="so-filter-options" data-option="Price">
                                <div class="so-filter-heading">
                                  <div class="so-filter-heading-text">
                                    <span>Price</span>
                                  </div>
                                </div>
                                <div class="so-filter-content-opts" style="display: block;padding-left: 10px;">
                                  <ul>
                                    <li>
                                        <input  type="hidden" id="price-range"  class="price-range-slider tertiary" value="@if(Request::get('price')) {{Request::get('price')}} @else 999999 @endif" form="shop_search_form"><br/>
                                        <button id="+'&price='+price" class="btn btn-info btn-sm common_selector">Update your Search</button>
                                    </li>
                                    
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        <div class="clear_filter" style="text-align: right;padding: 5px">
                            <button type="reset" id="resetAll" class="btn btn-danger inverse">
                                 Reset All
                            </button>
                        </div>
                    </div>
                </div>
            </aside>
            <div id="content" class="col-md-9 col-sm-12 col-xs-12 sticky-content" >
                <div id="dataLoading"></div>

                <a href="javascript:void(0)" class="open-sidebar hidden-lg hidden-md"><i class="fa fa-bars"></i>Filter By</a>
                @if($banners)
                   @include('frontend.sliders.slider2')
                @endif
                <div id="filter_product" class="products-category">   
                    @include('frontend.products.filter_products')
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
            to: 999999,
            step: 1,
            format: '{{Config::get('siteSetting.currency_symble')}}%s',
            width: 250,
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
        
        var category = "{!! str_replace(' ', '', Request::route('catslug')) !!}" ;
        var subcategory = "{!! (Request::route('subslug')) ? '/'. str_replace(' ', '', Request::route('subslug')) : '' !!}";
        var childcategory = "{!! (Request::route('childslug')) ? '/'. str_replace(' ', '', Request::route('childslug')) : '' !!}";

        var concatUrl = '?';
        
        var searchKey = $("#searchKey").val();
        if(searchKey != '' ){
            concatUrl += 'q='+searchKey;
        }
        @foreach($product_variations as $product_variation)
            var filterValue = get_filter('{{str_replace(' ', '', $product_variation->attribute_name)}}');
            if(filterValue != ''){
                concatUrl += '&{{strtolower(str_replace(' ', '', $product_variation->attribute_name))}}='+filterValue;
            }
            
        @endforeach
       
        var brand = get_filter('brand');
        if(brand != '' ){
            concatUrl += '&brand='+brand;
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
     
        var  link = '<?php echo URL::to("category");?>/'+category+subcategory+childcategory+concatUrl;
            history.pushState({id: 'category'}, category +' '+subcategory, link);

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
        $("#searchKey").val('');
        $('input:radio').removeAttr('checked');
         $("#price-range").val('0,999999');
        //call function
        filter_data();
    });
</script>
@endsection