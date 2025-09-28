<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>
<body>
    <header>
        <div class="header-left">
            <button class="btn-menu-lateral" id="btnMenuLateral">☰</button>
            <div class="logo-container">
            <a href="../Menu/index.html" class="logo">
                    <img src="../imgs/Logo.png" class="logo" alt="Snack Paradise Logo">
                </a>           
             </div>
        </div>

        <div class="header-center">
            <a href="../Menu/index.html" class="menu-item">Menu</a>
            <div class="menu-item cardapio-btn" id="cardapioBtn">
                Cardápio
                <div class="submenu" id="submenu">
                    <a href="../Cardápio/index.html" class="submenu-item">Hambúrgueres</a>
                    <a href="#" class="submenu-item">Acompanhamentos</a>
                    <a href="#" class="submenu-item">Bebidas</a>
                </div>
            </div>
            <a href="#" class="menu-item">Promoções</a>
            <a href="../Quem somos/index.html" class="menu-item">Sobre Nós</a>
        </div>

        <a href="../Tela de login/index.html" class="btn-conta">Conta</a>
    </header>

    <!-- Menu Lateral -->
    <nav class="menu-lateral" id="menuLateral">
        <a href="../Menu/index.html" class="menu-lateral-item">Início</a>
        <a href="../PerfilUser/index.html" class="menu-lateral-item">Perfil</a>
        <a href="../Acumular Pontos/pontos.html" class="menu-lateral-item active">Pontos</a>
        <a href="../SejaParceiro/index.html" class="menu-lateral-item">Seja Parceiro</a>
        <a href="../Feedback/index.html" class="menu-lateral-item">Avaliações</a>
        <a href="../Quem somos/index.html" class="menu-lateral-item">Sobre nós</a>
        <a href="../Auxílio Preferencial/auxilio.html" class="menu-lateral-item">Auxílio Preferencial</a>
    </nav>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <?php if (isset($_SESSION['user'])): ?>
    <h1>Olá, <?php echo htmlspecialchars($user['username'] ?? $user['name']); ?></h1>
        <?php else: ?>
        <h1>Você não está logado</h1>
    <?php endif; ?>
    <main class="main">
        <div class="janelas">
            <div class="itens-2">
                <h1>Itens Selecionados</h1>
                <ul id="itensCheckout"></ul>
                <p>Total: R$ <span id="totalCheckout">0.00</span></p>
            </div>
            <div class="pagamento">
                <h1>Pagamento</h1>
                <form id="payment-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" name="nome" required>
                        </div>

                        <div class="form-group">
                            <label for="rua">Endereço</label>
                            <input type="text" id="rua" name="rua" required>
                        </div>

                        <div class="form-group">
                            <label for="numero">Número</label>
                            <input type="text" id="numero" name="numero" required>
                        </div>

                        <div class="form-group">
                            <label for="complemento">Complemento</label>
                            <input type="text" id="complemento" name="complemento">
                        </div>

                        <div class="form-group">
                            <label for="preferencial">Atendimento Preferencial</label>
                            <select id="preferencial" name="preferencial">
                                <option value="Sim">Sim</option>
                                <option value="Não">Não</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="forma">Forma de Pagamento</label>
                            <select id="forma" name="forma" class="forma">
                                <option value="debito">Débito</option>
                                <option value="credito">Crédito</option>
                                <option value="cedula">Cédula</option>
                                <option value="pix">Pix</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn" name="btnsubm">Confirmar Pedido</button>
                </form>
            </div>
        </div>
    </main>
    <div class="modal" id="modal-loading">
        <div class="card">
            <div class="loading">
                <div class="spinner"></div>
                <p>Carregando...</p>
            </div>
            <div class="confirmation" style="display: none;">
                <i class="bi bi-check-circle" style="font-size: 40px; color: green;"></i>
                <p>Pedido confirmado!</p>
                <div class="close-btn">Fechar</div>
            </div>
        </div>
    </div>
    <div class="modal" id="modal-qrcode">
        <div class="card">
            <div id="qrcode" class="qrcode"></div>
            <button class="confirm-pix">Confirmar pagamento por Pix</button>
            <div class="close-btn">Fechar</div>
        </div>
    </div>    

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
    
    <script src="menu.js"></script>
</body>
</html>