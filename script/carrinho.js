
function changeQuantity(button, amount) {
  const input = button.parentElement.querySelector('input');
  const cartItems = [...document.querySelectorAll('.cart-item')];
  const index = cartItems.indexOf(button.closest('.cart-item'));

  let cart = JSON.parse(localStorage.getItem('cart')) || [];
  let value = parseInt(input.value) || 1;

  if (amount === -1 && value === 1) {
    removeItem(index);
    return;
  }

  value = Math.max(1, value + amount);
  input.value = value;

  if (cart[index]) {
    cart[index].quantity = value;
    localStorage.setItem('cart', JSON.stringify(cart));
  }

  updateTotal();
}

function updateTotal() {
  const items = document.querySelectorAll('.cart-item');
  let subtotal = 0;

  items.forEach((item) => {
    const priceText = item.querySelector('.current-price').textContent;
    const match = priceText.match(/R\$\s*([\d,]+)/);
    const price = match ? parseFloat(match[1].replace(',', '.')) : 0;
    const quantity = parseInt(item.querySelector('input').value) || 1;
    subtotal += price * quantity;
  });

  const frete = calculateFrete();
  const total = subtotal + frete;

  const resumo = document.querySelector('.prices-resumo');
  resumo.innerHTML = `
        <h3>Resumo</h3>
        <p>Subtotal: R$ ${subtotal.toFixed(2).replace('.', ',')}</p>
        <p>Frete: R$ ${frete.toFixed(2).replace('.', ',')}</p>
        <p><strong>Total: R$ ${total.toFixed(2).replace('.', ',')}</strong></p>
    `;
}

function calculateFrete() {
  const rawcep = document.getElementById('cep').value;
  const cep = rawcep.replace(/\D/g, '');

  if (!cep || cep.length !== 8) return 0;
  if (cep.startsWith('01')) return 10.0;
  if (cep.startsWith('20')) return 12.5;
  if (cep.startsWith('30')) return 14.0;
  return 18.9;
}


function removeItem(index) {
  let cart = JSON.parse(localStorage.getItem('cart')) || [];
  cart.splice(index, 1);
  localStorage.setItem('cart', JSON.stringify(cart));
  loadCart();
}

function loadCart() {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const cartSection = document.querySelector('.cartSection');
  cartSection.innerHTML = '';

  cart.forEach((item, index) => {
    const oldPrice = (item.price * 2).toFixed(2).replace('.', ',');
    const div = document.createElement('div');
    div.className = 'cart-item';
    div.innerHTML = `
            <div class="item-image">
                <img src="${item.imageUrl}" alt="Produto" />
            </div>
            <div class="item-details">
                <p class="item-name">${item.name}</p>
                <div class="price-info">
                    <span class="old-price">De R$ ${oldPrice} </span>
                    <span class="current-price">por R$ ${item.price.toFixed(2).replace('.', ',')}</span>
                </div>
            </div>
            <div class="quantity-wrapper">
                <button class="quantity-btn" onclick="changeQuantity(this, -1)">-</button>
                <input type="number" value="${item.quantity}" />
                <button class="quantity-btn" onclick="changeQuantity(this, 1)">+</button>
            </div>
        `;
    cartSection.appendChild(div);
  });

  updateTotal();
}
document.addEventListener('DOMContentLoaded', () => {
  const cepInput = document.getElementById('cep');
  const form = document.querySelector('.price-section form');

  if (!cepInput || !form) {
    console.error('Elementos cep ou form não encontrados no DOM');
    return;
  }

  loadCart();

  cepInput.addEventListener('input', updateTotal);

  form.addEventListener('submit', (event) => {
    event.preventDefault();

    if (!usuarioLogadoId) {
      alert('Você precisa estar logado para finalizar a compra.');
      return;
    }

    if (cepInput.value.trim() === '') {
      alert('Por favor, digite seu CEP antes de finalizar a compra.');
      return;
    }

    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cep = cepInput.value.trim();

    fetch('../crud/finalizar_compra.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        userId: usuarioLogadoId,
        cep,
        itens: cart,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status === 'success') {
          alert('Compra reservada com sucesso! Faça o pagamento no seu perfil!');
          localStorage.removeItem('cart');
          window.location.href = '../html/perfil_usuario.php#pedidos';
        } else {
          alert('Erro: ' + data.message);
        }
      })
      .catch(() => alert('Erro ao finalizar compra.'));
  });
});
