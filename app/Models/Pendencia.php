<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pendencia extends Model
{
    use  HasFactory;
    use SoftDeletes;

    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'pedido_id',
        'nome',
        'tipo',
        'status',
        'input',
        'observacao',
        'criado_em',
        'atualizado_em',
        'concluido_em',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function concluido_em()
    {
        if ($this->concluido_em == null)
            return '-';
        $concluido_em = Carbon::createFromFormat('Y-m-d H:i:s', $this->concluido_em);
        return $concluido_em->format('d/m/Y') . ' ' . $concluido_em->format('H:i');
    }

    public function status()
    {
        return match ($this->status) {
            'co' => 'Concluído',
            'pe' => 'Pendente',
            'rp' => 'Em Análise',
            default => '-',
        };

    }
}
