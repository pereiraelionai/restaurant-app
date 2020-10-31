@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('management.inc.sidebar-tenant')
            <div class="col-md-8">
                <i class="fas fa-user-plus"></i> Criar usuário
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
                <form action="/master/usuario" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" name="name" class="form-control" placeholder="Nome" id="name">
                    </div>
                    <div class="form-group">
                        <label for="db_chave">Chave</label>
                        <input type="text" name="db_chave" class="form-control" placeholder="Chave" id="db_chave">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" name="password" class="form-control" placeholder="Senha" id="password">
                    </div>
                    <div class="form-group">
                        <label for="role">Função</label>
                        <select name="role"class="form-control">
                            <option value="admin-master">Admin-master</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" >Salvar</button>
                </form>
            </div>
        </div>
    </div>
@endsection