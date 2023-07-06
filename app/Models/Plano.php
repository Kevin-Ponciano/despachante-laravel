<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    protected $fillable = [
        'nome',
        'preco',
        'descricao',
        'qtd_clientes',
        'qtd_acessos_clientes',
    ];
}
