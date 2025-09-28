<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snack Paradise</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="shortcut icon" href="../imgs/Logo.png" type="image/x-icon">
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
                            <button id="btn-cardapio">Cardápio</button>
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
                    <a href="../Tela de login/index.html"><button id="btn-conta" class="conta">Conta</button></a>
                </div>
            </div>
        </div>
    </header>

    <!-- Carrinho -->
    <div id="carrinho" class="carrinho">
        <h2>Seu Carrinho</h2>
        <ul id="itensCarrinho"></ul>
        <p>Total: R$ <span id="totalCarrinho">0.00</span></p>
        <button id="finalizarCompra" class="btn">Finalizar Compra</button>
    </div>

    <main class="main">
        <div class="modelos">
        </div>
        <div class="modelos">
    <div class="lanche-item" onclick="adicionarAoCarrinho('Hambúrguer Clássico', 10.00)">
        <div class="lanche-item--img"><img src="../imgs/hamburguer.jpg" alt="Hambúrguer Clássico" /></div>
        <div class="lanche-item--info">
            <strong>
                <div class="lanche-item--preco">R$ 10,00</div>
                <div class="lanche-item--nome">Hambúrguer Clássico</div>
            </strong>
            <div class="lanche-item--desc">Delicioso hambúrguer com carne 100% bovina.</div>
            <button class="btn-comprar" onclick="adicionarAoCarrinho('Hambúrguer Clássico', 10.00)">Adicionar ao Carrinho</button>
        </div>
    </div>
</div>
        <div class="itens">
            <h2 class="subheaderh2" id="subheaderh2">Lanches</h2>
            <div class="area-lanches"></div>
            <h2>Acompanhamentos</h2>
            <div class="area-acompanhamentos"></div>
            <h2>Bebidas</h2>
            <div class="area-bebidas"></div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <a href="../Menu/index.html">Início</a>
                <a href="../Quem somos/index.html">Sobre</a>
                <a href="../Auxílio Preferencial/auxilio.html">Serviços</a>
                <a href="https://www.instagram.com/_snackparadise_/profilecard/?igsh=OHh2eWpsOXBuOWRp">Contato</a>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 SnackParadise. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper>
      <div class="vw-plugin-top-wrapper"></div>
    </div>
  </div>
  <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
  <script>
    new window.VLibras.Widget('https://vlibras.gov.br/app');
  </script>
    <script src="menu.js"></script>
    <script src="main.json"></script>
</body>
</html>