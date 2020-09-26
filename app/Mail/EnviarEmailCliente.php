<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;

class EnviarEmailCliente extends Mailable
{
    use Queueable, SerializesModels;

    public $cliente;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cliente_id = $this->cliente->id;

        $pedidos = DB::table('clientes AS c') 
                    ->join('pedidos AS p', 'p.cliente_id', '=', 'c.id')
                    ->join('pedido_items AS pi', 'pi.pedido_id', '=', 'p.id')
                    ->join('pastels AS pa', 'pa.id', '=', 'pi.pastel_id')
                    ->select('c.*', 'p.id AS pedido_id', 'p.data_criacao', 'pi.pastel_id', 'pa.nome AS pastel', 'pa.preco', 'pa.foto', DB::raw("COUNT(pi.pastel_id) AS qtde")) 
                    ->where('p.cliente_id', $cliente_id) 
                    ->groupBy('p.cliente_id', 'pi.pastel_id') 
                    ->get();

        return $this->subject('Pedidos')
                    ->from('pastelaria@gmail.com')
                    ->view('enviar_email_cliente')
                    ->with([
                        'pedidos' => $pedidos,
                    ]);
    }
}
