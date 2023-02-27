@extends('layouts.frontend')
@section('title', 'Shopping Mall | '. Config::get('siteSetting.site_name') )
@section('css')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
   
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
      .so-filter-content-opts .form-group{margin-bottom: 0;}
  </style>
@endsection
@section('content')
    <!-- Main Container  -->
    <div class="breadcrumbs">
        <div class="container">
            <ul class="breadcrumb-cate">
                <li><a href="{{url('/')}}"><i class="fa fa-home"></i> </a></li>
               
                <li><a href="#">Shopping Mall</a></li>
                
            </ul>
        </div>
    </div>
    
    <div class="container product-detail">
        
         @include('frontend.sliders.slider2') 
         <br/>
        <div class="row">
            <aside class="col-md-3 col-sm-4 col-xs-12 content-aside left_column sidebar-offcanvas sticky-content">
                <span id="close-sidebar" class="fa fa-times"></span>
                <div class="module so_filter_wrap filter-horizontal">
                    <h3 class="modtitle"><span>Filter By</span> 
                        <a data-toggle="tooltip" class="resetAll" data-original-title="Clear all filter" title="" style="float: right;text-transform: none;padding: 0px 5px; font-size: 12px;color: red" >
                            Clear All <i class="fa fa-times"></i>
                        </a>
                    </h3>
                    <div class="modcontent">
                        <ul>
                            <li class="so-filter-options">
                                <div class="so-filter-heading">
                                    <div class="so-filter-heading-text">
                                        <span>Shop Zone</span>
                                    </div>
                                    <i class="fa fa-chevron-down"></i>
                                </div>
                                <div class="so-filter-content-opts" style="display: block;padding: 10px 10px;max-height:initial; ">
                                  <ul>
                                    <li>
                                    <div class="form-group">
                                        <label>Division</label>
                                        <select name="state" required onchange="get_city(this.value)"  id="state" data-parsley-required-message = "Rejion name is required" class="select2 form-control">
                                            <option value=""> --- Please Select --- </option>
                                            @foreach($states as $state)
                                            <option @if(Request::get('state') == $state->id) selected @endif value="{{$state->id}}"> {{$state->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    </li>
                                    <li>
                                      <div class="form-group">
                                        <label>City</label>
                                        <select name="city" required data-parsley-required-message = "City name is required" onchange="get_area(this.value)"  id="city" class="form-control select2">
                                            <option value=""> Select first zilla </option>
                                            
                                        </select>
                                    </div>
                                    </li>
                                    <li>
                                      <div class="form-group">
                                        <label>Area</label>
                                        <select name="area" required data-parsley-required-message = "Area name is required" id="area" onchange="filter_data()"  class="form-control select2">
                                            <option value=""> Select first city </option>
                                        </select>
                                    </div>
                                    </li>
                                   
                                    </ul>
                                </div>
                            </li>
                            
                            <li class="so-filter-options" >
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

                                
                        </ul>
                        <div class="clear_filter" style="text-align: right;padding: 5px">
                            <button type="reset" class="btn btn-danger inverse resetAll">
                                 Reset All
                            </button>
                        </div>
                    </div>
                </div>
            </aside>
            <div  class="col-md-9 col-sm-12 col-xs-12 sticky-content" >
                <a href="javascript:void(0)" class="open-sidebar hidden-lg hidden-md"><i class="fa fa-bars"></i>Filter By</a>
               
                <div id="filter_shop" class="products-category">   
                    @include('frontend.shop.filter_shop')
                </div>
            </div>
        </div>
    </div>
    
@endsection
@section('js')
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      
      $(".select2").select2();

    </script>
    <script type="text/javascript">

        function get_city(id){
            filter_data();
            var  url = '{{route("get_city", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#city").html(data);
                        $(".select2").select2();
                        $("#city").focus();
                    }else{
                        $("#city").html('<option>City not found</option>');
                    }
                }
            });
        }    

        function get_area(id){
            filter_data();
            var  url = '{{route("get_area", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#area").html(data);
                        $(".select2").select2();
                        $("#area").focus();
                       
                    }else{
                      $("#area").html('<option>Area not found</option>');
                  }
              }
          });
        }  

    function filter_data(page)
    {
        //enable loader
        document.getElementById('dataLoading').style.display ='block';
       
        var concatUrl = '?';

        var searchKey = $("#shopKey").val();
        if(searchKey != '' ){
            concatUrl += 'src='+searchKey;
        }
   
        var state = $("#state").find(':selected').val();
        if(typeof state != 'undefined' && state != ''){
           concatUrl += '&state='+state;
        }
        var city = $("#city").find(':selected').val();
        if(typeof city != 'undefined' && city != ''){
           concatUrl += '&city='+city;
        }

        var area = $("#area").find(':selected').val();
        if(typeof area != 'undefined' && area != ''){
           concatUrl += '&area='+area;
        }
        

        var ratting = get_filter('ratting');
        if(ratting != '' ){
            concatUrl += '&ratting='+ratting;
        }

        
        //check weather page null or set 
        if(page == null){
            //var active = $('.active .page-link').html();
            var page = 1;
        }
        

        if(page != null){concatUrl += '&page='+page;}
     
        var  link = '{{ route("shop") }}/'+concatUrl;
        history.pushState('shop', 'shop', link);

        $.ajax({
            url:link,
            method:"get",
            data:{
                filter:'filter'
            },
            success:function(data){
                document.getElementById('dataLoading').style.display ='none';
        
                if(data){
                    $('#filter_shop').html(data);
               }else{
                    $('#filter_shop').html('Not Found');
               }
            },
            error: function() {
                document.getElementById('dataLoading').style.display ='none';
                $('#filter_shop').html('<span class="ajaxError">Internal server error.!</span>');
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


    $(document).on('click', '.pagination a', function(e){
        e.preventDefault();

        var page = $(this).attr('href').split('page=')[1];

        filter_data(page);
    });

    $('.resetAll').click(function(){
       
        $("#shopKey").val('');
         $('input:radio').removeAttr('checked');
        $("#state option:selected").prop("selected", false);
        $("#city option:selected").prop("selected", false);
        $("#area option:selected").prop("selected", false);
        //call function
        filter_data();
    });


    </script>

@endsection
