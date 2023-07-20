<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'comprador_nome',
        'comprador_telefone',
        'placa',
        'veiculo',
        'preco_placa',
        'preco_honorario',
        'status',
        'observacoes',
        'criado_por',
        'cliente_id',
    ];
}
