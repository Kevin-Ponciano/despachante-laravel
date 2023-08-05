<?php

namespace Database\Factories;

use App\Models\PedidoServico;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoServicoFactory extends Factory
{
    protected $model = PedidoServico::class;

    public function definition(): array
    {
        return [
            'pedido_id' => 1,
            'servico_id' => 1,
            'preco' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }
}
