<x-dashboard
    :qtdProcessosAbertos="$qtdProcessosAbertos"
    :qtdProcessosRetornados="$qtdProcessosRetornados"
    :qtdProcessosEmAndamento="$qtdProcessosEmAndamento"
    :qtdProcessosPendentes="$qtdProcessosPendentes"
    :qtdProcessosDisponivelDownload="$qtdProcessosDisponivelDownload"
    :qtdAtpvsAbertos="$qtdAtpvsAbertos"
    :qtdAtpvsRetornados="$qtdAtpvsRetornados"
    :qtdAtpvsEmAndamento="$qtdAtpvsEmAndamento"
    :qtdAtpvsPendentes="$qtdAtpvsPendentes"
    :qtdAtpvsSolicitadoCancelamento="$qtdAtpvsSolicitadoCancelamento"
    :qtdAtpvsDisponivelDownload="$qtdAtpvsDisponivelDownload"
>
    @if(Auth::user()->isDespachante())
        <x-slot:routeProcessosAbertos>
            {{route('despachante.processos', ['status' => 'ab'])}}
        </x-slot:routeProcessosAbertos>
        <x-slot:routeProcessosRetornados>
            {{route('despachante.processos', ['status' => 'rp'])}}
        </x-slot:routeProcessosRetornados>
        <x-slot:routeProcessosEmAndamento>
            {{route('despachante.processos', ['status' => 'ea'])}}
        </x-slot:routeProcessosEmAndamento>
        <x-slot:routeProcessosPendentes>
            {{route('despachante.processos', ['status' => 'pe'])}}
        </x-slot:routeProcessosPendentes>
        <x-slot:routeAtpvsAbertos>
            {{route('despachante.atpvs', ['status' => 'ab'])}}
        </x-slot:routeAtpvsAbertos>
        <x-slot:routeAtpvsRetornados>
            {{route('despachante.atpvs', ['status' => 'rp'])}}
        </x-slot:routeAtpvsRetornados>
        <x-slot:routeAtpvsEmAndamento>
            {{route('despachante.atpvs', ['status' => 'ea'])}}
        </x-slot:routeAtpvsEmAndamento>
        <x-slot:routeAtpvsPendentes>
            {{route('despachante.atpvs', ['status' => 'pe'])}}
        </x-slot:routeAtpvsPendentes>
        <x-slot:routeAtpvsSolicitadoCancelamento>
            {{route('despachante.atpvs', ['status' => 'sc'])}}
        </x-slot:routeAtpvsSolicitadoCancelamento>
    @elseif(Auth::user()->isCliente())
        <x-slot:routeProcessosAbertos>
            {{route('cliente.processos', ['status' => 'ab'])}}
        </x-slot:routeProcessosAbertos>
        <x-slot:routeProcessosRetornados>
            {{route('cliente.processos', ['status' => 'rp'])}}
        </x-slot:routeProcessosRetornados>
        <x-slot:routeProcessosEmAndamento>
            {{route('cliente.processos', ['status' => 'ea'])}}
        </x-slot:routeProcessosEmAndamento>
        <x-slot:routeProcessosPendentes>
            {{route('cliente.processos', ['status' => 'pe'])}}
        </x-slot:routeProcessosPendentes>
        <x-slot:routeProcessosDisponivelDownload>
            {{route('cliente.processos', ['downloadDisponivel' => 'true'])}}
        </x-slot:routeProcessosDisponivelDownload>
        <x-slot:routeAtpvsAbertos>
            {{route('cliente.atpvs', ['status' => 'ab'])}}
        </x-slot:routeAtpvsAbertos>
        <x-slot:routeAtpvsRetornados>
            {{route('cliente.atpvs', ['status' => 'rp'])}}
        </x-slot:routeAtpvsRetornados>
        <x-slot:routeAtpvsEmAndamento>
            {{route('cliente.atpvs', ['status' => 'ea'])}}
        </x-slot:routeAtpvsEmAndamento>
        <x-slot:routeAtpvsPendentes>
            {{route('cliente.atpvs', ['status' => 'pe'])}}
        </x-slot:routeAtpvsPendentes>
        <x-slot:routeAtpvsSolicitadoCancelamento>
            {{route('cliente.atpvs', ['status' => 'sc'])}}
        </x-slot:routeAtpvsSolicitadoCancelamento>
        <x-slot:routeAtpvsDisponivelDownload>
            {{route('cliente.atpvs', ['downloadDisponivel' => 'true'])}}
        </x-slot:routeAtpvsDisponivelDownload>
    @endif
</x-dashboard>
