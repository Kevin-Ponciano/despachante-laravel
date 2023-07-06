<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nome',
        'status',
        'preco_1_placa',
        'preco_2_placa',
        'preco_atpv',
        'preco_loja',
        'preco_terceiro',
        'despachante_id',
    ];
}
