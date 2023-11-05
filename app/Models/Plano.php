<?php

namespace App\Models;

use App\Traits\AttributeModel;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    use AttributeModel;
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'nome',
        'preco',
        'descricao',
        'qtd_clientes',
        'qtd_usuarios',
        'qtd_processos_mes',
    ];

    public function despachantes()
    {
        return $this->belongsToMany(Despachante::class, 'plano_despachantes')->withPivot('preco', 'qtd_clientes', 'qtd_usuarios', 'qtd_processos_mes');
    }
}
