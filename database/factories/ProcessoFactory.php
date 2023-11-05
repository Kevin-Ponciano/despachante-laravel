<?php

namespace Database\Factories;

use App\Models\Processo;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProcessoFactory extends Factory
{
    protected $model = Processo::class;

    public function definition(): array
    {
        $faker = Faker::create('pt_BR');

        return [
            'tipo' => $faker->randomElement(['ss', 'rv']),
            'comprador_tipo' => $faker->randomElement(['lj', 'tc']),
            'qtd_placas' => $faker->randomElement([0, 1, 2]),
            'preco_placa' => $faker->randomFloat(2, 100, 1000),
            'pedido_id' => 1,
        ];
    }
}
