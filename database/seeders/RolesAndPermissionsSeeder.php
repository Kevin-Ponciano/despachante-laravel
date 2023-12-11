<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public static function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //# ADMIN
        Permission::create(['name' => '[ADMIN] - Acessar Admin']);
        Permission::create(['name' => '[ADMIN] - Excluir Pedidos']);
        Permission::create(['name' => '[ADMIN] - Acessar Telescope']);
        Permission::create(['name' => '[ADMIN] - Acessar Horizon']);
        Role::create(['name' => '[ADMIN]'])->givePermissionTo([
            '[ADMIN] - Acessar Admin',
            '[ADMIN] - Excluir Pedidos',
            '[ADMIN] - Acessar Telescope',
            '[ADMIN] - Acessar Horizon',
        ]);

        //# DESPACHANTE
        Permission::create(['name' => '[DESPACHANTE] - Acessar Sistema']);
        Permission::create(['name' => '[DESPACHANTE] - Excluir Pedidos']);
        Permission::create(['name' => '[DESPACHANTE] - Gerenciar Clientes']);
        Permission::create(['name' => '[DESPACHANTE] - Gerenciar Usuários']);
        Permission::create(['name' => '[DESPACHANTE] - Gerenciar Serviços']);
        Permission::create(['name' => '[DESPACHANTE] - Gerenciar Relatórios']);
        Permission::create(['name' => '[DESPACHANTE] - Alterar Configurações']);

        Role::create(['name' => '[DESPACHANTE] - USUÁRIO'])->givePermissionTo('[DESPACHANTE] - Acessar Sistema');

        Role::create(['name' => '[DESPACHANTE] - ADMIN'])->givePermissionTo([
            '[DESPACHANTE] - Acessar Sistema',
            '[DESPACHANTE] - Excluir Pedidos',
            '[DESPACHANTE] - Gerenciar Clientes',
            '[DESPACHANTE] - Gerenciar Usuários',
            '[DESPACHANTE] - Gerenciar Serviços',
            '[DESPACHANTE] - Gerenciar Relatórios',
            '[DESPACHANTE] - Alterar Configurações',
        ]);

        Permission::create(['name' => '[FINANCEIRO] - Acessar Módulo']);
        Permission::create(['name' => '[FINANCEIRO] - Gerenciar Contas a Pagar']);
        Permission::create(['name' => '[FINANCEIRO] - Gerenciar Contas a Receber']);
        Permission::create(['name' => '[FINANCEIRO] - Gerenciar Categorias']);
        Permission::create(['name' => '[FINANCEIRO] - Gerenciar Relatórios']);
        Permission::create(['name' => '[FINANCEIRO] - Gerenciar Configurações']);
        Role::create(['name' => '[FINANCEIRO] - ADMIN'])->givePermissionTo([
            '[FINANCEIRO] - Acessar Módulo',
            '[FINANCEIRO] - Gerenciar Contas a Pagar',
            '[FINANCEIRO] - Gerenciar Contas a Receber',
            '[FINANCEIRO] - Gerenciar Categorias',
            '[FINANCEIRO] - Gerenciar Relatórios',
            '[FINANCEIRO] - Gerenciar Configurações',
        ]);


        //# MÓDULOS DESPACHANTE
        //Role::create(['name'=> '[Módulo] - Relatório de Pedidos']);
        //Role::create(['name'=> '[Módulo] - FINANCEIRO']);

        //# CLIENTE
        Permission::create(['name' => '[CLIENTE] - Acessar Sistema']);
        Role::create(['name' => '[CLIENTE]'])->givePermissionTo('[CLIENTE] - Acessar Sistema');
    }
}
