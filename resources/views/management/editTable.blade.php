@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('management.inc.sidebar')
            <div class="col-md-8">
                <i class="fas fa-chair"></i> Editar mesa
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
                <form action="/management/table/{{$table->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="tableName">Nome da mesa</label>
                        <input type="text" name="name" value="{{$table->name}}" class="form-control" placeholder="Mesa" id="tableName">
                    </div>
                    <button type="submit" class="btn btn-warning" >Editar</button>
                </form>
            </div>
        </div>
    </div>
@endsection