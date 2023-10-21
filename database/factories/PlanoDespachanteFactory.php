<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PlanoDespachanteFactory extends Factory
{
    protected $model = PlanoDespachanteFactory::class;

    public function definition(): array
    {
        return [
            'plano_id' => 1,
            'despachante_id' => 1,
            'preco' => $this->faker->randomFloat(2, 1, 1000),
            'qtd_clientes' => $this->faker->numberBetween(1, 100),
            'qtd_usuarios' => $this->faker->numberBetween(1, 100),
            'qtd_processos_mes' => $this->faker->numberBetween(1, 1000000),
        ];
    }
}
