<?php

namespace Tests\Unit\Relationships;

use App\Models\Despachante;
use App\Models\PedidoServico;
use App\Models\Servico;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServicoTest extends TestCase
{
    use RefreshDatabase;

    public function test_belongs_to_despachante()
    {
        $despachante = Despachante::factory()->create();
        $servico = Servico::factory()->state([
            'despachante_id' => $despachante->id,
        ])->create();

        $this->assertTrue($servico->despachante->is($despachante));
    }

    public function test_has_many_pedido_servicos()
    {
        $servico = Servico::factory()->create();
        $pedidoServico = PedidoServico::factory()->count(3)->state([
            'servico_id' => $servico->id,
        ])->create();

        foreach ($pedidoServico as $pedido) {
            $this->assertTrue($servico->pedidoServicos->contains($pedido));
        }
    }
}
