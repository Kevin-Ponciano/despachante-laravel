<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servico extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'preco',
        'descricao',
        'despachante_id'
    ];

    public function despachante(): BelongsTo
    {
        return $this->belongsTo(Despachante::class);
    }

    public function pedidoServicos(): HasMany
    {
        return $this->hasMany(PedidoServico::class, 'servico_id');
    }
}
