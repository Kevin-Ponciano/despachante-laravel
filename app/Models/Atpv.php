<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atpv extends Model
{
    protected $fillable = [
        'renavam',
        'numero_crv',
        'codigo_crv',
        'hodometro',
        'data_hodometro',
        'vendedor_email',
        'vendedor_telefone',
        'vendedor_cpf_cnpj',
        'comprador_cpf_cnpj',
        'comprador_email',
        'comprador_endereco',
        'preco_venda',
        'pedido_id',
    ];
}
