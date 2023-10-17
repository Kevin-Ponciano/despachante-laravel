{{-- This file is used for menu items by any Backpack v6 theme --}}
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
