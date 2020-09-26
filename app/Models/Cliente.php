<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at',
        'data_nascimento' => 'Y-m-d',
        'data_criacao' => 'Y-m-d'
    ];

    protected $fillable = [
        'nome', 
        'email', 
        'telefone', 
        'data_nascimento', 
        'endereco', 
        'complemento', 
        'bairro', 
        'cep', 
        'data_cadastro'
    ];

    public $timestamps = false;

    //Transforma a Data em Formato americano ...
    public function data_americana($data)
    {
        //Verifico se a Data está em formato Brasileiro
        if(isset($data) && strpos($data, '/')) {
            $array_data     = explode('/', $data);
            $data_americana = $array_data[2].'-'.$array_data[1].'-'.$array_data[0];

            return $data_americana;
        }
    }

    //Transforma a Data em Formato brasileiro ...
    public function data_brasileira($data)
    {
        //Verifico se a Data está em formato Brasileiro
        if(isset($data) && strpos($data, '-')) {
            $array_data         = explode('-', $data);
            $data_brasileira    = $array_data[2].'-'.$array_data[1].'-'.$array_data[0];

            return $data_brasileira;
        }
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function pedidoitems()
    {
        return $this->hasMany(PedidoItem::class, 'pedido_id', 'id');
    }

    public function pastel()
    {
        return $this->belongsToMany(Pastel::class, PedidoItem::class, 'id', 'pastel_id');
    }
}
