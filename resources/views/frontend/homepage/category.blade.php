<?php  

$subcategories = App\Models\Category::where('parent_id', $section->product_id)->inRandomOrder()->take($section->item_number)->get();
?>

@if(count($subcategories)>0)
<section style="margin: 5px 0; @if($section->layout_width == 1) background:{{$section->background_color}} @endif">
  <div class="container" @if($section->layout_width != 1) style="background:{{$section->background_color}};border-radius: 5px; padding:5px;" @endif>
      <div class="title" style="color: {{$section->text_color}} !important;">
          {{$section->title}}
      </div>
      <div class="row">
          @if($section->thumb_image && $section->image_position == 'left')
          <div class="col-md-3 col-xs-12 hidden-xs hidden-sm">
            <div style="background: #fff;padding: 5px">
              <img style="width: 100%;height: 100%;" src="{{ asset('upload/images/homepage/'.$section->thumb_image) }}">
            </div>
          </div>
          @endif
          <div class="col-xs-12 col-md-{{($section->thumb_image) ? 9 : 12}} col_hksd">
              <div class="module so-listing-tabs-ltr home3_listingtab_style2">
                
                <div class="modcontent">
                    <div id="so_listing_tabs_727" class="so-listing-tabs first-load module">
                      <div class="ltabs-wrap">
                        <div class="ltabs-tabs-container">
                              <!--Begin Tabs-->
                            <div class="ltabs-tabs-wrap">
                                 <div class="item-sub-cat">
                                    <ul class="ltabs-tabs cf">
                                      @foreach($subcategories as $subcategory)
                                       <li @if($section->thumb_image) style="width: 16.5%;" @endif class="ltabs-tab tab-sel" data-category-id="40" data-active-content=".items-category-40">
                                          <div class="ltabs-tab-img">
                                            <a href="{{ route('home.category', [$subcategory->get_category->slug, $subcategory->slug]) }}">
                                                <img src="{{asset('upload/images/category/thumb/'. $subcategory->image)}}"
                                                    title="{{$subcategory->name}}" alt=""
                                                    style="background:#fff; margin-bottom: 5px"/>
                                                <span class="ltabs-tab-label">
                                                {{$subcategory->name}}
                                                </span>
                                            </a>
                                          </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                 </div>
                            </div>
                            <!-- End Tabs-->
                        </div>
                       
                      </div>
                    </div>
                </div>
              </div>
          </div>
          @if($section->thumb_image && $section->image_position == 'right')
          <div class="col-md-3 col-xs-12 hidden-xs hidden-sm">
            <div style="background: #fff;padding: 5px">
              <img style="width: 100%;height: 100%;" src="{{ asset('upload/images/homepage/'.$section->thumb_image) }}">
            </div>
          </div>
          @endif
      </div>
    </div>
</section>
@endif