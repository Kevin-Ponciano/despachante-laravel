<x-navbar :dashboard-route="route('cliente.dashboard')" :route-perfil="route('cliente.perfil')"
          :sub-name="Auth::user()->cliente->nome" :despachante-nome="Auth::user()->cliente->despachante->getNome()">
    <x-slot:navItens>
        <li class="nav-item">
            <a href="#" class="nav-link" data-bs-toggle="modal"
               data-bs-target="#modal-novo">
                <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-text-plus" width="24"
                         height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                       <path d="M19 10h-14"></path>
                       <path d="M5 6h14"></path>
                       <path d="M14 14h-9"></path>
                       <path d="M5 18h6"></path>
                       <path d="M18 15v6"></path>
                       <path d="M15 18h6"></path>
                    </svg>
                </span>
                <span class="nav-link-title">
                    Novo
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('cliente.processos')}}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notes" width="24"
                       height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none"
                       stroke-linecap="round" stroke-linejoin="round">
                       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                       <path d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"></path>
                       <path d="M9 7l6 0"></path>
                       <path d="M9 11l6 0"></path>
                       <path d="M9 15l4 0"></path>
                    </svg>
                </span>
                <span class="nav-link-title">
                    Processos
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('cliente.atpvs')}}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-transfer" width="24"
                     height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M20 10h-16l5.5 -6"></path>
                    <path d="M4 14h16l-5.5 6"></path>
                </svg>
                </span>
                <span class="nav-link-title">
                    Transferências
                </span>
            </a>
        </li>
    </x-slot:navItens>
</x-navbar>
