<?php

namespace App\Models;

use App\Traits\AttributeModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timeline extends Model
{
    use SoftDeletes;
    use HasFactory;
    use AttributeModel;

    protected $fillable = [
        'user_id',
        'pedido_id',
        'titulo',
        'descricao',
        'privado',
        'tipo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function getCreatedAt()
    {
        $carbon = new Carbon($this->created_at);
        $now = Carbon::now();

        if ($carbon->isToday()) {
            return "hoje às " . $carbon->format('H:i');
        } elseif ($carbon->isYesterday()) {
            return "ontem às " . $carbon->format('H:i');
        } else {
            return $carbon->format('d/m/Y \à\s H:i');
        }
    }

    public function getTipo()
    {
        switch ($this->tipo) {
            case 'np':
                return ['step-color' => 'steps-green', 'icon' => 'text-success ti ti-circle-plus', 'bg' => 'bg-success'];
            case 'up':
                return ['step-color' => 'steps-green', 'icon' => 'text-success ti ti-edit', 'bg' => 'bg-success'];
            case 'tp':
                return ['step-color' => 'steps-blue', 'icon' => 'text-primary ti ti-clock-play', 'bg' => 'bg-primary'];
            case 'cp':
                return ['step-color' => 'steps-green', 'icon' => 'text-success ti ti-circle-check', 'bg' => 'bg-success'];
            case 'ep':
                return ['step-color' => 'steps-red', 'icon' => 'text-danger ti ti-circle-x', 'bg' => 'bg-danger'];
            case 'ap':
                return ['step-color' => 'steps-green', 'icon' => 'text-success ti ti-circle-letter-a', 'bg' => 'bg-success'];
            case 'op':
            case 'pp':
                return ['step-color' => 'steps-orange', 'icon' => 'text-warning ti ti-alert-circle', 'bg' => 'bg-warning'];
            case 'rp':
                return ['step-color' => 'steps-orange', 'icon' => 'text-warning ti ti-refresh-alert', 'bg' => 'bg-warning'];
            case 'vp':
                return ['step-color' => 'steps-blue', 'icon' => 'text-primary ti ti-eye', 'bg' => 'bg-primary'];
            case 'pr':
                return ['step-color' => 'steps-green', 'icon' => 'text-success ti ti-checks', 'bg' => 'bg-success'];
            case 'uf':
                return ['step-color' => 'steps-green', 'icon' => 'text-success ti ti-upload', 'bg' => 'bg-success'];
            case 'df':
                return ['step-color' => 'steps-blue', 'icon' => 'text-primary ti ti-download', 'bg' => 'bg-primary'];
            case 'ef':
                return ['step-color' => 'steps-red', 'icon' => 'text-danger ti ti-trash', 'bg' => 'bg-danger'];
            default:
                return ['step-color' => 'steps-yellow', 'icon' => 'text-yellow ti ti-info', 'bg' => 'bg-yellow'];
        }
    }
}
