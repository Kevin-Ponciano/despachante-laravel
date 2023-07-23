<?php

namespace Database\Factories;

use App\Models\Log;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class LogFactory extends Factory
{
    protected $model = Log::class;

    public function definition(): array
    {
        $faker = Faker::create('pt_BR');
        return [
            'descricao' => $faker->text,
            'tipo' => $faker->randomElement(['if', 'wa', 'er']), // if = info, wa = warning, er = error
            'usuario_id' => 1,
            'pedido_id' => 1,
        ];
    }
}
