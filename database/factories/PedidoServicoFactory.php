<?php

namespace Database\Factories;

use App\Models\Pedido;
use App\Models\PedidoServico;
use App\Models\Servico;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PedidoServicoFactory extends Factory
{
    protected $model = PedidoServico::class;

    public function definition(): array
    {
        return [
            'pedido_id' => 1,
            'servico_id' => 1,
            'preco' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}
