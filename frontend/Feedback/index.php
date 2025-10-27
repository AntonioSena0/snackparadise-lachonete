<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliações - SnackParadise</title>
    <link rel="stylesheet" href="style.css">
     <link rel="stylesheet" href="../style.css">
    <link rel="shortcut icon" href="../imgs/Logo.png" type="image/x-icon">
</head>
<body>
       <header>
        <div class="header-left">
            <button class="btn-menu-lateral" id="btnMenuLateral">☰</button>
            <div class="logo-container">
            <a href="../Menu/index.php" class="logo">
                    <img src="../imgs/Logo.png" class="logo" alt="Snack Paradise Logo">
                </a>           
             </div>
        </div>

        <div class="header-center">
            <a href="../Menu/index.php" class="menu-item">Menu</a>
            <div class="menu-item cardapio-btn" id="cardapioBtn">
                Cardápio
                <div class="submenu" id="submenu">
                    <a href="../Cardápio/index.php" class="submenu-item">Hambúrgueres</a>
                    <a href="../Cardápio/index.php#acompanhamentos" class="submenu-item">Acompanhamentos</a>
                    <a href="../Cardápio/index.php#bebidas" class="submenu-item">Bebidas</a>
                </div>
            </div>
            <a href="pontos.php" class="menu-item">Promoções</a>
            <a href="../Quem somos/index.php" class="menu-item">Sobre Nós</a>
        </div>

        <a href="../Tela de login/index.php" class="btn-conta">Conta</a>
    </header>

    <!-- Menu Lateral -->
    <nav class="menu-lateral" id="menuLateral">
        <a href="../Menu/index.php" class="menu-lateral-item">Início</a>
        <a href="../PerfilUser/index.php" class="menu-lateral-item">Perfil</a>
        <a href="../Acumular Pontos/pontos.php" class="menu-lateral-item active">Pontos</a>
        <a href="../SejaParceiro/index.php" class="menu-lateral-item">Seja Parceiro</a>
        <a href="../Feedback/index.php" class="menu-lateral-item">Avaliações</a>
        <a href="../Quem somos/index.php" class="menu-lateral-item">Sobre nós</a>
        <a href="../Auxílio Preferencial/auxilio.php" class="menu-lateral-item">Auxílio Preferencial</a>
    </nav>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <main>
        <!-- Header Principal -->
        <section class="feedback-header">
            <h1 class="titulo-principal">Sua Opinião é Nosso Sabor Especial!</h1>
            <p class="subtitulo">Ajude-nos a melhorar e compartilhe sua experiência SnackParadise</p>
        </section>

        <!-- Estatísticas de Avaliações -->
        <section class="estatisticas-section">
            <div class="estatisticas-container">
                <div class="card-estatistica">
                    <div class="icone-estatistica">⭐</div>
                    <div class="numero-estatistica" id="mediaAvaliacoes">4.8</div>
                    <div class="label-estatistica">Média Geral</div>
                </div>
                <div class="card-estatistica">
                    <div class="icone-estatistica">💬</div>
                    <div class="numero-estatistica" id="totalAvaliacoes">1,247</div>
                    <div class="label-estatistica">Avaliações</div>
                </div>
                <div class="card-estatistica">
                    <div class="icone-estatistica">😊</div>
                    <div class="numero-estatistica" id="satisfacao">96%</div>
                    <div class="label-estatistica">Satisfação</div>
                </div>
            </div>
        </section>

        <!-- Formulário de Avaliação -->
        <section class="formulario-section">
            <div class="formulario-container">
                <h2 class="titulo-secao">Deixe Sua Avaliação</h2>
                
                <form class="feedback-form" id="feedbackForm">
                    <!-- Avaliação por Estrelas -->
                    <div class="campo-avaliacao">
                        <label class="campo-label">Como foi sua experiência?</label>
                        <div class="estrelas-container" id="estrelasContainer">
                            <span class="estrela" data-rating="1">⭐</span>
                            <span class="estrela" data-rating="2">⭐</span>
                            <span class="estrela" data-rating="3">⭐</span>
                            <span class="estrela" data-rating="4">⭐</span>
                            <span class="estrela" data-rating="5">⭐</span>
                        </div>
                        <div class="rating-text" id="ratingText">Selecione uma avaliação</div>
                        <input type="hidden" id="rating" name="rating" required>
                    </div>

                    <!-- Categoria de Avaliação -->
                    <div class="campo-categoria">
                        <label class="campo-label">Sobre o que você quer falar?</label>
                        <div class="categorias-grid">
                            <button type="button" class="categoria-btn" data-categoria="comida">
                                🍔 Qualidade da Comida
                            </button>
                            <button type="button" class="categoria-btn" data-categoria="atendimento">
                                👥 Atendimento
                            </button>
                            <button type="button" class="categoria-btn" data-categoria="entrega">
                                🚚 Entrega/Tempo
                            </button>
                            <button type="button" class="categoria-btn" data-categoria="preco">
                                💰 Preço/Custo-Benefício
                            </button>
                            <button type="button" class="categoria-btn" data-categoria="site">
                                💻 Site/App
                            </button>
                            <button type="button" class="categoria-btn" data-categoria="geral">
                                ⭐ Experiência Geral
                            </button>
                        </div>
                        <input type="hidden" id="categoria" name="categoria" required>
                    </div>

                    <!-- Dados Pessoais -->
                    <div class="dados-pessoais">
                        <div class="campo-grupo">
                            <div class="input-wrap">
                                <input type="text" class="input-field" id="nome" name="nome" required>
                                <label>Seu Nome</label>
                            </div>
                            <div class="input-wrap">
                                <input type="email" class="input-field" id="email" name="email" required>
                                <label>Seu E-mail</label>
                            </div>
                        </div>
                    </div>

                    <!-- Comentário -->
                    <div class="campo-comentario">
                        <div class="input-wrap textarea-wrap">
                            <textarea class="input-field textarea-field" id="comentario" name="comentario" rows="5" required></textarea>
                            <label>Conte-nos mais sobre sua experiência...</label>
                        </div>
                        <div class="contador-caracteres">
                            <span id="contadorAtual">0</span>/<span id="contadorMax">500</span> caracteres
                        </div>
                    </div>

                    <!-- Recomendação -->
                    <div class="campo-recomendacao">
                        <label class="campo-label">Você recomendaria o SnackParadise?</label>
                        <div class="recomendacao-opcoes">
                            <label class="radio-option">
                                <input type="radio" name="recomendacao" value="sim">
                                <span class="radio-custom"></span>
                                👍 Sim, com certeza!
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="recomendacao" value="talvez">
                                <span class="radio-custom"></span>
                                🤔 Talvez
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="recomendacao" value="nao">
                                <span class="radio-custom"></span>
                                👎 Não recomendaria
                            </label>
                        </div>
                    </div>

                    <!-- Botão de Envio -->
                    <button type="submit" class="btn-enviar" id="btnEnviar">
                        <span class="btn-texto">Enviar Avaliação</span>
                        <span class="btn-loading hidden">Enviando...</span>
                    </button>
                </form>
            </div>
        </section>

        <!-- Avaliações Recentes -->
        <section class="avaliacoes-recentes">
            <h2 class="titulo-secao">O que nossos clientes estão dizendo</h2>
            <div class="avaliacoes-grid" id="avaliacoesGrid">
                <!-- Avaliações serão carregadas via JavaScript -->
            </div>
            <button class="btn-ver-mais" id="btnVerMais">Ver Mais Avaliações</button>
        </section>
    </main>

    <!-- Footer -->
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

    <!-- VLibras -->
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
</body>
</html>