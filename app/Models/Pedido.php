<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'comprador_nome',
        'comprador_telefone',
        'placa',
        'veiculo',
        'preco_placa',
        'preco_honorario',
        'status',
        'observacoes',
        'criado_por',
        'cliente_id',
    ];

    public function usuarioCriador()
    {
        return $this->belongsTo(User::class, 'criado_por');
    }

    public function usuarioResponsavel()
    {
        return $this->belongsTo(User::class, 'responsavel_por');
    }

    public function usuarioConcluinte()
    {
        return $this->belongsTo(User::class, 'concluido_por');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function atpv()
    {
        return $this->hasOne(Atpv::class);
    }

    public function processo()
    {
        return $this->hasOne(Processo::class);
    }

    public function servicos()
    {
        return $this->belongsToMany(Servico::class, 'pedido_servicos')
            ->withPivot('preco');
    }
}
