function changeQuantity(button, amount) {
    const input = button.parentElement.querySelector('input');
    let value = parseInt(input.value) || 1;
    value = Math.max(1, value + amount);
    input.value = value;
    updateTotal(); // Atualiza total sempre que muda a quantidade
}

function updateTotal() {
    const items = document.querySelectorAll('.cart-item');
    let subtotal = 0;

    items.forEach(item => {
        const priceText = item.querySelector('.current-price').textContent.replace('R$', '').replace(',', '.');
        const price = parseFloat(priceText);
        const quantity = parseInt(item.querySelector('input').value) || 1;
        subtotal += price * quantity;
    });

    const frete = calculateFrete(); // Frete baseado no CEP
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
    // Obtém o valor do campo de CEP
    const rawCep = document.getElementById('CEP').value;

    // Remove tudo que não for número
    const cep = rawCep.replace(/\D/g, '');

    // Verifica se o CEP tem exatamente 8 dígitos
    if (!cep || cep.length !== 8) {
        console.warn('CEP inválido');
        return 0;
    }

    // Simulação de cálculo de frete baseado nos primeiros dígitos do CEP
    // Você pode substituir isso por uma API dos Correios ou transportadora real
    if (cep.startsWith('01')) {
        return 10.00;
    } else if (cep.startsWith('20')) {
        return 12.50;
    } else if (cep.startsWith('30')) {
        return 14.00;
    } else {
        return 18.90;
    }
}


document.getElementById('CEP').addEventListener('input', updateTotal);


document.addEventListener('DOMContentLoaded', () => {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartSection = document.querySelector('.cartSection');
    cartSection.innerHTML = ''; // limpa os itens existentes

    cart.forEach((item, index) => {
        const div = document.createElement('div');
        div.className = 'cart-item';
        div.innerHTML = `
            <div class="item-image">
                <img src="${item.imageUrl}" alt="Produto">
            </div>
            <div class="item-details">
                <p class="item-name">${item.name}</p>
                <div class="price-info">
                    <span class="old-price">De R$ 40,00 por</span>
                    <span class="current-price">R$ ${item.price.toFixed(2).replace('.', ',')}</span>
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
});
