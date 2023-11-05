<?php

namespace App\Models;

use App\Traits\AttributeModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pendencia extends Model
{
    use AttributeModel;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'pedido_id',
        'nome',
        'tipo',
        'status',
        'input',
        'observacao',
        'concluded_at',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function getStatus()
    {
        return match ($this->status) {
            'co' => 'Concluído',
            'pe' => 'Pendente',
            'rp' => 'Em Análise',
            default => '-',
        };

    }
}
