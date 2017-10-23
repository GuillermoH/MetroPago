@extends('layouts.adminApp')

@section('head')
    {!! Charts::styles() !!}
@endsection

@section('content')
<div class="container">
    <div class="row">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="col-md-6 top-break">
            <a class="btn btn-primary btn-jumbo" href="{{ route('admin.listUsers') }}" title="Total de usuarios registrados">
                <i class="fa fa-user"></i> &nbsp;&nbsp;=&nbsp;&nbsp; <span>{{ $userCount[0] }}</span>
            </a>
        </div>
        <div class="col-md-6">
            <a class="btn btn-success btn-jumbo" href="{{ route('admin.listStores') }}" title="Total de negocios registrados">
                <i class="fa fa-home"></i> &nbsp;&nbsp;=&nbsp;&nbsp;{{ $userCount[1] }}
            </a>
        </div>
        <div class="col-md-6">
            {!! $barChart->html() !!}
        </div>
        <div class="col-md-6">
            {!! $lineChart->html() !!}
        </div>

        {{--<div class="col-md-8 col-md-offset-2">--}}
            {{--<div class="panel panel-default">--}}
                {{--<div class="panel-heading">Dashboard</div>--}}

                {{--<div class="panel-body">--}}
                    {{--@if (session('status'))--}}
                        {{--<div class="alert alert-success">--}}
                            {{--{{ session('status') }}--}}
                        {{--</div>--}}
                    {{--@endif--}}
                    {{--{!! $chart->html() !!}--}}
                    {{--<h1>Dashboard de Administrador</h1>--}}
                    {{--<h3>Aqui van estadisticas y graficos</h3>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>
</div>
@endsection

@section('scripts')
    {!! Charts::scripts() !!}
    {!! $lineChart->script() !!}
    {!! $barChart->script() !!}
@endsection
