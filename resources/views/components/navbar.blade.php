<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container-fluid">
                <h1 class="navbar-brand d-none-navbar-horizontal pe-0 pe-md-3">
                    <a class="card-link" href="{{route('dashboard')}}">
                        <img src="{{asset('assets/img/logo3.png')}}" alt="Saled"
                             class="navbar-brand-image">
                        {{config('app.name')}}
                    </a>
                </h1>
                <div class="fw-bolder text-capitalize text-center w-8">
                    {{$despachanteNome}}
                </div>
                <div class="navbar-nav flex-row order-md-last">
                    <div class="d-none d-md-flex">
                        <div class="nav-item w-auto">
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                       viewBox="0 0 24 24"
                                       stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                       stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path
                                          d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path
                                          d="M21 21l-6 -6"></path></svg>
                                </span>
                                <input type="text" class="form-control" placeholder="Buscar Pedido">
                                <script>
                                    $(document).ready(function () {
                                        $('input').on('keypress', function (e) {
                                            if (e.which === 13) {
                                                e.preventDefault();
                                                window.location.href = "/pedido/" + $(this).val()
                                            }
                                        })
                                    })
                                </script>
                            </div>
                        </div>
                        <a class="nav-link px-0 hide-theme-dark cursor-pointer" data-bs-toggle="tooltip"
                           data-bs-placement="bottom" aria-label="Ativar modo escuro"
                           data-bs-original-title="Ativar modo escuro">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"></path>
                            </svg>
                        </a>
                        <a class="nav-link px-0 hide-theme-light cursor-pointer" data-bs-toggle="tooltip"
                           data-bs-placement="bottom" aria-label="Ativar modo claro"
                           data-bs-original-title="Ativar modo claro">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                <path
                                    d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"></path>
                            </svg>
                        </a>
                        {{--                        <div class="nav-item dropdown d-none d-md-flex me-3">--}}
                        {{--                            <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1"--}}
                        {{--                               aria-label="Show notifications">--}}
                        {{--                                <!-- Download SVG icon from http://tabler-icons.io/i/bell -->--}}
                        {{--                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"--}}
                        {{--                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"--}}
                        {{--                                     stroke-linecap="round" stroke-linejoin="round">--}}
                        {{--                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>--}}
                        {{--                                    <path--}}
                        {{--                                        d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path>--}}
                        {{--                                    <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path>--}}
                        {{--                                </svg>--}}
                        {{--                                <span class="badge bg-red"></span>--}}
                        {{--                            </a>--}}
                        {{--                            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">--}}
                        {{--                                <div class="card">--}}
                        {{--                                    <div class="card-header">--}}
                        {{--                                        <h3 class="card-title">Last updates</h3>--}}
                        {{--                                    </div>--}}
                        {{--                                    <div class="list-group list-group-flush list-group-hoverable">--}}
                        {{--                                        <div class="list-group-item">--}}
                        {{--                                            <div class="row align-items-center">--}}
                        {{--                                                <div class="col-auto"><span--}}
                        {{--                                                        class="status-dot status-dot-animated bg-red d-block"></span>--}}
                        {{--                                                </div>--}}
                        {{--                                                <div class="col text-truncate">--}}
                        {{--                                                    <a href="#" class="text-body d-block">Example 1</a>--}}
                        {{--                                                    <div class="d-block text-muted text-truncate mt-n1">--}}
                        {{--                                                        Change deprecated html tags to text decoration classes--}}
                        {{--                                                        (#29604)--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}
                        {{--                                                <div class="col-auto">--}}
                        {{--                                                    <a href="#" class="list-group-item-actions">--}}
                        {{--                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->--}}
                        {{--                                                        <svg xmlns="http://www.w3.org/2000/svg"--}}
                        {{--                                                             class="icon text-muted" width="24" height="24"--}}
                        {{--                                                             viewBox="0 0 24 24" stroke-width="2"--}}
                        {{--                                                             stroke="currentColor" fill="none"--}}
                        {{--                                                             stroke-linecap="round" stroke-linejoin="round">--}}
                        {{--                                                            <path stroke="none" d="M0 0h24v24H0z"--}}
                        {{--                                                                  fill="none"></path>--}}
                        {{--                                                            <path--}}
                        {{--                                                                d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>--}}
                        {{--                                                        </svg>--}}
                        {{--                                                    </a>--}}
                        {{--                                                </div>--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="list-group-item">--}}
                        {{--                                            <div class="row align-items-center">--}}
                        {{--                                                <div class="col-auto"><span class="status-dot d-block"></span></div>--}}
                        {{--                                                <div class="col text-truncate">--}}
                        {{--                                                    <a href="#" class="text-body d-block">Example 2</a>--}}
                        {{--                                                    <div class="d-block text-muted text-truncate mt-n1">--}}
                        {{--                                                        justify-content:between ⇒ justify-content:space-between--}}
                        {{--                                                        (#29734)--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}
                        {{--                                                <div class="col-auto">--}}
                        {{--                                                    <a href="#" class="list-group-item-actions show">--}}
                        {{--                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->--}}
                        {{--                                                        <svg xmlns="http://www.w3.org/2000/svg"--}}
                        {{--                                                             class="icon text-yellow" width="24" height="24"--}}
                        {{--                                                             viewBox="0 0 24 24" stroke-width="2"--}}
                        {{--                                                             stroke="currentColor" fill="none"--}}
                        {{--                                                             stroke-linecap="round" stroke-linejoin="round">--}}
                        {{--                                                            <path stroke="none" d="M0 0h24v24H0z"--}}
                        {{--                                                                  fill="none"></path>--}}
                        {{--                                                            <path--}}
                        {{--                                                                d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>--}}
                        {{--                                                        </svg>--}}
                        {{--                                                    </a>--}}
                        {{--                                                </div>--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="list-group-item">--}}
                        {{--                                            <div class="row align-items-center">--}}
                        {{--                                                <div class="col-auto"><span class="status-dot d-block"></span></div>--}}
                        {{--                                                <div class="col text-truncate">--}}
                        {{--                                                    <a href="#" class="text-body d-block">Example 3</a>--}}
                        {{--                                                    <div class="d-block text-muted text-truncate mt-n1">--}}
                        {{--                                                        Update change-version.js (#29736)--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}
                        {{--                                                <div class="col-auto">--}}
                        {{--                                                    <a href="#" class="list-group-item-actions">--}}
                        {{--                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->--}}
                        {{--                                                        <svg xmlns="http://www.w3.org/2000/svg"--}}
                        {{--                                                             class="icon text-muted" width="24" height="24"--}}
                        {{--                                                             viewBox="0 0 24 24" stroke-width="2"--}}
                        {{--                                                             stroke="currentColor" fill="none"--}}
                        {{--                                                             stroke-linecap="round" stroke-linejoin="round">--}}
                        {{--                                                            <path stroke="none" d="M0 0h24v24H0z"--}}
                        {{--                                                                  fill="none"></path>--}}
                        {{--                                                            <path--}}
                        {{--                                                                d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>--}}
                        {{--                                                        </svg>--}}
                        {{--                                                    </a>--}}
                        {{--                                                </div>--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="list-group-item">--}}
                        {{--                                            <div class="row align-items-center">--}}
                        {{--                                                <div class="col-auto"><span--}}
                        {{--                                                        class="status-dot status-dot-animated bg-green d-block"></span>--}}
                        {{--                                                </div>--}}
                        {{--                                                <div class="col text-truncate">--}}
                        {{--                                                    <a href="#" class="text-body d-block">Example 4</a>--}}
                        {{--                                                    <div class="d-block text-muted text-truncate mt-n1">--}}
                        {{--                                                        Regenerate package-lock.json (#29730)--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}
                        {{--                                                <div class="col-auto">--}}
                        {{--                                                    <a href="#" class="list-group-item-actions">--}}
                        {{--                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->--}}
                        {{--                                                        <svg xmlns="http://www.w3.org/2000/svg"--}}
                        {{--                                                             class="icon text-muted" width="24" height="24"--}}
                        {{--                                                             viewBox="0 0 24 24" stroke-width="2"--}}
                        {{--                                                             stroke="currentColor" fill="none"--}}
                        {{--                                                             stroke-linecap="round" stroke-linejoin="round">--}}
                        {{--                                                            <path stroke="none" d="M0 0h24v24H0z"--}}
                        {{--                                                                  fill="none"></path>--}}
                        {{--                                                            <path--}}
                        {{--                                                                d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>--}}
                        {{--                                                        </svg>--}}
                        {{--                                                    </a>--}}
                        {{--                                                </div>--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                           aria-label="Open user menu">
                                <span class="avatar avatar-sm"
                                      style="background-image: url({{Auth::user()->getProfilePhoto()}})"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div>{{Auth::user()->name}}</div>
                                <div class="mt-1 small text-muted">{{$subName}}</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            {{--                            <a href="#" class="dropdown-item">Status</a>--}}
                            <a href="{{$routePerfil}}" class="dropdown-item">
                                <i class="dropdown-item-icon icon ti ti-user"></i>
                                Perfil</a>
                            {{--                            <a href="#" class="dropdown-item">Feedback</a>--}}
                            {{--                            <div class="dropdown-divider"></div>--}}
                            @can('[DESPACHANTE] - Alterar Configurações')
                                <a href="{{route('despachante.settings')}}" class="dropdown-item">
                                    <i class="dropdown-item-icon icon ti ti-settings"></i>
                                    Configurações</a>
                            @endcan
                            <form method="POST" action="{{ route('logout') }}" id="logout">
                                @csrf
                            </form>
                            <a href="#" onclick="$('#logout').submit()" class="dropdown-item">
                                <i class="dropdown-item-icon icon ti ti-logout"></i>
                                Sair</a>
                        </div>
                    </div>
                </div>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{$dashboardRoute}}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                       viewBox="0 0 24 24"
                                       stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                       stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path
                                          d="M5 12l-2 0l9 -9l9 9l-2 0"></path><path
                                          d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path><path
                                          d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path></svg>
                                </span>
                            <span class="nav-link-title">
                                    Dashboard
                            </span>
                        </a>
                    </li>
                    {{$navItens??''}}
                </ul>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            let url = new URL(window.location.href)
            url = url.origin + url.pathname
            let item = $('li.nav-item a[href="' + url + '"]')

            if (item.attr('class') === 'dropdown-item') {
                item.addClass('active')
                item.parent().parent().parent().parent().addClass('active')
            } else {
                item.parent().addClass('active')
            }
        });
    </script>
</header>
