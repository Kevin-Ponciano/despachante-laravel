<?php

namespace App\Models;

use App\Traits\AttributeModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servico extends Model
{
    use AttributeModel;
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'nome',
        'preco',
        'descricao',
        'despachante_id',
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
