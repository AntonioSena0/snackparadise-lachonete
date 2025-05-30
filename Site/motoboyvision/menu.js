window.addEventListener("load", function() {
    document.body.classList.add("loaded");
});

document.querySelectorAll("a").forEach(link => {
    link.addEventListener("click", function(event) {
        event.preventDefault();
        document.body.classList.remove("loaded");
        setTimeout(() => {
            window.location.href = this.href;
        }, 500);
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Recupera os dados do checkout armazenados no localStorage
    const checkoutData = JSON.parse(localStorage.getItem('checkoutData'));

    if (checkoutData) {
        // Exibe os pedidos
        const pedidosContainer = document.getElementById('checkout-pedidos');
        pedidosContainer.innerHTML = ''; // Limpa o container
        checkoutData.pedidos.forEach(pedido => {
            const li = document.createElement('li');
            li.textContent = `${pedido.nome} - R$ ${pedido.preco.toFixed(2)}`;
            pedidosContainer.appendChild(li);
        });

        // Exibe o endereço e atendimento preferencial
        const enderecoContainer = document.getElementById('checkout-endereco');
        enderecoContainer.innerHTML = checkoutData.endereco;

        // Exibe a forma de pagamento
        const pagamentoContainer = document.getElementById('checkout-pagamento');
        pagamentoContainer.textContent = checkoutData.pagamento;
    } else {
        // Caso não haja dados, exibe uma mensagem
        document.getElementById('checkout-pedidos').textContent = 'Nenhum pedido encontrado.';
        document.getElementById('checkout-endereco').textContent = 'Endereço não informado.';
        document.getElementById('checkout-pagamento').textContent = 'Forma de pagamento não informada.';
    }
});