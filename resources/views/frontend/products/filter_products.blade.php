@if(count($products)>0)
<div class="product-filter filters-panel">
    <div class="row" >
        <div class="col-sm-5 col-md-5 col-xs-12">({{ ($products) ?  $products->total() : '0' }}) products found {{Request::get('q')}}</div>
    
        <div class="short-by-show form-inline text-right hidden-sm hidden-xs col-xs-8 col-md-5 col-sm-5">
            <div class="form-group short-by">
                <label class="control-label" for="input-sort">Sort By:</label>
                <select onchange="sortproduct()" id="sortby" class="form-control" >
                    <option value="">Default</option>
                    <option @if(Request::get('sortby') == 'name-a-z') selected @endif value="name-a-z">Name (A - Z)</option>
                    <option @if(Request::get('sortby') == 'name-z-a') selected @endif value="name-z-a"> Name (Z - A) </option>
                    <option @if(Request::get('sortby') == 'price-l-h') selected @endif value="price-l-h">Price (Low &gt; High)</option>
                    <option @if(Request::get('sortby') == 'price-h-l') selected @endif value="price-h-l"> Price (High &gt; Low) </option>
                    <option @if(Request::get('sortby') == 'ratting-h-l') selected @endif value="ratting-h-l">Rating (Highest)</option>
                    <option @if(Request::get('sortby') == 'ratting-l-h') selected @endif value="ratting-l-h"> Rating (Lowest) </option>

                </select>
            </div>
            <div class="form-group">
                <label class="control-label" for="input-limit">Show:</label>
                <select class="form-control" onchange="showPerPage()" id="perPage">
                    <option value="">Default</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="75">75</option>
                    <option value="100">100</option>
                </select>
            </div>
            
        </div>
        <div class="col-sm-2 view-mode hidden-sm hidden-xs">
          <div class="list-view" style="float: right;">
            <button data-view="grid" data-toggle="tooltip" data-original-title="Grid" class="btn btn-default grid active"><i class="fa fa-th"></i></button>
            <button data-view="list" data-toggle="tooltip" data-original-title="List" class="btn btn-default list"><i class="fa fa-th-list"></i></button>
          </div>
        </div>         
    </div>
</div>
<div class="products-list grid row number-col-4 so-filter-gird" style="margin-left: 0px;">
    @foreach($products as $product)
    <div class="product-layout col-lg-3 col-md-3 col-sm-4 col-xs-6">
        @include('frontend.products.products')
    </div>
    @endforeach
</div>

<div class="product-filter product-filter-bottom filters-panel">
    <div class="col-sm-6 col-md-6 col-lg-6 text-center">
       {{$products->appends(request()->query())->links()}}
      </div>
    <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of total {{$products->total()}} entries ({{$products->lastPage()}} Pages)</div>
</div>

@else
<div style="text-align: center;">
    <h3>Search Result Not Found.</h3>
    <p>We're sorry. We cannot find any matches for your search term</p>
    <i style="font-size: 10rem;" class="fa fa-search"></i>
</div>
@endif