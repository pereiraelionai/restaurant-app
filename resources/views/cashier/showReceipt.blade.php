<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Restaurant-Control - Recibo - Venda: {{$sale->id}}</title>

    <link rel="stylesheet" href="{{asset('/css/receipt.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{asset('/css/no-print.css')}}" type="text/css" media="print">

</head>
<body>
    <div id="wrapper">
        <div id="receipt-header">
            <h3 id="restaurant-name">Restaurant-Control</h3>
            <p>Endereço: Avenida Anchieta, 2985</p>
            <p>Bairro: Conceição São Paulo/SP</p>
            <p>Tel: 11 4789-6332</p>
            <p>Código: <strong>{{$sale->id}}</strong></p>
        </div>
        <div id="receipt-body">
            <table class="tb-sale-detail">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Qtd</th>
                        <th>Preço</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($saleDetails as $saleDetail)
                        <tr>
                            <td width="180" >{{$saleDetail->menu_name}}</td>
                            <td width="50" >{{$saleDetail->quantity}}</td>
                            <td width="55" >{{$saleDetail->menu_price}}</td>
                            <td width="65" >{{$saleDetail->menu_price * $saleDetail->quantity}}</td>                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="tb-sale-total">
                <tbody>
                    <tr>
                        <td>Quantidade Total</td>
                        <td>{{$saleDetails->count()}}</td>
                        <td>Total</td>
                        <td>R${{number_format($sale->total_price, 2)}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Tipo de pagamento</td>
                        <td colspan="2">{{$sale->payment_type}}</td>
                    </tr>
                    <tr>
                        <td colspan="3">Total recebido</td>
                        <td>R${{number_format($sale->total_recieved, 2)}}</td>
                    </tr>
                    <tr>
                        <td colspan="3">Troco</td>
                        <td>R${{number_format($sale->change, 2)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="receipt-footer">
            <p>Obrigado!</p>
        </div>
        <div id="buttons">
            <a href="/cashier">
                <button class="btn btn-back">Voltar</button>
            </a>
            <button class="btn btn-print" type="button" onclick="window.print(); return false;">Imprimir</button>
        </div>
    </div>
</body>
</html>
