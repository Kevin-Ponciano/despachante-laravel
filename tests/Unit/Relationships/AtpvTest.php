<?php

namespace Relationships;

use App\Models\Atpv;
use App\Models\Endereco;
use App\Models\Pedido;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AtpvTest extends TestCase
{
    use RefreshDatabase;

    public function test_belongs_to_pedido()
    {
        $pedido = Pedido::factory()->create();
        $atpv = Atpv::factory()->state([
            'pedido_id' => $pedido->id,
        ])->create();

        // Verifique se o relacionamento pertence ao pedido
        $this->assertTrue($atpv->pedido->is($pedido));
    }

    public function test_belongs_to_comprador_endereco()
    {

        $endereco = Endereco::factory()->create();
        $atpv = Atpv::factory()->state([
            'comprador_endereco_id' => $endereco->id,
        ])->create();

        $this->assertTrue($atpv->compradorEndereco->is($endereco));
    }
}
