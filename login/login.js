var isCpf;
var isCNPJ;

function formatNumber(number) {
    const cleanedNumber = number.replace(/\D/g, '');
  
    isCpf = cleanedNumber.length === 11;
    isCNPJ = cleanedNumber.length === 14;

    const mask = isCpf ? '000.000.000-00' : '00.000.000/0000-00';
  
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

function formatInputNumber() {
  const numberInput = document.getElementById('login-cpf-cnpj');
  const inputValue = numberInput.value;
  
  const formattedNumber = formatNumber(inputValue);
  numberInput.value = formattedNumber;
}

function redirect() {
  if (isCpf) window.location.pathname = '../../admin_entregador/admin_entregador.html'
  if (isCNPJ) window.location.pathname = '../../admin_loja/admin_loja.html'
}

