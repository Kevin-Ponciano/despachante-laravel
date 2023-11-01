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
        $qtdServicosPorDespachante = 10;
        $qtdPedidosPorCliente = 10;
        $qtdPendenciasPorPedido = 0;

        RolesAndPermissionsSeeder::run();
        $faker = Factory::create('pt_BR');
        Endereco::factory($qtdDespachantes)->create()->each(function ($endereco) use ($qtdPedidosPorCliente, $qtdPendenciasPorPedido, $qtdClientesPorDespachante, $qtdUsuariosPorDespachante, $faker) {
            $despachante = Despachante::factory()->create([
                'endereco_id' => $endereco->id,
            ]);
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
                $u->assignRole('[DESPACHANTE] - USUÁRIO');
            }

            Cliente::factory($qtdClientesPorDespachante)->create([
                'despachante_id' => $despachante->id,
            ])->each(function ($cliente) use ($qtdPendenciasPorPedido, $qtdPedidosPorCliente, $faker) {
                $user = User::factory()->create([
                    'despachante_id' => null,
                    'cliente_id' => $cliente->id,
                ]);
                $user->assignRole('[CLIENTE]');

                Pedido::factory($qtdPedidosPorCliente)->create([
                    'criado_por' => $user->id,
                    'cliente_id' => $cliente->id,
                ])->each(function ($pedido) use ($qtdPendenciasPorPedido) {
                    Atpv::factory()->create([
                        'comprador_endereco_id' => Endereco::factory()->create()->id,
                        'pedido_id' => $pedido->id,
                    ]);
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
                    Pendencia::factory($qtdPendenciasPorPedido)->create([
                        'pedido_id' => $pedido->id,
                    ]);
                });
            });

        });

        User::find(1)->assignRole('[ADMIN]')->assignRole('[DESPACHANTE] - ADMIN')
            ->update([
                'name' => 'admin',
                'email' => 'admin@admin',
                'password' => Hash::make('123'),
                'status' => 'at',
            ]);
        User::find(2)->assignRole('[DESPACHANTE] - ADMIN')
            ->update([
                'name' => 'despachante',
                'email' => 'despachante@despachante',
                'password' => Hash::make('123'),
                'status' => 'at',
            ]);

        User::find(5)->assignRole('[CLIENTE]')->removeRole('[DESPACHANTE] - ADMIN')
            ->update([
                'name' => 'cliente',
                'email' => 'cliente@cliente',
                'password' => Hash::make('123'),
                'status' => 'at',
                'cliente_id' => 1,
                'despachante_id' => null,
            ]);
    }
}
