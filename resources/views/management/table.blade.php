@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('management.inc.sidebar')
            <div class="col-md-9">
                <i class="fas fa-chair"></i> Mesas
                <a class="btn btn-success btn-sm float-right" href="/management/table/create"><i class="fas fa-plus"></i> Criar mesa</a>
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
                            <th scope="col">Mesa</th>
                            <th scope="col">Status</th>
                            <th scope="col">Editar</th>
                            <th scope="col">Apagar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tables as $table)
                            <tr>
                                <td>{{$table->id}}</td>
                                <td>{{$table->name}}</td>
                                <td>{{$table->status}}</td>
                                <td>
                                    <a href="/management/table/{{$table->id}}/edit" class="btn btn-warning">Editar</a>
                                </td>
                                <td>
                                    <form action="/management/table/{{$table->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="Apagar" class="btn btn-danger">
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