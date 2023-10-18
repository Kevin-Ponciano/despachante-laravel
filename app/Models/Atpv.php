<?php

namespace App\Models;

use App\Traits\AttributeModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atpv extends Model
{
    use HasFactory;
    use softDeletes;
    use AttributeModel;

    protected $touches = ['pedido'];
    protected $fillable = [
        'renavam',
        'numero_crv',
        'codigo_crv',
        'movimentacao',
        'hodometro',
        'data_hodometro',
        'vendedor_email',
        'vendedor_telefone',
        'vendedor_cpf_cnpj',
        'comprador_cpf_cnpj',
        'comprador_email',
        'comprador_endereco_id',
        'preco_venda',
        'pedido_id',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function compradorEndereco(): BelongsTo
    {
        return $this->belongsTo(Endereco::class, 'comprador_endereco_id');
    }

    public function getTipo()
    {
        if ($this->codigo_crv) {
            return 'RENAVE';
        } else {
            return 'ATPV';
        }
    }

    public function getMovimentacao()
    {
        if ($this->movimentacao === 'in') {
            return 'ENTRADA';
        } elseif ($this->movimentacao === 'out') {
            return 'SAÍDA';
        }
    }
}
