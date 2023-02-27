<?php
if(Auth::check()){
  $user_id = Auth::id();
}else{
  $user_id = (Cookie::has('user_id') ? Cookie::get('user_id') :  Session::get('user_id'));
}
$getCart = App\Models\Cart::where('user_id', $user_id)->count();
?>
<!-- Header Top -->
<header id="header" class="typeheader-6">
  <!-- mobile menu  -->
  <nav class="bottom-nav hidden-lg hidden-md">
    <a href="/" class="bottom-nav-item">
      <div class="bottom-nav-link" >
        <i class="fa fa-home"></i>
        <span>Home</span>
      </div>
    </a>
    <a href="{{route('offers')}}" class="bottom-nav-item">
      <div class="bottom-nav-link" >
        <i class="fa fa-bullhorn"></i>
        <span>Wishlist</span>
      </div>
    </a>
    <a href="{{route('cart')}}" class="bottom-nav-item">
      <div  class="bottom-nav-link ">
        <i class="cartCount" style="z-index: 1;top: -5px;right: 5px;min-width: 18px;height: 18px;line-height: 12px;font-size: 11px;padding: 3px;background: #ff6e26;border-radius: 12px;position: absolute;color: #fff;">{{$getCart}}</i>
        <i class="fa fa-cart-plus"></i>
        <span>Cart</span>
      </div>
    </a>
    <a href="{{route('wishlists')}}" class="bottom-nav-item">
       <div class="bottom-nav-link">
        <i class="fa fa-heart"></i>
        <span>Wishlist</span>
      </div>
    </a>
    @if(Auth::check())
    <div class="bottom-nav-item open-sidebar">
      <div class="bottom-nav-link">
        <i class="fa fa-user-circle"></i>
        <span>Dashboard</span>
      </div>
    </div>
    @else
    <div class="bottom-nav-item">
      <a class="bottom-nav-link" href="{{route('login')}}">
        <i class="fa fa-user-circle"></i>
        <span>Account</span>
      </a>
    </div>
    @endif
  </nav>
  <div class="header-top hidden-sm hidden-xs hidden-compact" style="background: {{config('siteSetting.header_bg_color')}}; color: {{ config('siteSetting.header_text_color')}}; /*border-bottom: 1px solid #f2f2f2;*/">
      <div class="container">
          <div class="row">
              <div class="header-top-left col-lg-6  col-sm-12 col-md-7 hidden-xs">
                  <div class="list-contact hidden-sm hidden-xs">
                      <ul class="top-link list-inline">
                        @foreach($menus->where('top_header', 1) as $menu)
                        <li class="account"><a style="color: {{ config('siteSetting.header_text_color')}}" href="{{  route('page', $menu->get_pages->slug)}}">{{$menu->name}}</a></li>
                        @endforeach
                      </ul>
                  </div>
              </div>
              <div class="header-top-right hidden-sm hidden-xs collapsed-block col-lg-6 col-sm-12 col-md-5 col-xs-12 ">
                  <div class="tabBlock" id="TabBlock-1">
                      <ul class="top-link list-inline">
                        
                        @if(Auth::guard('reseller')->check()) 
                        <li class="account "> <a href="{{ route('reseller.dashboard') }}">Reseller Dashboard </a> </li>
                        @endif

                          @if(Auth::guard('admin')->check()) 
                          <li class="account "> <a href="{{route('admin.dashboard')}}">Admin Dashboard </a> </li>
                          @endif
                          @if(Auth::check()) 
                          <li id="my_account">
                              <a href="#" title="My Account" class="btn-xs dropdown-toggle" data-toggle="dropdown"><img width="25" height ="25" style="border-radius:50%;border: 1px solid yellow;" src="{{ asset('upload/users') }}/{{(Auth::user()->photo) ? Auth::user()->photo : 'default.png'}}"> <span>Hello, {{Auth::user()->name}}</span> <span class="fa fa-angle-down"></span></a>
                              <ul class="dropdown-menu">
                                  <li><a href="{{route('user.dashboard')}}">Dashboard</a></li>
                                  <li><a href="{{route('user.orderHistory')}}">Order History</a></li>
                                  <li><a href="{{route('customer.walletHistory')}}"> My Wallet </a></li>
                                  <li><a href="{{route('user.change-password')}}"> Change Password </a></li>
                                  <li> <a href="{{route('userLogout')}}">Logout </a> </li>
                              </ul>
                          </li>
                          @else

                            @if(Auth::guard('reseller')->check()) 
                              <li class="account "> <a href="{{ route('reseller.logout') }}">Logout </a> </li>                              

                              @else
                              <li class="account "> <a data-toggle="modal" data-target="#so_sociallogin">Login </a> </li>
                              <li class="account "> <a href="{{route('register')}}">Register </a>  </li>
                            @endif
                        
                          @endif
                          @if(Auth::guard('reseller')->check()) 
                            &middot;
                          @else
<!--                          <li class="account"><a style="color: {{ config('siteSetting.header_text_color')}};border:1px solid {{ config('siteSetting.header_text_color')}}; padding: 0px 5px;border-radius: 5px;" href="{{route('vendorLogin')}}">Be a Seller</a></li>-->
                          <li class="account"><a style="color: {{ config('siteSetting.header_text_color')}};border:1px solid {{ config('siteSetting.header_text_color')}}; padding: 0px 5px;border-radius: 5px;" href="{{route('resellerLoginForm')}}">Be a Reseller</a></li>
                          <li >
                              <a style="background-color: red"  href="https://aurorabangladesh.com/">Shop Now</a>
                          </li>
                          @endif
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- //Header Top -->
  <!-- Header center -->
  <div class="header-center" style="background: #000">
      <div class="container">
          <div class="row">
              <div class="navbar-logo col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding: 0;">
                <button type="button" style="float: left;margin-left: 0" id="show-verticalmenu" data-toggle="collapse" class="navbar-toggle">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button> 
                <a href="{{url('/')}}"><img width="200" height="50" src="{{asset('upload/images/logo/'.Config::get('siteSetting.logo'))}}" title="Home" alt="Logo"></a>
               <button type="button" style="float: right;margin-left: 0" id="show-megamenu" data-toggle="collapse" class="navbar-toggle">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>               
              </div>
              <div class="header-center-right col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <div class="header_search">
                      <div id="sosearchpro" class="sosearchpro-wrapper so-search ">
                          <form method="GET" style="border: 2px solid #ff4747;border-radius: 4px;" action="{{ route('product.search') }}">
                              <div id="search0" class="search input-group form-group">
                                  <div title="Select Category" class="select_category filter_type  icon-select">
                                      <select class="no-border" name="cat">
                                          <option value="">All categories</option>
                                          @foreach($categories as $srccategory)
                                          <option @if(Request::get('cat') == $srccategory->slug) selected @endif value="{{$srccategory->slug}}">{{$srccategory->name}}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <input title="Write search keyword" class="form-control" type="text" style="height:42px;border: none;float: initial;" name="q" value="@if(Request::get('q')) {!! preg_replace('/"/',' ',Request::get('q') ) !!} @endif" id="searchKey" required placeholder="Search">
                                  <span class="input-group-btn">
                                  <button title="search product" type="submit" class="button-search btn btn-default btn-lg" ><span style="color:#fff" class="fa fa-search"></span></button>
                                  </span>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
              <div class="header-cart-phone col-lg-3 col-md-6 col-xs-3 hidden-xs hidden-sm">
                  <div class="bt-head header-cart" style="float:right;">
                      <div class="shopping_cart" onclick="getCart()">
                      <div id="cart" class="btn-shopping-cart">
                          <a data-loading-text="Loading... " class="btn-group top_cart dropdown-toggle" data-toggle="dropdown">
                            <div class="shopcart">
                              <span class="handle pull-left"></span>
                              <div class="cart-info" >
                                <h2 class="title-cart">Shopping cart</h2>
                                <h2 class="title-cart2 hidden">My Cart</h2>
                                <span class="total-shopping-cart cart-total-full">
                                <span class="items_cart cartCount">{{ $getCart }} </span> <span class="items_cart2"> item(s)</span>
                                </span>
                              </div>
                            </div>
                          </a>
                          <ul id="getCartHead" class="dropdown-menu pull-right shoppingcart-box">
                              <div class="loadingData-sm"></div>
                          </ul>
                        </div>
                      </div>
                   </div>
                  <div class="header_custom_link hidden-xs">
                      <ul>
                          <li class="compare"><a href="{{route('productCompare')}}" class="top-link-compare" title="Compare product"></a></li>
                          <li class="wishlist"><a href="{{route('wishlists')}}" class="top-link-wishlist" title="Wish List  "></a></li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- //Header center -->
  <!-- Heaader bottom -->
  <div class="header-bottom hidden-compact" style="border-bottom: 1px solid red">
      <div class="container">
          <div class="header-bottom-inner">
              <div class="row">
                  <div class="header-bottom-left menu-vertical col-md-3 col-sm-6 col-xs-7">
                      <div class="megamenu-style-dev megamenu-dev">
                          <div class="responsive">
                              <div class="so-vertical-menu no-gutter">
                                  <nav class="navbar-default">
                                      <div class=" container-megamenu  container   vertical  " style="background:transparent;">
                                        <a href="{{route('home.category')}}">
                                        <div id="menuHeading">
                                          <div class="megamenuToogle-wrapper">
                                            <div class="megamenuToogle-pattern">
                                              <div class="container">
                                                <span class="title-mega">
                                                <i class="fa fa-bars"></i> All Categories
                                                </span>
                                              </div>
                                            </div>
                                          </div>
                                        </div></a>
                                        <div class="vertical-wrapper">
                                          <span id="remove-verticalmenu" class="fa fa-times"></span>
                                          <div class="megamenu-pattern">
                                            <div class="container">
                                              <ul class="megamenu" data-transition="slide" data-animationtime="300">
                                              @foreach($categories as $category)
                                                @if(count($category->get_subcategory)>0)
                                                  <li class="item-vertical  css-menu with-sub-menu hover">
                                                    <p class="close-menu"></p>
                                                    <a href="{{ route('home.category', $category->slug) }}" class="clearfix">
                                                    <span>
                                                    <strong>
                                                      <!-- <img width="20" src="{{asset('upload/images/category/thumb/'.$category->image)}}" alt="{{$category->name}}"> -->
                                                      {{$category->name}}</strong>
                                                    </span>
                                                    <b class="fa fa-caret-right"></b>
                                                    </a>
                                                    <div class="sub-menu" style="width: 250px;">
                                                      <div class="content">
                                                        <div class="row">
                                                          <div class="col-sm-12">
                                                            <div class="categories ">
                                                              <div class="row">
                                                                <div class="col-sm-12 hover-menu">
                                                                  <div class="menu">
                                                                    <ul>
                                                                      @foreach($category->get_subcategory as $subcategory)
                                                                      <li>
                                                                        <a href="{{ route('home.category', [$category->slug, $subcategory->slug]) }}" class="main-menu">{{$subcategory->name}}
                                                                          @if(count($subcategory->get_subcategory)>0)
                                                                          <b class="fa fa-angle-right"></b>
                                                                          @endif
                                                                        </a>
                                                                        @if(count($subcategory->get_subcategory)>0)
                                                                        <ul>
                                                                          @foreach($subcategory->get_subcategory as $childcategory)
                                                                          <li><a href="{{ route('home.category',[ $category->slug, $subcategory->slug, $childcategory->slug]) }}" > {{$childcategory->name}}</a></li>
                                                                          @endforeach
                                                                        </ul>
                                                                        @endif
                                                                      </li>
                                                                      @endforeach
                                                                    </ul>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </li>
                                                @else
                                                  <li class="item-vertical">
                                                    <p class="close-menu"></p>
                                                    <a href="{{ route('home.category', $category->slug) }}" class="clearfix">
                                                    <span>
                                                    <strong>
                                                      <!-- <img width="20" alt="{{$category->name}}" src="{{asset('upload/images/category/thumb/'.$category->image)}}"> -->
                                                       {{$category->name}}</strong>
                                                    </span>
                                                    </a>
                                                  </li>
                                                @endif
                                                @endforeach
                                              </ul>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                  </nav>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- Menuhome -->
                  <div class="header-bottom-right col-md-9 col-sm-6 col-xs-5">
                      <div class="header-menu" style="padding-left: 50px;">
                          <div class="megamenu-style-dev megamenu-dev">
                              <div class="responsive">
                                  <nav class="navbar-default">
                                      <div class="container-megamenu horizontal">
                                          <div class="megamenu-wrapper">
                                            <span class="hidden-lg hidden-md ">
                                              @if(Auth::check())
                                              <a href="{{route('user.dashboard')}}"><img width="25" height ="25" style="border-radius:50%;border: 1px solid yellow;" src="{{ asset('upload/users') }}/{{(Auth::user()->photo) ? Auth::user()->photo : 'default.png'}}"> <span> Hello, {{Auth::user()->name}} </a> 
                                              @else
                                             <a href="{{route('login')}}"><i class="fa fa-user-circle"></i> Hello, Login </a>
                                              @endif
                                            </span>
                                            <span id="remove-megamenu" style="float: right;" class="fa fa-times"></span>
                                            <div class="megamenu-pattern">
                                              <div class="container">
                                                <ul class="megamenu" data-transition="slide" data-animationtime="500">
                                                  <li class="hidden-lg hidden-md"><a href="{{route('vendorLogin')}}">Be a Seller</a></li>
                                                  @foreach($menus->where('top_header', 1) as $menu)
                                                  <li class="hidden-lg hidden-md"><a  href="{{  route('page', $menu->get_pages->slug)}}">{{$menu->get_pages->title}}</a></li>
                                                  @endforeach
                                                  @if(count($menus)>0)
                                                    @foreach($menus->where('main_header', 1) as $menu)
                                                      @if($menu->menu_source == 'category')
                                                      <li class="item-style2 content-full feafute with-sub-menu hover">
                                                        <p class="close-menu"></p>
                                                          <a class="clearfix">
                                                          <strong>
                                                          {{$menu->name}}
                                                          </strong>
                                                          @if(count($menu->get_categories)>0)
                                                            <b class="caret"></b>
                                                            </a>
                                                            <div class="sub-menu" style="width: 100%">
                                                              <div class="content">
                                                                <div class="categories ">
                                                                  <div class="row">
                                                                    @foreach($menu->get_categories as $category)
                                                                    <div class="col-sm-3 static-menu">
                                                                      <div class="menu">
                                                                        <ul>
                                                                          <li>
                                                                            <a href="{{route('home.category', [$category->get_singleSubcategory->slug, $category->slug])}}" class="main-menu">{{$category->name}}</a>
                                                                            @if(count($category->get_subchild_category)>0)
                                                                            <ul>
                                                                              @foreach($category->get_subchild_category as $childcategory)
                                                                              <li><a href="{{route('home.category', [$category->get_singleSubcategory->slug, $childcategory->get_singleChildCategory->slug, $childcategory->slug])}}">{{$childcategory->name}}</a></li>
                                                                              @endforeach
                                                                            </ul>
                                                                            @endif
                                                                          </li>
                                                                        </ul>
                                                                      </div>
                                                                    </div>
                                                                   @endforeach
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          @else
                                                          </a>
                                                          @endif
                                                      </li>
                                                      @elseif($menu->menu_source == 'page')
                                                      <li class="style-page with-sub-menu hover">
                                                        <p class="close-menu"></p>
                                                        @php
                                                          $source_id = explode(',', $menu->source_id);
                                                          $get_pages =  \App\Models\Page::whereIn('id', $source_id)->get();
                                                        @endphp
                                                        @if(count($get_pages)>0)
                                                          @if(count($get_pages)>1)
                                                            <a class="clearfix" ><strong>{{$menu->name}} </strong>
                                                            <b class="caret"></b> </a>
                                                            <div class="sub-menu" style="width: 40%;">
                                                              <div class="content" >
                                                                <div class="row">
                                                                  <div class="col-md-6">
                                                                    <ul class="row-list">
                                                                      @foreach($get_pages as $page)
                                                                      <li><a class="subcategory_item"  href="{{  route('page', $page->slug)}}">{{$page->title}}</a></li>
                                                                      @endforeach
                                                                    </ul>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          @else
                                                           <a href="{{  route('page', $get_pages[0]->slug)}}" style="background: #bc{{ rand(10,99) }}04;border-radius: 15px 1px 15px 1px; color: white" class="clearfix">
                                                            <strong> {{$menu->name}} </strong>
                                                            </a>
                                                          @endif
                                                        @endif
                                                      </li>
                                                      @else @endif
                                                    @endforeach
                                                  @endif
                                                  @if(Auth::check())
                                                  <li class="hidden-lg hidden-md"><a href="{{route('userLogout')}}"><i class="fa fa-power-off"></i> Logout </a> </li>
                                                  @endif
                                                </ul>
                                              </div>
                                            </div>
                                          </div>
                                      </div>
                                  </nav>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</header>
