<div class="product-detail user-profile hidden-lg hidden-md" style="z-index: 99999999;">
    <aside style="background: #fff;padding-top: 10px; box-shadow: 0 2px 4px 0 rgb(0 0 0 / 25%);
    transform: scale(1.0);" class=" content-aside right_column sidebar-offcanvas">
        <span id="close-sidebar" class="fa fa-times"></span>
        <div class="user-image">
            <div class="profileImageBox">
                <img data-toggle="tooltip" data-original-title="Upoad Profile Image" src="{{ asset('upload/users') }}/{{(Auth::user()->photo) ? Auth::user()->photo : 'default.png'}}" class="rounded-circle" alt="">
                <span  data-toggle="modal" data-target="#user_imageModal" class="uploadIcon" ><i class="fa fa-camera"></i></span>
                <span  data-toggle="modal" data-target="#user_imageModal" style=" position: absolute;bottom: 12px;border: 1px solid #ccc;right: 75px;border-radius: 50%;padding: 0px 7px;background: #ccc;"><i class="fa fa-camera"></i></span>
            </div>
            <p style="text-align: center;"><strong>Wallet Balance: </strong>{{ config('siteSetting.currency_symble'). Auth::user()->wallet_balance}} </p>
        </div>
        <div class="module-content custom-border ">
            <ul class="list-box">
                 
                <li><a href="{{route('user.dashboard')}}"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="{{route('user.orderHistory')}}"><i class="fa fa-cart-plus"></i> Order History </a></li>
                <li><a href="{{route('user.voucherHistory')}}"><i class="fa fa-hourglass-half"></i> Skating Voucher </a></li>
                <!-- <li><a href="{{route('user.orderDownloadable')}}"><i class="fa fa fa-download"></i> Downloadable </a></li> -->
                
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


@if(Auth::check())
<div class="modal fade" id="user_imageModal" role="dialog"  tabindex="-1" aria-hidden="true" >
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header" style="border:none;">
              Update Profile Image
              <button type="button" id="modalClose" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body form-row">
              <form action="{{route('changeProfileImage')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group"> 
                        <input data-default-file="{{ asset('upload/users/avatars/') }}/{{(Auth::user()->photo) ? Auth::user()->photo : 'default.png'}}" type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif" required="" data-max-file-size="10M"  name="profileImage" id="input-file-events">
                        <i style="color: red;font-size: 12px;">Image Size: 150px*150px</i>
                    </div>
                    @if ($errors->has('profileImage'))
                        <span class="invalid-feedback" role="alert">
                            {{ $errors->first('profileImage') }}
                        </span>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" >Change Image</button>
                </div>
            </form>
          </div>
      </div>
    </div>
</div>
<!--user image Modal -->
@endif
