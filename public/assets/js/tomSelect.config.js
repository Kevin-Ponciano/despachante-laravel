$(document).ready(function () {
    //let select = initSelect();
    let select = new TomSelect("#select-cliente", {});
    select.on('change', function () {
        Livewire.emit('onChange', select.getValue());
        select.blur()
    });
    $('.ts-control').addClass('py-0 px-1 text-muted')
});
