<section id="section-style-h4-1" class="section-style-h4">
    <div class="container-fluid page-builder-ltr">
        <div class="row row_a90w  row-style ">
            <!--- SLider right-->  
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_dg1b slider-right">
                <div class="module sohomepage-slider so-homeslider-ltr  ">
                    <div class="modcontent">
                        <div id="sohomepage-slider1">
                            <div class="so-homeslider sohomeslider-inner-1">
                                @foreach($sliders as $slider)
                                <div class="item">
                                    <a href="{{$slider->btn_link}}" target="_self">
                                    <img style="max-height: 350px" class="responsive" src="{{asset('upload/images/slider/'.$slider->phato)}}" alt="slider image">
                                    </a>
                                    <div class="slider-details">
                                        
                                        <div class="slider-content-5 slider-animated-1 text-{{$slider->text_position}}">
                                            <h1><strong style="font-size:{{$slider->title_size}}px; color:{{$slider->title_color}}; font-family: {{$slider->title_style}}"> {{ $slider->title }} </strong></h1>
                                            <p style="font-size:{{$slider->title_size}}px; color:{{$slider->title_color}}; font-family: {{$slider->title_style}}">{{$slider->subtitle}}</p>
                                           @if($slider->btn_text) <a href="{{$slider->btn_link}}" class="btn btn-info">{{($slider->btn_text) ? $slider->btn_text : 'SHOP NOW'}}</a>@endif
                                        </div>
                                    
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
