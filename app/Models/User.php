<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Storage;

class User extends Authenticatable
{
    use CrudTrait;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
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
        'profile_photo_path'
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

    public function getIdDespachante()
    {
        if ($this->isDespachante())
            return $this->despachante->id;
        elseif ($this->isCliente())
            return $this->cliente->despachante->id;
        else
            abort(500, 'Erro ao obter ID do despachante.');
    }

    public function empresa()
    {
        if ($this->isDespachante())
            return $this->despachante;
        elseif ($this->isCliente())
            return $this->cliente;
        else
            abort(500, 'Erro ao obter a empresa.');
    }

    public function status()
    {
        return match ($this->status) {
            'at' => 'Ativo',
            'in' => 'Inativo',
        };
    }

    public function getProfilePhoto()
    {
        if ($this->profile_photo_path) {
            return Storage::disk('local')->url($this->profile_photo_path);
        } else {
            return 'https://ui-avatars.com/api/?name=' . $this->name[0] . '&color=7F9CF5&background=EBF4FF';
        }
    }


}
