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

function returnCEPformated(number){
    const cleanedNumber = number.replace(/\D/g, '');
    const mask = '00.000-000';

    let formattedNumber = '';
    let index = 0;
    for (let i = 0; i < mask.length; i++) {
        if (mask[i] === '0') {
            formattedNumber += cleanedNumber[index] || '';
            index++;
        } else {
            formattedNumber += mask[i];
        }
    }
    return formattedNumber;
}
function formatCep(id) {
    const numberInput = document.getElementById(id);
    const inputValue = numberInput.value;

    const formattedNumber = returnCEPformated(inputValue);
    numberInput.value = formattedNumber;
}
