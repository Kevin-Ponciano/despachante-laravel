<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Despachante extends Model
{
    protected $fillable = [
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'celular',
        'telefone',
        'endereco_id',
        'plano_id',
    ];
}
