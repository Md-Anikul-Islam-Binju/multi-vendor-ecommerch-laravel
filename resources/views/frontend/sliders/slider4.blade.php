@if(count($sliders)>0)
<section class="section">
  <div class="module sohomepage-slider so-homeslider-ltr" style="overflow: hidden; max-height: 300px !important; width: 100% !important;">
      <div class="modcontent">
          <div id="sohompage-slider1">
              <div class="so-homeslider yt-content-slider full_slider owl-drag" data-rtl="yes" data-autoplay="yes" data-autoheight="no" data-delay="4" data-speed="0.6"data-items_column00="1" data-items_column0="1" data-items_column1="1" data-items_column2="1"  data-items_column3="1" data-items_column4="1" data-arrows="yes" data-pagination="yes" data-lazyload="yes" data-loop="yes" data-hoverpause="yes">
              @foreach($sliders as $slider)
              <div class="item">
                  <a href="{{$slider->btn_link}}" target="_self">
                  <img class="responsive" style="border-radius: inherit;" src="{{asset('upload/images/slider/'.$slider->phato)}}" alt="slider image">
                  </a>
              </div>
              @endforeach
              </div>
          </div>
      </div> 
	</div>
</section>
@endif