<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PedidoItem extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'pedido_id', 
        'pastel_id'
    ];

    public $timestamps = false;

    public function pastel()
    {
        return $this->hasOne(Pastel::class, 'id', 'pastel_id');
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function cliente()
    {
        return $this->belongsToMany(Cliente::class, Pedido::class, 'id', 'cliente_id');
    }
}
