<select class="form-control-rounded form-select w-auto d-inline" name="list-forms">
    <option value="">Filtro Empresa</option>
    <option value="despachante">Despachantes</option>
    <option value="cliente">Clientes</option>
</select>

<script>
    let url = new URL(window.location.href);
    let form = url.searchParams.get("empresa-filtro");
    if (form) {
        document.querySelector('select[name="list-forms"]').value = form;
    }

    document.querySelector('select[name="list-forms"]').addEventListener('change', function (e) {
        window.location.href = '?empresa-filtro=' + e.target.value;
        console.log(e.target.value)
    });
</script>
