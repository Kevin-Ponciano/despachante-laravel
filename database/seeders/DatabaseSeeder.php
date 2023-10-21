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
        $qtdDespachantes = 3;
        $qtdUsuariosPorDespachante = 3;
        $qtdClientesPorDespachante = 3;
        $qtdServicosPorDespachante = 3;
        $qtdPedidosPorCliente = 15;
        $qtdPendenciasPorPedido = 0;

        RolesAndPermissionsSeeder::run();
        $faker = Factory::create('pt_BR');
        Despachante::factory($qtdDespachantes)->create()->each(function ($despachante) use ($qtdPedidosPorCliente, $qtdPendenciasPorPedido, $qtdClientesPorDespachante, $qtdUsuariosPorDespachante, $faker) {
            $despachante->endereco_id = Endereco::factory()->create()->id;
            $despachante->save();
            Servico::factory(3)->create([
                'despachante_id' => $despachante->id,
            ]);

            $planoId = Plano::factory()->create()->id;
            $despachante->plano()->attach($planoId, [
                'preco' => $faker->randomFloat(2, 1, 1000),
                'qtd_clientes' => $faker->numberBetween(1, 100),
                'qtd_usuarios' => $faker->numberBetween(1, 100),
                'qtd_processos_mes' => $faker->numberBetween(1, 1000000),
            ]);

            $user = User::factory($qtdUsuariosPorDespachante)->create([
                'despachante_id' => $despachante->id,
            ]);
            foreach ($user as $u) {
                $u->assignRole('Despachante-Admin');
            }

            Cliente::factory($qtdClientesPorDespachante)->create([
                'despachante_id' => $despachante->id,
            ])->each(function ($cliente) use ($qtdPendenciasPorPedido, $qtdPedidosPorCliente, $faker) {
                $user = User::factory()->create([
                    'role' => 'ca',
                    'despachante_id' => null,
                    'cliente_id' => $cliente->id,
                ]);
                $user->assignRole('Cliente');

                Pedido::factory($qtdPedidosPorCliente)->create([
                    'criado_por' => $user->id,
                    'cliente_id' => $cliente->id,
                ])->each(function ($pedido) use ($qtdPendenciasPorPedido) {
                    Atpv::factory()->create([
                        'comprador_endereco_id' => Endereco::factory()->create()->id,
                        'pedido_id' => $pedido->id,
                    ]);
//                    PedidoServico::create([
//                        'pedido_id' => $pedido->id,
//                        'servico_id' => Servico::factory()->create([
//                            'despachante_id' => $pedido->cliente->despachante->id,
//                        ])->id,
//                    ]);
                    Pendencia::factory($qtdPendenciasPorPedido)->create([
                        'pedido_id' => $pedido->id,
                    ]);
                });
                Pedido::factory($qtdPedidosPorCliente)->create([
                    'criado_por' => $user->id,
                    'cliente_id' => $cliente->id,
                ])->each(function ($pedido) use ($qtdPendenciasPorPedido, $faker) {
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
                    Pendencia::factory($qtdPendenciasPorPedido)->create([
                        'pedido_id' => $pedido->id,
                    ]);
                });
            });

        });

        User::find(1)->assignRole('Admin')->assignRole('Despachante-Admin')
            ->update([
                'name' => 'admin',
                'email' => 'admin@admin',
                'password' => Hash::make('123'),
                'role' => 'da',
                'status' => 'at',
            ]);
        User::find(2)->assignRole('Despachante-Admin')
            ->update([
                'name' => 'despachante',
                'email' => 'despachante@despachante',
                'password' => Hash::make('123'),
                'role' => 'da',
                'status' => 'at',
            ]);

        User::find(3)->assignRole('Cliente')
            ->update([
                'name' => 'cliente',
                'email' => 'cliente@cliente',
                'password' => Hash::make('123'),
                'role' => 'ca',
                'status' => 'at',
                'cliente_id' => 1,
                'despachante_id' => null,
            ]);
    }
}
