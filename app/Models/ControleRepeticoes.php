<?php

namespace App\Models;

use App\Traits\AttributeModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ControleRepeticoes extends Model
{
    use SoftDeletes, HasFactory;
    use AttributeModel;

    protected $fillable = [
        'transicao_anterior_id',
        'transacao_id',
        'transicao_posterior_id',
        'status',
        'posicao',
        'transacao_original_id',
        'total_repeticoes',
    ];

    public function transacao()
    {
        return $this->belongsTo(Transacao::class);
    }

    public function transacaoAnterior()
    {
        return $this->belongsTo(Transacao::class, 'transicao_anterior_id');
    }

    public function transacaoPosterior()
    {
        return $this->belongsTo(Transacao::class, 'transicao_posterior_id');
    }

    public function transacaoOriginal()
    {
        return $this->belongsTo(Transacao::class, 'original_id');
    }
}
