function changeQuantity(button, amount) {
    const input = button.parentElement.querySelector('input');
    const cartItems = [...document.querySelectorAll('.cart-item')];
    const index = cartItems.indexOf(button.closest('.cart-item'));

    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let value = parseInt(input.value) || 1;

    if (amount === -1 && value === 1) {
        // Se a quantidade for 1 e clicar em "-", remove o item
        removeItem(index);
        return;
    }

    value = Math.max(1, value + amount);
    input.value = value;

    // Atualiza quantidade no localStorage
    if (cart[index]) {
        cart[index].quantity = value;
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    updateTotal();
}

function updateTotal() {
    const items = document.querySelectorAll('.cart-item');
    let subtotal = 0;

    items.forEach(item => {
        const priceText = item.querySelector('.current-price').textContent;
        
        // Extrai apenas o valor numérico do texto (ignora "por", espaços, etc.)
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
    const rawCep = document.getElementById('CEP').value;
    const cep = rawCep.replace(/\D/g, '');

    if (!cep || cep.length !== 8) return 0;

    if (cep.startsWith('01')) return 10.00;
    if (cep.startsWith('20')) return 12.50;
    if (cep.startsWith('30')) return 14.00;
    return 18.90;
}

function removeItem(index) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    loadCart(); // recarrega os itens do carrinho
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
                <img src="${item.imageUrl}" alt="Produto">
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
                <input type="number" value="${item.quantity}">
                <button class="quantity-btn" onclick="changeQuantity(this, 1)">+</button>
            </div>
        `;
        cartSection.appendChild(div);
    });

    updateTotal();
}


document.getElementById('CEP').addEventListener('input', updateTotal);
document.addEventListener('DOMContentLoaded', loadCart);
