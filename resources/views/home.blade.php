@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <h2>Usted posee distintos roles asociados a su cuenta, seleccione aquel que desee visualizar.</h2><br><br>
        @foreach($rl as $role)
            <div class="col-md-{{ 12/count($rl) }}">

                @if($role == "Admin")
                    <a class="btn btn-success btn-jumbo-home" href="{{ route(strtolower($role).'.home') }}" title="Entrar como {{ $role }}">
                        <i class="fa fa-sign-in"></i> Administrador
                    </a>
                @elseif($role == "Store")
                    <a class="btn btn-primary btn-jumbo-home" href="{{ route(strtolower($role).'.home') }}" title="Entrar como {{ $role }}">
                        <i class="fa fa-sign-in"></i> Negocio
                    </a>
                @elseif($role == "User")
                    <a class="btn btn-warning btn-jumbo-home" href="{{ route(strtolower($role).'.home') }}" title="Entrar como {{ $role }}">
                        <i class="fa fa-sign-in"></i> Usuario
                    </a>
                @endif
            </div>

        @endforeach
    </div>
</div>
@endsection
