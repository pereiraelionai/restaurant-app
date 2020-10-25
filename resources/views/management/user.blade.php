@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('management.inc.sidebar')
            <div class="col-md-9">
                <i class="fas fa-users"></i> Usuários
                <a class="btn btn-success btn-sm float-right" href="/management/user/create"><i class="fas fa-plus"></i> Criar Usuário</a>
                <hr>
                @if (Session()->has('status'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" >x</button>
                        {{Session()->get('status')}}
                    </div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Função</th>
                            <th scope="col">Email</th>
                            <th scope="col">Editar</th>
                            <th scope="col">Apagar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->role}}</td>
                                <td>{{$user->email}}</td>
                                <td><a href="/management/user/{{$user->id}}/edit" class="btn btn-warning btn-sm">Editar</a></td>
                                <td>
                                    <form action="/management/user/{{$user->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="Apagar" class="btn btn-danger btn-sm">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
@endsection