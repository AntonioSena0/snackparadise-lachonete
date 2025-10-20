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

// Função para recusar pedido (motoboy)
async function recusarPedidoMotoboy(pedidoId) {
    if (!confirm('Tem certeza que deseja recusar este pedido? O pedido voltará para a lista de disponíveis.')) {
        return;
    }

    try {
        const resp = await fetch('../back/controllers/recusar_pedido_motoboy.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ pedido_id: pedidoId })
        });
        
        const result = await resp.json();

        if (result.success) {
            alert('Pedido recusado com sucesso!');
            // Remove o pedido da tela
            const pedidoElement = document.getElementById(`pedido-${pedidoId}`);
            if (pedidoElement) {
                pedidoElement.style.opacity = '0';
                setTimeout(() => {
                    pedidoElement.remove();
                    // Verifica se ainda há pedidos
                    const grid = document.getElementById('meus-pedidos-grid');
                    const remainingOrders = grid.querySelectorAll('.order-card');
                    if (remainingOrders.length === 0) {
                        grid.innerHTML = '<p>Nenhum pedido atribuído a você no momento.</p>';
                    }
                }, 300);
            }
        } else {
            alert('Erro ao recusar pedido: ' + (result.message || 'Tente novamente.'));
        }
    } catch (e) {
        console.error('Erro:', e);
        alert('Erro ao processar a solicitação.');
    }
}

// Função para iniciar entrega
async function iniciarEntrega(pedidoId) {
    if (!confirm('Confirmar que está iniciando a entrega deste pedido?')) {
        return;
    }

    try {
        const resp = await fetch('../back/controllers/aceitar_pedido.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ pedido_id: pedidoId })
        });
        
        const result = await resp.json();

        if (result.success) {
            alert('Entrega iniciada! Status atualizado para "em_entrega".');
            // Atualiza o status visualmente
            const statusElement = document.querySelector(`#pedido-${pedidoId} .order-status`);
            if (statusElement) {
                statusElement.textContent = 'em_entrega';
                statusElement.className = 'order-status status-em_entrega';
            }
        } else {
            alert('Erro ao iniciar entrega: ' + (result.message || 'Tente novamente.'));
        }
    } catch (e) {
        console.error('Erro:', e);
        alert('Erro ao processar a solicitação.');
    }
}

// Função para carregar pedidos do motoboy (atualização em tempo real)
async function carregarPedidosMotoboy() {
    try {
        const resp = await fetch('../back/controllers/carregar_pedidos_motoboy.php');
        const pedidos = await resp.json();
        
        const grid = document.getElementById('meus-pedidos-grid');
        if (!grid) return;

        if (!pedidos.length) {
            grid.innerHTML = '<p>Nenhum pedido atribuído a você no momento.</p>';
            return;
        }

        grid.innerHTML = pedidos.map(order => `
            <div class="order-card" id="pedido-${order.id}">
                <h3>Pedido #${order.id}</h3>
                <p><strong>Cliente:</strong> ${order.cliente_nome || '—'}</p>
                <div><strong>Itens:</strong>
                    <ul style="margin: 6px 0 0 0; padding-left: 18px;">
                        ${order.itens_descricao ? order.itens_descricao.split(', ').map(item => `<li>${item}</li>`).join('') : ''}
                    </ul>
                </div>
                <p><strong>Total:</strong> R$ ${order.total ? order.total.toFixed(2).replace('.', ',') : '—'}</p>
                <p><strong>Endereço:</strong> ${order.endereco}</p>
                <p><strong>Pagamento:</strong> ${order.pagamento}</p>
                <p><strong>Status:</strong> <span class="order-status status-${order.status}">${order.status}</span></p>
                <p><strong>Data:</strong> ${order.criado_em}</p>
                <div class="order-actions">
                    <button class="btn btn-aceitar" onclick="iniciarEntrega(${order.id})">
                        Iniciar Entrega
                    </button>
                    <button class="btn btn-recusar" onclick="recusarPedidoMotoboy(${order.id})">
                        Recusar Pedido
                    </button>
                </div>
            </div>
        `).join('');
    } catch (e) {
        console.error('Erro ao carregar pedidos:', e);
    }
}

// Atualiza os pedidos a cada 30 segundos
setInterval(carregarPedidosMotoboy, 30000);

// Carrega os pedidos quando a página carrega
document.addEventListener('DOMContentLoaded', function() {
    carregarPedidosMotoboy();
});