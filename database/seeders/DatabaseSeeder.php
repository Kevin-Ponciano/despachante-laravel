<?php

namespace Database\Seeders;

use App\Models\Atpv;
use App\Models\Cliente;
use App\Models\Despachante;
use App\Models\Endereco;
use App\Models\Pedido;
use App\Models\PedidoServico;
use App\Models\Pendencia;
use App\Models\Plano;
use App\Models\Processo;
use App\Models\Servico;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        RolesAndPermissionsSeeder::run();
        $faker = Factory::create('pt_BR');
        Despachante::factory(3)->create()->each(function ($despachante) use ($faker) {
            $despachante->endereco_id = Endereco::factory()->create()->id;
            $despachante->plano_id = Plano::factory()->create()->id;
            $despachante->save();

            User::factory()->create([
                'despachante_id' => $despachante->id,
            ])->assignRole('Usuario Despachante');

            Cliente::factory(3)->create([
                'despachante_id' => $despachante->id,
            ])->each(function ($cliente) use ($faker) {
                $user = User::factory()->create([
                    'role' => 'ca',
                    'despachante_id' => null,
                    'cliente_id' => $cliente->id,
                ]);
                $user->assignRole('Cliente');

                Pedido::factory(5)->create([
                    'criado_por' => $user->id,
                    'cliente_id' => $cliente->id,
                ])->each(function ($pedido) {
                    Atpv::factory()->create([
                        'comprador_endereco_id' => Endereco::factory()->create()->id,
                        'pedido_id' => $pedido->id,
                    ]);
                    PedidoServico::create([
                        'pedido_id' => $pedido->id,
                        'servico_id' => Servico::factory()->create([
                            'despachante_id' => $pedido->cliente->despachante->id,
                        ])->id,
                    ]);
                    Pendencia::factory()->create([
                        'pedido_id' => $pedido->id,
                    ]);
                });
                Pedido::factory(5)->create([
                    'criado_por' => $user->id,
                    'cliente_id' => $cliente->id,
                ])->each(function ($pedido) use ($faker) {
                    Processo::factory()->create([
                        'pedido_id' => $pedido->id,
                    ]);
                    PedidoServico::create([
                        'pedido_id' => $pedido->id,
                        'servico_id' => Servico::factory()->create([
                            'despachante_id' => $pedido->cliente->despachante->id,
                        ])->id,
                        'preco' => $faker->randomFloat(2, 1, 10000),
                    ]);
                    Pendencia::factory()->create([
                        'pedido_id' => $pedido->id,
                    ]);
                });
            });

        });

        User::find(9)->assignRole('Admin')
            ->update([
                'name' => 'admin',
                'email' => 'admin@admin',
                'password' => Hash::make('123'),
                'role' => 'da',
                'status' => 'at',
            ]);

        User::find(12)->update([
            'name' => 'cliente',
            'status' => 'at',
            'cliente_id' => 9,
        ]);
    }
}
