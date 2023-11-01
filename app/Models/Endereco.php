<?php

namespace App\Models;

use App\Traits\AttributeModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Endereco extends Model
{
    use HasFactory;
    use softDeletes;
    use AttributeModel;

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

    public function cliente()
    {
        return $this->hasOne(Cliente::class);
    }

    public function atpvs()
    {
        return $this->hasMany(Atpv::class, 'comprador_endereco_id');
    }

}
