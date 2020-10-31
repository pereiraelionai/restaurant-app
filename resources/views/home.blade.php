@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Funções</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row text-center">
                        @if (Auth::user()->checkAdmin())
                        <div class="col-sm-4">
                            <a href="{{Auth::user()->db_chave == 'restaurante' ? "master" : "management"}}">
                                <h4>Gerenciar</h4>
                                <img width="70px" src="{{asset('images/product-management.svg')}}">
                            </a>
                        </div>
                        @endif
                        <div class="col-sm-4">
                            <a href="/cashier">
                                <h4>Caixa</h4>
                                <img width="70px" src="{{asset('images/cashier-machine.svg')}}">
                            </a>
                        </div>
                        @if (Auth::user()->checkAdmin())
                        <div class="col-sm-4">
                            <a href="/report">
                                <h4>Relatórios</h4>
                                <img width="70px" src="{{asset('images/business-report.svg')}}">
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
