<?php

namespace Tests\Unit\Relationships;

use App\Models\Atpv;
use App\Models\Despachante;
use App\Models\Endereco;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnderecoTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_one_despachantes()
    {
        $endereco = Endereco::factory()->create();
        $despachante = Despachante::factory()->state([
            'endereco_id' => $endereco->id
        ])->create();

        $this->assertTrue($endereco->despachante->is($despachante));
    }

    public function test_has_many_atpvs()
    {
        $endereco = Endereco::factory()->create();
        $atpvs = Atpv::factory()->count(3)->state([
            'comprador_endereco_id' => $endereco->id,
        ])->create();

        foreach ($atpvs as $atpv) {
            $this->assertTrue($endereco->atpvs->contains($atpv));
        }
    }
}
