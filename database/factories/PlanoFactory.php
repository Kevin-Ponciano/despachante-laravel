<?php

namespace Database\Factories;

use App\Models\Plano;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PlanoFactory extends Factory
{
    protected $model = Plano::class;

    public function definition(): array
    {
        $faker = Faker::create('pt_BR');
        return [
            'nome' => $faker->word,
            'preco' => $faker->randomFloat(2, 100, 1000),
            'descricao' => $faker->text,
            'qtd_clientes' => $faker->numberBetween(1, 50),
            'qtd_acessos_clientes' => $faker->numberBetween(1, 10),
        ];
    }
}
