<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;
    protected $fillable = [
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'cep',
    ];

    public function despachante()
    {
        return $this->hasOne(Despachante::class);
    }

    public function atpvs()
    {
        return $this->hasMany(Atpv::class,'comprador_endereco_id');
    }
}
