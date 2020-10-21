@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="table-datail"></div>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <button class="btn btn-primary btn-block" id="btn-show-table">Ver mesas</button>
            <div class="selected-table"></div>
            <div id="order-detail"></div>
        </div>
        <div class="col-md-7">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    @foreach ($categories as $category)
                        <a class="nav-item nav-link" data-id="{{$category->id}}" data-toggle="tab" href="">
                            {{$category->name}}
                        </a>
                    @endforeach
                </div>
            </nav>
            <div class="row mt-2" id="list-menu"></div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        //faz as mesas sumirem
        $("#table-datail").hide();
        //mostrar todas as mesas quando clicar
        $("#btn-show-table").click(function() {
            if($("#table-datail").is(":hidden")) {
                $.get("/cashier/getTable", function(data) {
                    $("#table-datail").html(data);
                    $("#table-datail").slideDown('fast');
                    $("#btn-show-table").html('Esconder mesas').removeClass('btn-primary').addClass('btn-danger')
                })
            } else {
                $("#table-datail").slideUp('fast');
                $("#btn-show-table").html('Ver mesas').removeClass('btn-danger').addClass('btn-primary')
            }

        });

        //carregar cardápio
        $(".nav-link").click(function(){
            $.get("/cashier/getMenuByCategory/" + $(this).data('id'), function(data) {
                $("#list-menu").hide();
                $("#list-menu").html(data);
                $("#list-menu").fadeIn('fast');
            });
        })

        var SELECTED_TABLE_ID = '';
        var SELECTED_TABLE_NAME = '';
        //detectar mesa clicada
        $("#table-datail").on("click", ".btn-table", function() {
            SELECTED_TABLE_ID = $(this).data("id")
            SELECTED_TABLE_NAME = $(this).data("name")
            $(".selected-table").html('<br><h3>Mesa: '+SELECTED_TABLE_NAME+'</h3><hr>')
        })

        $("#list-menu").on("click", ".btn-menu", function() {
            if(SELECTED_TABLE_NAME == '') {
                alert('Você precisa selecionar uma mesa!')
            } else {
                var menu_id = $(this).data('id')
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    data: {
                        "_token:" : $('meta[name="csrf-token"]').attr('content'),
                        "menu_id": menu_id,
                        "table_id": SELECTED_TABLE_ID,
                        "table_name": SELECTED_TABLE_NAME,
                        "quantity": 1
                    },
                    url: "/cashier/orderFood",
                    success: function(data) {
                        $("#order-detail").html(data);
                    }
                })
            }
        })

    })
</script>
@endsection
