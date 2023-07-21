<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Atpv;
use App\Models\Cliente;
use App\Models\Despachante;
use App\Models\Endereco;
use App\Models\Pedido;
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
//        $endereco = Endereco::create([
//            'logradouro' => 'Rua 1',
//            'numero' => '123',
//            'bairro' => 'Bairro 1',
//            'cidade' => 'Cidade 1',
//            'estado' => 'es',
//            'cep' => '12345678',
//        ]);
//
//        $plano = Plano::create([
//            'nome' => 'Plano 1',
//            'preco' => 100,
//            'descricao' => 'Descrição 1',
//            'qtd_clientes' => 10,
//            'qtd_acessos_clientes' => 10,
//        ]);
//
//        Despachante::create([
//            'razao_social' => 'Despachante 1',
//            'cnpj' => '123456789',
//            'endereco_id' => $endereco->id,
//            'plano_id' => $plano->id,
//        ]);
//
//        User::create([
//            'name' => 'admin',
//            'email' => 'admin@admin',
//            'password' => Hash::make('123'),
//            'role' => 'dm'
//        ]);
//        Pedido::create([
//            'comprador_nome' => 'Comprador 1',
//            'comprador_telefone' => '27999999999',
//            'placa' => 'ABC1234',
//            'veiculo' => 'Veículo 1',
//            'preco_placa' => 100,
//            'preco_honorario' => 100,
//            'status' => 'ac',
//            'criado_por' => '1',
//            'cliente_id' => 1,
//        ]);

//        Servico::create([
//            'nome' => 'Serviço 1',
//            'preco' => 100,
//            'descricao' => 'Descrição 1',
//            'despachante_id' => 1,
//        ]);
//
//        Servico::create([
//            'nome' => 'Serviço 2',
//            'preco' => 150,
//            'descricao' => 'Descrição 2',
//            'despachante_id' => 1,
//        ]);
//
//        Servico::create([
//            'nome' => 'Serviço 3',
//            'preco' => 200,
//            'descricao' => 'Descrição 3',
//            'despachante_id' => 1,
//        ]);

//        Servico::create([
//            'nome' => 'Serviço 4',
//            'preco' => 250,
//            'descricao' => 'Descrição 4',
//            'despachante_id' => 1,
//        ]);


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

//        $clientes = [];
//        $qtd_clientes = 5;
//        for ($i = 0; $i < $qtd_clientes; $i++) {
//            $clientes[] = [
//                'nome' => $faker->company(),
//                'status' => $faker->randomElement(['ac', 'in']),
//                'preco_1_placa' => $faker->randomFloat(2, 100, 1000),
//                'preco_2_placa' => $faker->randomFloat(2, 100, 1000),
//                'preco_atpv' => $faker->randomFloat(2, 100, 1000),
//                'preco_loja' => $faker->randomFloat(2, 100, 1000),
//                'preco_terceiro' => $faker->randomFloat(2, 100, 1000),
//                'despachante_id' => 1,
//            ];
//        }
//        foreach ($clientes as $cliente) {
//            Cliente::create($cliente);
//        }

    }
}
