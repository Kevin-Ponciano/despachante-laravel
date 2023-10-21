<?php

namespace Database\Factories;

use App\Models\Despachante;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class DespachanteFactory extends Factory
{
    protected $model = Despachante::class;

    public function definition(): array
    {
        $faker = Faker::create('pt_BR');
        return [
            'razao_social' => $faker->company,
            'nome_fantasia' => $faker->company,
            'cnpj' => $faker->numerify('##.###.###/####-##'),
            'telefone' => $faker->numerify('(##) ####-####'),
            'celular' => $faker->cellphoneNumber,
            'email' => $faker->unique()->safeEmail,
            'endereco_id' => $faker->unique()->numberBetween(1, 10000),
        ];
    }
}
