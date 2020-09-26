<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at',
        'data_criacao' => 'Y-m-d'
    ];

    protected $fillable = [
        'cliente_id', 
        'data_criacao'
    ];

    public $timestamps = false;

    public function pedidoitems()
    {
        return $this->hasMany(PedidoItem::class);
    }

    public function pastel()
    {
        return $this->belongsToMany(Pastel::class, PedidoItem::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
