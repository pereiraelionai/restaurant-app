@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('management.inc.sidebar')
            <div class="col-md-9">
                <i class="fas fa-drumstick-bite"></i> Cardápio
                <a class="btn btn-success btn-sm float-right" href="/management/menu/create"><i class="fas fa-plus"></i> Criar Cardápio</a>
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
                            <th scope="col">Preço</th>
                            <th scope="col">Imagem</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Editar</th>
                            <th scope="col">Apagar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $menu)
                            <tr>
                                <td>{{$menu->id}}</td>
                                <td>{{$menu->name}}</td>
                                <td>{{$menu->price}}</td>
                                <td>
                                    <img src="{{asset('menu_images')}}/{{$menu->image}}" alt="{{$menu->name}}" width="120px" height="100px" class="image-thumbnail">
                                </td>
                                <td>{{$menu->description}}</td>
                                <td>{{$menu->category->name}}</td>
                                <td><a href="/management/menu/{{$menu->id}}/edit" class="btn btn-warning btn-sm">Editar</a></td>
                                <td>
                                    <form action="/management/menu/{{$menu->id}}" method="POST">
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