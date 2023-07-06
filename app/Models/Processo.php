<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Processo extends Model
{
    protected $fillable = [
        'tipo',
        'comprador_tipo',
        'qtd_placas',
        'pedido_id',
    ];
}
