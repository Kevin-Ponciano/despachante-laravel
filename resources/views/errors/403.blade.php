<x-guest-layout>
    <div class="page border-top-wide border-red page-center">
        <div class="container-tight py-4">
            <div class="empty">
                <div class="empty-header">403</div>
                <p class="empty-title">Ops… Você não tem permissão para acessar esta página</p>
                <div class="empty-action">
                    <a href="{{route('dashboard')}}" class="btn btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                             stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                             stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l14 0"></path>
                            <path d="M5 12l6 6"></path>
                            <path d="M5 12l6 -6"></path>
                        </svg>
                        Voltar para a página inicial
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
