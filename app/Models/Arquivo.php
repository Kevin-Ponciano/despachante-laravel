<?php

namespace App\Models;

use App\Traits\AttributeModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Arquivo extends Model
{
    use AttributeModel;

    protected $fillable = [
        'pedido_id',
        'nome',
        'path',
        'folder',
        'mime_type',
        'url',
        'updated_at',
    ];


    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

}
