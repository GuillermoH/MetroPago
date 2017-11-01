@extends('layouts.adminApp')

@section('head')
    {!! Charts::styles() !!}
@endsection

@section('content')
<section id="chart" class="top-break">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                {!! $chart->html() !!}
            </div>

        </div>
    </div>
</section>
<section id="users" class="top-break">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h3 class="text-primary">USUARIOS DESHABILITADOS</h3><br>
            </div>
            <div class="col-lg-6">
                <br>
                <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>E-mail</th>
                        <th>C.I</th>
                        <th># de Carnet</th>
                        <th>Tipo</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody data-link="row" class="rowlink" id="myTable">
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->c_id }} </td>
                            <td>{{ $user->username }} </td>
                            <td>{{ $user->type }}</td>
                            <td>
                                <form action="{{ route('admin.userEnable',['user'=>$user->id]) }}" method="post" class="list-buttons">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Estás seguro que desea habilitar el usuario?');" data-toggle="tooltip" title="Habilitar usuario"><span class="glyphicon glyphicon-check"></span></button>
                                </form>

                            </td>
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
    {!! $chart->script() !!}
@endsection