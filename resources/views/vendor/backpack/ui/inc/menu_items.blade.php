<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}"><i
            class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}
    </a>
</li>
<x-backpack::menu-dropdown title="Autenticação" icon="la la-user">
    <x-backpack::menu-dropdown-item title="Usuários" icon="la la-user" :link="backpack_url('user')"/>
    <x-backpack::menu-dropdown-item title="Funções" icon="la la-group" :link="backpack_url('role')"/>
    <x-backpack::menu-dropdown-item title="Permissões" icon="la la-key" :link="backpack_url('permission')"/>
</x-backpack::menu-dropdown>
<x-backpack::menu-dropdown title="Empresas" icon="la la-city">
    <x-backpack::menu-dropdown-item title="Despachantes" icon="la la-toolbox" :link="backpack_url('despachante')"/>
    <x-backpack::menu-dropdown-item title="Clientes" icon="la la-car" :link="backpack_url('cliente')"/>
</x-backpack::menu-dropdown>
<x-backpack::menu-item title="Pedidos" icon="la la-file-invoice" :link="backpack_url('pedido')"/>
<x-backpack::menu-item title="Planos" icon="la la-wallet" :link="backpack_url('plano')"/>
<x-backpack::menu-item title="Plano Do Despachante" icon="la la-question" :link="backpack_url('plano-despachante')"/>
<x-backpack::menu-dropdown title="Gerenciamento do Sistema" icon="la la-cog">
<x-backpack::menu-dropdown-item title='Backups' icon='la la-hdd-o' :link="backpack_url('backup')" />
<x-backpack::menu-dropdown-item title='Logs' icon='la la-terminal' :link="backpack_url('log')"/>
<x-backpack::menu-dropdown-item title='Horizon' icon='la la-sync' :link="route('horizon.index')"/>
<x-backpack::menu-dropdown-item title='Telescope' icon='la la-binoculars' :link="route('telescope')"/>
</x-backpack::menu-dropdown>

<x-backpack::menu-item title="Trocar Sistema" icon='la la-sync' :link="route('login')"/>
