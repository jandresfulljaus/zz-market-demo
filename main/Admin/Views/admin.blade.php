<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png" />

    <title>
        @hasSection('title')
            @yield('title') -
        @endif
        Bridgestone OMS
    </title>
    
    <script src="{{ asset('template/js/main/jquery.min.js') }}"></script>
    <script src="{{ asset('template/js/main/bootstrap.bundle.min.js') }}"></script>

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('template/css/icons/material/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('template/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('template/css/icons/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/fulljaus.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/layout.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/components.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/colors.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/tickets.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/dropzone.min.css') }}" rel="stylesheet" type="text/css">
    @stack('styles')
</head>

<body @hasSection('sidebar-secondary') class="sidebar-xs" @endif>
    @include('Admin.Views.nav')

    <div class="page-content">
        @include('Admin.Views.sidebar-main')

        @yield('sidebar-secondary')

        <div class="content-wrapper">
            @include('Admin.Views.page-header')

            <div class="content @if(!empty($admin_info->contentNoPadding)) p-0 @endif ">
                @include('Admin.Views.messages')

                @yield('content')
            </div>
            <div class="navbar navbar-expand-lg navbar-light">
                <span class="navbar-text">
                    {{__('messages.developedByHome')}}
                    <a href="http://www.fulljaus.com/" target="_blank">Fulljaus</a>
                    - &copy; 2022
                </span>
            </div>
        </div>
    </div>

    @can('access', 'auth.loginas')
        @include('auth::loginas')
    @endcan

    
    <script async src="{{ asset('template/js/plugins/loaders/blockui.min.js') }}"></script>

    <script src="{{ asset('js/dropzone.min.js') }}"></script>

    <script defer src="{{ asset('template/js/plugins/forms/styling/switchery.min.js') }}"></script>
    <script defer src="{{ asset('template/js/plugins/editors/summernote/summernote.min.js') }}"></script>
    
    <script defer src="{{ asset('template/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script defer src="{{ asset('template/js/plugins/forms/inputs/duallistbox/duallistbox.min.js') }}"></script>
    <script defer src="{{ asset('template/js/plugins/notifications/sweet_alert.min.js') }}"></script>
    <script defer src="{{ asset('template/js/plugins/media/cropper.min.js') }}"></script>

    <script src="{{ asset('js/admin.js') }}?{{ uniqid() }}"></script>
    <script src="{{ asset('js/fulljaus.js') }}?{{ uniqid() }}"></script>
    <script src="{{ asset('js/form.js') }}?{{ uniqid() }}"></script>
    <script src="{{ asset('js/notifications.js') }}?{{ uniqid() }}"></script>
    @stack('scripts')
</body>
</html>
