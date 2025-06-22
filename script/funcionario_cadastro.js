
document.addEventListener('DOMContentLoaded', () => {
  const cpfInput = document.getElementById('cpf');
  const rgInput = document.getElementById('rg');
  const telefoneInput = document.getElementById('telefone');
  const salarioInput = document.getElementById('salario');
  const form = document.getElementById('form-funcionario');

  // CPF: 000.000.000-00
  cpfInput.addEventListener('input', e => {
    let value = e.target.value.replace(/\D/g, '').slice(0, 11);
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    e.target.value = value;
  });

  // RG: 00.000.000-0
  rgInput.addEventListener('input', e => {
    let value = e.target.value.replace(/\D/g, '').slice(0, 9);
    value = value.replace(/(\d{2})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d{1})$/, '$1-$2');
    e.target.value = value;
  });

  // Telefone: (00) 00000-0000 ou (00) 0000-0000
  telefoneInput.addEventListener('input', e => {
    let value = e.target.value.replace(/\D/g, '').slice(0, 11);
    if (value.length > 10) {
      value = value.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
    } else if (value.length > 6) {
      value = value.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
    } else if (value.length > 2) {
      value = value.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
    } else {
      value = value.replace(/^(\d*)/, '($1');
    }
    e.target.value = value;
  });

  // Salário: permite números e vírgula, formata ao sair do campo
  salarioInput.addEventListener('input', e => {
    e.target.value = e.target.value
      .replace(/[^\d,]/g, '')     // somente números e vírgula
      .replace(/^,+/, '');        // evita começar com vírgula
  });

  salarioInput.addEventListener('blur', e => {
    let value = e.target.value;
    if (!value) return;

    value = value.replace(',', '.');
    let number = parseFloat(value);
    if (isNaN(number)) {
      e.target.value = '';
      return;
    }

    e.target.value = number.toLocaleString('pt-BR', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  });

  // Alerta de cadastro
  form.addEventListener('submit', e => {
    e.preventDefault(); // evita envio real

    alert('Funcionário cadastrado com sucesso!');
    form.reset(); // limpa os campos
  });
});

