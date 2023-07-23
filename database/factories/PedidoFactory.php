<?php

namespace Database\Factories;

use App\Models\Pedido;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PedidoFactory extends Factory
{
    protected $model = Pedido::class;

    public function definition(): array
    {
        $faker = Faker::create('pt_BR');
        return [
            'comprador_nome' => $faker->name,
            'comprador_telefone' => $faker->cellphoneNumber,
            'placa' => $faker->numerify('#######'),
            'veiculo' => $faker->word,
            'preco_placa' => $faker->randomFloat(2, 100, 1000),
            'preco_honorario' => $faker->randomFloat(2, 100, 1000),
            'status' => $faker->randomElement(['ab', 'ea', 'pe', 'co']),
            'dados_inconsistentes' => null,
            'retorno_pendencia' => 0,
            'documento_enviado' => 0,
            'criado_por' => 1,
            'responsavel_por' => 1,
            'concluido_por' => $faker->randomElement([null, 1]),
            'cliente_id' => 1,
        ];
    }
}
