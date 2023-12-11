<?php

namespace App\Events;

use App\Models\Despachante;
use Illuminate\Foundation\Events\Dispatchable;

class CreatedDespachanteEvent
{
    use Dispatchable;

    public Despachante $despachante;

    public function __construct(Despachante $despachante)
    {
        $this->despachante = $despachante;
    }
}
