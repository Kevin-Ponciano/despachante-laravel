<?php

namespace App\Models;

use App\Models\Scopes\SoftDeleteScope;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Log;
use Spatie\Permission\Traits\HasRoles;
use Storage;

class User extends Authenticatable
{
    use CrudTrait;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'profile_photo_path',
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

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SoftDeleteScope);
    }

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

    public function getFuncao()
    {
        $this->hasAnyRole('[ADMIN]', '[DESPACHANTE] - ADMIN') ? $funcao = 'Administrador' : $funcao = 'Usuário';

        return $funcao;
    }

    public function getUuidDespachante()
    {
        if ($this->isDespachante()) {
            return $this->despachante->uuid;
        } elseif ($this->isCliente()) {
            return $this->cliente->despachante->uuid;
        } else {
            Log::error('Erro ao obter uuid do despachante.');
        }
        abort(500, 'Erro ao obter uuid do despachante.');
    }

    public function isDespachante(): bool
    {
        return $this->despachante_id != null && $this->hasPermissionTo('[DESPACHANTE] - Acessar Sistema');
    }

    public function isCliente(): bool
    {
        return $this->cliente_id != null && $this->hasPermissionTo('[CLIENTE] - Acessar Sistema');
    }

    public function empresa()
    {
        if ($this->isDespachante()) {
            return $this->despachante;
        } elseif ($this->isCliente()) {
            return $this->cliente;
        } else {
            Log::error('Erro ao obter a empresa.');
        }
        abort(500, 'Erro ao obter a empresa.');
    }

    public function getStatus()
    {
        return match ($this->status) {
            'at' => 'Ativo',
            'in' => 'Inativo',
            'ex' => 'Excluído',
        };
    }

    public function getProfilePhoto()
    {
        if ($this->profile_photo_path) {
            return Storage::disk('public')->url($this->profile_photo_path);
        } else {
            return 'https://ui-avatars.com/api/?name='.$this->name[0].'&color=7F9CF5&background=EBF4FF';
        }
    }
}
