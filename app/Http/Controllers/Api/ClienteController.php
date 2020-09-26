<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Http\Requests\ClienteStoreUpdateFormRequest;
use App\Mail\EnviarEmailCliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ClienteController extends Controller
{
    private $cliente;

    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    public function index()
    {
        if(!$clientes = $this->cliente->with(['pedidos', 'pedidoitems', 'pastel'])->orderBy('nome', 'ASC')->get())
            return response()->json(['mensagem' => 'Not Found Cliente(s) !'], 404);

        return response()->json($clientes);
    }

    public function show($id)
    {
        if(!$cliente = $this->cliente->find($id))
            return response()->json(['mensagem' => 'Not Found Cliente !'], 404);

        return response()->json($cliente);
    }

    public function store(ClienteStoreUpdateFormRequest $request)
    {
        //Tratando os campos de Data ...
        $request['data_nascimento'] = $this->cliente->data_americana($request->data_nascimento);
        $request['data_cadastro']   = date('Y-m-d');
        
        $cliente = $this->cliente->create($request->all());

        return response()->json($cliente, 201);
    }

    public function update(ClienteStoreUpdateFormRequest $request, $id)
    {
        if(!$cliente = $this->cliente->find($id))
            return response()->json(['mensagem' => 'Not Found Cliente !'], 404);

        //Tratando os campos de Data ...
        $request['data_nascimento'] = $this->cliente->data_americana($request->data_nascimento);
        
        $cliente->update($request->all());

        return response()->json($cliente);
    }

    public function destroy($id)
    {
        if(!$cliente = $this->cliente->find($id))
            return response()->json(['mensagem' => 'Not Found Cliente !'], 404);

        $cliente->delete();

        return response()->json($cliente, 204);
    }

    public function enviar_email()
    {
        $clientes_com_pedido = DB::table('clientes AS c') 
                                ->join('pedidos AS p', 'p.cliente_id', '=', 'c.id') 
                                ->join('pedido_items AS pi', 'pi.pedido_id', '=', 'p.id')
                                ->select('c.id') 
                                ->groupBy('c.id') 
                                ->get();

        foreach($clientes_com_pedido as $cliente_com_pedido)
        {
            $cliente_com_pedido->id;

            $cliente = $this->cliente->find($cliente_com_pedido->id);

            Mail::to($cliente->email)
                    ->send(new EnviarEmailCliente($cliente));
        }
    }
}
