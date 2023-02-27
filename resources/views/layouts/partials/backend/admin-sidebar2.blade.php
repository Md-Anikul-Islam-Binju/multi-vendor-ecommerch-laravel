<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                
                <?php

                if(!Session::get('modules')){
                    if(Auth::guard('admin')->check()){
                        $role_id = SUPER_ADMIN;
                    }elseif(Auth::guard('admin')->check()){
                        $role_id = ADMIN;
                    }else{
                        $role_id = ADMIN;
                    }
                    $modules = App\Models\Module::with(['sub_modules' => function ($query){
                    $query->where('status', 1)->where('is_hidden_sidebar', null);
                    }, 'sub_modules.rolePermission' => function ($query) use ($role_id) {
                    $query->where('role_id', '=', $role_id); }])
                    ->where('parent_id', null)
                    ->orderBy('position', 'asc')
                    ->get()->toArray();
                    $modules = Session::put('modules', $modules);
                }
                $modules = Session::get('modules');
                ?>
            @foreach($modules as $index => $module) 
                
                @if($module['slug'] == 'dashboard')
                <li> <a class="waves-effect waves-dark" href="{{route('admin.dashboard')}}" aria-expanded="false"><i class="{{$module['icon']}}"></i><span class="hide-menu">{{$module['module_name']}}</span></a></li>
                @elseif($module['slug'] == 'product')
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="{{ ($module['route']) ? route($module['route']) : 'javascript:void(0)'}}" aria-expanded="false"><i class="{{$module['icon']}}"></i><span class="hide-menu">{{$module['module_name']}} </span></a>
                    
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.product.upload')}}">Product Upload</a></li>
                        <li><a href="{{route('admin.product.list')}}">Manage Product</a></li>
                    </ul>
                </li>
                @elseif($module['slug'] == 'order')
                <li>
                    @php $pendingOrder = App\Models\Order::where('payment_method', '!=', 'pending')->where('order_status', 'pending')->count(); @endphp

                    <a class="@if(count($module['sub_modules'])>0) has-arrow @endif waves-effect waves-dark" href="{{ ($module['route']) ? route($module['route']) : 'javascript:void(0)'}}" aria-expanded="false"><i class="{{$module['icon']}}"></i><span class="hide-menu">{{$module['module_name']}} <span class="badge badge-pill badge-cyan ml-auto">{{ $pendingOrder }}</span></span></a>
                    @if(count($module['sub_modules'])>0)
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.orderList')}}">All Orders</a></li>
                        <li><a href="{{route('admin.orderList', 'pending')}}">Pending Orders <span class="badge badge-pill badge-cyan ml-auto">{{ $pendingOrder }}</span></a></li>
                        @foreach($module['sub_modules'] as $submoduleIndex => $submodule)
                        @php $permission = $submodule['role_permission']; @endphp
                        <li><a href="{{ ($submodule['route']) ? route($submodule['route']) : 'javascript:void(0)'}}">{{ $submodule['module_name'] }}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @elseif($module['slug'] == 'seller')
                <li>
                    @php $sellerRequest = App\Vendor::where('status', 'pending')->count(); @endphp

                    <a class="@if(count($module['sub_modules'])>0) has-arrow @endif waves-effect waves-dark" href="{{ ($module['route']) ? route($module['route']) : 'javascript:void(0)'}}" aria-expanded="false"><i class="{{$module['icon']}}"></i><span class="hide-menu">{{$module['module_name']}} <span class="badge badge-pill badge-primary ml-auto">{{ $sellerRequest }}</span></span></a>
                    @if(count($module['sub_modules'])>0)
                    <ul aria-expanded="false" class="collapse">
                        <li> <a href="{{route('vendor.list')}}">Seller List</a></li>
                        <li> <a href="{{route('vendor.list', 'pending')}}">Seller Request <span class="badge badge-pill badge-cyan ml-auto">{{$sellerRequest}}</span></a></li>
                        @foreach($module['sub_modules'] as $submoduleIndex => $submodule)
                        @php $permission = $submodule['role_permission']; @endphp
                        <li><a href="{{ ($submodule['route']) ? route($submodule['route']) : 'javascript:void(0)'}}">{{ $submodule['module_name'] }}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </li>

                @elseif($module['slug'] == 'wallet')
                <li>
                    @php $withdrawRequest = App\Models\Transaction::where('customer_id', '!=', null)->where('status', 'pending')->count(); @endphp

                    <a class="@if(count($module['sub_modules'])>0) has-arrow @endif waves-effect waves-dark" href="{{ ($module['route']) ? route($module['route']) : 'javascript:void(0)'}}" aria-expanded="false"><i class="{{$module['icon']}}"></i><span class="hide-menu">{{$module['module_name']}} <span class="badge badge-pill badge-cyan ml-auto">{{ $withdrawRequest }}</span></span></a>
                    @if(count($module['sub_modules'])>0)
                    <ul aria-expanded="false" class="collapse">
                        <li> <a href="{{route('customerWalletHistory')}}">Wallet History</a></li>
                        <li> <a href="{{route('customerWithdrawRequest')}}">Withdraw Request <span class="badge badge-pill badge-cyan ml-auto">{{$withdrawRequest}}</span></a></li>
                        @foreach($module['sub_modules'] as $submoduleIndex => $submodule)
                        @php $permission = $submodule['role_permission']; @endphp
                        <li><a href="{{ ($submodule['route']) ? route($submodule['route']) : 'javascript:void(0)'}}">{{ $submodule['module_name'] }}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @else    
                <li>
                    <a class="@if(count($module['sub_modules'])>0) has-arrow @endif waves-effect waves-dark" href="{{ ($module['route']) ? route($module['route']) : 'javascript:void(0)'}}" aria-expanded="false"><i class="{{$module['icon']}}"></i><span class="hide-menu">{{$module['module_name']}} </span></a>
                    @if(count($module['sub_modules'])>0)
                    <ul aria-expanded="false" class="collapse">
                        @foreach($module['sub_modules'] as $submoduleIndex => $submodule)
                        @php $permission = $submodule['role_permission']; @endphp
                        <li><a href="{{ ($submodule['route']) ? route($submodule['route']) : 'javascript:void(0)'}}">{{ $submodule['module_name'] }}</a></li>
                        @endforeach
                   
                    </ul>
                    @endif
                </li>
                @endif
            @endforeach
                <li> <a class="waves-effect waves-dark" href="{{ route('adminLogout') }}"  aria-expanded="false"><i class="fa fa-power-off text-success"></i><span class="hide-menu">Log Out</span></a></li>
               
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>