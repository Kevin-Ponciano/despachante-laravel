<?php

namespace App\Models;

use App\Models\Scopes\SoftDeleteScope;
use App\Traits\AttributeModel;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

class Despachante extends Model
{
    use CrudTrait;
    use HasFactory;
    use softDeletes;
    use AttributeModel;

    protected $fillable = [
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'celular',
        'telefone',
        'email',
        'site',
        'status',
        'endereco_id',
    ];

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SoftDeleteScope);
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });

        static::deleted(function ($model) {
            $model->clientes()->each(function ($item) {
                $item->delete();
            });
        });
    }

    public function clientes(): HasMany
    {
        return $this->hasMany(Cliente::class);
    }

    public function endereco(): BelongsTo
    {
        return $this->belongsTo(Endereco::class);
    }

    public function plano(): BelongsToMany
    {
        return $this->belongsToMany(Plano::class, 'plano_despachantes')->withPivot('preco', 'qtd_clientes', 'qtd_usuarios', 'qtd_processos_mes');
    }

    public function servicos(): HasMany
    {
        return $this->hasMany(Servico::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function pedidosProcessos()
    {
        return $this->pedidos()->has('processo');
    }

    public function pedidos()
    {
        return $this->hasManyThrough(Pedido::class, Cliente::class);
    }

    public function pedidosAtpvs()
    {
        return $this->pedidos()->has('atpv');
    }

    public function getNome()
    {
        return $this->nome_fantasia ?? $this->razao_social;
    }
}
