<?php

namespace Tests\Unit\Relationships;

use App\Models\Pedido;
use App\Models\PedidoServico;
use App\Models\Servico;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PedidoServicoTest extends TestCase
{
    use RefreshDatabase;

    public function test_belongs_to_servico()
    {
        $servico = Servico::factory()->create();
        $pedidoServico = PedidoServico::factory()->state([
            'servico_id' => $servico->id,
        ])->create();

        $this->assertTrue($pedidoServico->servico->is($servico));
    }

    public function test_belongs_to_pedido()
    {
        $pedido = Pedido::factory()->create();
        $pedidoServico = PedidoServico::factory()->state([
            'pedido_id' => $pedido->id,
        ])->create();

        $this->assertTrue($pedidoServico->pedido->is($pedido));
    }
}
