<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ControleFixas extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'transacao_original_id',
        'tipo',
        'despachante_id',
        'categoria_id',
        'valor',
        'status',
        'data_vencimento',
        'descricao',
        'observacao',
    ];

    public function despachante()
    {
        return $this->belongsTo(Despachante::class);
    }

    public function transacaoOriginal()
    {
        return $this->belongsTo(Transacao::class, 'transacao_original_id', 'id');
    }
}
