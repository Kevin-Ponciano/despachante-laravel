<?php

namespace Database\Factories;

use App\Models\Atpv;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class AtpvFactory extends Factory
{
    protected $model = Atpv::class;

    public function definition(): array
    {
        $faker = Faker::create('pt_BR');
        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $faker->dateTime->format('Y-m-d H:i:s'));
        return [
            'renavam' => $faker->numerify('###########'),
            'numero_crv' => $faker->numerify('############'),
            'codigo_crv' => $faker->randomElement([null, $faker->numerify('############')]),
            'hodometro' => $this->faker->randomFloat(2, 0, 1000),
            'data_hodometro' => $datetime->format('Y-m-d H:i'),
            'vendedor_email' => $faker->email,
            'vendedor_telefone' => $faker->cellphoneNumber,
            'vendedor_cpf_cnpj' => $faker->numerify('##.###.###/####-##'),
            'comprador_cpf_cnpj' => $faker->numerify('###.###.###-##'),
            'comprador_email' => $faker->email,
            'comprador_endereco_id' => 1,
            'preco_venda' => $this->faker->randomFloat(2, 0, 10000),
            'pedido_id' => 1,
        ];
    }
}
