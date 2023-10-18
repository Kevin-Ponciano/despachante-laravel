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

        ## CLIENTE
        Permission::create(['name' => '[CLIENTE] - Acessar Sistema']);
        Role::create(['name' => 'Cliente'])->givePermissionTo('[CLIENTE] - Acessar Sistema');

        ## DESPACHANTE
        Permission::create(['name' => '[DESPACHANTE] - Acessar Sistema']);

        Role::create(['name' => 'Usuario Despachante'])->givePermissionTo('[DESPACHANTE] - Acessar Sistema');
        Role::create(['name' => 'Administrador Despachante'])->givePermissionTo('[DESPACHANTE] - Acessar Sistema');

        ## ADMIN
        Permission::create(['name' => '[ADMIN] - Acessar Admin']);
        Permission::create(['name' => '[ADMIN] - Excluir Pedidos']);

        Role::create(['name' => 'Admin'])->givePermissionTo([
            '[ADMIN] - Acessar Admin',
            '[ADMIN] - Excluir Pedidos'
        ]);
    }
}
