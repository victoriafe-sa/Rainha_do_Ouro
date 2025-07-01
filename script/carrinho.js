function changeQuantity(amount) {
    const input = document.getElementById('quantity');
    let value = parseInt(input.value) || 1;
    value = Math.max(1, value + amount);
    input.value = value;
}