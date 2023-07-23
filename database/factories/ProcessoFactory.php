<?php

namespace Database\Factories;

use App\Models\Pedido;
use App\Models\Processo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

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
            'pedido_id' => 1,
        ];
    }
}
