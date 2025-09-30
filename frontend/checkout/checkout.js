document.addEventListener("DOMContentLoaded", () => {
    carregarEnderecoUsuario();
    carregarCarrinhoNoCheckout();
    setupFormSubmit();
});

async function carregarEnderecoUsuario() {
    try {
        const response = await fetch('../../backend/controllers/PedidoController.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({action: 'get_endereco_usuario'})
        });
        const result = await response.json();
        if (result.success && result.endereco) {
            // Supondo que o campo do endereço tenha id="endereco"
            document.getElementById('endereco').value = result.endereco.endereco || '';
            // Se tiver campos separados, preencha cada um
            // document.getElementById('rua').value = result.endereco.rua || '';
            // document.getElementById('numero').value = result.endereco.numero || '';
            // document.getElementById('bairro').value = result.endereco.bairro || '';
            // document.getElementById('cidade').value = result.endereco.cidade || '';
        }
    } catch (e) {
        // Silencie ou mostre erro se quiser
    }
}

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
