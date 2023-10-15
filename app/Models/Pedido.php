<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use HasFactory;
    use softDeletes;

    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'comprador_nome',
        'comprador_telefone',
        'placa',
        'veiculo',
        'preco_honorario',
        'status',
        'solicitado_cancelamento',
        'observacoes',
        'criado_por',
        'responsavel_por',
        'concluido_por',
        'concluido_em',
        'cliente_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pedido) {
            $numero_pedido = $pedido->cliente->despachante->pedidos()->max('numero_pedido') + 1;
            $pedido->numero_pedido = $numero_pedido;
        });
    }

    public function criado_em()
    {
        if (!$this->criado_em)
            return null;
        $criado_em = Carbon::createFromFormat('Y-m-d H:i:s', $this->criado_em);
        return $criado_em->format('d/m/Y') . ' - ' . $criado_em->format('H:i');
    }

    public function atualizado_em()
    {
        if (!$this->atualizado_em)
            return null;
        $atualizado_em = Carbon::createFromFormat('Y-m-d H:i:s', $this->atualizado_em);
        return $atualizado_em->format('d/m/Y') . ' - ' . $atualizado_em->format('H:i');
    }

    public function concluido_em()
    {
        if (!$this->concluido_em)
            return null;
        $concluido_em = Carbon::createFromFormat('Y-m-d H:i:s', $this->concluido_em);
        return $concluido_em->format('d/m/Y') . ' - ' . $concluido_em->format('H:i');
    }

    public function usuarioCriador()
    {
        return $this->belongsTo(User::class, 'criado_por');
    }

    public function usuarioResponsavel()
    {
        return $this->belongsTo(User::class, 'responsavel_por');
    }

    public function usuarioConcluinte()
    {
        return $this->belongsTo(User::class, 'concluido_por');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function atpv()
    {
        return $this->hasOne(Atpv::class);
    }

    public function processo()
    {
        return $this->hasOne(Processo::class);
    }

    public function pendencias()
    {
        return $this->hasMany(Pendencia::class);
    }

    public function arquivos()
    {
        return $this->hasMany(Arquivo::class);
    }

    public function timelines()
    {
        return $this->hasMany(Timeline::class);
    }

    public function servicos()
    {
        return $this->belongsToMany(Servico::class, 'pedido_servicos')
            ->withPivot('preco');
    }

    public function status()
    {
        switch ($this->status) {
            case 'ab':
                return ['Aberto', 'bg-success'];
            case 'ea':
                return ['Em Andamento', 'bg-primary'];
            case 'co':
                if ($this->solicitado_cancelamento)
                    return ['Cancelamento Realizado', 'bg-success'];
                else
                    return ['Concluído', 'bg-success'];
            case 'sc':
                return ['Solicitado Cancelamento', 'bg-warning'];
            case 'ex':
                return ['Excluído', 'bg-danger'];
            case 'pe':
                return ['Pendente', 'bg-warning'];
            case 'rp':
                if (Auth::user()->isDespachante())
                    return ['Retorno de Pendência', 'bg-warning'];
                else
                    return ['Em Análise', 'bg-warning'];
            default:
                return ['Desconhecido', 'bg-secondary'];
        }
    }
}
