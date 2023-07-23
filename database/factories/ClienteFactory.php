<?php

namespace Database\Factories;

use App\Models\Cliente;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition(): array
    {
        $faker = Faker::create('pt_BR');
        return [
            'nome' => $faker->company,
            'status' => $faker->randomElement(['at', 'in']),
            'preco_1_placa' => $faker->randomFloat(2, 100, 1000),
            'preco_2_placa' => $faker->randomFloat(2, 100, 1000),
            'preco_atpv' => $faker->randomFloat(2, 100, 1000),
            'preco_loja' => $faker->randomFloat(2, 100, 1000),
            'preco_terceiro' => $faker->randomFloat(2, 100, 1000),
            'despachante_id' => 1,
        ];
    }
}
