<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'preco',
        'descricao',
        'qtd_clientes',
        'qtd_acessos_clientes',
    ];

    public function despachantes()
    {
        return $this->hasMany(Despachante::class);
    }
}
