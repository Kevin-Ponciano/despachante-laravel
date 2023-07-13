const configDefault = {
    language: {
        url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/pt-BR.json',
    }
}
$(document).ready(function () {
    let processo_table = $('#processos-table').DataTable({
        ...configDefault,
        dom: "<'row'<'col-sm-12 col-md-6 px-2'l><'col-sm-12 col-md-6 px-2'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    });

    $('#clientes-table').DataTable({
        ...configDefault,
    });

    $('#atpvs-table').DataTable({
        ...configDefault,
    });


});
