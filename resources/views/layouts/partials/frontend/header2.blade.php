<header id="header" class="typeheader-3">
    <!-- Header Top -->
  <div class="header-top hidden-compact hidden-lg hidden-md">
      <div class="container">
          <div class="row">
              <div style="text-align: right;" class="header-top-right collapsed-block col-lg-6 col-sm-12 col-md-5 col-xs-12 ">
                  <div class="tabBlock" id="TabBlock-1">
                      <ul class="top-link list-inline">
                          @if(Auth::check()) 
                          <li class="account " id="my_account">
                              <a href="#" title="My Account" class="btn-xs dropdown-toggle" data-toggle="dropdown"> <span>{{Auth::user()->name}}</span> <span class="fa fa-angle-down"></span></a>
                              <ul class="dropdown-menu ">
                                  <li><a href="{{route('user.dashboard')}}">Dashboard</a></li>
                                  <li><a href="{{route('user.orderHistory')}}">Order History</a></li>
                                <!--   <li><a href="#">Transactions</a></li> -->
                                  <li><a href="{{route('checkout')}}"> Checkout </a></li>
                                  <li><a href="{{route('user.change-password')}}"> Change Password </a></li>
                                  <li> <a href="{{route('userLogout')}}">Logout </a> </li>
                              </ul>
                          </li>
                          @else
                          <li class="account "> <a data-toggle="modal" data-target="#so_sociallogin">Login </a> </li>
                          <li class="account "> <a href="{{route('register')}}">Register </a>  </li>
                          @endif
                          <li class="account"><a style="color: {{ config('siteSetting.header_text_color')}};border:1px solid {{ config('siteSetting.header_text_color')}}; padding: 0px 5px;border-radius: 5px;" href="{{route('vendorLogin')}}">Be a Seller</a></li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>
   <!-- Header center -->
  <div class="header-center">
    <div class="container">
      <div class="row">
        <div class="header-logo col-lg-2 col-md-2 col-sm-12 col-xs-12">
         <button type="button" style="float: left;margin-left: 0" id="show-verticalmenu" data-toggle="collapse" class="navbar-toggle">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>            
              <a href="{{url('/')}}"><img width="200" height="40" src="{{asset('upload/images/logo/'.Config::get('siteSetting.logo'))}}" title="Home" alt="Logo"></a>
              
            <button type="button" id="show-megamenu" data-toggle="collapse" class="navbar-toggle">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
        </div>
        <div class="header-search col-lg-6 col-md-6 col-sm-6 col-xs-5">
          <div id="sosearchpro" class="sosearchpro-wrapper so-search ">
            <form method="GET" action="{{ route('product.search') }}">
              <div id="search0" class="search input-group form-group">
                <div title="Select Category" class="select_category filter_type  icon-select">
                                  
                    <select class="no-border" name="cat">
                        <option value="">All categories</option>
                        @foreach($categories as $srccategory)
                        <option @if(Request::get('cat') == $srccategory->slug) selected @endif value="{{$srccategory->slug}}">{{$srccategory->name}}</option>
                        @endforeach
                    </select>
                </div>
                <input title="Write search keyword" style="height:40px;float: initial;"  class="autosearch-input form-control" type="text" size="50" autocomplete="off" placeholder="Search" name="q" value="@if(Request::get('q')) {!! preg_replace('/"/',' ',Request::get('q') ) !!} @endif" id="searchKey">
                <span class="input-group-btn">
                <button type="submit" class="button-search btn btn-default btn-lg" name="submit_search"><i class="fa fa-search"></i><span class="hidden">Search</span></button>
                </span>
              </div>
              <input type="hidden" name="route" value="product/search">
            </form>
          </div>
        </div>
        <div class="header-cart col-lg-2 col-md-2 col-sm-2  col-xs-1">
          <div class="header_custom_link hidden-xs" style="display: inline-block;padding: 5px 5px 0;">
                  <ul>
                      <li style="display: inline-block; padding-right: 5px" class="compare"><a href="{{route('productCompare')}}" class="top-link-compare" title="Compare product"></a></li>
                      <li style="display: inline-block;" class="wishlist"><a href="{{route('wishlists')}}" class="top-link-wishlist" title="Wish List  "></a></li>
                  </ul>
              </div>
          <div class="shopping_cart" onclick="getCart()" style="display: inline-block;">
                  <div id="cart" class="btn-shopping-cart">
                      <a data-loading-text="Loading... " class="btn-group top_cart dropdown-toggle" data-toggle="dropdown">
                        <div class="shopcart">
                         <?php
                          $sessionCart = $user_id = 0;

                          if(Auth::check()){
                            $user_id = Auth::id();
                          }else{
                            $user_id = (Cookie::has('user_id') ? Cookie::get('user_id') :  Session::get('user_id'));
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
                      <ul id="getCartHead" class="dropdown-menu pull-right shoppingcart-box">
                          <div class="loadingData-sm"></div>
                      </ul>
                    </div>
                  </div>
        </div>
        <div class="user-info-layout-3 col-lg-2 col-md-2 col-sm-3 col-xs-3">
          <div class="userinfo-block">
            <div class="user-info">
              @if(Auth::check()) 
                <ul class="top-link list-inline">
                    <li class="account " style="list-style: none;" id="my_account">
                        <a href="#" title="My Account" class="btn-xs dropdown-toggle" data-toggle="dropdown"> <span>{{Auth::user()->name}}</span> <span class="fa fa-angle-down"></span></a>
                        <ul class="dropdown-menu ">
                          
                            <li><a href="{{route('user.dashboard')}}">Dashboard</a></li>
                            <li><a href="{{route('user.orderHistory')}}">Order History</a></li>
                          <!--   <li><a href="#">Transactions</a></li> -->
                            <li><a href="{{route('checkout')}}"> Checkout </a></li>
                            <li><a href="{{route('user.change-password')}}"> Change Password </a></li>
                            <li> <a href="{{route('userLogout')}}">Logout </a> </li>
                          
                        </ul>
                    </li>
                  </ul>
              @else
               
              <a class="link-lg" data-toggle="modal" data-target="#so_sociallogin">Login </a> /
              <a class="link-lg" href="{{route('register')}}">Register </a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- //Header center -->
  <!-- //Header center -->
  <!-- Heaader bottom -->
  <div class="header-bottom hidden-compact" style="background:#fff;">
      <div class="container">
          <div class="header-bottom-inner">
              <div class="row">
                  <div class="header-bottom-left menu-vertical col-md-3 col-sm-6 col-xs-7">
                      <div class="megamenu-style-dev megamenu-dev">
                          <div class="responsive">
                              <div class="so-vertical-menu no-gutter">
                                  <nav class="navbar-default">
                                      <div class="header3menu container-megamenu  container   vertical  ">
                                        <div id="menuHeading">
                                          <div class="megamenuToogle-wrapper">
                                            <div class="megamenuToogle-pattern">
                                              <div class="container" style="background-color: #fb9e2f;">
                                                <div><span></span><span></span><span></span></div>
                                                <span class="title-mega">
                                                All Categories
                                                </span>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        
                                        @if(!Request::is('/'))
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
                                                    <strong><img width="20" src="{{asset('upload/images/category/thumb/'.$category->image)}}" alt="">  {{$category->name}}</strong>
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
                                                    <strong><img width="30" src="{{asset('upload/images/category/thumb/'.$category->image)}}" alt=""> {{$category->name}}</strong>
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
                                        @endif
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
                                          
                                          <div class="megamenu-wrapper">
                                            <span id="remove-megamenu" class="fa fa-times"></span>
                                            <div class="megamenu-pattern">
                                              <div class="container">
                                                <ul class="megamenu" data-transition="slide" data-animationtime="500">
                                                
                                                  @foreach($menus->where('top_header', 1) as $menu)
                                                  <li class="hidden-lg hidden-md"><a style="color: #000;" href="{{  route('page', $menu->get_pages->slug)}}">{{$menu->get_pages->title}}</a></li>
                                                  @endforeach
                                                 
                                                  @if(count($menus)>0)
                                                    @foreach($menus->where('main_header', 1) as $menu)
                                                      @if($menu->menu_source == 'category')
                                                      <li class="item-style2 content-full feafute with-sub-menu hover">
                                                        <p class="close-menu"></p>
                                                          <a class="clearfix" style="color: #000;">
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
                                                            <a style="color:#000" class="clearfix"><strong>{{$menu->name}} </strong>
                                                            <b class="caret"></b> </a>
                                                            <div class="sub-menu" style="width: 40%;">
                                                              <div class="content" >
                                                                <div class="row">

                                                                  <div class="col-md-6">
                                                                    <ul class="row-list">
                                                                      @foreach($get_pages as $page)
                                                                      <li><a class="subcategory_item" href="{{  route('page', $page->slug)}}">{{$page->title}}</a></li>
                                                                      @endforeach

                                                                    </ul>
                                                                  </div>
                                                                  
                                                                </div>
                                                              </div>
                                                            </div>
                                                          @else
                                                           <a style="color: #000" href="{{  route('page', $get_pages[0]->slug)}}" class="clearfix">
                                                            <strong> {{$menu->name}} </strong>
                                                            </a>
                                                          @endif
                                                        @endif
                                                      </li>

                                                      @else @endif
                                                    @endforeach
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
