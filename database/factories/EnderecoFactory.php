<?php

namespace Database\Factories;

use App\Models\Endereco;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EnderecoFactory extends Factory
{
    protected $model = Endereco::class;

    public function definition(): array
    {
        $faker = Faker::create('pt_BR');
        return [
            'logradouro' => $faker->streetName,
            'numero' => $faker->buildingNumber,
            'bairro' => $faker->citySuffix,
            'cidade' => $faker->city,
            'estado' => $faker->stateAbbr,
            'cep' => $faker->postcode,
        ];
    }
}
