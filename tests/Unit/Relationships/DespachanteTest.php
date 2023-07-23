<?php

namespace Relationships;

use App\Models\Cliente;
use App\Models\Despachante;
use App\Models\Endereco;
use App\Models\Plano;
use App\Models\User;
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
        $users= User::factory()->count(3)->state([
            'despachante_id' => $despachante->id,
        ])->create();

        foreach ($users as $user) {
            $this->assertTrue($despachante->users->contains($user));
        }
    }
}
