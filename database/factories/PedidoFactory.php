<?php

namespace Database\Factories;

use App\Models\Pedido;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoFactory extends Factory
{
    protected $model = Pedido::class;

    public function definition(): array
    {
        $faker = Faker::create('pt_BR');
        return [
            'comprador_nome' => $faker->name,
            'comprador_telefone' => $faker->cellphoneNumber,
            'placa' => $faker->regexify('[A-Z]{3}[0-9]{4}'),
            'veiculo' => $faker->word,
            'preco_honorario' => $faker->randomFloat(2, 100, 1000),
            'status' => $faker->randomElement(['ab', 'rp', 'ea', 'pe', 'co']),
            'criado_por' => 1,
            'responsavel_por' => null,
            'cliente_id' => 1,
        ];
    }
}
