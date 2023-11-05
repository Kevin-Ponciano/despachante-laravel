<?php

namespace Database\Factories;

use App\Models\Plano;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'qtd_clientes' => $this->faker->numberBetween(1, 100),
            'qtd_usuarios' => $this->faker->numberBetween(1, 100),
            'qtd_processos_mes' => $this->faker->numberBetween(1, 1000000),
        ];
    }
}
