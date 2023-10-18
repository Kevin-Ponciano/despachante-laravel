<?php

namespace App\Models;

use App\Traits\AttributeModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    use HasFactory;
    use AttributeModel;

    protected $fillable = [
        'nome',
        'preco',
        'descricao',
        'qtd_clientes',
        'qtd_usuarios_clientes',
        'qtd_usuarios',
    ];

    public function despachantes()
    {
        return $this->hasMany(Despachante::class);
    }
}
