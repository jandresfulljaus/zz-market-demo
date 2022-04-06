<div class="sidebar sidebar-light sidebar-main sidebar-expand-md">
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        <span class="font-weight-semibold">Menú principal</span>
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <div class="sidebar-content">
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">
                    {{__('messages.principalSidebarHome')}}
                    </div>
                </li>

                @can('access', 'admin.home')
                    <li class="nav-item">
                        <a title="{{__('messages.homeHome')}}" id="admin.home" class="nav-link" href="{{ route('admin.home')}}">
                            <i class="icon-home"></i>
                            <span>{{__('messages.homeHome')}}</span>
                            <span id="messageNotifications" class="sidebar-badge"></span>
                        </a>
                    </li>
                @endcan

                {{-- @can('access', 'products.products.list')
                    <li class="nav-item">
                        <a title="{{__('messages.productsSidebarHome')}}" id="products.products.list" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.products.home')}}">
                            <i class="icon-store2"></i>
                            <span>{{__('messages.productsSidebarHome')}}</span>
                            <span id="messageNotifications" class="sidebar-badge"></span>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a title="{{__('messages.productsSidebarHome')}}" id="products.prices.list" class="nav-link {{ request()->routeIs('products.prices.list') ? 'active' : '' }}" href="{{ route('products.prices.list')}}">
                            <i class="icon-store2"></i>
                            <span>{{__('messages.productsSidebarHome')}}</span>
                            <span id="messageNotifications" class="sidebar-badge"></span>
                        </a>
                    </li>
                @endcan --}}

                {{-- @can('access', 'orders.orders.list')
                    <li class="nav-item">
                        <a title="{{__('messages.ordersOrders')}}" id="orders.orders.list" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.orders.home')}}">
                            <i class="icon-pencil7"></i>
                            <span>{{__('messages.ordersOrders')}}</span>
                            <span id="messageNotifications" class="sidebar-badge"></span>
                        </a>
                    </li>
                @endcan --}}

                @can('access', 'auth.organizations.list')
                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">
                            {{__('messages.settingsSidebarHome')}}
                        </div>
                    </li>
                    <li class="nav-item">
                        <a title="{{__('messages.generalConfigurationSidebarHome')}}" id="auth.organizations.list" class="nav-link {{ request()->routeIs('auditory.*', 'auth.perms.*', 'auth.roles.*', 'auth.users.*', 'auth.organizations.*', 'auth.branches.*') ? 'active' : '' }}" href="{{ route('auth.organizations.list')}}">
                        <i class="icon-archive"></i>
                            <span>{{__('messages.generalConfigurationSidebarHome')}}</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
