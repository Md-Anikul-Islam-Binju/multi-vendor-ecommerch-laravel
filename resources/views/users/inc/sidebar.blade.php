<div class="product-detail user-profile col-md-3 col-sm-4 col-xs-12 sticky-content" style="z-index: 999;">
    <aside style="background: #fff;padding-top: 10px; box-shadow: 0 2px 4px 0 rgb(0 0 0 / 25%);
    transform: scale(1.0);" class=" content-aside right_column sidebar-offcanvas">
      
        <div class="user-image">
            <div class="profileImageBox">
                <img data-toggle="tooltip" data-original-title="Upload Profile Image" src="{{ asset('upload/users') }}/{{(Auth::user()->photo) ? Auth::user()->photo : 'default.png'}}" class="rounded-circle" alt="">
                <span  data-toggle="modal" data-target="#user_imageModal" class="uploadIcon" ><i class="fa fa-camera"></i></span>
                <span  data-toggle="modal" data-target="#user_imageModal" style=" position: absolute;bottom: 12px;border: 1px solid #ccc;right: 75px;border-radius: 50%;padding: 0px 7px;background: #ccc;"><i class="fa fa-camera"></i></span>
            </div>
            <p style="text-align: center;"><strong>Wallet Balance: </strong>{{ config('siteSetting.currency_symble'). Auth::user()->wallet_balance}} </p>
        </div>
        <div class="module-content custom-border ">
            <ul class="list-box">
                 
                <li><a href="{{route('user.dashboard')}}"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="{{route('user.orderHistory')}}"><i class="fa fa-cart-plus"></i> Order History </a></li>
            
                
                <li><a href="{{route('wishlists')}}"><i class="fa fa-heart"></i> Wish List </a></li>
                <li><a href="{{route('productCompare')}}"><i class="fa fa-list"></i> Compare</a></li>
                <li><a href="{{route('user.return_request')}}"><i class="fa fa-history"></i> Return Request</a></li>
                <li><a href="{{route('customer.walletHistory')}}">{{Config::get('siteSetting.currency_symble')}} My Wallet </a></li>
                <li><a href="{{route('user.myAccount')}}"><i class="fa fa-user"></i> Profile</a></li> 
                <li><a href="{{route('user.addressBook')}}"><i class="fa fa-map-marker"></i> Address Book</a></li> 
         <!--        <li><a href="#">Newsletter </a></li> -->
               <!--  <li><a href="#">Woaid Points </a></li> -->
                <li><a href="{{route('user.change-password')}}"><i class="fa fa-edit"></i> Change Password </a></li>
                <li><a href="{{route('userLogout')}}"><i class="fa fa-power-off"></i> Logout</a></li>
                 
            </ul>
        </div>
    </aside>
</div>