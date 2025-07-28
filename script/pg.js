
  const slides = document.querySelector('.slides');
  const imagens = document.querySelectorAll('.slides img');
  const btnEsquerda = document.querySelector('.esquerda');
  const btnDireita = document.querySelector('.direita');
  let index = 0;

  btnDireita.addEventListener('click', () => {
    index = (index + 1) % imagens.length;
    atualizarCarrossel();
  });

  btnEsquerda.addEventListener('click', () => {
    index = (index - 1 + imagens.length) % imagens.length;
    atualizarCarrossel();
  });

  function atualizarCarrossel() {
    slides.style.transform = `translateX(-${index * 100}%)`;
  }

