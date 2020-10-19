@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="list-group">
                    <a href="/management/category" class="list-group-item list-group-item-action"><i class="fas fa-align-justify"></i> Categoria</a>
                    <a href="/management/menu" class="list-group-item list-group-item-action"><i class="fas fa-drumstick-bite"></i> Menu</a>
                    <a href="/management/table" class="list-group-item list-group-item-action"><i class="fas fa-chair"></i> Mesas</a>
                    <a href="/management/users" class="list-group-item list-group-item-action"><i class="fas fa-users-cog"></i> Usuários</a>
                </div>
            </div>
            <div class="col-md-8">
                <i class="fas fa-align-justify"></i> Categoria
                <a class="btn btn-success btn-sm float-right" href="/management/category/create"><i class="fas fa-plus"></i> Criar categoria</a>
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
                            <th scope="col">Categoria</th>
                            <th scope="col">Editar</th>
                            <th scope="col">Apagar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <th scope="row">{{$category->id}}</th>
                                <td>{{$category->name}}</td>
                                <td>
                                    <a href="/management/category/{{$category->id}}/edit " class="btn btn-warning">Editar</a>
                                </td>
                                <td>
                                    <form action="/management/category/{{$category->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="Apagar" class="btn btn-danger">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$categories->links()}}
            </div>
        </div>
    </div>
@endsection