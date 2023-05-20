async function consultaLogradouro() {
    const cep = document.getElementById("cadastro-cep").value.replace(/[^0-9]+/, '');
    const url = `https://viacep.com.br/ws/${cep}/json/`;

    const response = await fetch(url);
    const json = await response.json();

    return json;
}

async function atualizaCampos() {
    const json = await consultaLogradouro();
    
    document.getElementById("cadastro-logradouro").value = json.logradouro;
    document.getElementById("cadastro-bairro").value = json.bairro;
    document.getElementById("cadastro-complemento").value = json.complemento;
    document.getElementById("cadastro-cidade").value = json.localidade;
    document.getElementById("cadastro-uf").value = json.uf;
}
