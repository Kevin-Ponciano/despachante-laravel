<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Processo extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'comprador_tipo',
        'qtd_placas',
        'preco_placa',
        'pedido_id',
    ];

    protected $touches = ['pedido'];

    public function tipo()
    {
        $tipo = $this->tipo;
        if ($tipo == 'ss')
            return 'Solicitação de Serviço';
        elseif ($tipo == 'rv')
            return 'RENAVE';
        else
            return '-';
    }

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }
}
