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
    // Menu Lateral
    const btnMenuLateral = document.getElementById('btnMenuLateral');
    const menuLateral = document.getElementById('menuLateral');

    btnMenuLateral.addEventListener('click', function(event) {
        event.stopPropagation();
        
        if (menuLateral.classList.contains('ativo')) {
            menuLateral.classList.remove('ativo');
            btnMenuLateral.classList.remove('active');
            btnMenuLateral.innerHTML = '☰';
        } else {
            menuLateral.classList.add('ativo');
            btnMenuLateral.classList.add('active');
            btnMenuLateral.innerHTML = '✖';
        }
    });

    // Submenu Cardápio
    const cardapioBtn = document.getElementById('cardapioBtn');
    const submenu = document.getElementById('submenu');

    if (cardapioBtn && submenu) {
        cardapioBtn.addEventListener('click', function(event) {
            event.stopPropagation();
            
            if (submenu.classList.contains('ativo')) {
                submenu.classList.remove('ativo');
                cardapioBtn.classList.remove('active');
            } else {
                submenu.classList.add('ativo');
                cardapioBtn.classList.add('active');
            }
        });

        // Evitar que cliques no submenu o fechem
        submenu.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    }

    // Fechar menus ao clicar fora
    document.addEventListener('click', function(event) {
        if (!menuLateral.contains(event.target) && 
            !btnMenuLateral.contains(event.target)) {
            menuLateral.classList.remove('ativo');
            btnMenuLateral.classList.remove('active');
            btnMenuLateral.innerHTML = '☰';
        }

        if (submenu && !submenu.contains(event.target) && 
            !cardapioBtn.contains(event.target)) {
            submenu.classList.remove('ativo');
            cardapioBtn.classList.remove('active');
        }
    });
});

document.addEventListener('DOMContentLoaded', async function() {
    const pedidosContainer = document.getElementById('checkout-pedidos');
    pedidosContainer.innerHTML = 'Carregando pedidos...';

    try {
        const response = await fetch('../back/controllers/listar_pedidos.php');
        const pedidos = await response.json();

        pedidosContainer.innerHTML = '';
        pedidos.forEach(pedido => {
            const li = document.createElement('li');
            li.innerHTML = `
                <strong>ID:</strong> ${pedido.id}<br>
                <strong>Email:</strong> ${pedido.usuario_email}<br>
                <strong>Itens:</strong> ${JSON.parse(pedido.itens).map(item => `${item.nome} (x${item.quantidade})`).join(', ')}<br>
                <strong>Endereço:</strong> ${pedido.endereco}<br>
                <strong>Pagamento:</strong> ${pedido.pagamento}<br>
                <strong>Data:</strong> ${pedido.criado_em}
                <hr>
            `;
            pedidosContainer.appendChild(li);
        });
    } catch (e) {
        pedidosContainer.innerHTML = 'Erro ao carregar pedidos!';
    }
});

// Exemplo de função para aceitar pedido
async function aceitarPedido(pedidoId) {
    const resposta = await fetch('../back/controllers/aceitar_pedido.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ pedido_id: pedidoId })
    });
    const texto = await resposta.text();
    alert(texto);
    // Atualize a lista de pedidos ou mova o pedido para a área de entregas
}