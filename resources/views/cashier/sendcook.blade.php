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
            <h3 id="restaurant-name">Preparar Pedido</h3>
            <p>Código: <strong>{{$sale->id}}</strong></p>
            <p>Mesa: <strong>{{$sale->table_name}}</strong></p>
        </div>
        <div id="receipt-body">
            <table class="tb-sale-detail">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Qtd</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($saleDetails as $saleDetail)
                        <tr>
                            <td width="180" >{{$saleDetail->menu_name}}</td>
                            <td width="50" >{{$saleDetail->quantity}}</td>                         
                        </tr>
                    @endforeach
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
