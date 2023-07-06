<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoServico extends Model
{
    protected $fillable = [
        'pedido_id',
        'servico_id',
        'preco',
    ];
}
