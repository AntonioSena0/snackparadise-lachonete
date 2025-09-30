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
    <header>
        <div class="header-left">
            <button class="btn-menu-lateral" id="btnMenuLateral">☰</button>
            <div class="logo-container">
            <a href="index.php" class="logo">
                    <img src="../imgs/Logo.png" class="logo" alt="Snack Paradise Logo">
                </a>           
             </div>
        </div>

        <div class="header-center">
            <a href="index.php" class="menu-item">Menu</a>
            <div class="menu-item cardapio-btn" id="cardapioBtn">
                Cardápio
                <div class="submenu" id="submenu">
                    <a href="#subheader2" class="submenu-item">Hambúrgueres</a>
                    <a href="#acompanhamentos" class="submenu-item">Acompanhamentos</a>
                    <a href="#bebidas" class="submenu-item">Bebidas</a>
                </div>
            </div>
            <a href="#" class="menu-item">Promoções</a>
            <a href="../Quem somos/index.html" class="menu-item">Sobre Nós</a>
        </div>

        <a href="../PerfilUser/index.php" class="btn-conta">Conta</a>
    </header>

    <!-- Menu Lateral -->
    <nav class="menu-lateral" id="menuLateral">
        <a href="index.php" class="menu-lateral-item">Início</a>
        <a href="../PerfilUser/index.php" class="menu-lateral-item">Perfil</a>
        <a href="../Acumular Pontos/pontos.html" class="menu-lateral-item active">Pontos</a>
        <a href="../SejaParceiro/index.php" class="menu-lateral-item">Seja Parceiro</a>
        <a href="../Feedback/index.php" class="menu-lateral-item">Avaliações</a>
        <a href="../Quem somos/index.php" class="menu-lateral-item">Sobre nós</a>
        <a href="../Auxílio Preferencial/auxilio.php" class="menu-lateral-item">Auxílio Preferencial</a>
    </nav>

    <!-- Carrinho -->
    <div id="carrinho" class="carrinho">
        <h2>Seu Carrinho</h2>
        <ul id="itensCarrinho"></ul>
        <p>Total: R$ <span id="totalCarrinho">0.00</span></p>
        <!--<button id="finalizarCompra" class="btn">Finalizar Compra</button> -->
        <a href="../checkout/index.php" id="finalizarCompra" class="btn">Finalizar Compra</a>

    </div>

    <main class="main">
        <div class="modelos">
        </div>
        <div class="modelos">
    <div class="lanche-item">
        <div class="lanche-item--img"><img src=""/></div>
        <div class="lanche-item--info">
            <strong>
                <div class="lanche-item--preco"></div>
                <div class="lanche-item--nome"></div>
            </strong>
            <div class="lanche-item--desc"></div>
            <button class="btn-comprar">Adicionar ao Carrinho</button>
        </div>
    </div>
</div>
        <div class="itens">
            <h2 class="subheaderh2" id="subheaderh2">Lanches</h2>
            <div class="area-lanches"></div>
            <h2 id="acompanhamentos">Acompanhamentos</h2>
            <div class="area-acompanhamentos"></div>
            <h2 id="bebidas">Bebidas</h2>
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