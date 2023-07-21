<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Atpv;
use App\Models\Cliente;
use App\Models\Despachante;
use App\Models\Endereco;
use App\Models\Pedido;
use App\Models\PedidoServico;
use App\Models\Plano;
use App\Models\Processo;
use App\Models\Servico;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create('pt_BR');

        $plano = Plano::create([
            'nome' => 'Plano 1',
            'preco' => 100,
            'descricao' => 'Descrição 1',
            'qtd_clientes' => 100,
            'qtd_acessos_clientes' => 10,
        ]);

        for ($i = 0; $i < 3; $i++) {
            $endereco = Endereco::create([
                'logradouro' => $faker->streetName,
                'numero' => $faker->buildingNumber,
                'bairro' => $faker->citySuffix,
                'cidade' => $faker->city,
                'estado' => $faker->stateAbbr,
                'cep' => $faker->postcode,
            ]);

            $despachantes = Despachante::create([
                'razao_social' => $faker->company,
                'cnpj' => $faker->numerify('##############'),
                'endereco_id' => $endereco->id,
                'plano_id' => $plano->id,
            ]);
        }


<<<<<<< Updated upstream
        $pedidos = [];
        $qtd_pedidos = 30;
        for($i = 0; $i < $qtd_pedidos; $i++) {
            $pedidos[] = [
                'comprador_nome' => $faker->name,
                'comprador_telefone' => $faker->cellphoneNumber,
                'placa' => $faker->numerify('#######'),
                'veiculo' => $faker->word,
                'preco_placa' => $faker->randomFloat(2, 100, 1000),
                'preco_honorario' => $faker->randomFloat(2, 100, 1000),
                'status' => $faker->randomElement(['ab', 'ea', 'cd']),
                'criado_por' => 1,
                'cliente_id' => 1,
            ];
        }
        foreach ($pedidos as $pedido) {
            $pedidoNovo = Pedido::create($pedido);
            Atpv::create([
                'renavam' => $faker->numerify('###########'),
                'numero_crv' => $faker->numerify('############'),
                'vendedor_email' => $faker->email,
                'vendedor_telefone' => $faker->cellphoneNumber,
                'vendedor_cpf_cnpj' => $faker->numerify('##############'),
                'comprador_cpf_cnpj' => $faker->numerify('##############'),
                'comprador_email' => $faker->email,
                'comprador_endereco' => 1,
                'preco_venda' => $faker->randomFloat(2, 100, 1000),
                'pedido_id' => $pedidoNovo->id,
            ]);
        }



//        $processos = [];
//        $pedidos = Pedido::all();
//        foreach ($pedidos as $pedido) {
//            $processos[] = [
//                'tipo' => $faker->randomElement(['ss', 'rv']),
//                'comprador_tipo' => $faker->randomElement(['lj', 'tc']),
//                'qtd_placas' => $faker->randomDigit,
//                'pedido_id' => $pedido->id,
//            ];
//        }
//        foreach ($processos as $processo) {
//            Processo::create($processo);
//        }
=======
        foreach (Despachante::all() as $item) {
            for ($j = 0; $j < 3; $j++) {
                $servico = Servico::create([
                    'nome' => $faker->word,
                    'preco' => $faker->randomFloat(2, 100, 1000),
                    'descricao' => $faker->text,
                    'despachante_id' => $item->id,
                ]);
>>>>>>> Stashed changes

                $user = User::create([
                    'name' => $faker->name,
                    'email' => $faker->email,
                    'password' => Hash::make('123'),
                    'role' => $faker->randomElement(['da', 'du']),
                    'despachante_id' => $item->id,
                ]);
                for ($p = 0; $p < 3; $p++) {
                    $cliente = Cliente::create([
                        'nome' => $faker->company,
                        'status' => $faker->randomElement(['ac', 'in']),
                        'preco_1_placa' => $faker->randomFloat(2, 100, 1000),
                        'preco_2_placa' => $faker->randomFloat(2, 100, 1000),
                        'preco_atpv' => $faker->randomFloat(2, 100, 1000),
                        'preco_loja' => $faker->randomFloat(2, 100, 1000),
                        'preco_terceiro' => $faker->randomFloat(2, 100, 1000),
                        'despachante_id' => $item->id,
                    ]);

                    User::create([
                        'name' => $faker->name,
                        'email' => $faker->email,
                        'password' => Hash::make('123'),
                        'role' => 'ca',
                        'cliente_id' => $cliente->id,
                    ]);

                    for ($k = 0; $k < 5; $k++) {
                        $pedido = Pedido::create([
                            'comprador_nome' => $faker->name,
                            'comprador_telefone' => $faker->cellphoneNumber,
                            'placa' => $faker->numerify('#######'),
                            'veiculo' => $faker->word,
                            'preco_placa' => $faker->randomFloat(2, 100, 1000),
                            'preco_honorario' => $faker->randomFloat(2, 100, 1000),
                            'status' => $faker->randomElement(['ab', 'ea', 'pe', 'co']),
                            'criado_por' => $user->id,
                            'cliente_id' => $cliente->id,
                        ]);

                        Atpv::create([
                            'renavam' => $faker->numerify('###########'),
                            'numero_crv' => $faker->numerify('############'),
                            'vendedor_email' => $faker->email,
                            'vendedor_telefone' => $faker->cellphoneNumber,
                            'vendedor_cpf_cnpj' => $faker->numerify('##.###.###/####-##'),
                            'comprador_cpf_cnpj' => $faker->numerify('###.###.###-##'),
                            'comprador_email' => $faker->email,
                            'comprador_endereco' => $endereco->id,
                            'preco_venda' => $faker->randomFloat(2, 100, 1000),
                            'pedido_id' => $pedido->id,
                        ]);
                    }
                    for ($t = 0; $t < 5; $t++) {
                        $pedido = Pedido::create([
                            'comprador_nome' => $faker->name,
                            'comprador_telefone' => $faker->cellphoneNumber,
                            'placa' => $faker->numerify('#######'),
                            'veiculo' => $faker->word,
                            'preco_placa' => $faker->randomFloat(2, 100, 1000),
                            'preco_honorario' => $faker->randomFloat(2, 100, 1000),
                            'status' => $faker->randomElement(['ab', 'ea', 'pe', 'co']),
                            'criado_por' => $user->id,
                            'cliente_id' => $cliente->id,
                        ]);

                        Processo::create([
                            'tipo' => $faker->randomElement(['ss', 'rv']),
                            'comprador_tipo' => $faker->randomElement(['lj', 'tc']),
                            'qtd_placas' => $faker->randomElement([0, 1, 2]),
                            'pedido_id' => $pedido->id,
                        ]);

                        PedidoServico::create([
                            'pedido_id' => $pedido->id,
                            'servico_id' => $servico->id,
                        ]);
                    }
                }
            }
        }


        User::create([
            'name' => 'admin',
            'email' => 'admin@admin',
            'password' => Hash::make('123'),
            'role' => 'dm',
            'despachante_id' => Despachante::first()->id,
        ]);

    }
}
