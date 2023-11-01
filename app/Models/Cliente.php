<?php

namespace App\Models;

use App\Models\Scopes\SoftDeleteScope;
use App\Traits\AttributeModel;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use CrudTrait;
    use HasFactory;
    use softDeletes;
    use AttributeModel;

    protected $fillable = [
        'numero_cliente',
        'nome',
        'cpf_cnpj',
        'telefone',
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
        static::addGlobalScope(new SoftDeleteScope);

        static::creating(function ($cliente) {
            $numero_cliente = $cliente->despachante->clientes()->max('numero_cliente') + 1;
            $cliente->numero_cliente = $numero_cliente;
        });
        static::deleted(function ($model) {
            $model->pedidos()->each(function ($item) {
                $item->delete();
            });

            $model->user()->each(function ($item) {
                $item->delete();
            });
        });
    }

    public function despachante()
    {
        return $this->belongsTo(Despachante::class);
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function processos()
    {
        return $this->hasManyThrough(Processo::class, Pedido::class);
    }

//    public function pedidosWithProcessos()
//    {
//        return $this->pedidos()->with('processo')->get()->reject(function ($value) {
//            return $value->processo == null;
//        });
//    }

//    public function pedidosWithAtpvs()
//    {
//        return $this->pedidos()->with('atpv')->get()->reject(function ($value) {
//            return $value->atpv == null;
//        });
//    }

    public function pedidosProcessos()
    {
        return $this->pedidos()->has('processo');
    }

    public function pedidosAtpvs()
    {
        return $this->pedidos()->has('atpv');
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getStatus()
    {
        return match ($this->status) {
            'at' => 'Ativo',
            'in' => 'Inativo',
            'ex' => 'Excluído',
        };
    }
}
