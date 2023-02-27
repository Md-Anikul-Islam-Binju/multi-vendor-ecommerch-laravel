
<header id="header" class="typeheader-6">
  <!-- Header Top -->
  <div class="header-top hidden-compact">
      <div class="container">
          <div class="row">
                <div class="header-top-left  col-lg-6  col-sm-12 col-md-7 hidden-xs">
                    <div class="list-contact hidden-sm hidden-xs">
                        <ul class="top-link list-inline">

                          <li class="account"><a style="color: #fff" href="#">Sell On</a></li>
                          <li class="account"><a style="color: #fff" href="#">Track Order</a></li>
                          <li class="account"><a style="color: #fff" href="#">How To Buy</a></li>
                        </ul>
                    </div>
                </div>
              <div class="header-top-right collapsed-block col-lg-6 col-sm-12 col-md-5 col-xs-12 ">
                  <div class="tabBlock" id="TabBlock-1">
                      <ul class="top-link list-inline">

                          <li class="account " id="my_account">
                              <a href="#" title="My Account" class="btn-xs dropdown-toggle" data-toggle="dropdown"> <span>@if(Auth::check()) {{Auth::user()->name}} @else My Account @endif</span> <span class="fa fa-angle-down"></span></a>
                              <ul class="dropdown-menu ">
                                  @if(Auth::check())
                                  <li><a href="{{route('user.myAccount')}}">My Account</a></li>
                                  <li><a href="{{route('user.orderHistory')}}">Order History</a></li>
                                  <li><a href="#">Transactions</a></li>
                                  <li><a href="{{route('checkout')}}"> Checkout </a></li>
                                  <li> <a href="{{route('userLogout')}}">Logout </a> </li>
                                  @else

                                  <li> <a href="{{route('login')}}">Login </a> </li>
                                  <li> <a href="{{route('register')}}">Register </a>  </li>
                                  @endif
                              </ul>
                          </li>
                          <!-- LANGUAGE CURENTY -->
                          <li>
                              <div class="pull-left">
                                  <form action="#" method="post" enctype="multipart/form-data" id="form-language">
                                      <div class="btn-group">
                                          <button class="btn-link dropdown-toggle" data-toggle="dropdown">
                                          <img src="{{asset('frontend')}}/image/catalog/flags/gb.png" alt="English" title="English">
                                          <span class="hidden-xs hidden-sm hidden-md">English</span>&nbsp;<i class="fa fa-angle-down"></i>
                                          </button>
                                          <ul class="dropdown-menu">
                                              <li>
                                                  <button class="btn-block language-select" type="button" name="ar-ar"><img src="{{asset('frontend')}}/image/catalog/flags/bd.png" alt="Arabic" title="Bangla"> Bangla</button>
                                              </li>
                                              <li>
                                                  <button class="btn-block language-select" type="button" name="en-gb"><img src="{{asset('frontend')}}/image/catalog/flags/gb.png" alt="English" title="English"> English</button>
                                              </li>
                                          </ul>
                                      </div>
                                      <input type="hidden" name="code" value="">
                                      <input type="hidden" name="redirect" value="#">
                                  </form>
                              </div>
                          </li>
                          <li class="currency">
                              <div class="pull-left">
                                  <form action="#" method="post" enctype="multipart/form-data" id="form-currency">
                                      <div class="btn-group">
                                          <button class="btn-link dropdown-toggle" data-toggle="dropdown">
                                          $<span class="hidden-xs"> US Dollar</span>
                                          <i class="fa fa-angle-down"></i>
                                          </button>
                                          <ul class="dropdown-menu">
                                              <li>
                                                  <button class="currency-select btn-block" type="button" name="EUR">€ Euro</button>
                                              </li>
                                              <li>
                                                  <button class="currency-select btn-block" type="button" name="GBP">£ Pound Sterling</button>
                                              </li>
                                              <li>
                                                  <button class="currency-select btn-block" type="button" name="USD">$ US Dollar</button>
                                              </li>
                                          </ul>
                                      </div>
                                      <input type="hidden" name="code" value="">
                                      <input type="hidden" name="redirect" value="#">
                                  </form>
                              </div>
                          </li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>
    <!-- //Header Top -->
    <!-- Header center -->
  <div class="header-center">
      <div class="container">
          <div class="row">
              <div class="navbar-logo col-lg-3 col-md-12 col-xs-12">
                  <a href="{{url('/')}}"><img width="200" height="50" src="{{asset('frontend/image/logo/'.Config::get('siteSetting.logo'))}}" title="Home" alt="Logo"></a>
              </div>
              <div class="header-center-right col-lg-6 col-md-7 col-sm-7 col-xs-9">
                  <div class="header_search">
                      <div id="sosearchpro" class="sosearchpro-wrapper so-search ">
                          <form method="GET" action="{{ route('product.search') }}">
                              <div id="search0" class="search input-group form-group">
                                  <div title="Select Category" class="select_category filter_type  icon-select">
                                      <?php $categories =  \App\Models\Category::where('parent_id', '=', null)->orderBy('orderBy', 'asc')->where('status', 1)->get() ?>
                                      <select class="no-border" name="cat">
                                          <option value="">All categories</option>
                                          @foreach($categories as $srccategory)
                                          <option @if(Request::get('cat') == $srccategory->slug) selected @endif value="{{$srccategory->slug}}">{{$srccategory->name}}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <input title="Write search keyword" class="autosearch-input form-control" type="text" onkeyup="searchItem(this.value)" name="q" value="@if(Request::get('q')){!! Request::get('q') !!}@endif" id="searchKey" required placeholder="Search">
                                  <span class="input-group-btn">
                                  <button title="search product" type="submit" class="button-search btn btn-default btn-lg" ><span class="fa fa-search"></span></button>
                                  </span>
                              </div>

                          </form>
                      </div>
                  </div>
              </div>
              <div class="header-cart-phone col-lg-3 col-md-5 col-sm-5 col-xs-3">
                  <div class="bt-head header-cart">
                      <div class="shopping_cart" onclick="getCart()">
                      <div id="cart" class="btn-shopping-cart">
                          <a data-loading-text="Loading... " class="btn-group top_cart dropdown-toggle" data-toggle="dropdown">
                            <div class="shopcart">
                             <?php
                              $sessionCart = $user_id = 0;

                              if(Auth::check()){
                                $user_id = Auth::id();
                              }else{
                                 
                                  $user_id = Session::get('user_id');
                                  
                              }
                              $getCart = App\Models\Cart::where('user_id', $user_id)->get()->toArray();
                              if(count($getCart)>0){
                                $sessionCart = array_sum(array_column($getCart, 'qty'));
                              }
                              ?>
                              <span class="handle pull-left"></span>
                              <div class="cart-info" >
                                <h2 class="title-cart">Shopping cart</h2>
                                <h2 class="title-cart2 hidden">My Cart</h2>
                                <span class="total-shopping-cart cart-total-full">
                                <span class="items_cart"  id="cartCount">{{ $sessionCart }} </span> <span class="items_cart2"> item(s)</span>
                                </span>
                              </div>
                            </div>
                          </a>
                          <ul  id="getCartHead" class="dropdown-menu pull-right shoppingcart-box">
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
  <div class="header-bottom hidden-compact">
      <div class="container">
          <div class="header-bottom-inner">
              <div class="row">
                  <div class="header-bottom-left menu-vertical col-md-3 col-sm-6 col-xs-7">
                      <div class="megamenu-style-dev megamenu-dev">
                          <div class="responsive">
                              <div class="so-vertical-menu no-gutter">
                                  <nav class="navbar-default">
                                      <div class=" container-megamenu  container   vertical  ">
                                        <div id="menuHeading">
                                          <div class="megamenuToogle-wrapper">
                                            <div class="megamenuToogle-pattern">
                                              <div class="container">
                                                <div><span></span><span></span><span></span></div>
                                                <span class="title-mega">
                                                All Categories
                                                </span>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="navbar-header">
                                          <span class="title-navbar hidden-lg hidden-md">  All Categories  </span>
                                          <button type="button" id="show-verticalmenu" data-toggle="collapse" class="navbar-toggle">
                                          <span class="icon-bar"></span>
                                          <span class="icon-bar"></span>
                                          <span class="icon-bar"></span>
                                          </button>
                                        </div>
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
                                                    <strong>{{$category->name}}</strong>
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
                                                                        <a href="{{ route('home.category', [$category->slug, $subcategory->slug]) }}"  class="main-menu">{{$subcategory->name}}
                                                                          @if(count($subcategory->get_subcategory)>0)
                                                                          <b class="fa fa-angle-right"></b>
                                                                          @endif
                                                                        </a>
                                                                        @if(count($subcategory->get_subcategory)>0)
                                                                        <ul>
                                                                          @foreach($subcategory->get_subcategory as $childcategory)
                                                                          <li><a href="{{ route('home.category',[ $category->slug, $subcategory->slug, $childcategory->slug]) }}" >{{$childcategory->name}}</a></li>
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
                                                    <strong>{{$category->name}}</strong>
                                                    </span>
                                                    </a>
                                                  </li>
                                                @endif
                                                @endforeach

                                                <li class="loadmore"><i class="fa fa-plus-square"></i><span class="more-view"> More Categories</span></li>
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
                      <div class="header-menu">
                          <div class="megamenu-style-dev megamenu-dev">
                              <div class="responsive">
                                  <nav class="navbar-default">
                                      <div class="container-megamenu horizontal">
                                          <div class="navbar-header">
                                            <button type="button" id="show-megamenu" data-toggle="collapse" class="navbar-toggle">
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            </button>
                                          </div>
                                          <div class="megamenu-wrapper">
                                            <span id="remove-megamenu" class="fa fa-times"></span>
                                            <div class="megamenu-pattern">
                                              <div class="container">
                                                <ul class="megamenu" data-transition="slide" data-animationtime="500">

                                                <?php $menus =  \App\Models\Menu::where('main_header', 1)->where('status', 1)->get() ?>

                                                @foreach($menus as $menu)
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

                                                  @else
                                                  <li class="style-page with-sub-menu hover">
                                                    <p class="close-menu"></p>
                                                    @if(count($menu->get_pages)>1)

                                                    @foreach($menu->get_pages as $page)
                                                      <a class="clearfix">
                                                      <strong>
                                                      {{$menu->name}}
                                                      </strong>
                                                      <b class="caret"></b>
                                                      </a>
                                                      <div class="sub-menu" style="width: 40%;">
                                                        <div class="content" >
                                                          <div class="row">
                                                            <div class="col-md-6">
                                                              <ul class="row-list">
                                                                <li><a class="subcategory_item" href="faq.html">FAQ</a></li>
                                                                <li><a class="subcategory_item" href="sitemap.html">Site Map</a></li>
                                                                <li><a class="subcategory_item" href="contact.html">Contact us</a></li>
                                                                <li><a class="subcategory_item" href="banner-effect.html">Banner Effect</a></li>
                                                              </ul>
                                                            </div>
                                                            <div class="col-md-6">
                                                              <ul class="row-list">
                                                                <li><a class="subcategory_item" href="about-us.html">About Us 1</a></li>
                                                                <li><a class="subcategory_item" href="about-us-2.html">About Us 2</a></li>
                                                                <li><a class="subcategory_item" href="about-us-3.html">About Us 3</a></li>
                                                                <li><a class="subcategory_item" href="about-us-4.html">About Us 4</a></li>
                                                              </ul>
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    @endforeach
                                                    @else
                                                     <a href="{{ ($menu->get_pages[0]->is_default == 1) ? url($menu->get_pages[0]->slug) : route('page', $menu->get_pages[0]->slug)}}" class="clearfix">
                                                      <strong>
                                                      {{$menu->get_pages[0]->title}}
                                                      </strong>
                                                      </a>
                                                    @endif
                                                  </li>
                                                  @endif
                                                @endforeach
                                                  <!-- <li class="deal-h5 hidden">
                                                    <p class="close-menu"></p>
                                                    <a href="#" class="clearfix">
                                                    <strong>
                                                    <img src="{{asset('frontend')}}/image/catalog/demo/menu/hot-block.png" alt="">Top Sales
                                                    </strong>
                                                    </a>
                                                  </li>
                                                  <li class="deal-h5 hidden">
                                                    <p class="close-menu"></p>
                                                    <a href="#" class="clearfix">
                                                    <strong>
                                                    Today Deals
                                                    </strong>
                                                    </a>
                                                  </li> -->
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
