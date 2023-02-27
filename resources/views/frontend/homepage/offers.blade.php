<?php  

$offers = App\Models\Offer::where('end_date', '>=', now())->orderBy('position', 'asc')->where('status', 1)->take($section->item_number)->get(); 
$feature_exist = null;
?>
@if(count($offers)>0)
<section @if($section->layout_width == 1) style="background:{{$section->background_color}};padding: 10px 0 10px;" @endif>
  <div class="container" @if($section->layout_width != 1) style="background:{{$section->background_color}};border-radius: 5px; padding:5px;" @endif>
    <div class="row">
      
        <div class="col-xs-12 col-md-12">
          @foreach($offers as $offer)
          @if($offer->featured == 1 && $feature_exist == null)
          <div class="offer_section">
            <a href="{{route('offer.details', $offer->slug)}}">
            <div >
            
              <img alt="" src="{{asset('upload/images/offer/banner/'.$offer->banner)}}">
            
              @if(now() <= $offer->start_date)
              <div class="liveBtn"><span class="blink">Up Comming</span>
                <div class="head" id="offerDate" data-offerDate="{{Carbon\Carbon::parse($offer->start_date)->format('m,d,Y H:i:s')}}">
 
                 <div class="count">
                    <div class="count_d" style="background:{{$offer->background_color}}; color: {{$offer->text_color}}" >
                    <h2>Days</h2>
                      <span id="days">00</span>
                    </div>
                    <div class="count_d" style="background:{{$offer->background_color}}; color: {{$offer->text_color}}">
                    <h2>HOURS</h2>
                      <span id="hour">00</span>
                    </div>
                    <div class="count_d" style="background:{{$offer->background_color}}; color: {{$offer->text_color}}">
                    <h2>MINUTES</h2>
                      <span id="minutes">00</span>
                    </div>
                    <div class="count_d" style="background:{{$offer->background_color}}; color: {{$offer->text_color}}">
                    <h2>SECONDS</h2>
                      <span id="seconds">00</span>
                    </div>
                  </div>
                </div>
                </div>

                @elseif(now() >= $offer->start_date && now() <= $offer->end_date)
                <div class="liveBtn"><span class="blink"> Live Offer</span>
                 
                  <div class="head" id="offerDate" data-offerDate="{{Carbon\Carbon::parse($offer->end_date)->format('m,d,Y H:i:s')}}">
 
                    <div class="count">
                      <div class="count_d" style="background:{{$offer->background_color}}; color: {{$offer->text_color}}">
                      <h2>Days</h2>
                        <span id="days">00</span>
                      </div>
                      <div class="count_d" style="background:{{$offer->background_color}}; color: {{$offer->text_color}}">
                      <h2>HOURS</h2>
                        <span id="hour">00</span>
                      </div>
                      <div class="count_d" style="background:{{$offer->background_color}}; color: {{$offer->text_color}}">
                      <h2>MINUTES</h2>
                        <span id="minutes">00</span>
                      </div>
                      <div class="count_d" style="background:{{$offer->background_color}}; color: {{$offer->text_color}}">
                      <h2>SECONDS</h2>
                        <span id="seconds">00</span>
                      </div>
                    </div>
                  </div>
                </div>
                @else
                <div class="liveBtn" style="padding: 8px 60px 23px;">Closed <br/> Offer</div>
                @endif
            </div>
            </a>
          </div>
          @endif
          @php  $feature_exist = 1; @endphp
          @endforeach
        </div>
       
    </div>
  </div>
  </div>
</section>
@endif