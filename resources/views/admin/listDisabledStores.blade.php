@extends('layouts.adminApp')

@section('content')
<section id="users" class="top-break">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h3 class="text-primary">Negocios</h3><br>
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
                        <th>usuario</th>
                        <th>RIF</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody data-link="row" class="rowlink">
                    @foreach($stores as $store)
                        <tr>
                            <td>{{ $store->id }}</td>
                            <td>{{ $store->name }}</td>
                            <td>{{ $store->email }}</td>
                            <td>{{ $store->username }} </td>
                            <td>{{ $store->c_id }}</td>
                            <td><form action="{{ route('admin.storeEnable',['user'=>$store->id]) }}" method="post" class="list-buttons">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Estás seguro que quieres habilitar el Negocio?');" title="Habilitar negocio"><span class="glyphicon glyphicon-check"></span></button>
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
