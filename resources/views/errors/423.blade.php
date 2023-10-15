<x-guest-layout>
    <div class="border-top-wide border-primary d-flex flex-column">
        <div class="mt-8">
            <div class="container-tight py-4">
                <div class="empty">
                    <img src="{{asset('assets/img/undraw_quitting_time_dm8t.svg')}}" height="128"
                         alt="">
                    <p class="empty-title">{{$exception->getMessage()}}</p>
                    <p class="empty-subtitle text-secondary">
                        {{$exception->getHeaders()['message']}}
                    </p>
                    <div class="empty-action">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-primary" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout-2"
                                     width="24"
                                     height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2"></path>
                                    <path d="M15 12h-12l3 -3"></path>
                                    <path d="M6 15l-3 -3"></path>
                                </svg>
                                Sair
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
