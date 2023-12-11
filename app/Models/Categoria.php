<?php

namespace App\Models;

use App\Traits\AttributeModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use SoftDeletes, HasFactory;
    use AttributeModel;

    protected $fillable = [
        'despachante_id',
        'nome',
        'icone',
        'cor',
        'status',
    ];

    public function despachante()
    {
        return $this->belongsTo(Despachante::class);
    }

    public function transacoes()
    {
        return $this->hasMany(Transacao::class);
    }
}
