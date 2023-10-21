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
        @if(Auth::user()->hasAnyPermission(['[DESPACHANTE] - Gerenciar Clientes', '[DESPACHANTE] - Gerenciar Usuários', '[DESPACHANTE] - Gerenciar Serviços']))
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
                            @can('[DESPACHANTE] - Gerenciar Clientes')
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
                            @endcan
                            @can('[DESPACHANTE] - Gerenciar Usuários')
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
                            @endcan
                            @can('[DESPACHANTE] - Gerenciar Serviços')
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
                            @endcan
                        </div>
                    </div>
                </div>
            </li>
        @endif
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="" data-bs-toggle="dropdown"
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
            <div class="dropdown-menu">
                <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                        <a class="dropdown-item" href="{{route('despachante.relatorios.pedidos')}}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="icon icon-tabler icon-tabler-table-options" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M12 21h-7a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7"></path>
                                <path d="M3 10h18"></path>
                                <path d="M10 3v18"></path>
                                <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                <path d="M19.001 15.5v1.5"></path>
                                <path d="M19.001 21v1.5"></path>
                                <path d="M22.032 17.25l-1.299 .75"></path>
                                <path d="M17.27 20l-1.3 .75"></path>
                                <path d="M15.97 17.25l1.3 .75"></path>
                                <path d="M20.733 20l1.3 .75"></path>
                            </svg>
                            <span class="ms-2">
                                Pedidos
                            </span>
                        </a>
                        <a class="dropdown-item" href="">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="icon icon-tabler icon-tabler-file-alert" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                <path
                                    d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                <path d="M12 17l.01 0"></path>
                                <path d="M12 11l0 3"></path>
                            </svg>
                            <span class="ms-2">
                                Pendencia
                            </span>
                        </a>
                        <a class="dropdown-item" href="">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="icon icon-tabler icon-tabler-chart-bar" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M3 12m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                                <path
                                    d="M9 8m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                                <path
                                    d="M15 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                                <path d="M4 20l14 0"></path>
                            </svg>
                            <span class="ms-2">
                                Faturamento
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </li>
    </x-slot:navItens>
</x-navbar>
