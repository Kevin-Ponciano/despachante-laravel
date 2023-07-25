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

        Despachante::factory(3)->create()->each(function ($despachante) {
            $despachante->endereco_id = Endereco::factory()->create()->id;
            $despachante->save();
            Servico::factory(3)->create([
                'despachante_id' => $despachante->id,
            ]);

            User::factory(2)->create([
                'despachante_id' => $despachante->id,
            ]);

            Cliente::factory(3)->create([
                'despachante_id' => $despachante->id,
            ])->each(function ($cliente) {
                $user = User::factory()->create([
                    'role' => 'ca',
                    'despachante_id' => null,
                    'cliente_id' => $cliente->id,
                ]);

                Pedido::factory(5)->create([
                    'criado_por' => $user->id,
                    'cliente_id' => $cliente->id,
                ])->each(function ($pedido) {
                    Atpv::factory()->create([
                        'comprador_endereco_id' => Endereco::factory()->create()->id,
                        'pedido_id' => $pedido->id,
                    ]);
                });
                Pedido::factory(5)->create([
                    'criado_por' => $user->id,
                    'cliente_id' => $cliente->id,
                ])->each(function ($pedido) {
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
            'despachante_id' => Despachante::orderBy('id', 'desc')->first()->id,
        ]);
        User::factory()->create([
            'name' => 'cliente',
            'password' => Hash::make('123'),
            'role' => 'ca',
            'cliente_id' => Cliente::first()->id,
        ]);
    }
}
