$(document).ready(function () {
    let el = $("#select-cliente")
    if (el.length === 0) return
    let select = new TomSelect(el, {})
    if (select !== null) {
        select.on('change', function () {
            Livewire.emit('onChange', select.getValue())
            select.blur()
        });
        $('.ts-control').addClass('py-0 px-1 text-muted')
    }
});

$(document).ready(function () {
    let el = $("#select-cliente-processo-novo")
    if (el.length === 0) return
    let select = new TomSelect(el, {})
    if (select !== null) {
        select.on('change', function () {
            Livewire.emit('onChange', select.getValue())
            select.blur()
        });
    }
});
