<?php

namespace Database\Factories;

use App\Models\Pendencia;
use Illuminate\Database\Eloquent\Factories\Factory;

class PendenciaFactory extends Factory
{
    protected $model = Pendencia::class;

    public function definition(): array
    {
        return [
            'nome' => $this->faker->word,
            'tipo' => $this->faker->randomElement(['dc', 'cp']),
            'status' => $this->faker->randomElement(['co', 'pe']),
            'observacao' => $this->faker->text(100),
        ];
    }
}
