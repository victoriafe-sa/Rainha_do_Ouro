const steps = document.querySelectorAll('.form-step');
const nextBtns = document.querySelectorAll('.next-btn');
const prevBtns = document.querySelectorAll('.prev-btn');
const progressSteps = document.querySelectorAll('.progress-bar .step');

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

document.querySelectorAll('.service').forEach(label => {
  label.addEventListener('click', () => {
    document.querySelectorAll('.service').forEach(s => s.classList.remove('active'));
    label.classList.add('active');
    label.querySelector('input').checked = true;

    // Atualizar o conteúdo dinâmico com base no serviço selecionado
    const selectedLabel = label.querySelector('span').innerText;
    step2Content.innerHTML = serviceDetails[selectedLabel] || '<p>Selecione um serviço válido.</p>';
  });
});

document.getElementById('quoteForm').addEventListener('submit', e => {
  e.preventDefault();
  currentStep = steps.length - 1;
  showStep(currentStep);
});

const serviceDetails = {
  "Trança": `
      <label>Tipo de Trança *</label>
      <select required>
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
      <select required>
        <option value="">Selecione</option>
        <option value="Hidratação">Hidratação</option>
        <option value="Nutrição">Nutrição</option>
        <option value="Reconstrução">Reconstrução</option>
      </select>
    `,
  "Consultoria": `
      <label>Tipo de Consultoria *</label>
      <select required>
        <option value="">Selecione</option>
        <option value="Imagem pessoal">Imagem pessoal</option>
        <option value="Cuidados capilares">Cuidados capilares</option>
      </select>
    `,
  "Higienização": `
      <label>Tipo de Higienização *</label>
      <select required>
        <option value="">Selecione</option>
        <option value="Scalp Detox">Scalp Detox</option>
        <option value="Higienização profunda">Higienização profunda</option>
        <option value="Lavagem">Lavagem + Finalização</option>
      </select>
    `,
  "Corte": `
      <label>Tipo de Corte *</label>
      <select required>
        <option value="">Selecione</option>
        <option value="Corte bordado">Corte bordado</option>
        <option value="Corte em camadas">Corte em camadas</option>
        <option value="Corte em Shaggy">Corte em Shaggy</option>
        <option value="Corte Mullet">Corte Mullet</option>
      </select>
    `,
    "Manutenção": `
        <label>Tipo de Manutenção*</label>
        <select required>
          <option value="">Selecione</option>
          <option value="Manutenção de Trança">Manutenção de Trança</option>
          <option value="Coloração">Coloração</option>
        </select>
      `
};

const serviceRadios = document.querySelectorAll('input[name="service"]');
const step2Content = document.getElementById('step2-dynamic-content');

// Inicializar com o conteúdo do serviço padrão
window.addEventListener('DOMContentLoaded', () => {
  const checkedRadio = document.querySelector('input[name="service"]:checked');
  if (checkedRadio) {
    const selectedLabel = checkedRadio.parentElement.querySelector('span').innerText;
    step2Content.innerHTML = serviceDetails[selectedLabel] || '';
  }
});