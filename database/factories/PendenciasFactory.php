<?php

namespace Database\Factories;

use App\Models\Pendencias;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PendenciasFactory extends Factory
{
    protected $model = Pendencias::class;

    public function definition(): array
    {
        return [
            'data' => Carbon::now()->format('Y-m-d'),
            'descricao' => $this->faker->text(100),
            'status' => $this->faker->randomElement(['pendente', 'concluido']),
            'processo_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
