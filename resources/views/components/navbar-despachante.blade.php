<x-navbar :dashboard-route="route('despachante.dashboard')" :route-perfil="route('despachante.perfil')"
          :sub-name="Auth::user()->getFuncao()" :despachante-nome="Auth::user()->despachante->getNome()">
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
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="" data-bs-toggle="dropdown"
               data-bs-auto-close="outside" role="button" aria-expanded="false">
                <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                       viewBox="0 0 24 24"
                       stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                       stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path
                          d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path><path
                          d="M12 12l8 -4.5"></path><path
                          d="M12 12l0 9"></path><path d="M12 12l-8 -4.5"></path><path
                          d="M16 5.25l-8 4.5"></path>
                  </svg>
                </span>
                <span class="nav-link-title">
                    Gestão
                </span>
            </a>
            <div class="dropdown-menu">
                <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                        <a class="dropdown-item" href="{{route('despachante.clientes')}}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="icon icon-tabler icon-tabler-manual-gearbox" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                <path d="M12 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                <path d="M19 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                <path d="M5 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                <path d="M12 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                <path d="M5 8l0 8"></path>
                                <path d="M12 8l0 8"></path>
                                <path d="M19 8v2a2 2 0 0 1 -2 2h-12"></path>
                            </svg>
                            <span class="ms-2">
                                Clientes
                            </span>
                        </a>
                        <a class="dropdown-item" href="{{route('despachante.usuarios')}}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="icon icon-tabler icon-tabler-users-group" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                            </svg>
                            <span class="ms-2">
                                Usuários
                            </span>
                        </a>
                        <a class="dropdown-item" href="{{route('despachante.servicos')}}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="icon icon-tabler icon-tabler-tools" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M3 21h4l13 -13a1.5 1.5 0 0 0 -4 -4l-13 13v4"></path>
                                <path d="M14.5 5.5l4 4"></path>
                                <path d="M12 8l-5 -5l-4 4l5 5"></path>
                                <path d="M7 8l-1.5 1.5"></path>
                                <path d="M16 12l5 5l-4 4l-5 -5"></path>
                                <path d="M16 17l-1.5 1.5"></path>
                            </svg>
                            <span class="ms-2">
                                Serviços
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" href="{{route('despachante.relatorios.pedidos')}}"
               data-bs-auto-close="outside" role="button" aria-expanded="false">
                <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-report"
                         width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                         stroke="currentColor"
                         fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697"></path>
                        <path d="M18 14v4h4"></path>
                        <path d="M18 11v-4a2 2 0 0 0 -2 -2h-2"></path>
                        <path
                            d="M8 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                        <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                        <path d="M8 11h4"></path>
                        <path d="M8 15h3"></path>
                    </svg>
                </span>
                <span class="nav-link-title">
                    Relatórios
                </span>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="" data-bs-toggle="dropdown"
               data-bs-auto-close="outside" role="button" aria-expanded="false">
                <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-coins" width="24"
                         height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M9 14c0 1.657 2.686 3 6 3s6 -1.343 6 -3s-2.686 -3 -6 -3s-6 1.343 -6 3z"></path>
                    <path d="M9 14v4c0 1.656 2.686 3 6 3s6 -1.344 6 -3v-4"></path>
                    <path
                        d="M3 6c0 1.072 1.144 2.062 3 2.598s4.144 .536 6 0c1.856 -.536 3 -1.526 3 -2.598c0 -1.072 -1.144 -2.062 -3 -2.598s-4.144 -.536 -6 0c-1.856 .536 -3 1.526 -3 2.598z"></path>
                    <path d="M3 6v10c0 .888 .772 1.45 2 2"></path>
                    <path d="M3 11c0 .888 .772 1.45 2 2"></path>
                </svg>
                </span>
                <span class="nav-link-title">
                    Financeiro
                </span>
            </a>
            <div class="dropdown-menu">

            </div>
        </li>
    </x-slot:navItens>
</x-navbar>
