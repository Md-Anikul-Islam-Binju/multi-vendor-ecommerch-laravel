@extends('layouts.frontend')
@section('title', $seller->shop_name.' | '. Config::get('siteSetting.site_name') )
@section('metatag')
  <meta name="title" content="{{$seller->shop_name}}">
    <meta name="description" content="{!! strip_tags($seller->shop_dsc) !!}">
    <meta name="image" content="{{ ($seller->banner) ? asset('upload/vendors/banner/'.$seller->banner) : asset('upload/vendors/logo/'.$seller->logo) }}">
   
    <!-- Schema.org for Google -->
    <meta itemprop="name" content="{{$seller->shop_name}}">
    <meta itemprop="description" content="{!! strip_tags($seller->shop_dsc) !!}">
    <meta itemprop="image" content="{{ ($seller->banner) ? asset('upload/vendors/banner/'.$seller->banner) : asset('upload/vendors/logo/'.$seller->logo) }}">
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('frontend/css/jquery.range.css') }}">
  <style type="text/css">
      #wrapper{background: #fdfdfdc7;}
      .ratting label{font-size: 18px;}
      .slider-container{margin-top: 12px;}
      .pagination>li>a, .pagination>li>span{padding: 6px 10px;}

     .seller-thumb{position: relative;width: 100%;padding: 3px;height: 100px;
      background: #fff;text-align: center;}
      .desc-listcategoreis {
          color: #000;
          text-align: center;
          padding: 0px;
          background: #fff;
          overflow: hidden;
      }
      .seller-thumb img{height: 100%}


.profile-header {

  width: 100%;
  height: 230px;
  position: relative;
  background-position: center !important;
    background-size: cover!important;
  box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.2);
}

.profile-img img {
  border-radius: 50%;
  height: 230px;
  width: 230px;
  border: 5px solid #fff;
  box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
 
  left: 50px;
  top: 20px;
  z-index: 5;
  background: #fff;
}


.profile-nav-info h3 {
  font-variant: small-caps;
  font-size: 2rem;
  font-family: sans-serif;
  font-weight: bold;
}

.profile-nav-info .address {
  display: flex;
  font-weight: bold;
  color: #777;
}



.profile-option:hover {
  background: #fff;
  border: 1px solid #e40046;
}
.profile-option:hover .notification i {
  color: #e40046;
}

.profile-option:hover span {
  background: #e40046;
}


.profile-btn {
  display: flex;
}

button.chatbtn,
button.createbtn {
  border: 0;
  padding: 5px 10px;
  border-radius: 3px;
  background: #e40046;
  color: #fff;
  font-family: "Bree Serif";
  font-size: 1rem;
  margin: 5px 2px;
  cursor: pointer;
  outline: none;
  margin-bottom: 10px;
  transition: background 0.3s ease-in-out;
  box-shadow: 0px 5px 7px 0px rgba(0, 0, 0, 0.3);
}

button.chatbtn:hover,
button.createbtn:hover {
  background: rgba(288, 0, 70, 0.9);
}

button.chatbtn i,
button.createbtn i {
  margin-right: 5px;
}

.nav {
  width: 100%;
 position: relative;
}

.nav ul {
  display: flex;
  justify-content: space-around;
  list-style-type: none;
  height: 40px;
  background: #fff;
  margin-bottom: 20px;
  background: #ececec;
}

.nav ul li {

  cursor: pointer;
  text-align: left;
  transition: all 0.2s ease-in-out;
}
.nav ul li a{display: block;padding: 10px;white-space: nowrap;}

.nav ul li:hover,
.nav ul li.active {
  box-shadow: 0px -3px 0px rgba(288, 0, 70, 0.9) inset;
}
.user-rating {
    display: flex;
}
 @media (min-width: 920px) {
  .seller-details{
      min-width: 220px;
      max-width: 400px;
      position: relative;
    
      left: -50px;
      bottom: -10px;
      color: #000000;
      border-radius: 3px;
      background: #ffffff52;
      padding: 10px 25px;}

  }
  </style>
@endsection
@section('content')
    @php $avg_ratting = round($seller->reviews->avg('ratting'), 1); @endphp
    <div class="container" >
        <div class="profile-header" style="margin-top: 5px; background:#fff url({{asset('upload/vendors/banner/'.$seller->banner)}});">
              <div class="row">
                <div class="col-xs-12 col-md-3 ">
                  <div class="profile-img">
                  <img src="{{asset('upload/vendors/logo/'.($seller->logo ? $seller->logo : 'logo.png'))}}" width="200" alt="Logo"></div>
                </div>
                <div class="col-xs-12 col-md-7">
                  <div class="seller-details">
                     <h3 style="margin: 0">{{$seller->shop_name}}</h3>
                     <p style="line-height: 1">{{Str::limit($seller->shop_dsc, 250)}}</p>
                     <div class="user-rating">
                        <h3 class="rating"><span style="font-size: 30px">{{$avg_ratting}}</span>/5 </h3>
                        <div class="rate">
                          <div class="star-outer">
                            <div class="star-inner">
                             {{\App\Http\Controllers\HelperController::ratting($avg_ratting)}} 
                            </div>
                          </div>
                          <!-- <span class="no-of-user-rate"><span>{{count($seller->reviews)}}</span> Seller reviews</span> 
                           <p style="margin: 0;line-height: 1">{{count($seller->reviews)}}  Followers</p> -->
                          
                        </div>

                      </div>
                      
                    </div>
                  </div>
              </div>
        </div>
    </div>
        
    <div class="container">
      <div class="nav">
            <ul>
              <li class=""><a @if(!Request::is('shop_details')) href="{{route('shop_details', [$seller->slug])}}" @endif> Homepage</a></li>
              <li  class="active"><a href="{{route('seller_products', [$seller->slug])}}">All Products </a></li>
              <li class=""><!--  <a href="#">Reviews </a> --></li>
              <div class="input-group" style="margin-top: 3px;">
                  <input type="text" placeholder="Search" class="form-control" name="text_search" id="sellerKey" value="{!! Request::get('q') !!}">
                  <div class="input-group-btn">
                      <button class="btn btn-success common_selector"  type="button" id="submit_text_search"><i class="fa fa-search"></i></button>
                  </div>
              </div> 
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
                                                <div style="clear:both">
                                                    <ul>
                                                      @foreach($categories as $category )
                                                       
                                                         <li>
                                                            <a href="{{ route('seller_products',[$seller->slug,$category->slug])}}">{{$category->name}}</a>
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
            <div class="col-md-9 col-sm-12 col-xs-12 sticky-content">
                <div id="dataLoading"></div>
                 <a href="javascript:void(0)" class="open-sidebar hidden-lg hidden-md"><i class="fa fa-bars"></i>Filter By</a>
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
        var category = "{!! Request::route('catslug') !!}" ;

        var concatUrl = '?';

        var searchKey = $("#sellerKey").val();
        if(searchKey != '' ){
            concatUrl += 'q='+searchKey;
        }
   
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
     
        var  link = '{{ route("seller_products",$seller->slug) }}/'+category+concatUrl;
        history.pushState('shop', '{{$seller->slug}}', link);

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