<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Hambúrgueres - Snack Paradise</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header id="header">
        <div class="container">
            <div class="flex">
                <nav>
                    <ul>
                        <li class="list-menu2">
                            <button class="btn-ativação" id="btn-ativação">☰</button>
                            <div class="barralateral" id="barralateral">
                                <a href="../Menu/index.html" target="_self">Início</a>
                                <a href="#" target="_self">Perfil</a>
                                <a href="#" target="_self">Pontos</a>
                                <a href="#" target="_self">Seja Parceiro</a>
                                <a href="#" target="_self">Avaliações</a>
                                <a href="../Quem somos/index.html" target="_self">Sobre nós</a>
                                <a href="../Auxílio Preferencial/auxilio.html" target="_self">Auxílio Preferencial</a>
                            </div>
                        </li>
                        <li class="list-menu1">
                            <button id="btn-cardapio">&darr;Cardápio</button>
                            <div class="submenu" id="submenu">
                                <a href="../Cardápio/hamburgueres.html" target="_self"><button>Hamburgueres</button></a>
                                <hr>
                                <a href="../Cardápio/acompanhamentos.html" target="_self"><button>Acompanhamentos</button></a>
                                <hr>
                                <a href="../Cardápio/bebidas.html" target="_self"><button>Bebidas</button></a>
                            </div>
                        </li>
                        <li class="list-menu1">
                            <a href="#" target="_self">Promoções</a>
                        </li>
                        <li class="list-menu1">
                            <a href="#" target="_self">Pedidos</a>
                        </li>
                        <li class="list-menu1">
                            <a href="#" target="_self">App SP</a>
                        </li>
                    </ul>
                </nav>
                <div class="btn-conta">
                    <a href="<?php echo $logged ? '../../backend/views/Conta.php' : '../Tela de Login/index.html'; ?>">
                        <button id="btn-conta" class="conta">Conta</button>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <nav class="menu-cardapio">
        <a href="hamburgueres.html">Hambúrgueres</a>
        <a href="acompanhamentos.html">Acompanhamentos</a>
        <a href="bebidas.html">Bebidas</a>
    </nav>

    <!-- Carrinho -->
    <div id="carrinho" class="carrinho">
        <h2>Seu Carrinho</h2>
        <ul id="itensCarrinho"></ul>
        <p>Total: R$ <span id="totalCarrinho">0.00</span></p>
        <button id="finalizarCompra" class="btn">Finalizar Compra</button>
    </div>

    <main>
        <div class="itens">
            <h2>Hambúrgueres</h2>
            
            <!-- Template que será clonado para cada item do JSON -->
            <div class="modelos" style="display: none;">
                <div class="lanche-item">
                    <div class="lanche-item--img"><img src="" /></div>
                    <div class="lanche-item-info">
                        <strong>
                            <div class="lanche-item--preco"></div>
                            <div class="lanche-item--nome"></div>
                        </strong>
                        <div class="lanche-item--desc"></div>
                        <button class="btn-comprar">Adicionar ao Carrinho</button>
                    </div>
                </div>
            </div>

            <!-- Área onde os hambúrgueres do JSON serão inseridos -->
            <div class="area-hamburgueres"></div>
        </div>
    </main>
<script>
    // carrega os hambúrgueres do json
    function carregarHamburgueres() {
        fetch('main.json')
            .then(response => response.json())
            .then(data => {
                const areaHamburgueres = document.querySelector('.area-hamburgueres');
                const modelo = document.querySelector('.modelos .lanche-item');

                if (!areaHamburgueres || !modelo) {
                    console.error("elementos .area-hamburgueres ou .modelos .lanche-item não encontrados");
                    return;
                }

                // limpa antes de renderizar de novo
                areaHamburgueres.innerHTML = "";

                // pega só categoria hamburguer (id 1)
                const hamburgueres = data.lanches.filter(lanche => lanche.categoria === 1);

                hamburgueres.forEach(hamburguer => {
                    const novoItem = modelo.cloneNode(true);
                    novoItem.style.display = "block"; // garante q não fique invisível

                    // preenche os dados
                    novoItem.querySelector('.lanche-item--img img').src = hamburguer.imagem;
                    novoItem.querySelector('.lanche-item--img img').alt = hamburguer.nome;
                    novoItem.querySelector('.lanche-item--preco').textContent = `R$ ${hamburguer.preco.toFixed(2)}`;
                    novoItem.querySelector('.lanche-item--nome').textContent = hamburguer.nome;
                    novoItem.querySelector('.lanche-item--desc').textContent = hamburguer.descricao;

                    // botão comprar
                    const btnComprar = novoItem.querySelector('.btn-comprar');
                    btnComprar.onclick = () => {
                        adicionarAoCarrinho(hamburguer.nome, hamburguer.preco);
                    };

                    areaHamburgueres.appendChild(novoItem);
                });
            })
            .catch(error => console.error('Erro ao carregar hambúrgueres:', error));
    }

    // carrinho
    let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];

    function adicionarAoCarrinho(nome, preco) {
        const existente = carrinho.find(item => item.nome === nome);
        if (existente) {
            existente.quantidade += 1;
        } else {
            carrinho.push({ nome, preco, quantidade: 1 });
        }
        localStorage.setItem('carrinho', JSON.stringify(carrinho));
        atualizarCarrinho();
        alert(`${nome} adicionado ao carrinho!`);
    }

    function atualizarCarrinho() {
        const itensCarrinho = document.getElementById('itensCarrinho');
        const totalCarrinho = document.getElementById('totalCarrinho');

        if (!itensCarrinho || !totalCarrinho) return;

        itensCarrinho.innerHTML = '';
        let total = 0;

        carrinho.forEach((item, index) => {
            total += item.preco * item.quantidade;
            const li = document.createElement('li');
            li.textContent = `${item.nome} (x${item.quantidade}) - R$ ${(item.preco * item.quantidade).toFixed(2)}`;

            // botão remover
            const btnRemover = document.createElement('button');
            btnRemover.textContent = 'Remover';
            btnRemover.onclick = () => removerDoCarrinho(index);

            li.appendChild(btnRemover);
            itensCarrinho.appendChild(li);
        });

        totalCarrinho.textContent = total.toFixed(2);
    }

    function removerDoCarrinho(index) {
        carrinho.splice(index, 1);
        localStorage.setItem('carrinho', JSON.stringify(carrinho));
        atualizarCarrinho();
    }

    // inicialização
    document.addEventListener('DOMContentLoaded', () => {
        carregarHamburgueres();
        atualizarCarrinho();

        const btnFinalizar = document.getElementById('finalizarCompra');
        if (btnFinalizar) {
            btnFinalizar.onclick = () => {
                if (carrinho.length === 0) {
                    alert('Carrinho vazio!');
                    return;
                }
                alert('Compra finalizada! Total: R$ ' + document.getElementById('totalCarrinho').textContent);
                carrinho = [];
                localStorage.setItem('carrinho', JSON.stringify(carrinho));
                atualizarCarrinho();
            };
        }
    });
</script>
    <script src="carrinho.js"></script>
    <script src="menu.js"></script>
</body>
</html>