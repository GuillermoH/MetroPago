@extends('layouts.adminApp')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar usuario</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('admin.updateUser', ["id"=>$user->id]) }}">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Nombre*</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail*</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">Carnet*</label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" name="username" value="{{ $user->username }}" required>

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('c_id') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">C&eacute;dula*</label>

                                <div class="col-md-6">
                                    <input id="c_id" type="text" class="form-control" name="c_id" value="{{ $user->c_id }}" required>

                                    @if ($errors->has('c_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('c_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" onclick="return confirm('¿Estás seguro que deseas editar el usario de {{ $user->name }}?');">
                                        Registrar cambio
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">Agregar fondos a {{ $user->name }}</div>


                    <div class="panel-body">
                        <form class="form-horizontal form-button" method="POST" action="{{ route('admin.depositUser', ["id"=>$user->id]) }}">
                        {{ csrf_field() }}
                            <input id="amount" type="hidden" class="form-control" name="amount" value="10000" required>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Valores gen&eacute;ricos:</label>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary" onclick="return confirm('¿Estás seguro que deseas agregar fondos a {{ $user->name }}?');">
                                        <span class="glyphicon glyphicon-plus"></span> Bs.F 10.000
                                    </button>
                                </div>
                            </div>
                        </form>
                        <form class="form-horizontal form-button" method="POST" action="{{ route('admin.depositUser', ["id"=>$user->id]) }}">
                            {{ csrf_field() }}
                            <input id="amount" type="hidden" class="form-control" name="amount" value="20000" required>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" onclick="return confirm('¿Estás seguro que deseas agregar fondos a {{ $user->name }}?');">
                                        <span class="glyphicon glyphicon-plus"></span> Bs.F 20.000
                                    </button>
                                </div>
                            </div>
                        </form>
                        <form class="form-horizontal form-button" method="POST" action="{{ route('admin.depositUser', ["id"=>$user->id]) }}">
                            {{ csrf_field() }}
                            <input id="amount" type="hidden" class="form-control" name="amount" value="50000" required>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" onclick="return confirm('¿Estás seguro que deseas agregar fondos a {{ $user->name }}?');">
                                        <span class="glyphicon glyphicon-plus"></span> Bs.F 50.000
                                    </button>
                                </div>
                            </div>
                        </form>
                        <form class="form-horizontal " method="POST" action="{{ route('admin.depositUser', ["id"=>$user->id]) }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                <label for="amount" class="col-md-4 control-label">Otro monto:</label>

                                <div class="col-md-6">
                                    <input id="amount" type="number" class="form-control" name="amount" value="" required>

                                    @if ($errors->has('amount'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" onclick="return confirm('¿Estás seguro que deseas agregar fondos a {{ $user->name }}?');">
                                        Agregar fondos
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
