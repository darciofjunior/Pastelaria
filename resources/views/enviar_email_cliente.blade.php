@php
    $total_item = 0; 
    $total_geral = 0  
@endphp

<div class="card-body">
    <div class="table-responsive">
        <div class="col md-6 mx-auto">
            <h1 class="text-center">
                <br/>Detalhes do Pedido N.º {{ $pedidos[0]->id }}
            </h1>
            <h3 class="text-center">
                Data de Criação: {{ formatDateAndTime($cliente->data_criacao, 'd/m/Y') }}
            </h3>
            <h3 class="text-center">
                Cliente: {{ $cliente->nome }}
            </h3>
            <br/>
            <table class="table table-bordered table-striped">
                <tr align="center">
                    <th>Qtde</th>
                    <th>Pastel</th>
                    <th>Foto</th>
                    <th>Preço</th>
                    <th>Total por Item</th>
                </tr>
                @foreach($pedidos as $pedido)
                <tr>
                    <td align="center">
                        {{ $pedido->qtde }}
                    </td>
                    <td>{{ $pedido->pastel }}</td>
                    <td>
                        <img src="{{ $message->embed("storage/fotos/{$pedido->foto}") }}" width="100" height="50">
                    </td>
                    <td align="right">
                        R$ {{ number_format($pedido->preco, 2, ',', '.') }}
                    </td>
                    <td align="right">
                        @php
                            $total_item = ($pedido->qtde * $pedido->preco);
                            $total_geral+= $total_item
                        @endphp

                        R$ {{ number_format($total_item, 2, ',', '.') }}
                    </td>
                </tr>
                @endforeach
                <tfoot>
                    <td colspan="5">
                        <h3 class="text-right">
                            Total do Pedido em => R$ {{ number_format($total_geral, 2, ',', '.') }}
                        </h3>
                    </td>
                </tfoot>
            </table>
        </div>
    </div>
</div>
