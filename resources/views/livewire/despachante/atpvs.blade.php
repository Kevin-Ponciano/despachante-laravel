<div>
    @php(redirect()->to('#tabs-atpv'))
    <div class="page-body">
        <div class="container-xl">
            <x-table id="atpvs-table"
                     title="ATPVs"
                     subtitle="Lista de ATPVs"
            >
                <x-slot:actions>
                    <a href="#" class="btn btn-primary d-none d-sm-inline-block"
                       data-bs-toggle="modal"
                       data-bs-target="#modal-novo">
                        <i class="ti ti-plus"></i>
                        Novo ATPV
                    </a>
                </x-slot:actions>
                <x-slot:thead>
                    <tr>
                        <th>id</th>
                        <th>Cliente</th>
                        <th>Placa</th>
                        <th>Aberto às</th>
                    </tr>
                </x-slot:thead>
                <x-slot:tbody>
                    @foreach($atpvs as $atpv)
                        <tr>
                        </tr>
                    @endforeach
                </x-slot:tbody>
            </x-table>
        </div>
    </div>
    <script>$(window).ready(function () {
            switchButton('atpv')
        })</script>
</div>

