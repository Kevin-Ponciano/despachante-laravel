$(document).ready(function () {
    function limpa_formulario_cep() {
        // Limpa valores do formulário de cep.
        $("#rua").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#uf").val("");
        $("#ibge").val("");
    }

    // Quando o campo cep perde o foco.
    $("#cep").blur(function () {
        // Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, "");

        // Verifica se campo cep possui valor informado.
        if (cep != "") {
            // Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            // Valida o formato do CEP.
            if (validacep.test(cep)) {
                // Preenche os campos com "..." enquanto consulta webservice.
                $("#rua").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#uf").val("...");
                $("#ibge").val("...");

                // Consulta o webservice viacep.com.br/ utilizando Axios.
                axios
                    .get(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(function (response) {
                        if (!response.data.erro) {
                            Livewire.emit('cep-found', response.data);
                        } else {
                            // CEP pesquisado não foi encontrado.
                            limpa_formulario_cep();
                            alert("CEP não encontrado.");
                        }
                    })
                    .catch(function () {
                        // Ocorreu um erro na requisição.
                        limpa_formulario_cep();
                        alert("Erro ao consultar o CEP.");
                    });
            } else {
                // CEP é inválido.
                limpa_formulario_cep();
                // todo - Disparar evento, para que o livewire possa tratar o erro.
                alert("Formato de CEP inválido.");
            }
        } else {
            // CEP sem valor, limpa formulário.
            limpa_formulario_cep();
        }
    });
});
