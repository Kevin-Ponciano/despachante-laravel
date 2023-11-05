<?php

namespace Tests\Unit\Relationships;

use App\Models\Cliente;
use App\Models\Despachante;
use App\Models\Log;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_belongs_to_despachante()
    {
        $despachante = Despachante::factory()->create();
        $user = User::factory()->state([
            'despachante_id' => $despachante->id,
        ])->create();

        $this->assertTrue($user->despachante->is($despachante));
    }

    public function test_belogns_to_cliente()
    {
        $cliente = Cliente::factory()->create();
        $user = User::factory()->state([
            'cliente_id' => $cliente->id,
        ])->create();

        $this->assertTrue($user->cliente->is($cliente));
    }

    public function test_has_many_pedidos_criados()
    {
        $user = User::factory()->create();
        $pedidos = Pedido::factory()->count(3)->state([
            'criado_por' => $user->id,
        ])->create();

        foreach ($pedidos as $pedido) {
            $this->assertTrue($user->pedidosCriados->contains($pedido));
        }
    }

    public function test_has_many_pedidos_responsaveis()
    {
        $user = User::factory()->create();
        $pedidos = Pedido::factory()->count(3)->state([
            'responsavel_por' => $user->id,
        ])->create();

        foreach ($pedidos as $pedido) {
            $this->assertTrue($user->pedidosResponsaveis->contains($pedido));
        }
    }

    public function test_has_many_pedidos_concluidos()
    {
        $user = User::factory()->create();
        $pedidos = Pedido::factory()->count(3)->state([
            'concluido_por' => $user->id,
        ])->create();

        foreach ($pedidos as $pedido) {
            $this->assertTrue($user->pedidosConcluidos->contains($pedido));
        }
    }

    public function test_has_many_logs()
    {
        $user = User::factory()->create();
        $logs = Log::factory()->count(3)->state([
            'usuario_id' => $user->id,
        ])->create();

        foreach ($logs as $log) {
            $this->assertTrue($user->logs->contains($log));
        }
    }
}
