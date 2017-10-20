@extends('layouts.adminApp')

@section('content')
<section id="users" class="top-break">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h3 class="text-primary">USUARIOS</h3><br>
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
                        <th></th>
                    </tr>
                    </thead>
                    <tbody data-link="row" class="rowlink">
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->c_id }} </td>
                            <td>{{ $user->username }} </td>
                            <td><form action="{{ route('admin.userDestroy',['user'=>$user->id]) }}" method="post" class="list-buttons">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-default btn-sm" onclick="return confirm('¿Estás seguro que quieres borrar el usuario?');"><span class="glyphicon glyphicon-remove"></span></button>
                                </form>
                                <div class="list-buttons">
                                    <a class="btn btn-default btn-sm" href="{{ route('admin.editUser', ["id" => $user->id]) }}"><span class="glyphicon glyphicon-pencil"></span></a>
                                </div>
                                {{--<form action="{{ route('admin.userDestroy',['user'=>$user->id]) }}" method="post" class="list-buttons">--}}
                                    {{--{{ csrf_field() }}--}}
                                    {{--{{ method_field('DELETE') }}--}}
                                    {{--<button type="submit" class="btn btn-default btn-sm" onclick="return confirm('¿Estás seguro que quieres borrar la inversion?');"><span class="glyphicon glyphicon-pencil"></span></button>--}}
                                {{--</form>--}}
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
