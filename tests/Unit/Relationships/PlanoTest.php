<?php

namespace Tests\Unit\Relationships;

use App\Models\Despachante;
use App\Models\Plano;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanoTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_many_despachantes()
    {
        $plano = Plano::factory()->create();
        $despachantes = Despachante::factory()->count(3)->state([
            'plano_id' => $plano->id,
        ])->create();

        foreach ($despachantes as $despachante) {
            $this->assertTrue($plano->despachantes->contains($despachante));
        }
    }
}
