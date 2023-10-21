<?php

namespace App\Models;

use App\Traits\AttributeModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Processo extends Model
{
    use HasFactory;
    use softDeletes;
    use AttributeModel;

    protected $touches = ['pedido'];
    protected $fillable = [
        'tipo',
        'comprador_tipo',
        'qtd_placas',
        'preco_placa',
        'pedido_id',
    ];


    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    public function getTipo()
    {
        $tipo = $this->tipo;
        if ($tipo == 'ss')
            return 'Solicitação de Serviço';
        elseif ($tipo == 'rv')
            return 'RENAVE';
        else
            return '-';
    }
}
