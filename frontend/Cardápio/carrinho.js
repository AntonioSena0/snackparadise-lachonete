document.addEventListener('DOMContentLoaded', function() {
    carregarCardapio();
    atualizarCarrinho();
});

function carregarCardapio() {
    fetch('main.json') // substitua pelo caminho correto do seu JSON
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao carregar cardápio');
            }
            return response.json();
        })
        .then(cardapio => {
            const modelos = document.querySelector('.modelos');
            modelos.innerHTML = '';

            // Carrega lanches
            cardapio.lanches.forEach(item => {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'lanche-item';
                
                itemDiv.innerHTML = `
                    <div class="lanche-item--img">
                        <img src="${item.img}" alt="${item.nome}" />
                    </div>
                    <div class="lanche-item--info">
                        <strong>
                            <div class="lanche-item--preco">R$ ${item.preco.toFixed(2)}</div>
                            <div class="lanche-item--nome">${item.nome}</div>
                        </strong>
                        <div class="lanche-item--desc">${item.descricao}</div>
                        <button class="btn-comprar" 
                                data-nome="${item.nome}" 
                                data-preco="${item.preco}">
                            Adicionar ao Carrinho
                        </button>
                    </div>
                `;
                
                modelos.appendChild(itemDiv);
            });

            // Carrega acompanhamentos
            cardapio.acompanhamentos.forEach(item => {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'lanche-item';
                
                itemDiv.innerHTML = `
                    <div class="lanche-item--img">
                        <img src="${item.img}" alt="${item.nome}" />
                    </div>
                    <div class="lanche-item--info">
                        <strong>
                            <div class="lanche-item--preco">R$ ${item.preco.toFixed(2)}</div>
                            <div class="lanche-item--nome">${item.nome}</div>
                        </strong>
                        <div class="lanche-item--desc">${item.descricao || ''}</div>
                        <button class="btn-comprar" 
                                data-nome="${item.nome}" 
                                data-preco="${item.preco}">
                            Adicionar ao Carrinho
                        </button>
                    </div>
                `;
                
                modelos.appendChild(itemDiv);
            });

            // Carrega bebidas
            cardapio.bebidas.forEach(item => {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'lanche-item';
                
                itemDiv.innerHTML = `
                    <div class="lanche-item--img">
                        <img src="${item.img}" alt="${item.nome}" />
                    </div>
                    <div class="lanche-item--info">
                        <strong>
                            <div class="lanche-item--preco">R$ ${item.preco.toFixed(2)}</div>
                            <div class="lanche-item--nome">${item.nome}</div>
                        </strong>
                        <div class="lanche-item--desc">${item.descricao || ''}</div>
                        <button class="btn-comprar" 
                                data-nome="${item.nome}" 
                                data-preco="${item.preco}">
                            Adicionar ao Carrinho
                        </button>
                    </div>
                `;
                
                modelos.appendChild(itemDiv);
            });

            // Adiciona os event listeners após carregar todos os itens
            adicionarEventListeners();
        })
        .catch(error => {
            console.error('Erro ao carregar cardápio:', error);
            // Fallback caso o JSON não carregue
            carregarCardapioFallback();
        });
}

function carregarCardapioFallback() {
    const modelos = document.querySelector('.modelos');
    modelos.innerHTML = `
        <div class="lanche-item">
            <div class="lanche-item--img">
                <img src="Assets/Encomendar e Retirar (Tradicional)/Hamburguer 2 1.png" alt="Sunset Burguer" />
            </div>
            <div class="lanche-item--info">
                <strong>
                    <div class="lanche-item--preco">R$ 28.00</div>
                    <div class="lanche-item--nome">Sunset Burguer</div>
                </strong>
                <div class="lanche-item--desc">Bacon, cheddar, Hamburguer grelhado, Molho Barbecue, Pão com gergelim</div>
                <button class="btn-comprar" data-nome="Sunset Burguer" data-preco="28.00">
                    Adicionar ao Carrinho
                </button>
            </div>
        </div>
        
        <div class="lanche-item">
            <div class="lanche-item--img">
                <img src="Assets/Encomendar e Retirar (Tradicional)/Hamburguer 1 1.png" alt="Hamburguer Praiano" />
            </div>
            <div class="lanche-item--info">
                <strong>
                    <div class="lanche-item--preco">R$ 27.00</div>
                    <div class="lanche-item--nome">Hamburguer Praiano</div>
                </strong>
                <div class="lanche-item--desc">Alface, cebola, hamburguer grelhado, pão com gergelim, picles, tomate</div>
                <button class="btn-comprar" data-nome="Hamburguer Praiano" data-preco="27.00">
                    Adicionar ao Carrinho
                </button>
            </div>
        </div>
        
        <!-- Adicione mais itens conforme necessário -->
    `;
    
    adicionarEventListeners();
}

function adicionarEventListeners() {
    const botoesComprar = document.querySelectorAll('.btn-comprar');
    
    botoesComprar.forEach(botao => {
        // Remove event listeners antigos para evitar duplicação
        botao.replaceWith(botao.cloneNode(true));
    });

    // Adiciona novos event listeners
    const novosBotoes = document.querySelectorAll('.btn-comprar');
    
    novosBotoes.forEach(botao => {
        botao.addEventListener('click', function() {
            const nome = this.getAttribute('data-nome');
            const preco = parseFloat(this.getAttribute('data-preco'));
            
            console.log('Adicionando:', nome, preco); // Para debug
            adicionarAoCarrinho(nome, preco);
        });
    });

    // Event listener para finalizar compra
    const btnFinalizar = document.getElementById('finalizarCompra');
    if (btnFinalizar) {
        btnFinalizar.addEventListener('click', finalizarCompra);
    }
}

function adicionarAoCarrinho(nome, preco) {
    let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];

    const existente = carrinho.find(item => item.nome === nome);
    if (existente) {
        existente.quantidade += 1;
    } else {
        carrinho.push({ 
            nome: nome, 
            preco: preco, 
            quantidade: 1 
        });
    }

    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    atualizarCarrinho();
    
    // Feedback visual
    alert(`${nome} adicionado ao carrinho!`);
}

function atualizarCarrinho() {
    const itensCarrinho = document.getElementById('itensCarrinho');
    const totalCarrinho = document.getElementById('totalCarrinho');
    
    if (!itensCarrinho || !totalCarrinho) return;
    
    const carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
    itensCarrinho.innerHTML = '';
    let total = 0;
    
    carrinho.forEach((item, index) => {
        const li = document.createElement('li');
        li.innerHTML = `
            <span>${item.nome} (x${item.quantidade}) - R$ ${(item.preco * item.quantidade).toFixed(2)}</span>
            <button onclick="removerDoCarrinho(${index})" class="btn-remover">Remover</button>
        `;
        itensCarrinho.appendChild(li);
        total += item.preco * item.quantidade;
    });
    
    totalCarrinho.textContent = total.toFixed(2);
}

function removerDoCarrinho(index) {
    let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
    const itemRemovido = carrinho[index];
    carrinho.splice(index, 1);
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    atualizarCarrinho();
    
    alert(`${itemRemovido.nome} removido do carrinho!`);
}

function finalizarCompra() {
    const carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
    if (carrinho.length === 0) {
        alert('Seu carrinho está vazio!');
        return;
    }
    
    alert('Compra finalizada com sucesso!');
    localStorage.removeItem('carrinho');
    atualizarCarrinho();
}