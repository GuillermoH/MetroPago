@extends('layouts.adminApp')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Registrar usuario</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('admin.storeUser') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Nombre*</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

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
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

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
                                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required>

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
                                    <input id="c_id" type="text" class="form-control" name="c_id" value="{{ old('c_id') }}" required>

                                    @if ($errors->has('c_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('c_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('uid') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">UID</label>

                                <div class="col-md-6">
                                    <input id="uid" type="text" class="form-control" name="uid" value="{{ old('uid') }}">

                                    @if ($errors->has('uid'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('uid') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                <label for="type" class="col-md-4 control-label">Tipo de usuario:</label>

                                <div class="col-md-6">
                                    <select name="type" id="type" class="form-control">
                                        <option value="Estudiante" selected>Estudiante</option>
                                        <option value="Profesor">Profesor</option>
                                        <option value="Empleado">Empleado</option>

                                    </select>

                                    @if ($errors->has('type'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
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
