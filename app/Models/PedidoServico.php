<?php

namespace App\Models;

use App\Traits\AttributeModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PedidoServico extends Model
{
    use HasFactory;
    use softDeletes;
    use AttributeModel;

    protected $fillable = [
        'pedido_id',
        'servico_id',
        'preco',
    ];

    protected $touches = ['pedido'];

    public function servico(): BelongsTo
    {
        return $this->belongsTo(Servico::class);
    }

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }
}
