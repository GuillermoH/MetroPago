@extends('layouts.adminApp')

{{--@section('head')--}}
    {{--{!! Charts::styles() !!}--}}
{{--@endsection--}}

@section('content')
{{--<section id="chart" class="top-break">--}}
    {{--<div class="container">--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-6 col-md-offset-3">--}}
                {{--{!! $chart->html() !!}--}}
            {{--</div>--}}

        {{--</div>--}}
    {{--</div>--}}
{{--</section>--}}
<section id="users" class="top-break">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h3 class="text-primary">DEP&Oacute;SITOS</h3>
                <h4 class="text-primary">Aprobados</h4>
            </div>
            <div class="col-lg-6">
                <br><br>
                <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="deposits-table">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Monto</th>
                            <th>Tipo</th>
                            <th>Referencia</th>
                            <th>Aprobado</th>
                            <th>Fecha</th>
                        </tr>
                        </thead>
                        <tbody data-link="row" class="rowlink" id="myTable">
                        @foreach($approvedDeposits as $deposit)
                            <tr>
                                <td>{{ $deposit->id }}</td>
                                <td>{{ $deposit->user->name }}</td>
                                <td>{{ $deposit->amount }}</td>
                                <td>{{ $deposit->type }} </td>
                                <td>{{ $deposit->reference }}</td>
                                <td>{{ $deposit->approved }} </td>
                                <td>{{ $deposit->created_at }}</td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <h4 class="text-primary">Transferencias por confirmar</h4>
            </div>
            <div class="col-lg-6">
                <h4 class="text-primary">Transferencias rechazadas</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="deposits-table">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Monto</th>
                            <th>Referencia</th>
                            <th>Fecha</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody data-link="row" class="rowlink">
                        {{--@foreach($needApprovalDeposits as $deposit)--}}
                            {{--<tr class="warning">--}}
                                {{--<td>{{ $deposit->user->name }}</td>--}}
                                {{--<td>{{ $deposit->amount }}</td>--}}
                                {{--<td>{{ $deposit->reference }}</td>--}}
                                {{--<td>{{ $deposit->created_at }}</td>--}}
                                {{--<td>--}}
                                    {{--<form action="{{ route('admin.updateDeposit', ["id" => $deposit->id]) }}" method="post" class="list-buttons">--}}
                                        {{--{{ csrf_field() }}--}}
                                        {{--{{ method_field('PUT') }}--}}
                                        {{--<input type="hidden" id="newStatus" name="newStatus" value="1">--}}
                                        {{--<button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Estás seguro que la transferencia fue procesada?');" data-toggle="tooltip" title="Aprobar Transferencia"><i class="fa fa-check"></i></button>--}}
                                    {{--</form>--}}
                                    {{--<form action="{{ route('admin.updateDeposit', ["id" => $deposit->id]) }}" method="post" class="list-buttons">--}}
                                        {{--{{ csrf_field() }}--}}
                                        {{--{{ method_field('PUT') }}--}}
                                        {{--<input type="hidden" id="newStatus" name="newStatus" value="2">--}}
                                        {{--<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro que la transferencia no se hizo?');" data-toggle="tooltip" title="Rechazar transferencia"><i class="fa fa-times"></i></button>--}}
                                    {{--</form>--}}

                                {{--</td>--}}
                            {{--</tr>--}}

                        {{--@endforeach--}}

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="col-md-6">
                <div class="deposits-table">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Monto</th>
                            <th>Referencia</th>
                            <th>Fecha</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody data-link="row" class="rowlink">
                        {{--@foreach($deniedDeposits as $deposit)--}}
                            {{--<tr class="danger">--}}
                                {{--<td>{{ $deposit->user->name }}</td>--}}
                                {{--<td>{{ $deposit->amount }}</td>--}}
                                {{--<td>{{ $deposit->reference }}</td>--}}
                                {{--<td>{{ $deposit->created_at }}</td>--}}

                                {{--<td>--}}
                                    {{--<form action="{{ route('admin.updateDeposit', ["id" => $deposit->id]) }}" method="post" class="list-buttons">--}}
                                        {{--{{ csrf_field() }}--}}
                                        {{--{{ method_field('PUT') }}--}}
                                        {{--<input type="hidden" id="newStatus" name="newStatus" value="1">--}}
                                        {{--<button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('¿Estás seguro que la transferencia fue procesada?');" data-toggle="tooltip" title="Aprobar Transferencia"><i class="fa fa-check"></i></button>--}}
                                    {{--</form>--}}

                                {{--</td>--}}
                            {{--</tr>--}}

                        {{--@endforeach--}}

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
    {{--{!! Charts::scripts() !!}--}}
    {{--{!! $chart->script() !!}--}}\
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    </script>
@endsection