<?php

namespace Tests\Unit\Relationships;


use App\Models\Atpv;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\PedidoServico;
use App\Models\Processo;
use App\Models\Servico;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PedidoTest extends TestCase
{
    use RefreshDatabase;

    public function test_belongs_to_usuario_criador()
    {
        $usuario = User::factory()->create();
        $pedido = Pedido::factory()->state([
            'criado_por' => $usuario->id,
        ])->create();

        $this->assertTrue($pedido->usuarioCriador->is($usuario));
    }

    public function test_belongs_to_usuario_responsavel()
    {
        $usuario = User::factory()->create();
        $pedido = Pedido::factory()->state([
            'responsavel_por' => $usuario->id,
        ])->create();

        $this->assertTrue($pedido->usuarioResponsavel->is($usuario));
    }

    public function test_belongs_to_usuario_concluinte()
    {
        $usuario = User::factory()->create();
        $pedido = Pedido::factory()->state([
            'concluido_por' => $usuario->id,
        ])->create();

        $this->assertTrue($pedido->usuarioConcluinte->is($usuario));
    }

    public function test_belongs_to_cliente()
    {
        $cliente = Cliente::factory()->create();
        $pedido = Pedido::factory()->state([
            'cliente_id' => $cliente->id,
        ])->create();

        $this->assertTrue($pedido->cliente->is($cliente));
    }

    public function test_has_one_atpv()
    {
        $pedido = Pedido::factory()->create();
        $atpv = Atpv::factory()->state([
            'pedido_id' => $pedido->id,
        ])->create();

        $this->assertTrue($pedido->atpv->is($atpv));
    }

    public function test_has_one_processo()
    {
        $pedido = Pedido::factory()->create();
        $processo = Processo::factory()->state([
            'pedido_id' => $pedido->id,
        ])->create();

        $this->assertTrue($pedido->processo->is($processo));
    }

    public function test_belongs_to_many_servicos()
    {
        $pedido = Pedido::factory()->create();
        $servico = Servico::factory()->count(3)->create();
        $pedidoServicos = PedidoServico::factory()->count(3)->state(
            new Sequence(
                ['pedido_id' => $pedido->id, 'servico_id' => $servico[0]->id],
                ['pedido_id' => $pedido->id, 'servico_id' => $servico[1]->id],
                ['pedido_id' => $pedido->id, 'servico_id' => $servico[2]->id],
            )
        )->create();

        foreach ($servico as $s) {
            $this->assertTrue($pedido->servicos->contains($s));
        }
    }
}
