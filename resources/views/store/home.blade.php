@extends('layouts.storeApp')

@section('head')
    {!! Charts::styles() !!}
@endsection

@section('content')
    <section id="sells" class="top-break">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h3 class="text-primary">Resumen de ventas</h3><br>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    {!! $lineChart->html() !!}
                </div>
                <div class="col-md-6 hidden-xs">
                    {!! $pieChart->html() !!}
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <br>
                    <h4 class="text-primary">Ventas de los &uacute;ltimos 7 d&iacute;</h4><br>
                </div>
                <div class="col-lg-6">
                    <br>
                    <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12  purchases-7d-table">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th class="hidden-xs">#</th>
                            <th>Nombre del cliente</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                        </tr>
                        </thead>
                        <tbody data-link="row" class="rowlink" id="myTable">
                        @foreach($purchasesList as $purchase)
                            <tr>
                                <td class="hidden-xs">{{ $purchase->id }}</td>
                                <td>{{ $purchase->user->name }}</td>
                                <td>{{ number_format($purchase->amount, 2)  }}</td>
                                <td>{{ \Carbon\Carbon::parse($purchase->created_at)->format('d/m/y h:i:s A') }} </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                </div>





            </div>
        </div>
    </section>
@endsection

@section('scripts')
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
    {!! Charts::scripts() !!}
    {!! $lineChart->script() !!}
    {!! $pieChart->script() !!}
@endsection
