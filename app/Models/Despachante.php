<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Despachante extends Model
{
    use HasFactory;

    protected $fillable = [
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'celular',
        'telefone',
        'endereco_id',
        'plano_id',
    ];


    public function endereco(): BelongsTo
    {
        return $this->belongsTo(Endereco::class);
    }

    public function plano(): BelongsTo
    {
        return $this->belongsTo(Plano::class);
    }

    public function servicos(): HasMany
    {
        return $this->hasMany(Servico::class);
    }

    public function clientes(): HasMany
    {
        return $this->hasMany(Cliente::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function pedidos()
    {
        return $this->hasManyThrough(Pedido::class, Cliente::class);
    }

    public function pedidosProcessos()
    {
        return $this->pedidos()->has('processo');
    }

    public function pedidosAtpvs()
    {
        return $this->pedidos()->has('atpv');
    }

    public function nome()
    {
        return $this->nome_fantasia ?? $this->razao_social;
    }

}
