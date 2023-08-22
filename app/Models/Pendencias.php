<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pendencias extends Model
{
    use  HasFactory;
    use SoftDeletes;

    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'pedido_id',
        'nome',
        'tipo',
        'status',
        'observacao',
        'criado_em',
        'atualizado_em',
        'concluido_em',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
