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
            'cor' => 'bg-secondary',
        ]);

        $despachante->categorias()->create([
            'nome' => 'Serviços',
            'icone' => 'ti ti-clipboard-list',
            'cor' => 'bg-green',
        ]);

        $despachante->categorias()->create([
            'nome' => 'Salários',
            'icone' => 'ti ti-coin',
            'cor' => 'bg-primary',
        ]);
    }
}
