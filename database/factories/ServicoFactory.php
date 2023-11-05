<?php

namespace Database\Factories;

use App\Models\Servico;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServicoFactory extends Factory
{
    protected $model = Servico::class;

    public function definition(): array
    {
        $faker = Faker::create('pt_BR');

        return [
            'nome' => $faker->word,
            'preco' => $faker->randomFloat(2, 100, 1000),
            'descricao' => $faker->text,
            'despachante_id' => 1,
        ];
    }
}
