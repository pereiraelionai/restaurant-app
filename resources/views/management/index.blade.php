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
                
            </div>
        </div>
    </div>
@endsection