@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in as :
                        @foreach($rl as $role)
                            {{ $role }}
                        @endforeach!

                    @foreach($rl as $role)
                        <a class="btn btn-primary btn-lg" href="{{ route(strtolower($role).'.home') }}">{{ $role }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
