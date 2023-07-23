<?php

namespace Tests\Unit\Relationships;

use App\Models\Pedido;
use App\Models\Processo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProcessoTest extends TestCase
{
    use RefreshDatabase;

    public function test_belongs_to_pedido()
    {
        $pedido = Pedido::factory()->create();
        $processo = Processo::factory()->state([
            'pedido_id' => $pedido->id
        ])->create();

        $this->assertTrue($processo->pedido->is($pedido));
    }
}
