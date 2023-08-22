<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use softDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function despachante()
    {
        return $this->belongsTo(Despachante::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function pedidosCriados()
    {
        return $this->hasMany(Pedido::class, 'criado_por');
    }

    public function pedidosResponsaveis()
    {
        return $this->hasMany(Pedido::class, 'responsavel_por');
    }

    public function pedidosConcluidos()
    {
        return $this->hasMany(Pedido::class, 'concluido_por');
    }

    public function logs()
    {
        return $this->hasMany(Log::class, 'usuario_id');
    }

    public function isDespachante(): bool
    {
        $role = $this->role[0];
        if ($role === 'd') {
            return true;
        } else {
            return false;
        }
    }

    public function isCliente(): bool
    {
        $role = $this->role[0];
        if ($role === 'c') {
            return true;
        } else {
            return false;
        }
    }

    public function getFuncao()
    {
        $role = $this->role[1];
        if ($role === 'a') {
            return 'Administrador';
        } elseif ($role === 'u') {
            return 'Usuário';
        } elseif ($role === 'm') {
            return 'Master';
        } else {
            return 'undefined';
        }
    }


    public function nomeEmpresa()
    {
        if ($this->isDespachante())
            return $this->despachante->razao_social;
        elseif ($this->isCliente())
            return $this->cliente->nome;
        else
            return 'undefined';
    }

    public function status()
    {
        return match ($this->status) {
            'at' => 'Ativo',
            'in' => 'Inativo',
        };
    }


}
