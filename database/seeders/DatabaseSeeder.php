<?php

namespace Database\Seeders;

use App\Models\Atpv;
use App\Models\Cliente;
use App\Models\Despachante;
use App\Models\Endereco;
use App\Models\Pedido;
use App\Models\Processo;
use App\Models\Servico;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $quantidadeDespachantes = 3;
        $quantidadeServicosPorDespachante = 3;
        $quantidadeClientesPorDespachante = 3;
        $quantidadePedidosPorCliente = 5;
        $quantidadeAtpvPorPedido = 1;

        Despachante::factory($quantidadeDespachantes)->create()->each(function ($despachante) use ($quantidadeServicosPorDespachante, $quantidadeClientesPorDespachante, $quantidadePedidosPorCliente, $quantidadeAtpvPorPedido) {
            $despachante->endereco_id = Endereco::factory()->create()->id;
            $despachante->save();

            Servico::factory($quantidadeServicosPorDespachante)->create([
                'despachante_id' => $despachante->id,
            ]);

            $user = User::factory()->create([
                'despachante_id' => $despachante->id,
            ]);

            Cliente::factory($quantidadeClientesPorDespachante)->create([
                'despachante_id' => $despachante->id,
            ])->each(function ($cliente) use ($user, $quantidadePedidosPorCliente, $quantidadeAtpvPorPedido) {
                User::factory()->create([
                    'role' => 'ca',
                    'cliente_id' => $cliente->id,
                ]);

                Pedido::factory($quantidadePedidosPorCliente)->create([
                    'criado_por' => $user->id,
                    'cliente_id' => $cliente->id,
                ])->each(function ($pedido) use ($cliente, $quantidadeAtpvPorPedido) {
                    for ($i = 0; $i < $quantidadeAtpvPorPedido; $i++) {
                        Atpv::factory()->create([
                            'comprador_endereco_id' => Endereco::factory()->create()->id,
                            'pedido_id' => $pedido->id,
                        ]);
                    }
                });
                Pedido::factory($quantidadePedidosPorCliente)->create([
                    'criado_por' => $user->id,
                    'cliente_id' => $cliente->id,
                ])->each(function ($pedido) use ($quantidadeAtpvPorPedido) {
                    for ($i = 0; $i < $quantidadeAtpvPorPedido; $i++) {
                        Atpv::factory()->create([
                            'pedido_id' => $pedido->id,
                        ]);
                    }

                    Processo::factory()->create([
                        'pedido_id' => $pedido->id,
                    ]);
                });
            });


        });

        User::create([
            'name' => 'admin',
            'email' => 'admin@admin',
            'password' => Hash::make('123'),
            'role' => 'dm',
            'despachante_id' => Despachante::first()->id,
        ]);
        User::factory()->create([
            'role' => 'ca',
            'cliente_id' => Cliente::first()->id,
        ]);
    }
}
