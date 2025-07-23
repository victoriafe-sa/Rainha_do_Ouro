const steps = document.querySelectorAll('.form-step');
const nextBtns = document.querySelectorAll('.next-btn');
const prevBtns = document.querySelectorAll('.prev-btn');
const progressSteps = document.querySelectorAll('.progress-bar .step');
const step2Content = document.getElementById('step2-dynamic-content');
const form = document.getElementById('quoteForm');

let currentStep = 0;

function showStep(step) {
  steps.forEach((s, i) => s.classList.toggle('active', i === step));
  progressSteps.forEach((p, i) => p.classList.toggle('active', i <= step));
}

nextBtns.forEach(btn => btn.addEventListener('click', () => {
  if (currentStep < steps.length - 1) {
    currentStep++;
    showStep(currentStep);
  }
}));

prevBtns.forEach(btn => btn.addEventListener('click', () => {
  if (currentStep > 0) {
    currentStep--;
    showStep(currentStep);
  }
}));

const serviceDetails = {
  "Trança": `
    <label>Tipo de Trança *</label>
    <select name="tipoServico" required>
      <option value="">Selecione</option>
      <option value="Nagô">Nagô</option>
      <option value="Box Braids">Box Braids</option>
      <option value="Twist">Twist</option>
      <option value="Goddess">Goddess</option>
      <option value="Fulani">Fulani</option>
      <option value="Dread Locs">Dread Locs</option>
      <option value="Lemonade">Lemonade</option>
    </select>
  `,
  "Tratamento": `
    <label>Tipo de Tratamento *</label>
    <select name="tipoServico" required>
      <option value="">Selecione</option>
      <option value="Hidratação">Hidratação</option>
      <option value="Nutrição">Nutrição</option>
      <option value="Reconstrução">Reconstrução</option>
    </select>
  `,
  "Consultoria": `
    <label>Tipo de Consultoria *</label>
    <select name="tipoServico" required>
      <option value="">Selecione</option>
      <option value="Imagem pessoal">Imagem pessoal</option>
      <option value="Cuidados capilares">Cuidados capilares</option>
    </select>
  `,
  "Higienização": `
    <label>Tipo de Higienização *</label>
    <select name="tipoServico" required>
      <option value="">Selecione</option>
      <option value="Scalp Detox">Scalp Detox</option>
      <option value="Higienização profunda">Higienização profunda</option>
      <option value="Lavagem">Lavagem + Finalização</option>
    </select>
  `,
  "Corte": `
    <label>Tipo de Corte *</label>
    <select name="tipoServico" required>
      <option value="">Selecione</option>
      <option value="Corte bordado">Corte bordado</option>
      <option value="Corte em camadas">Corte em camadas</option>
      <option value="Corte em Shaggy">Corte em Shaggy</option>
      <option value="Corte Mullet">Corte Mullet</option>
    </select>
  `,
  "Manutenção": `
    <label>Tipo de Manutenção *</label>
    <select name="tipoServico" required>
      <option value="">Selecione</option>
      <option value="Manutenção de Trança">Manutenção de Trança</option>
      <option value="Coloração">Coloração</option>
    </select>
  `
};

document.querySelectorAll('.service').forEach(label => {
  label.addEventListener('click', () => {
    document.querySelectorAll('.service').forEach(s => s.classList.remove('active'));
    label.classList.add('active');
    label.querySelector('input').checked = true;

    const selectedLabel = label.querySelector('span').innerText;
    const dynamicField = serviceDetails[selectedLabel] || '<p>Selecione um serviço válido.</p>';

    step2Content.innerHTML = `
      ${dynamicField}
      <label>Selecione a Data *</label>
      <input type="date" name="data" id="data" required>

      <label>Selecione o Horário *</label>
      <select name="horario" required>
        <option value="">Horário</option>
        <option value="09:00">09:00</option>
        <option value="10:00">10:00</option>
        <option value="11:00">11:00</option>
        <option value="12:00">12:00</option>
        <option value="13:00">13:00</option>
        <option value="14:00">14:00</option>
        <option value="15:00">15:00</option>
        <option value="16:00">16:00</option>
        <option value="17:00">17:00</option>
      </select>
    `;

    inicializarVerificacaoData(); // reaplica listeners na data
  });
});

form.addEventListener('submit', e => {
  // e.preventDefault(); // se quiser testar sem enviar, descomente isso
  currentStep = steps.length - 1;
  showStep(currentStep);
  form.submit();
});

// Função para verificar e carregar horários disponíveis
function inicializarVerificacaoData() {
  const inputData = document.querySelector("#data");
  const selectHorario = document.querySelector("select[name='horario']");

  if (!inputData || !selectHorario) return;

  const hoje = new Date();
  const ano = hoje.getFullYear();
  const mes = String(hoje.getMonth() + 1).padStart(2, '0');
  const dia = String(hoje.getDate()).padStart(2, '0');
  const dataMinima = `${ano}-${mes}-${dia}`;
  inputData.min = dataMinima;

  inputData.addEventListener("change", function () {
    const dataSelecionada = this.value;
    if (!dataSelecionada) return;

    fetch(`buscar_horarios.php?data=${dataSelecionada}`)
      .then(res => res.json())
      .then(horariosAgendados => {
        const todosHorarios = [
          "09:00", "10:00", "11:00", "12:00",
          "13:00", "14:00", "15:00", "16:00", "17:00"
        ];

        selectHorario.innerHTML = "";

        todosHorarios.forEach(horario => {
          if (!horariosAgendados.includes(horario)) {
            const option = document.createElement("option");
            option.value = horario;
            option.textContent = horario;
            selectHorario.appendChild(option);
          }
        });

        if (selectHorario.options.length === 0) {
          const option = document.createElement("option");
          option.textContent = "Nenhum horário disponível";
          option.disabled = true;
          option.selected = true;
          selectHorario.appendChild(option);
        }
      });
  });
}

// Caso algum serviço já esteja selecionado ao carregar a página
window.addEventListener('DOMContentLoaded', () => {
  const checkedRadio = document.querySelector('input[name="service"]:checked');
  if (checkedRadio) {
    const selectedLabel = checkedRadio.parentElement.querySelector('span').innerText;
    const dynamicField = serviceDetails[selectedLabel] || '';
    step2Content.innerHTML = `
      ${dynamicField}
      <label>Selecione a Data *</label>
      <input type="date" name="data" id="data" required>

      <label>Selecione o Horário *</label>
      <select name="horario" required>
        <option value="09:00">09:00</option>
        <option value="10:00">10:00</option>
        <option value="11:00">11:00</option>
        <option value="12:00">12:00</option>
        <option value="13:00">13:00</option>
        <option value="14:00">14:00</option>
        <option value="15:00">15:00</option>
        <option value="16:00">16:00</option>
        <option value="17:00">17:00</option>
      </select>
    `;
    inicializarVerificacaoData();
  }
});
