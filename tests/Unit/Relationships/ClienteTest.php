<?php

namespace Relationships;

use App\Models\Cliente;
use App\Models\Despachante;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    use RefreshDatabase;
    public function test_belongs_to_despachante()
    {
        $despachante = Despachante::factory()->create();
        $cliente = Cliente::factory()->state([
            'despachante_id' => $despachante->id,
        ])->create();

        $this->assertTrue($cliente->despachante->is($despachante));
    }

    public function test_has_many_users()
    {
        $cliente = Cliente::factory()->create();
        $users= User::factory()->count(3)->state([
            'cliente_id' => $cliente->id,
        ])->create();

        foreach ($users as $user) {
            $this->assertTrue($cliente->users->contains($user));
        }
    }

    public function test_has_many_pedidos()
    {
        $cliente = Cliente::factory()->create();
        $pedidos = Pedido::factory()->count(3)->state([
            'cliente_id' => $cliente->id,
        ])->create();

        foreach ($pedidos as $pedido) {
            $this->assertTrue($cliente->pedidos->contains($pedido));
        }
    }
}
