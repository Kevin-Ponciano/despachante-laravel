<?php

namespace Tests\Unit\Relationships;


use App\Models\Log;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class LogTest extends TestCase
{
    use RefreshDatabase;

    public function test_belongs_to_user()
    {
        $user = User::factory()->create();
        $log = Log::factory()->state([
            'usuario_id' => $user->id,
        ])->create();

        $this->assertTrue($log->usuario->is($user));
    }

    public function test_belongs_to_pedido()
    {
        $pedido = Pedido::factory()->create();
        $log = Log::factory()->state([
            'pedido_id' => $pedido->id,
        ])->create();

        $this->assertTrue($log->pedido->is($pedido));
    }

}
