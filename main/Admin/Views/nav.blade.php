<div class="navbar navbar-expand-md navbar-dark bg-primary navbar-static">
    <div class="navbar-brand">
        <a href="{{ route('admin.home') }}" class="d-inline-block">
            <img class="visible-on-sidebar-regular" src="{{ asset('images/logo115x17.png') }}">
        </a>
    </div>
    <div class="d-md-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="mi-help-outline"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
        @hasSection('sidebar-secondary')
            <button class="navbar-toggler sidebar-mobile-secondary-toggle" type="button">
                <i class="icon-list-unordered"></i>
            </button>
        @endif
    </div>
    <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                    <i class="icon-paragraph-justify3"></i>
                </a>
            </li>
            @hasSection('sidebar-secondary')
                <li class="nav-item">
                    <a href="#" class="navbar-nav-link sidebar-control sidebar-secondary-toggle d-none d-md-block">
                        <i class="icon-list-unordered"></i>
                    </a>
                </li>
            @endif
        </ul>
        <span class="navbar-text ml-md-3"></span>
        <ul class="navbar-nav ml-md-auto">
            @can('access', 'admin.notifications.index')
                <!--li class="nav-item dropdown">
                    <a
                        href="#"
                        class="navbar-nav-link dropdown-toggle legitRipple"
                        aria-expanded="false"
                        data-toggle="dropdown"
                    >
                        <i class="icon-bell2"></i>
                        <span id="headerNotifications" class="badge badge-danger position-static ml-auto"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right wmin-md-350">
                        <div id="notificationContent" data-notification="{{__('messages.NoPendingNotifications')}}"></div>
                        <div class="dropdown-divider"></div>
                        <a
                            href="{{ route('admin.notifications.index', ['f' => 'unread']) }}"
                            class="dropdown-item d-block text-center text-muted"
                        >
                            {{ __('messages.viewAllNotificationsNavBar') }}
                        </a>
                    </div>
                </li-->
            @endcan
            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link dropdown-toggle legitRipple" data-toggle="dropdown" aria-expanded="false">
                    <i class="icon-user mr-2"></i>
                    {{ auth()->user()->person->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                    <div class="dropdown-content-body dropdown-scrollable p-2">
                        <a href="{{ route('admin.profile.edit') }}" class="dropdown-item font-size-sm line-height-sm text-uppercase font-weight-semibold text-grey m-0">
                            <i class="mi-account-box "></i>
                            {{ __('messages.editProfileWindow') }}
                        </a>
                        <a href="{{ route('admin.activity.list') }}" class="dropdown-item font-size-sm line-height-sm text-uppercase font-weight-semibold text-grey m-0">
                            <i class="mi-remove-from-queue "></i>
                            {{ __('messages.myActivityWindow') }}
                        </a>
                    </div>
                    <div class="dropdown-content-body dropdown-scrollable p-2">

                        @foreach($available_locales as $locale_name => $available_locale)
                            <a href="{{ route('admin.locale', $available_locale) }}" class="dropdown-item font-size-sm line-height-sm text-uppercase font-weight-semibold text-grey m-0">
                                <i class="mi-devices-other  "></i>
                                @if($available_locale === $current_locale)
                                    <b>{{ $locale_name }}</b>
                                @else
                                    {{ $locale_name }}
                                @endif
                            </a>
                        @endforeach
                    </div>                    
                    <div class="dropdown-content-footer bg-light">
                        <a href="#" class="font-size-sm line-height-sm text-uppercase font-weight-semibold text-grey mr-auto">&nbsp;</a>
                        <div>
                            <a href="{{ route('auth.logout') }}" class="text-grey" >
                                <i class="icon-switch2"></i>
                                {{ __('messages.logoutWindow') }}
                            </a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
