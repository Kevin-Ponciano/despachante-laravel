const configDefault = {
    language: {
        url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/pt-BR.json',
    }
}

const tablePlay = () => {

}
$(document).ready(function () {
    Livewire.on('tablePlay', () => {
        let table = $('#table').DataTable({
            ...configDefault,
            dom: "<'row'<'col-sm-12 col-md-6 px-2'><'col-sm-12 col-md-6 px-2'>>" +
                "<'row'<'col-sm-12'>>" +
                "<'row'<'col-sm-12 col-md-5'><'col-sm-12 col-md-7'>>",
        });
    });

    let clientesTable = $('#clientes-table').DataTable({
        ...configDefault,
        'order': [[2, 'asc']],
        'ajax': '/despachante/clientes/table',
        'columns': [
            {
                'data': 'numero_cliente',
                'createdCell': function (td, cellData, rowData, row, col) {
                    $(td).addClass('fw-bold');
                }
            },
            {'data': 'nome'},
            {
                'data': 'status',
                'createdCell': function (td, cellData, rowData, row, col) {
                    $(td).addClass('text-center');
                },
                'render': function (data, type, row) {
                    let status = row.status === 'at' ? 'Ativo' : 'Inativo';
                    let color = row.status === 'at' ? 'success' : 'danger';
                    return '<span class="badge bg-' + color + '">' + status + '</span>';
                }
            },
            {
                'createdCell': function (td) {
                    $(td).addClass('text-center');
                },
                'defaultContent': '<a href="#" class="btn btn-sm btn-primary">Editar</a>',
                'render': function (data, type, row) {
                    let url = '/despachante/clientes/' + row.numero_cliente;
                    return '<a href="' + url + '" class="btn btn-sm btn-primary">Editar</a>';
                }
            },
        ],
        'rowCallback': function (row, data, index) {
            let url = '/despachante/clientes/' + data.numero_cliente;
            $(row).attr('data-href', url);
            $(row).css('cursor', 'pointer');
            $(row).on('click', function () {
                window.location.href = $(this).data('href');
            });
        }
    });

    $('#atpvs-table').DataTable({
        ...configDefault,
    });

    let usuariosTable = $('#usuarios-table').DataTable({
        ...configDefault,
        'order': [[3, 'asc']],
        'ajax': '/despachante/usuarios/table',
        'columns': [
            {'data': 'name'},
            {'data': 'email'},
            {
                'data': 'status',
                'createdCell': function (td, cellData, rowData, row, col) {
                    $(td).addClass('text-center');
                },
                'render': function (data, type, row) {
                    let status = row.status === 'at' ? 'Ativo' : 'Inativo';
                    let color = row.status === 'at' ? 'success' : 'danger';
                    return '<span class="badge bg-' + color + '">' + status + '</span>';
                }
            },
            {
                'data': 'role',
                'createdCell': function (td, cellData, rowData, row, col) {
                    $(td).addClass('text-center');
                },
            },
            {
                'createdCell': function (td) {
                    $(td).addClass('text-center');
                },
                'defaultContent': '<a href="#" class="btn btn-sm btn-primary">Editar</a>',
                'render': function (data, type, row) {
                    let url = '/despachante/usuarios/' + row.id;
                    return '<a href="' + url + '" class="btn btn-sm btn-primary">Editar</a>';
                }
            },
        ],
        'rowCallback': function (row, data, index) {
            let url = '/despachante/usuarios/' + data.id;
            $(row).attr('data-href', url);
            $(row).css('cursor', 'pointer');
            $(row).on('click', function () {
                window.location.href = $(this).data('href');
            });
        }
    });

    $('#servicos-table').DataTable({
        ...configDefault,
    });

    Livewire.on('tableRefresh', () => {
        $('#modal-cliente-novo').modal('hide');
        $('#modal-usuario-novo').modal('hide');
        clientesTable.ajax.reload();
        usuariosTable.ajax.reload();
    })
});



