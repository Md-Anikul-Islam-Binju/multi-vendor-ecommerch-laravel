@extends('layouts.frontend')
@section('title', 'wishtlist | '. Config::get('siteSetting.site_name') )
@section('css')

@endsection
@section('content')
<div class="breadcrumbs">
  <div class="container">
    
    <ul class="breadcrumb-cate">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#">Wishtlist</a></li>
     </ul>
  </div>
</div>
<!-- Main Container  -->
<div class="container">
    <div class="row">
        @include('users.inc.sidebar')
        <div id="content" class="col-sm-9 sticky-content">
            <h2>My Wish List</h2>
            @if(count($wishlists)>0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td class="text-center">Image</td>
                                <td class="text-left">Product Name</td>
                                <td class="text-right">Stock</td>
                                <td class="text-right">Unit Price</td>
                                <td class="text-right">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($wishlists as $wishlist)
                            <tr id="item{{$wishlist->id}}">
                                <td class="text-center">
                                    <a href="{{route('product_details', $wishlist->get_product->slug)}}"><img src="{{asset('upload/images/product/thumb/'. $wishlist->get_product->feature_image)}}" width="48" height="40" class="img-thumbnail"></a>
                                </td>
                                <td class="text-left"><a href="{{route('product_details', $wishlist->get_product->slug)}}">{{Str::limit($wishlist->get_product->title, 30)}}</a></td>
                               
                                <td class="text-right">@if($wishlist->get_product->stock>=1)In Stock @else Out Of Stock @endif</td>
                                <td class="text-right">
                                    <div class="price"> <b>{{Config::get('siteSetting.currency_symble')}}{{$wishlist->get_product->selling_price-($wishlist->get_product->discount*$wishlist->get_product->selling_price)/100 }}</b>  @if($wishlist->get_product->discount) <s>{{Config::get('siteSetting.currency_symble')}}{{$wishlist->get_product->selling_price}}</s>@endif </div>
                                </td>
                                <td class="text-right">
                                    <button type="button" onclick="addToCart({{$wishlist->product_id}})"  data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add to Cart"><i class="fa fa-shopping-cart"></i></button>
                                    <a href="#" onclick="deleteConfirmPopup('{{route("wishlist.remove", $wishlist->id)}}')" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-times"></i></a></td>
                            </tr>
                           @endforeach
                        </tbody>

                    </table>
                </div>
                <div class="buttons clearfix">
                    <div class="pull-right"><a href="{{url('/')}}" class="btn btn-primary">Continue</a></div>
                </div>
            @else
                
                <div style="text-align: center;">
                    <i style="font-size: 80px;" class="fa fa-heart"></i>
                    <h1>Your wishlist is empty.</h1>
                    <p>Looks line you have no items in your wishlist list.</p>
                    Click here <a href="{{url('/')}}">Continue Shopping</a>
                </div>
            @endif
        </div>
    </div>

</div>	

<!-- //Main Container -->
@endsection	   

@section('js')
    @include('modal.delete-modal')
@endsection    


