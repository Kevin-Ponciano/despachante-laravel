<?php

namespace Relationships;

use App\Models\Atpv;
use App\Models\Cliente;
use App\Models\Despachante;
use App\Models\Endereco;
use App\Models\Pedido;
use App\Models\Plano;
use App\Models\Processo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DespachanteTest extends TestCase
{
    use RefreshDatabase;

    public function test_belongs_to_endereco()
    {
        $endereco = Endereco::factory()->create();
        $despachante = Despachante::factory()->state([
            'endereco_id' => $endereco->id
        ])->create();

        $this->assertTrue($despachante->endereco->is($endereco));
    }

    public function test_belongs_to_plano()
    {
        $plano = Plano::factory()->create();
        $despachante = Despachante::factory()->state([
            'plano_id' => $plano->id
        ])->create();

        $this->assertTrue($despachante->plano->is($plano));
    }

    public function test_has_many_clientes()
    {
        $despachante = Despachante::factory()->create();
        $clientes = Cliente::factory()->count(3)->state([
            'despachante_id' => $despachante->id
        ])->create();

        foreach ($clientes as $cliente) {
            $this->assertTrue($despachante->clientes->contains($cliente));
        }
    }

    public function test_has_many_users()
    {
        $despachante = Despachante::factory()->create();
        $users = User::factory()->count(3)->state([
            'despachante_id' => $despachante->id,
        ])->create();

        foreach ($users as $user) {
            $this->assertTrue($despachante->users->contains($user));
        }
    }

    public function test_has_many_through_pedidos()
    {
        $user = User::factory()->state([
            'despachante_id' => Despachante::factory()->create()->id,
        ])->create();
        $pedidos = Pedido::factory(6)->state(new Sequence(
            ['cliente_id' => Cliente::factory()->state([
                'despachante_id' => $user->despachante->id,
            ])->create()->id],
            ['cliente_id' => Cliente::factory()->state([
                'despachante_id' => $user->despachante->id,
            ])->create()->id],
            ['cliente_id' => Cliente::factory()->state([
                'despachante_id' => $user->despachante->id,
            ])->create()->id],
        ))->create();

        foreach ($pedidos as $pedido) {
            $this->assertTrue($user->despachante->pedidos->contains($pedido));
        }
    }

    public function test_has_many_through_processos()
    {
        $user = User::factory()->state([
            'despachante_id' => Despachante::factory()->create()->id,
        ])->create();
        $clientes = Cliente::factory(3)->state([
            'despachante_id' => $user->despachante->id,
        ])->create();
        $pedidos = Pedido::factory(3)->state(new Sequence(
            ['cliente_id' => $clientes[0]->id],
            ['cliente_id' => $clientes[1]->id],
            ['cliente_id' => $clientes[2]->id],
        ))->create();
        $processos = Processo::factory(3)->state(new Sequence(
            ['pedido_id' => $pedidos[0]->id],
            ['pedido_id' => $pedidos[1]->id],
            ['pedido_id' => $pedidos[2]->id],
        ))->create();

        foreach ($processos as $processo) {
            $this->assertTrue($user->despachante->processos()->contains($processo));
        }
    }

    public function test_pedidos_with_processos()
    {
        $despachante = Despachante::factory()->create();
        $cliente = Cliente::factory(3)->state([
            'despachante_id' => $despachante->id,
        ])->create();
        Processo::factory(3)->state(new Sequence(
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente[0]->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente[1]->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente[2]->id,
            ])->create()->id],
        ))->create();

        Atpv::factory(3)->state(new Sequence(
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente[0]->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente[1]->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente[2]->id,
            ])->create()->id],
        ))->create();

        $pedidos = $despachante->pedidos()->with('processo')->get()->reject(function ($value) {
            return $value->processo == null;
        });

        foreach ($pedidos as $pedido) {
            $this->assertTrue($despachante->pedidosWithProcessos()->contains($pedido));
        }
    }

    public function test_pedidos_with_atpvs()
    {
        $despachante = Despachante::factory()->create();
        $cliente = Cliente::factory(3)->state([
            'despachante_id' => $despachante->id,
        ])->create();
        Processo::factory(3)->state(new Sequence(
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente[0]->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente[1]->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente[2]->id,
            ])->create()->id],
        ))->create();

        Atpv::factory(3)->state(new Sequence(
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente[0]->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente[1]->id,
            ])->create()->id],
            ['pedido_id' => Pedido::factory()->state([
                'cliente_id' => $cliente[2]->id,
            ])->create()->id],
        ))->create();

        $pedidos = $despachante->pedidos()->with('atpv')->get()->reject(function ($value) {
            return $value->atpv == null;
        });

        foreach ($pedidos as $pedido) {
            $this->assertTrue($despachante->pedidosWithAtpvs()->contains($pedido));
        }
    }
}
