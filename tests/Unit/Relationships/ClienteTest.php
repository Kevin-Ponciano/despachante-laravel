<?php

namespace Relationships;

use App\Models\Atpv;
use App\Models\Cliente;
use App\Models\Despachante;
use App\Models\Pedido;
use App\Models\Processo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
        $users = User::factory()->count(3)->state([
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

    public function test_has_many_through_processos()
    {
        $cliente = Cliente::factory()->create();
        $processos = Processo::factory(6)->state(new Sequence(
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente->id,
            ])->create()->id],
        ))->create();

        foreach ($processos as $processo) {
            $this->assertTrue($cliente->processos->contains($processo));
        }
    }

    public function test_pedidos_with_processos()
    {
        $cliente = Cliente::factory()->create();
        Processo::factory(3)->state(new Sequence(
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente->id,
            ])->create()->id],
        ))->create();

        Atpv::factory(3)->state(new Sequence(
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente->id,
            ])->create()->id],
        ))->create();

        $pedidos = Pedido::with('processo')->where('cliente_id', $cliente->id)
            ->get()->reject(function ($value) {
                return $value->processo == null;
            });

        foreach ($pedidos as $pedido) {
            $this->assertTrue($cliente->pedidosWithProcessos()->contains($pedido));
        }
    }

    public function test_pedidos_with_atpvs()
    {
        $cliente = Cliente::factory()->create();
        Processo::factory(3)->state(new Sequence(
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente->id,
            ])->create()->id],
        ))->create();

        Atpv::factory(3)->state(new Sequence(
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente->id,
            ])->create()->id],
        ))->create();

        $pedidos = Pedido::with('atpv')->where('cliente_id', $cliente->id)
            ->get()->reject(function ($value) {
                return $value->atpv == null;
            });

        foreach ($pedidos as $pedido) {
            $this->assertTrue($cliente->pedidosWithAtpvs()->contains($pedido));
        }
    }
}
