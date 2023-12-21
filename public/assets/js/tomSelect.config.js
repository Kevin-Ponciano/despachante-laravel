$(document).ready(function () {
    let applySelect = (el) => {
        if (el.length === 0) return
        el.each(function () {
            let select = new TomSelect(el, {
                allowEmptyOption: true,
            })
            select.on('change', function () {
                select.blur()
            });
        })
    }
    // applySelect($("#select-cliente"))
    // applySelect($("#select-cliente-processo-novo"))
    // applySelect($("#select-cliente-atpv-novo"))
    // applySelect($("#select-cliente-renave-novo"))
    // applySelect($("#select-servico"))
    // applySelect($("#select-servico-novo"))

    $.find('select').forEach(function (el) {
        if($(el).hasClass('select-ignore')) return
        applySelect($(el))
    })
    $('.ts-control').addClass('py-0 px-2 text-muted')
});
