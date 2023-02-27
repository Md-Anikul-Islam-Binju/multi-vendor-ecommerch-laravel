<footer class="footer-container typefooter-2">
  <div class="footer_area" >
    <div class="so-page-builder">
      <section class="section_3" style="margin-bottom:0">
        <div class="container">
          <div class="row row_bh6y  row-style ">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_mehx  col-style">
              <div class="row row_q34c  border ">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 col_5j8y col-style">
                  <div class="contactinfo">
                    <img width="200" src="{{ asset('upload/images/logo/'.Config::get('siteSetting.logo') )}}" title="" alt="">
                    <p>{{Config::get('siteSetting.about')}}</p>
                    <div class="content-footer">

                      <div class="address">
                        <label><i class="fa fa-map-marker" aria-hidden="true"></i></label>
                        <span>{{Config::get('siteSetting.address')}}</span>
                      </div>
                      <div class="phone">
                        <label><i class="fa fa-phone" aria-hidden="true"></i></label>
                        <a href="tel:{{Config::get('siteSetting.phone')}}">{{Config::get('siteSetting.phone')}}
                      </div>
                      <div class="email">
                        <label><i class="fa fa-envelope"></i></label>
                        <a href="mailto:{{Config::get('siteSetting.email')}}">{{Config::get('siteSetting.email')}}</a>
                      </div>
                    </div>
                  </div>
                </div>
                
                @php $footer_menus = $menus->where('footer', 1); @endphp
                @foreach($footer_menus as $menu)
                <div class="col-lg-{{(count($footer_menus) > 2 )  ? 2 : 3}} col-md-{{(count($footer_menus) > 2 )  ? 2 : 3}} col-sm-6 col-xs-6">
                  <div class="footer-links">
                    <h4 class="title-footer">
                      {{$menu->name}}
                    </h4>
                    <ul class="links">
                      @php
                        $source_id = explode(',', $menu->source_id);
                        $get_pages =  \App\Models\Page::whereIn('id', $source_id)->get();
                      @endphp
                      
                        @if($menu->menu_source == 'page')
                        @foreach($get_pages as $page)
                        <li>
                          <a href="{{ route('page', $page->slug)}}">{{$page->title}}</a>
                        </li>
                        @endforeach
                        @endif
                        @if(count($menu->get_categories)>0)
                          @foreach($menu->get_categories as $category)
                          <li>
                          <a href="{{route('home.category', [$category->get_singleSubcategory->slug, $category->slug])}}" >{{$category->name}}</a>
                          </li>
                          @endforeach
                        @endif
                    </ul>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
  <div class="footer-bottom copyright_area ">
    <div class="container">
      <div class="row">
        <div class="col-md-6  col-sm-6 copyright">
          {!! config::get('siteSetting.copyright_text') !!}
        </div>
        <div class="col-md-6">@php
          if(!Session::has('socialLists')){
              Session::put('socialLists', App\Models\Social::where('type', 'admin')->orderBy('position', 'asc')->where('status', 1)->get());
          }
          @endphp
          <div class="footer-social">
            <h3 class="block-title hidden">Follow us</h3>
            <div class="socials" style="text-align: right;">
              @foreach(Session::get('socialLists') as $social)
              <a  style="background:{{$social->background}}; color:{{$social->text_color}}" href="{{$social->link}}" class="facebook" target="_blank">
                <i class="fa {{$social->icon}}"></i>
              </a>
               @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>