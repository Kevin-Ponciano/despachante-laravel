<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Atpv extends Model
{
    use HasFactory;

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

    protected $touches = ['pedido'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function compradorEndereco(): BelongsTo
    {
        return $this->belongsTo(Endereco::class, 'comprador_endereco_id');
    }

    public function tipo()
    {
        if ($this->codigo_crv) {
            return 'RENAVE';
        } else {
            return 'ATPV';
        }
    }

    public function movimentacao()
    {
        if ($this->movimentacao === 'in') {
            return 'ENTRADA';
        } elseif ($this->movimentacao === 'out') {
            return 'SAÍDA';
        }
    }
}
