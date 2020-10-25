<table>
    <thead>
        <tr>
            <th>*</th>
            <th>Cod Recibo</th>
            <th>Data</th>
            <th>Mesa</th>
            <th>Funcionário</th>
            <th>Valor total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $countSale = 1;
        @endphp
        @foreach ($sales as $sale)
            <tr>
                <td>{{$countSale++}}</td>
                <td>{{$sale->id}}</td>
                <td>{{date("d/m/Y", strtotime($sale->upedated_at))}}</td>
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
        <tr>
            <td colspan="5">Valor total de {{$dateStart}} a {{$dateEnd}}</td>
            <td>{{number_format($totalSale, 2)}}</td>
        </tr>
    </tbody>
</table>