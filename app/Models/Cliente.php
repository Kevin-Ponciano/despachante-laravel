<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'numero_cliente',
        'nome',
        'status',
        'preco_1_placa',
        'preco_2_placa',
        'preco_atpv',
        'preco_loja',
        'preco_terceiro',
        'preco_renave_entrada',
        'preco_renave_saida',
        'despachante_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cliente) {
            $numero_cliente = $cliente->despachante->clientes()->max('numero_cliente') + 1;
            $cliente->numero_cliente = $numero_cliente;
        });
    }

    public function despachante()
    {
        return $this->belongsTo(Despachante::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function processos()
    {
        return $this->hasManyThrough(Processo::class, Pedido::class);
    }

    public function pedidosWithProcessos()
    {
        return $this->pedidos()->with('processo')->get()->reject(function ($value) {
            return $value->processo == null;
        });
    }

    public function pedidosWithAtpvs()
    {
        return $this->pedidos()->with('atpv')->get()->reject(function ($value) {
            return $value->atpv == null;
        });
    }

    public function status()
    {
        return match ($this->status) {
            'at' => 'Ativo',
            'in' => 'Inativo',
        };
    }
}
