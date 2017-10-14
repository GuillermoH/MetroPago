@extends('layouts.adminApp')

@section('content')
    @if (session('status'))
        <div class="container">
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        </div>
    @endif
    
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
                    </tr>
                    </thead>
                    <tbody data-link="row" class="rowlink">
                    @foreach($stores as $store)
                        <tr>
                            <td>{{ $store->id }}</td>
                            <td>{{ $store->name }}</td>
                            <td>{{ $store->email }}</td>
                            <td>{{ $store->username }} </td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>





        </div>
    </div>
</section>
@endsection
