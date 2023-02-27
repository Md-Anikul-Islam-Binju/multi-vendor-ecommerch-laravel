<div class="product-filter filters-panel">
<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-9">
      <h3 style="padding-top: 8px"> Total {{$sellers->total()}} Shops</h3>
  </div>
  <div class="col-xs-6 col-sm-6 col-md-3">
    <div class="so-filter-content-opts" style="padding: 10px;">
        <div class="so-filter-content-opts-container">
            <div class="so-filter-option" data-type="search">
                <div class="so-option-container">
                 
                    <div class="input-group">
                        <input type="text" placeholder="Search" class="form-control" name="src" onkeyup="filter_data()" id="shopKey" value="{!! Request::get('src') !!}">
                        <div class="input-group-btn">
                            <button class="btn btn-default" onclick="filter_data()" type="button" id="submit_text_search"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                 
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
</div>
<div class="row">
	<div class="col-xs-12"><div id="dataLoading"></div></div>
  @foreach($sellers as $seller)
  <div class="col-xs-4 col-sm-3 col-md-3" style="padding-right: 0px;margin-bottom:10px;">
      <div class="seller-list">
          <a href="{{ route('shop_details', $seller->slug) }}"> 
          <div class="seller-thumb">
            @if($seller->logo)
              <img src="{{asset('upload/vendors/logo/'.$seller->logo)}}" alt="">
            @else
            <p style="font-size: 50px;line-height: 2;font-weight: bold;"> @php echo ucfirst(substr(trim($seller->shop_name), 0, 1)); @endphp </p>
            @endif
          </div>
          <div class="desc-listcategoreis" >
              <div class="rating">
                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
             </div>
              <p style="font-weight: bold;font-size: 12px;margin-bottom:0px;line-height: 1">{{$seller->shop_name}}</p>
              <span>{{ count($seller->allproducts)}} Products</span>
                 
          </div>
          </a>
      </div>
  </div>
  @endforeach
  <div class="col-xs-12" style="text-align: center;">{{ $sellers->links()}}</div>
</div>