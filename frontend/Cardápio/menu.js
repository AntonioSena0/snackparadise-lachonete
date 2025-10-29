document.addEventListener('DOMContentLoaded', function() {
    initializeMenu();
    carregarDados();
    atualizarCarrinho();
});

function initializeMenu() {
    // Menu Lateral
    const btnMenuLateral = document.getElementById('btnMenuLateral');
    const menuLateral = document.getElementById('menuLateral');

    if (btnMenuLateral && menuLateral) {
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
    }

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

        submenu.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    }

    // Fechar menus ao clicar fora
    document.addEventListener('click', function(event) {
        if (menuLateral && !menuLateral.contains(event.target) && 
            btnMenuLateral && !btnMenuLateral.contains(event.target)) {
            menuLateral.classList.remove('ativo');
            btnMenuLateral.classList.remove('active');
            btnMenuLateral.innerHTML = '☰';
        }

        if (submenu && !submenu.contains(event.target) && 
            cardapioBtn && !cardapioBtn.contains(event.target)) {
            submenu.classList.remove('ativo');
            cardapioBtn.classList.remove('active');
        }
    });

    // Configurar botão finalizar compra
    const btnFinalizarCompra = document.getElementById('finalizarCompra');
    if (btnFinalizarCompra) {
        btnFinalizarCompra.addEventListener('click', finalizarCompra);
    }
}

window.addEventListener("load", function() {
    document.body.classList.add("loaded");
});

// Navegação suave
document.querySelectorAll("a").forEach(link => {
    link.addEventListener("click", function(event) {
        if (this.href && this.href !== "#" && !this.href.includes("instagram.com")) {
            event.preventDefault();
            document.body.classList.remove("loaded");
            setTimeout(() => {
                window.location.href = this.href;
            }, 500);
        }
    });
});

let lanches = [];
let acompanhamentos = [];
let bebidas = [];

function carregarDados() {
    // Carregar apenas do JSON local, ignorando backend
    fetch('main.json')
        .then(response => response.json())
        .then(data => {
            lanches = data.lanches || [];
            acompanhamentos = data.acompanhamentos || [];
            bebidas = data.bebidas || [];
            adicionarItens();
        })
        .catch(error => {
            console.error('Erro ao carregar dados:', error);
            showNotification('Erro ao carregar cardápio', 'error');
        });
}

function processarDadosBackend(produtos) {
    // Separar produtos por categoria (baseado no seu banco)
    lanches = produtos.filter(p => p.categoria === 'lanche' || p.id <= 6);
    acompanhamentos = produtos.filter(p => p.categoria === 'acompanhamento' || (p.id >= 7 && p.id <= 9));
    bebidas = produtos.filter(p => p.categoria === 'bebida' || p.id >= 10);
    
    adicionarItens();
}

function adicionarItens() {
    adicionarLanches();
    adicionarAcompanhamentos();
    adicionarBebidas();
}

function adicionarLanches() {
    const areaLanches = document.querySelector('.area-lanches');
    if (!areaLanches || !lanches.length) return;

    areaLanches.innerHTML = '';
    
    lanches.forEach((item) => {
        let lancheItem = document.querySelector('.modelos .lanche-item').cloneNode(true);
        
        // Configurar imagem
        const imgElement = lancheItem.querySelector('.lanche-item--img img');
        imgElement.src = corrigirCaminhoImagem(item.img || item.imagem || '');
        imgElement.alt = item.nome;
        imgElement.onerror = function() {
            this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjE1MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkltYWdlbSBuw6NvIGNhcnJlZ2FkYTwvdGV4dD48L3N2Zz4=';
        };
        
        // Configurar dados
        lancheItem.querySelector('.lanche-item--preco').textContent = `R$ ${parseFloat(item.preco).toFixed(2)}`;
        lancheItem.querySelector('.lanche-item--nome').textContent = item.nome;
        
        const descElement = lancheItem.querySelector('.lanche-item--desc');
        if (item.descricao) {
            descElement.textContent = item.descricao;
        } else {
            descElement.style.display = 'none';
        }
        
        // Configurar botão
        const btnComprar = lancheItem.querySelector('.btn-comprar');
        btnComprar.addEventListener('click', function() {
            adicionarAoCarrinho(item.nome, parseFloat(item.preco), item.id);
        });
        
        // Mostrar item
        lancheItem.style.display = 'block';
        areaLanches.appendChild(lancheItem);
    });
}

function adicionarAcompanhamentos() {
    const areaAcompanhamentos = document.querySelector('.area-acompanhamentos');
    if (!areaAcompanhamentos || !acompanhamentos.length) return;

    areaAcompanhamentos.innerHTML = '';
    
    acompanhamentos.forEach((item) => {
        let lancheItem = document.querySelector('.modelos .lanche-item').cloneNode(true);
        
        const imgElement = lancheItem.querySelector('.lanche-item--img img');
        imgElement.src = corrigirCaminhoImagem(item.img || item.imagem || '');
        imgElement.alt = item.nome;
        imgElement.onerror = function() {
            this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjE1MCIgeG1zbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkltYWdlbSBuw6NvIGNhcnJlZ2FkYTwvdGV4dD48L3N2Zz4=';
        };
        
        lancheItem.querySelector('.lanche-item--preco').textContent = `R$ ${parseFloat(item.preco).toFixed(2)}`;
        lancheItem.querySelector('.lanche-item--nome').textContent = item.nome;
        lancheItem.querySelector('.lanche-item--desc').style.display = 'none';
        
        const btnComprar = lancheItem.querySelector('.btn-comprar');
        btnComprar.addEventListener('click', function() {
            adicionarAoCarrinho(item.nome, parseFloat(item.preco), item.id);
        });
        
        lancheItem.style.display = 'block';
        areaAcompanhamentos.appendChild(lancheItem);
    });
}

function adicionarBebidas() {
    const areaBebidas = document.querySelector('.area-bebidas');
    if (!areaBebidas || !bebidas.length) return;

    areaBebidas.innerHTML = '';
    
    bebidas.forEach((item) => {
        let lancheItem = document.querySelector('.modelos .lanche-item').cloneNode(true);
        
        const imgElement = lancheItem.querySelector('.lanche-item--img img');
        imgElement.src = corrigirCaminhoImagem(item.img || item.imagem || '');
        imgElement.alt = item.nome;
        imgElement.onerror = function() {
            this.src = 'data:image/svg+xml;basecyw==';
        };
        
        lancheItem.querySelector('.lanche-item--preco').textContent = `R$ ${parseFloat(item.preco).toFixed(2)}`;
        lancheItem.querySelector('.lanche-item--nome').textContent = item.nome;
        lancheItem.querySelector('.lanche-item--desc').style.display = 'none';
        
        const btnComprar = lancheItem.querySelector('.btn-comprar');
        btnComprar.addEventListener('click', function() {
            adicionarAoCarrinho(item.nome, parseFloat(item.preco), item.id);
        });
        
        lancheItem.style.display = 'block';
        areaBebidas.appendChild(lancheItem);
    });
}

// Função para adicionar itens ao carrinho
function adicionarAoCarrinho(nome, preco, id) {
    let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
    const itemExistente = carrinho.find(item => item.id === id);
    
    if (itemExistente) {
        itemExistente.quantidade += 1;
    } else {
        carrinho.push({ 
            id: id,
            nome: nome, 
            preco: preco, 
            quantidade: 1 
        });
    }
    
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    atualizarCarrinho();
    showNotification(`${nome} adicionado ao carrinho!`, 'success');
}

// Função para atualizar o carrinho na interface
function atualizarCarrinho() {
    const itensCarrinho = document.getElementById('itensCarrinho');
    const totalCarrinho = document.getElementById('totalCarrinho');

    if (!itensCarrinho || !totalCarrinho) return;

    const carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
    itensCarrinho.innerHTML = '';
    let total = 0;

    if (carrinho.length === 0) {
        itensCarrinho.innerHTML = '<li>Carrinho vazio</li>';
        totalCarrinho.textContent = '0.00';
        return;
    }

    carrinho.forEach((item, index) => {
        const li = document.createElement('li');
        li.innerHTML = `
            ${item.nome} (x${item.quantidade}) - R$ ${(item.preco * item.quantidade).toFixed(2)}
            <button class="btn-remover" onclick="removerDoCarrinho(${index})">Remover</button>
        `;
        itensCarrinho.appendChild(li);
        total += item.preco * item.quantidade;
    });

    totalCarrinho.textContent = total.toFixed(2);
}

// Função para remover itens do carrinho
function removerDoCarrinho(index) {
    let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
    carrinho.splice(index, 1);
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    atualizarCarrinho();
    showNotification('Item removido do carrinho!', 'warning');
}

// Finalizar compra - integrado com backend
async function finalizarCompra() {
    const carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
    
    if (carrinho.length === 0) {
        showNotification('Seu carrinho está vazio!', 'error');
        return;
    }

    // Verificar se usuário está logado
    if (!USER_LOGGED) {
        showNotification('Você precisa estar logado para finalizar a compra!', 'error');
        setTimeout(() => {
            window.location.href = '../Tela de Login/index.php';
        }, 2000);
        return;
    }

    // Redirecionar para checkout
    const total = carrinho.reduce((sum, item) => sum + (item.preco * item.quantidade), 0);
    localStorage.setItem('total', total.toFixed(2));
    window.location.href = '../checkout/index.php';
}

// Função para mostrar notificação
function showNotification(message, type = 'info') {
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <span>${message}</span>
        <button onclick="this.parentElement.remove()">&times;</button>
    `;

    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 0.8rem;
        color: white;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        min-width: 300px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        animation: slideIn 0.3s ease-out;
    `;

    const colors = {
        success: '#28a745',
        error: '#dc3545',
        warning: '#ffc107',
        info: '#17a2b8'
    };

    notification.style.background = colors[type] || colors.info;

    const closeBtn = notification.querySelector('button');
    closeBtn.style.cssText = `
        background: none;
        border: none;
        color: white;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        if (notification.parentElement) {
            notification.style.animation = 'slideOut 0.3s ease-in forwards';
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}

// Corrigir caminhos das imagens
function corrigirCaminhoImagem(caminhoOriginal) {
    if (!caminhoOriginal) return '';
    // Corrige para caminho relativo à pasta atual
    if (caminhoOriginal.startsWith('Assets/')) {
        return caminhoOriginal;
    }
    return 'Assets/' + caminhoOriginal.replace(/^\.\//, '').replace(/^\.\.\//, '');
}

// Adicionar estilos CSS dinamicamente
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    .notification { animation: slideIn 0.3s ease-out; }
`;
document.head.appendChild(style);