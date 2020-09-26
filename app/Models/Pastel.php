<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pastel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nome', 
        'preco', 
        'foto'
    ];

    public $timestamps = false;

    //Transforma a Preço no formato que o MySQL trabalha ...
    public function formatar_moeda($preco)
    {
        $preco = str_replace('.', '', $preco);//Tira o separador de milhar ...
        $preco = str_replace(',', '.', $preco);//Transforma o decimal em ponto ...

        return $preco;
    }

    public function pedidoitems()
    {
        return $this->belongsToMany(PedidoItem::class);
    }
}
