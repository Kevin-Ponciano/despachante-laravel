<?php

namespace Database\Factories;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create('pt_BR');
        return [
            'name' => $faker->unique()->name,
            'email' => $faker->unique()->email,
            'email_verified_at' => now(),
            'password' => Hash::make('123'),
            'role' => 'du',
            'status' => 'at',
            'despachante_id' => 1,
            'cliente_id' => null,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
        ];
    }

    /**
     * Indicate that the user is an admin.
     */
    public function adminDespachante(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'da',
            ];
        });
    }

    public function cliente(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'cu',
                'cliente_id' => 1,
            ];
        });
    }

    public function adminCliente(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'ca',
                'cliente_id' => 1,
            ];
        });
    }


    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

}
