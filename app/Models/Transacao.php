<?php

namespace App\Models;

use App\Traits\AttributeModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transacao extends Model
{
    use SoftDeletes, HasFactory;
    use AttributeModel;

    protected $table = 'transacoes';

    protected $fillable = [
        'transacao_original_id',
        'tipo',
        'despachante_id',
        'cliente_id',
        'pedido_id',
        'categoria_id',
        'valor',
        'status',
        'data_vencimento',
        'data_pagamento',
        'descricao',
        'observacao',
        'repetir',
    ];

    public function despachante()
    {
        return $this->belongsTo(Despachante::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function transacaoOriginal()
    {
        return $this->belongsTo(Transacao::class, 'transacao_original_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function repeticoes()
    {
        return $this->hasMany(ControleRepeticoes::class);
    }

    public function getDataVencimento()
    {
        return Carbon::createFromFormat('Y-m-d', $this->data_vencimento)->format('d/m/Y');
    }

    public function getDataPagamento()
    {
        return Carbon::createFromFormat('Y-m-d', $this->data_pagamento)->format('d/m/Y');
    }

    public function getValor()
    {
        return number_format($this->valor, 2, ',', '.');
    }

    public function getStatus()
    {
        return match ($this->status) {
            'pg' => ['text' => 'Pago', 'color' => 'success', 'icon' => 'ti ti-check'],
            'cl' => ['text' => 'Cancelado', 'color' => 'danger', 'icon' => 'ti ti-x'],
            'ex' => ['text' => 'Excluído', 'color' => 'danger', 'icon' => 'ti ti-x'],
            'at' => ['text' => 'Atrasado', 'color' => 'danger', 'icon' => 'ti ti-exclamation-mark'],
            default => ['text' => 'Pendente', 'color' => 'warning', 'icon' => 'ti ti-exclamation-mark'],
        };
    }
}
