<?php

namespace Database\Factories;

use App\Models\Transacao;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TransacaoFactory extends Factory
{
    protected $model = Transacao::class;

    public function definition(): array
    {
        return [
            'transacao_original_id' => null,
            'tipo' => $this->faker->randomElement(['in', 'out']),
            'despachante_id' => null,
            'cliente_id' => null,
            'pedido_id' => null,
            'categoria_id' => null,
            'valor' => $this->faker->randomFloat(2, 0, 9999.99),
            'status' => $this->faker->randomElement(['pg', 'pe']),
            'data_vencimento' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'data_pagamento' => $this->faker->randomElement([null, $this->faker->dateTimeBetween('-1 year', '+1 year')]),
            'descricao' => $this->faker->sentence(3),
            'observacao' => $this->faker->randomElement([null, $this->faker->sentence(3)]),
            'recorrencia' => 'n/a',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
