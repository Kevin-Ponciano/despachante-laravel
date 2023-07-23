<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'status',
        'preco_1_placa',
        'preco_2_placa',
        'preco_atpv',
        'preco_loja',
        'preco_terceiro',
        'despachante_id',
    ];

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


}
