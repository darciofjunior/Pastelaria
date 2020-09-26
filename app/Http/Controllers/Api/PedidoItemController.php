<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PedidoItem;
use App\Http\Requests\PedidoItemStoreUpdateFormRequest;

class PedidoItemController extends Controller
{
    private $pedidoitem;

    public function __construct(PedidoItem $pedidoitem)
    {
        $this->pedidoitem = $pedidoitem;
    }

    public function index()
    {
        if(!$pedidoitems = $this->pedidoitem->with(['pastel', 'pedido', 'cliente'])->get())
            return response()->json(['mensagem' => 'Not Found Pedido Item(s) !'], 404);

        return response()->json($pedidoitems);
    }

    public function show($id)
    {
        if(!$pedidoitem = $this->pedidoitem->with(['pastel', 'pedido', 'cliente'])->find($id))
            return response()->json(['mensagem' => 'Not Found Pedido Item !'], 404);

        return response()->json($pedidoitem);
    }

    public function store(PedidoItemStoreUpdateFormRequest $request)
    {
        $pedidoitem = $this->pedidoitem->create($request->all());

        return response()->json($pedidoitem, 201);
    }

    public function update(PedidoItemStoreUpdateFormRequest $request, $id)
    {
        if(!$pedidoitem = $this->pedidoitem->find($id))
            return response()->json(['mensagem' => 'Not Found Pedido Item !'], 404);

        $pedidoitem->update($request->all());

        return response()->json($pedidoitem);
    }

    public function destroy($id)
    {
        if(!$pedidoitem = $this->pedidoitem->find($id))
            return response()->json(['mensagem' => 'Not Found Pedido Item !'], 404);

        //Delete o Registro em si ...
        $pedidoitem->delete();

        return response()->json($pedidoitem, 204);
    }
}
