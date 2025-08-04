
  const imagens = document.querySelectorAll('.imagem-expandir');
  const popup = document.getElementById('popup');
  const imagemExpandida = document.getElementById('imagemExpandida');

  imagens.forEach(img => {
    img.addEventListener('click', () => {
      popup.style.display = 'flex';
      imagemExpandida.src = img.src;
    });
  });

  function fecharImagem() {
    popup.style.display = 'none';
  }

