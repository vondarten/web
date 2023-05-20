function formatNumber(number) {
    const cleanedNumber = number.replace(/\D/g, '');
  
    const mask =  '00.000.000/0000-00';
  
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
  const numberInput = document.getElementById('cadastro-cnpj');
  const inputValue = numberInput.value;
  
  const formattedNumber = formatNumber(inputValue);
  numberInput.value = formattedNumber;
}

