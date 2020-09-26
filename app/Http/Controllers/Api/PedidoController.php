<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Http\Requests\PedidoStoreUpdateFormRequest;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    private $pedido;

    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    public function index()
    {
        if(!$pedidos = $this->pedido->with(['pedidoitems', 'pastel', 'cliente'])->get())
            return response()->json(['mensagem' => 'Not Found Pedido(s) !'], 404);

        return response()->json($pedidos);
    }

    public function show($id)
    {
        if(!$pedido = $this->pedido->with(['pedidoitems', 'pastel', 'cliente'])->find($id))
            return response()->json(['mensagem' => 'Not Found Pedido !'], 404);

        return response()->json($pedido);
    }

    public function store(PedidoStoreUpdateFormRequest $request)
    {
        $request['data_criacao'] = date('Y-m-d');
        $pedido = $this->pedido->create($request->all());

        return response()->json($pedido, 201);
    }

    public function update(PedidoStoreUpdateFormRequest $request, $id)
    {
        if(!$pedido = $this->pedido->find($id))
            return response()->json(['mensagem' => 'Not Found Pedido !'], 404);

        $pedido->update($request->all());

        return response()->json($pedido);
    }

    public function destroy($id)
    {
        if(!$pedido = $this->pedido->find($id))
            return response()->json(['mensagem' => 'Not Found Pedido !'], 404);

        //Delete o Registro em si ...
        $pedido->delete();

        return response()->json($pedido, 204);
    }
}
