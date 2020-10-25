@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home">Menu principal</a></li>
                        <li class="breadcrumb-item"><a href="/report">Relatórios</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Resultado</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
                <div class="col-md-12">
                    @if ($sales->count() > 0)
                        <div class="alert alert-success" role="alert">
                            <p>Total de vendas de {{$dateStart}} a {{$dateEnd}} é R$ {{number_format($totalSale, 2)}}</p>
                            <p>Total de vendas: {{$sales->total()}}</p>
                        </div>
                        <table class="table">
                            <thead>
                                <tr class="bg-primary text-light">
                                    <th scope="col">*</th>
                                    <th scope="col">Cod Recibo</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Mesa</th>
                                    <th scope="col">Funcionário</th>
                                    <th scope="col">Valor total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $countSale = ($sales->currentPage() -1) * $sales->perPage() +1;
                                @endphp
                                @foreach ($sales as $sale)
                                    <tr class="bg-secondary text-light">
                                        <td>{{$countSale++}}</td>
                                        <td>{{$sale->id}}</td>
                                        <td>{{date("d/m/Y", strtotime($sale->updated_at))}}</td>
                                        <td>{{$sale->table_name}}</td>
                                        <td>{{$sale->user_name}}</td>
                                        <td>R$ {{$sale->total_price}}</td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th>Cod</th>
                                        <th>Cardápio</th>
                                        <th>Quantidade</th>
                                        <th>Preço</th>
                                        <th>Total</th>
                                    </tr>
                                    @foreach ($sale->saleDetails as $saleDetail)
                                        <tr>
                                            <td></td>
                                            <td>{{$saleDetail->menu_id}}</td>
                                            <td>{{$saleDetail->menu_name}}</td>
                                            <td>{{$saleDetail->quantity}}</td>
                                            <td>R$ {{$saleDetail->menu_price}}</td>
                                            <td>R$ {{$saleDetail->menu_price * $saleDetail->quantity}}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                        {{$sales->appends($_GET)->links()}}
                        <form action="/report/show/export" method="get">
                            <input type="hidden" name="dateStart" value="{{$dateStart}}">
                            <input type="hidden" name="dateEnd" value="{{$sale->updated_at}}">
                            <input type="submit" class="btn btn-warning" value="Exportar Excel">
                        </form>
                    @else
                        <div class="alert alert-danger" role="alert">
                            Não existe vendas para o periodo informado
                        </div>
                    @endif
                </div>
        </div>
    </div>
@endsection
