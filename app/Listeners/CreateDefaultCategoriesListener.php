<?php

namespace App\Listeners;

use App\Events\CreatedDespachanteEvent;

class CreateDefaultCategoriesListener
{
    public function __construct()
    {
    }

    public function handle(CreatedDespachanteEvent $event): void
    {
        $despachante = $event->despachante;

        $despachante->categorias()->create([
            'nome' => 'Outros',
            'icone' => 'ti ti-dots',
            'cor' => 'secondary',
        ]);

        $despachante->categorias()->create([
            'nome' => 'Serviços',
            'icone' => 'ti ti-clipboard-list',
            'cor' => 'green',
        ]);

        $despachante->categorias()->create([
            'nome' => 'Salário',
            'icone' => 'ti ti-coin',
            'cor' => 'primary',
        ]);
    }
}
