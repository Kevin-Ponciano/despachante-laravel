<?php

namespace App\Models;

use App\Models\Scopes\SoftDeleteScope;
use App\Traits\AttributeModel;
use Auth;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use CrudTrait;
    use HasFactory;
    use softDeletes;
    use AttributeModel;

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
        'viewed_at',
        'concluded_at',
        'cliente_id',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SoftDeleteScope);

        static::creating(function ($model) {
            $numero_pedido = $model->cliente->despachante->pedidos()->count() + 1;
            $model->numero_pedido = $numero_pedido;
        });

        static::deleted(function ($model) {
            $model->atpv->delete();
            $model->processo->delete();
        });
    }

    public function atpv()
    {
        return $this->hasOne(Atpv::class);
    }

    public function processo()
    {
        return $this->hasOne(Processo::class);
    }

    public function getViewedAtAttribute($value): ?string
    {
        return $this->dataTimeToBr($value);
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

    public function getStatus()
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
