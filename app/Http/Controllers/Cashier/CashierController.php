<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Table;
use App\Category;
use App\Menu;
use App\Sale;
use App\SalesDetail;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    public function index() {
        $categories = Category::all();
        return view('cashier.index')->with('categories', $categories);
    }

    public function getTables() {
        $tables = Table::all();
        $html = '';
        foreach($tables as $table) {
            $html .= '<div class="col-md-2 mb-5">';
            $html .= 
            '<button class="btn btn-primary btn-table" data-id="'.$table->id.'" data-name="'.$table->name.'">
            <img class="img-fluid" src="'.url('/images/table-2.svg').'"/>
            <br>
            <span class="badge badge-success"> '.$table->name.'</span>
            </button>';
            $html .= '</div>';
        }
        return $html;
    }

    public function getMenuByCategory($category_id) {
        $menus = Menu::where('category_id', $category_id)->get();
        $html = '';
        foreach($menus as $menu) {
            $html .= '
            <div class="col-md-3 text-center">
                <a class="btn btn-outline-secondary btn-menu" data-id="'.$menu->id.'">
                    <img class="img-fluid" src="'.url('/menu_images/'.$menu->image).'">
                    <br>
                    '.$menu->name.'
                    <br>
                    R$'.number_format($menu->price).'
                </a>
            </div>
            ';
        }
        return $html;
    }

    public function orderFood(Request $request) {
        $menu = Menu::find($request->menu_id);
        $table_id = $request->table_id;
        $table_name = $request->table_name;
        $sale = Sale::where('table_id', $table_id)->where('sale_status', 'Não pago')->first();
        //se não houver venda selecionada na mesa, criamos uma nova
        if(!$sale) {
            $user = Auth::user();
            $sale = new Sale();
            $sale->table_id = $table_id;
            $sale->table_name = $table_name;
            $sale->user_id = $user->id;
            $sale->user_name = $user->name;
            $sale->save();
            $sale_id = $sale->id;
            //atualizar status da mesa
            $table = Table::find($table_id);
            $table->status = 'Indisponível';
            $table->save();
        } else {//tem uma venda na mesa selecionada
            $sale_id = $sale->id;
        }

        //adicionando pedido do menu nos detalhes do pedido
        $saleDetail = new SalesDetail();
        $saleDetail->sale_id = $sale_id;
        $saleDetail->menu_id = $menu->id;
        $saleDetail->menu_name = $menu->name;
        $saleDetail->menu_price = $menu->price;
        $saleDetail->quantity = $request->quantity;
        $saleDetail->save();
        //atualizar preço total em detalhes da venda
        $sale->total_price = $sale->total_price + ($request->quantity * $menu->price);
        $sale->save();

        $html = $this->getSaleDetail($sale_id);

        return $html;

    }

    private function getSaleDetail($sale_id) {
        //listar todos os detalhes da venda
        $html = '<p>Código da venda: '.$sale_id.'</p>';
        $saleDetail = SalesDetail::where('sale_id', $sale_id)->get();
        $html .= '
            <div class="table-responsive-md" style="overflow-y:scroll; height: 400px; border: 1px solid #343A40;">
                <table class="table table-scripped table-dark">
                    <thead>
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Item</th>
                            <th scope="col">Qtd</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Total</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        foreach($saleDetail as $sale) {
            $html .= '
                <tr>                        <td>'.$sale->menu_id.'</td>
                    <td>'.$sale->menu_name.'</td>
                    <td>'.$sale->quantity.'</td>
                    <td>'.$sale->menu_price.'</td>
                    <td>'.($sale->menu_price * $sale->quantity).'</td>
                    <td>'.$sale->status.'</td>
                </tr>
                ';
        }
            $html .= '</tbody></table></div>';
            return $html;
    }
}
