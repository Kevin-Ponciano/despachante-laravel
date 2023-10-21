<?php

namespace Database\Factories;

use App\Models\Atpv;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class AtpvFactory extends Factory
{
    protected $model = Atpv::class;

    public function definition(): array
    {
        $faker = Faker::create('pt_BR');
        return [
            'renavam' => $faker->numerify('###########'),
            'numero_crv' => $faker->numerify('############'),
            'codigo_crv' => $faker->randomElement([null, $faker->numerify('############')]),
            'movimentacao' => $faker->randomElement([null, 'in', 'out']),
            'hodometro' => $this->faker->randomFloat(2, 0, 1000),
            'data_hodometro' => $faker->dateTime->format('Y-m-d H:i:s'),
            'vendedor_email' => $faker->email,
            'vendedor_telefone' => $faker->cellphoneNumber,
            'vendedor_cpf_cnpj' => '08.204.239/0001-95',
            'comprador_cpf_cnpj' => '08.204.239/0001-95',
            'comprador_email' => $faker->email,
            'comprador_endereco_id' => 1,
            'preco_venda' => $this->faker->randomFloat(2, 0, 10000),
            'pedido_id' => 1,
        ];
    }
}
