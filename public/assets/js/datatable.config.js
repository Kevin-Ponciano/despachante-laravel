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


    $('#clientes-table').DataTable({
        ...configDefault,
    });

    $('#atpvs-table').DataTable({
        ...configDefault,
    });

    $('#usuarios-table').DataTable({
        ...configDefault,
    });

    $('#servicos-table').DataTable({
        ...configDefault,
    });
});



