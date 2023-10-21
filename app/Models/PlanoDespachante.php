<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanoDespachante extends Model
{
    use CrudTrait;
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'plano_id',
        'despachante_id',
        'qtd_clientes',
        'qtd_usuarios',
        'qtd_processos_mes',
    ];

    public function plano()
    {
        return $this->belongsTo(Plano::class);
    }

    public function despachante()
    {
        return $this->belongsTo(Despachante::class);
    }
}
