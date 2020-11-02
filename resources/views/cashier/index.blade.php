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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pagamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 class="totalAmount"></h3>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">$</span>
            </div>
            <input type="number" id="recieved-amount" class="form-control">
        </div>
        <h3 class="changeAmount"></h3>
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="payment" value="Dinheiro" id="cash" checked>Dinheiro
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="payment" value="Débito" id="debit">Débito
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="payment" value="Crédito" id="credit">Cartão de crédito
                </label>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary btn-save-payment" disabled >Pagar</button>
      </div>
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
        var SALE_ID = '';
        //detectar mesa clicada
        $("#table-datail").on("click", ".btn-table", function() {
            SELECTED_TABLE_ID = $(this).data("id")
            SELECTED_TABLE_NAME = $(this).data("name")
            $(".selected-table").html('<br><h3>Mesa: '+SELECTED_TABLE_NAME+'</h3><hr>')
            $.get("/cashier/getSaleDetailsByTable/"+SELECTED_TABLE_ID, function(data) {
                $("#order-detail").html(data);
            })
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

        $("#order-detail").on("click", ".btn-confirm-order", function() {
            var SaleId = $(this).data('id')
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                data: {
                    "_token:" : $('meta[name="csrf-token"]').attr('content'),
                    "sale_id" : SaleId
                },
                url: "/cashier/confirmOrderStatus",
                success: function(data) {
                    $("#order-detail").html(data)
                }
            })
        })

        //deletar item em detalhes do pedido
        $("#order-detail").on("click", ".btn-delete-saledetail", function() {
            var saleDetailId = $(this).data("id");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                data : {
                    "_token:" : $('meta[name="csrf-token"]').attr('content'),
                    "saleDetail_id": saleDetailId
                },
                url: "/cashier/deleteSaleDetail",
                success: function(data) {
                    $("#order-detail").html(data);
                }
            })
        })

        //acrescentando quantidade
                $("#order-detail").on("click", ".btn-increase-quantity", function() {
            var saleDetailId = $(this).data("id");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                data : {
                    "_token:" : $('meta[name="csrf-token"]').attr('content'),
                    "saleDetail_id": saleDetailId
                },
                url: "/cashier/increase-quantity",
                success: function(data) {
                    $("#order-detail").html(data);
                }
            })
        })

        //decrescendo quantidade
        $("#order-detail").on("click", ".btn-decrease-quantity", function() {
            var saleDetailId = $(this).data("id");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                data : {
                    "_token:" : $('meta[name="csrf-token"]').attr('content'),
                    "saleDetail_id": saleDetailId
                },
                url: "/cashier/decrease-quantity",
                success: function(data) {
                    $("#order-detail").html(data);
                }
            })
        })

        //quando clicado em no botão de pagamento
        $("#order-detail").on("click", ".btn-payment", function() {
            var totalAmount = $(this).attr('data-totalAmount');
            $(".totalAmount").html("Preço total: R$" + totalAmount);
            $('#recieved-amount').val('');
            $(".btn-save-payment").prop('disabled', true)
            $('.changeAmount').html('')
            SALE_ID = $(this).data('id');
        })
        
        //calcular troco
        $("#recieved-amount").keyup(function() {
            var total_amount = $(".btn-payment").attr('data-totalAmount');
            var recievedAmount = $(this).val();
            var changeAmount = recievedAmount - total_amount;
            var arrendondado = parseFloat(changeAmount.toFixed(2))
            $(".changeAmount").html("Troco: R$ " + arrendondado);

            //checar se o valor do pagamento é suficiente e habilitar botão pagar
            if(changeAmount >=0) {
                $(".btn-save-payment").prop('disabled', false)
            } else {
                $(".btn-save-payment").prop('disabled', true)
            }
        })

        //salvar pagamento
        $('.btn-save-payment').click(function() {
            var recievedAmount = $("#recieved-amount").val();
            var paymentType = $("input[type='radio'][name='payment']:checked").val();
            var saleId = SALE_ID;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                data: {
                    "_token:" : $('meta[name="csrf-token"]').attr('content'),
                    "saleId" : saleId,
                    "recievedAmount" : recievedAmount,
                    "paymentType" : paymentType
                },
                url: "/cashier/savePayment",
                success: function(data) {
                    window.location.href = data;
                    //console.log(data)
                }
            })
        })

    })
</script>
@endsection
