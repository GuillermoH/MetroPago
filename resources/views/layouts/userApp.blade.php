<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">

    @yield('head')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ route('user.home') }}">
                        {{--{{ config('app.name', 'Laravel') }}--}}
                        <img class="navbar-logo" src="{{asset('img/logo-metropago.png')}}" alt="logo Metro Pago">
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        {{--&nbsp;<li><a href="{{ route('user.addFunds') }}">Agregar fondos</a></li>--}}
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Agregar Fondos <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a data-toggle="modal" data-target="#transferModal" href="">
                                        Registrar Transferencia
                                    </a>
                                </li>
                                <li>
                                    <a href="" data-toggle="modal" data-target="#creditModal">
                                        Con tarjeta de Cr&eacute;dito
                                    </a>
                                </li>
                                {{--<li>--}}
                                    {{--<a href="">--}}
                                        {{--Status de transacciones--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                            </ul>
                        </li>
                        <li><a href="{{ route('user.viewBalance') }}">Balances</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @if (session('status'))
            <div class="container">
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            </div>
        @endif
        @if (session('warning'))
            <div class="container">
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            </div>
        @endif
        @if (session('danger'))
            <div class="container">
                <div class="alert alert-danger">
                    {{ session('danger') }}
                </div>
            </div>
        @endif

        <div class="modal fade" id="transferModal" role="dialog">
            <div class="modal-dialog">
                <form class="form-horizontal" method="POST" action="{{ route('user.storeDeposit') }}">
                    {{ csrf_field() }}
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Registrar una transferencia</h4>
                        </div>
                        <div class="modal-body">
                            <p>Llenar los datos a continuaci&oacute;n, los mismos seran validados entre 24 y 48 horas por nuestro personal administrativo.</p>
                            <br>

                            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-5 control-label">Monto de la transferencia*</label>

                                <div class="col-md-7">
                                    <input id="amount" type="number" class="form-control" name="amount" value="{{ old('amount') }}" required>

                                    @if ($errors->has('amount'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('reference') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-5 control-label">Referencia Bancaria*</label>

                                <div class="col-md-7">
                                    <input id="reference" type="text" class="form-control" name="reference" value="{{ old('reference') }}" required>

                                    @if ($errors->has('reference'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('reference') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" value="Transferencia" id="type" name="type">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            {{--<div class="form-group">--}}
                                {{--<button type="submit" class="btn btn-primary">--}}
                                    {{--Registrar--}}
                                {{--</button>--}}
                            {{--</div>--}}
                            <button type="submit" class="btn btn-primary">
                                Registrar
                            </button>
                        </div>
                    </div>
                </form>



            </div>
        </div>

        <div class="modal fade" id="creditModal" role="dialog">
            <div class="modal-dialog">
                <form class="form-horizontal" method="POST" action="{{ route('user.storeDeposit') }}" id="creditForm">
                {{ csrf_field() }}
                <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Registrar una transferencia</h4>
                        </div>
                        <div class="modal-body" id="creditBody">
                            <div class="alert alert-warning" id="empty-warning" hidden>
                                Debe completar <b>todos</b> los campos
                            </div>
                            <p>Complete los datos para agregar fondos a su cuenta mediante una tarjeta de cr&eacute;dito.</p>
                            <br>

                            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-5 control-label">Monto a cobrar*</label>

                                <div class="col-md-7">
                                    <input id="amount" type="number" class="form-control" name="amount" value="{{ old('amount') }}" required>

                                    @if ($errors->has('amount'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-5 control-label">Tarjeta*</label>
                                <div class="col-md-5">
                                    <input type="number" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" placeholder="CVC" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-5 control-label">Fecha de vencimiento*</label>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" placeholder="DD" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" placeholder="MM" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" placeholder="AAAA" required>
                                </div>
                            </div>
                            <input type="hidden" value="TDC" id="type" name="type">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" onclick="creditSubmit()">
                                Registrar
                            </button>
                        </div>
                    </div>
                </form>



            </div>
        </div>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
    <script>
        function creditSubmit() {
            var errors = 0;
            $("#creditBody :input").map(function(){

                if( !$(this).val() ) {
                    errors++;
                }

            });
            if (errors > 0){
                $('#empty-warning').removeAttr('hidden');
            }else if(errors == 0){
                waitingDialog.show('Confirmando transaccion', {dialogSize: 'md', progressType: 'warning'});
                setTimeout(function () {
                    waitingDialog.hide();
                    $('#creditForm').submit();
                }, 5000);
            }

        }
    </script>
    <script>
        var waitingDialog = waitingDialog || (function ($) {
                    'use strict';

                    // Creating modal dialog's DOM
                    var $dialog = $(
                            '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
                            '<div class="modal-dialog modal-m">' +
                            '<div class="modal-content">' +
                            '<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
                            '<div class="modal-body">' +
                            '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
                            '</div>' +
                            '</div></div></div>');

                    return {
                        /**
                         * Opens our dialog
                         * @param message Custom message
                         * @param options Custom options:
                         * 				  options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
                         * 				  options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
                         */
                        show: function (message, options) {
                            // Assigning defaults
                            if (typeof options === 'undefined') {
                                options = {};
                            }
                            if (typeof message === 'undefined') {
                                message = 'Loading';
                            }
                            var settings = $.extend({
                                dialogSize: 'm',
                                progressType: '',
                                onHide: null // This callback runs after the dialog was hidden
                            }, options);

                            // Configuring dialog
                            $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
                            $dialog.find('.progress-bar').attr('class', 'progress-bar');
                            if (settings.progressType) {
                                $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
                            }
                            $dialog.find('h3').text(message);
                            // Adding callbacks
                            if (typeof settings.onHide === 'function') {
                                $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
                                    settings.onHide.call($dialog);
                                });
                            }
                            // Opening dialog
                            $dialog.modal();
                        },
                        /**
                         * Closes dialog
                         */
                        hide: function () {
                            $dialog.modal('hide');
                        }
                    };

                })(jQuery);
    </script>
</body>
</html>
