<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MetroPago</title>

        <!-- Fonts -->
        {{--<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">--}}

        <!-- Styles -->
        <style>
            /*fonts*/
            /* latin-ext */
            @font-face {
                font-family: 'Raleway';
                font-style: normal;
                font-weight: 100;
                src: local('Raleway Thin'), local('Raleway-Thin'), url(/fonts/raleway/rr0ijB5_2nAJsAoZ6vECXRJtnKITppOI_IvcXXDNrsc.woff2) format('woff2');
                unicode-range: U+0100-024F, U+1E00-1EFF, U+20A0-20AB, U+20AD-20CF, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
                font-family: 'Raleway';
                font-style: normal;
                font-weight: 100;
                src: local('Raleway Thin'), local('Raleway-Thin'), url(/fonts/raleway/RJMlAoFXXQEzZoMSUteGWFtXRa8TVwTICgirnJhmVJw.woff2) format('woff2');
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215;
            }
            /* latin-ext */
            @font-face {
                font-family: 'Raleway';
                font-style: normal;
                font-weight: 600;
                src: local('Raleway SemiBold'), local('Raleway-SemiBold'), url(/fonts/raleway/STBOO2waD2LpX45SXYjQBSEAvth_LlrfE80CYdSH47w.woff2) format('woff2');
                unicode-range: U+0100-024F, U+1E00-1EFF, U+20A0-20AB, U+20AD-20CF, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
                font-family: 'Raleway';
                font-style: normal;
                font-weight: 600;
                src: local('Raleway SemiBold'), local('Raleway-SemiBold'), url(/fonts/raleway/xkvoNo9fC8O2RDydKj12b_k_vArhqVIZ0nv9q090hN8.woff2) format('woff2');
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215;
            }

            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #dfeff3;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }


            .alert {
                padding: 15px;
                margin-bottom: 22px;
                border: 1px solid transparent;
                border-radius: 4px;
            }

            .alert h4 {
                margin-top: 0;
                color: inherit;
            }

            .alert .alert-link {
                font-weight: bold;
            }

            .alert > p,
            .alert > ul {
                margin-bottom: 0;
            }

            .alert > p + p {
                margin-top: 5px;
            }

            .alert-dismissable,
            .alert-dismissible {
                padding-right: 35px;
            }

            .alert-dismissable .close,
            .alert-dismissible .close {
                position: relative;
                top: -2px;
                right: -21px;
                color: inherit;
            }

            .alert-success {
                background-color: #dff0d8;
                border-color: #d6e9c6;
                color: #3c763d;
            }

            .alert-success hr {
                border-top-color: #c9e2b3;
            }

            .alert-success .alert-link {
                color: #2b542c;
            }

            .alert-info {
                background-color: #d9edf7;
                border-color: #bce8f1;
                color: #31708f;
            }

            .alert-info hr {
                border-top-color: #a6e1ec;
            }

            .alert-info .alert-link {
                color: #245269;
            }

            .alert-warning {
                background-color: #fcf8e3;
                border-color: #faebcc;
                color: #8a6d3b;
            }

            .alert-warning hr {
                border-top-color: #f7e1b5;
            }

            .alert-warning .alert-link {
                color: #66512c;
            }

            .alert-danger {
                background-color: #f2dede;
                border-color: #ebccd1;
                color: #a94442;
            }

            .alert-danger hr {
                border-top-color: #e4b9c0;
            }

            .alert-danger .alert-link {
                color: #843534;
            }


            #main-page{
                /* The image used */
                background:
                        linear-gradient(
                                rgba(15, 0, 17, 0.54),
                                rgba(15, 0, 17, 0.54)
                        ),
                        url({{ url("/img/landing.jpg") }});
                /*background-image: url();*/

                /* Full height */
                height: 100%;

                /* Center and scale the image nicely */
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }

            .welcome-logo{
                width: 30%;
                height: auto;
            }

        </style>
    </head>
    <body>
    <div class="container" id="main-page">
        @if (session('warning'))
            <div class="container">
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            </div>
        @endif
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Inicio</a>
                    @else
                        <a href="{{ url('/login') }}">Iniciar sesi&oacute;n</a>
                        {{--<a href="{{ url('/register') }}">Register</a>--}}
                    @endif
                </div>
            @endif

            <div class="content">
                <a href="@if (Auth::check())
                        {{ url('/home') }}
                @else
                    {{ url('/login') }}
                    {{--<a href="{{ url('/register') }}">Register</a>--}}
                @endif">
                    <img class="welcome-logo" src="{{asset('img/logo-metropago.png')}}" alt="logo Metro Pago">
                </a>


                {{--<div class="links">--}}
                    {{--<a href="https://laravel.com/docs">Documentation</a>--}}
                    {{--@if (Auth::check())--}}
                        {{--<a href="{{ url('/home') }}">Inicio</a>--}}
                    {{--@else--}}
                        {{--<a href="{{ url('/login') }}">Inicias sesi&oacute;n</a>--}}
                        {{--<a href="{{ url('/register') }}">Register</a>--}}
                    {{--@endif--}}
                    {{--<a href="https://laracasts.com">Laracasts</a>--}}
                    {{--<a href="https://laravel-news.com">News</a>--}}
                    {{--<a href="https://forge.laravel.com">Forge</a>--}}
                    {{--<a href="https://github.com/laravel/laravel">GitHub</a>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>

    </body>
</html>
