@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('management.inc.sidebar')
            <div class="col-md-8">
                <i class="fas fa-align-justify"></i> Criar Categoria
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
                <form action="/management/category" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="categoryName">Nome da categoria</label>
                        <input type="text" name="name" class="form-control" placeholder="Categoria" id="categoryName">
                    </div>
                    <button type="submit" class="btn btn-primary" >Salvar</button>
                </form>
            </div>
        </div>
    </div>
@endsection