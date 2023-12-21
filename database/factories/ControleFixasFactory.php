<?php

namespace Database\Factories;

use App\Models\ControleFixas;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ControleFixasFactory extends Factory
{
    protected $model = ControleFixas::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
