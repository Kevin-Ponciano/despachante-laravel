<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Despachante;
use App\Models\Endereco;
use App\Models\Pedido;
use App\Models\Plano;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
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
//            'role' => 'DM'
//        ]);

        Pedido::create([
            'comprador_nome' => 'Comprador 1',
            'comprador_telefone' => '27999999999',
            'placa' => 'ABC1234',
            'veiculo' => 'Veículo 1',
            'preco_placa' => 100,
            'preco_honorario' => 100,
            'status' => 'ac',
            'criado_por' => '1',
            'cliente_id' => 1,
        ]);

    }
}
