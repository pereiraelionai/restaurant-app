@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('management.inc.sidebar')
            <div class="col-md-8">
                <i class="fas fa-drumstick-bite"></i> Adicionar ao cardápio
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
                <form action="/management/menu" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="menuName">Nome</label>
                        <input type="text" name="name" class="form-control" placeholder="Digite o nome do prato" id="menuName">
                    </div>
                    <div class="row">
                        <div class="col-4 margem">
                            <label for="menuPrice">Preço</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">R$</span>
                                </div>
                                <input type="text" name="price" class="form-control" aria-label="Amount(to the nearest dollor)">
                                <div class="inout-grooup-append">
                                    <span class="input-group-text">,00</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <label for="menuImage">Imagem</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="inputGroupFile01">
                                    <label class="custom-file-label" for="inputGroupFile01">Escolha o arquivo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Category">Categoria</label>
                        <select class="form-control" name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Description">Descrição</label>
                        <input type="text" name="description" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary" >Salvar</button>
                </form>
            </div>
        </div>
    </div>
@endsection