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
                <i class="fas fa-align-justify"></i> Editar Categoria
                <hr>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="/management/category/{{$category->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="categoryName">Nome da categoria</label>
                        <input type="text" name="name" value="{{$category->name}}" class="form-control" placeholder="Categoria" id="categoryName">
                    </div>
                    <button type="submit" class="btn btn-warning" >Editar</button>
                </form>
            </div>
        </div>
    </div>
@endsection