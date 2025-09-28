document.addEventListener("DOMContentLoaded", () => {
    carregarCarrinhoNoCheckout();
});

function carregarCarrinhoNoCheckout() {
    const carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
    const ul = document.getElementById('itensCheckout');
    const totalSpan = document.getElementById('totalCheckout');

    ul.innerHTML = '';
    let total = 0;

    if (carrinho.length === 0) {
        ul.innerHTML = '<li>Carrinho vazio.</li>';
        totalSpan.textContent = '0.00';
        return;
    }

    carrinho.forEach(item => {
        const li = document.createElement('li');
        li.textContent = `${item.nome} (x${item.quantidade}) - R$ ${(item.preco * item.quantidade).toFixed(2)}`;
        ul.appendChild(li);
        total += item.preco * item.quantidade;
    });

    totalSpan.textContent = total.toFixed(2);
}
