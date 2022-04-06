<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Bridgestone OMS</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,300,100,500,700,900" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Custom Theme Style -->
		<link href="{{ asset('css/login.css') }}" rel="stylesheet">

		<style>
			.vlogin {
				background: #F7F7F7 url('/Admin/Assets/images/background.jpg') no-repeat fixed center;
				background-size: cover;
			}
            .login {
                margin: 2% auto;
            }
		</style>
	</head>
	<body class="vlogin text-center">

        <div class="wrapper fadeInDown">
            <div id="formContent">

                <form id="formLogin" class="login" method="POST" action="{{ route('auth.do_login') }}">
                    @csrf
                    @include('Admin.Views.messages')

                    <div class="fadeIn first">
                        <img class="mb-4" src="{{ asset('images/logo.png') }}" class="img-responsive" alt="" width="72" height="72">
                        <h3>Bridgestone OMS</h3>
                    </div>

                    <input type="text" name="username" value="{{ old('username') }}" class="form-control fadeIn second" placeholder="{{__('messages.placeholderEmailIndex')}}" required autocomplete="off" />
			        <input id="password" type="password" class="form-control fadeIn third" name="password" required autocomplete="off" placeholder="{{__('messages.placeholderPasswordIndex')}}">
                    <button class="mt-5 mb-5 btn btn-lg btn-primary btn-block fadeIn fourth" type="submit">{{__('messages.submitIndex')}}</button>
                </form>

                <div id="formFooter">
                    <a class="underlineHover" href="#">{{__('messages.forgotPasswordIndex')}}</a>
                </div>

            </div>
        </div>

        <script type="text/javascript">
            // si viene por la app de Android
            if (/Fulljaus Android/i.test(navigator.userAgent)) {
                var input = document.createElement("input");
                input.setAttribute("type", "hidden");
                input.setAttribute("name", "remember");
                input.setAttribute("value", "1");

                document.getElementById('formLogin').append(input);
            }
        </script>
	</body>
</html>
