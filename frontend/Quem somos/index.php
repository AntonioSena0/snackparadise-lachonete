<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - SnackParadise</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../imgs/Logo.png" type="image/x-icon">
</head>
<body>
    <header>
        <div class="header-left">
            <button class="btn-menu-lateral" id="btnMenuLateral">☰</button>
            <div class="logo-container">
            <a href="../Cardápio/index.php" class="logo">
                    <img src="../imgs/Logo.png" class="logo" alt="Snack Paradise Logo">
                </a>           
             </div>
        </div>

        <div class="header-center">
            <a href="../Cardápio/index.php" class="menu-item">Menu</a>
            <div class="menu-item cardapio-btn" id="cardapioBtn">
                Cardápio
                <div class="submenu" id="submenu">
                    <a href="../Cardápio/menu.php#subheader2" class="submenu-item">Hambúrgueres</a>
                    <a href="../Cardápio/menu.php#acompanhamentos" class="submenu-item">Acompanhamentos</a>
                    <a href="../Cardápio/menu.php#bebidas" class="submenu-item">Bebidas</a>
                </div>
            </div>
            <a href="../Acumular Pontos/pontos.html" class="menu-item">Promoções</a>
            <a href="index.php" class="menu-item">Sobre Nós</a>
        </div>

        <a href="../PerfilUser/index.php" class="btn-conta">Conta</a>
    </header>

    <!-- Menu Lateral -->
    <nav class="menu-lateral" id="menuLateral">
        <a href="../Cardápio/index.php" class="menu-lateral-item">Início</a>
        <a href="../PerfilUser/index.php" class="menu-lateral-item">Perfil</a>
        <a href="../Acumular Pontos/pontos.html" class="menu-lateral-item active">Pontos</a>
        <a href="../SejaParceiro/index.php" class="menu-lateral-item">Seja Parceiro</a>
        <a href="../Feedback/index.php" class="menu-lateral-item">Avaliações</a>
        <a href="index.php" class="menu-lateral-item">Sobre nós</a>
        <a href="../Auxílio Preferencial/auxilio.php" class="menu-lateral-item">Auxílio Preferencial</a>
        <a href="../Duvidas/index.php" class="menu-lateral-item">Dúvidas</a>
    </nav>


    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <main>
        <div class="sobre-container">
            <div class="hero-section">
                <div class="hero-content">
                    <h1 class="titulo-principal">Conheça a SnackParadise</h1>
                    <p class="subtitulo">Sabor, qualidade e inovação desde 2024</p>
                </div>
                <div class="hero-logo">
                    <img src="../imgs/Logo.png" alt="SnackParadise Logo" class="logo-principal">
                </div>
            </div>

            <!-- Nossa História -->
            <section class="secao-historia">
                <div class="container-historia">
                    <div class="historia-conteudo">
                        <h2 class="titulo-secao">Nossa História</h2>
                        <div class="historia-texto">
                            <p>
                                Somos a <strong>Snack Paradise</strong> ou <strong>SP</strong>, um restaurante que busca primariamente o sabor, o fácil acesso e a memorabilidade em nossas receitas! 
                            </p>
                            <p>
                                Sendo oficialmente fundada em <strong>2024</strong>, nosso projeto originalmente nasceu de um trabalho do curso de Desenvolvimento de Sistemas, onde planejamos o conceito original e a estética de nosso restaurante.
                            </p>
                            <p>
                                Atualmente, trabalhamos apenas virtualmente, por conta de desafios financeiros e também por conta dos integrantes serem todos menores de idade.
                            </p>
                        </div>
                    </div>
                    <div class="historia-visual">
                        <div class="card-timeline">
                            <div class="timeline-item">
                                <div class="timeline-icon">🎓</div>
                                <div class="timeline-content">
                                    <h3>2024</h3>
                                    <p>Nascimento do projeto durante o curso de Desenvolvimento de Sistemas</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon">🚀</div>
                                <div class="timeline-content">
                                    <h3>Fundação</h3>
                                    <p>Criação oficial da SnackParadise com foco em inovação gastronômica</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon">💻</div>
                                <div class="timeline-content">
                                    <h3>Presente</h3>
                                    <p>Operação virtual com visão de expansão física</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Valores -->
            <section class="secao-valores">
                <h2 class="titulo-secao">Nossos Valores</h2>
                <div class="valores-grid">
                    <div class="card-valor">
                        <div class="valor-icon">🤝</div>
                        <h3>Integridade</h3>
                        <p>Transparência e honestidade com nossos consumidores em cada interação</p>
                    </div>

                    <div class="card-valor">
                        <div class="valor-icon">❤️</div>
                        <h3>Respeito</h3>
                        <p>Valorização de funcionários, clientes e todos os envolvidos em nossa jornada</p>
                    </div>

                    <div class="card-valor">
                        <div class="valor-icon">💡</div>
                        <h3>Inovação</h3>
                        <p>Constante busca por novas soluções e experiências gastronômicas únicas</p>
                    </div>

                    <div class="card-valor">
                        <div class="valor-icon">🌟</div>
                        <h3>Inclusividade</h3>
                        <p>Ambiente acolhedor e acessível para todos desfrutarem de nossos serviços</p>
                    </div>

                    <div class="card-valor">
                        <div class="valor-icon">🎯</div>
                        <h3>Qualidade</h3>
                        <p>Compromisso com a excelência em cada produto e serviço oferecido</p>
                    </div>

                    <div class="card-valor">
                        <div class="valor-icon">🌱</div>
                        <h3>Crescimento</h3>
                        <p>Evolução contínua com responsabilidade social e ambiental</p>
                    </div>
                </div>
            </section>

            <!-- Missão, Visão e Valores -->
            <section class="secao-mvv">
                <div class="mvv-grid">
                    <div class="card-mvv missao">
                        <div class="mvv-header">
                            <div class="mvv-icon">🎯</div>
                            <h3>Missão</h3>
                        </div>
                        <p>Proporcionar experiências gastronômicas memoráveis através de sabores únicos, serviço de qualidade e tecnologia inovadora, tornando momentos especiais ainda mais saborosos.</p>
                    </div>

                    <div class="card-mvv visao">
                        <div class="mvv-header">
                            <div class="mvv-icon">🔮</div>
                            <h3>Visão</h3>
                        </div>
                        <p>Ser reconhecida como a principal referência em fast food gourmet no Brasil, expandindo para estabelecimentos físicos e criando uma rede nacional de sabor e qualidade.</p>
                    </div>

                    <div class="card-mvv valores">
                        <div class="mvv-header">
                            <div class="mvv-icon">💎</div>
                            <h3>Compromisso</h3>
                        </div>
                        <p>Manter sempre o foco no cliente, investir em nossos colaboradores e contribuir positivamente para as comunidades onde atuamos, crescendo de forma sustentável e responsável.</p>
                    </div>
                </div>
            </section>

            <!-- Estatísticas -->
            <section class="secao-stats">
                <h2 class="titulo-secao">SnackParadise em Números</h2>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-numero" data-target="2024">2024</div>
                        <div class="stat-label">Ano de Fundação</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-numero" data-target="100">100</div>
                        <div class="stat-label">% Satisfação</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-numero" data-target="24">6</div>
                        <div class="stat-label">Horas de Atendimento</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-numero" data-target="5">5</div>
                        <div class="stat-label">Estrelas Avaliação</div>
                    </div>
                </div>
            </section>

            <!-- Call to Action -->
            <section class="secao-cta">
                <div class="cta-content">
                    <h2>Faça Parte da Nossa História</h2>
                    <p>Junte-se a nós nessa jornada de sabores e descubra por que a SnackParadise é mais que um restaurante - é uma experiência!</p>
                    <div class="cta-buttons">
                        <a href="../Cardápio/menu.php" class="btn-cta primario">Ver Cardápio</a>
                        <a href="../Cardápio/index.php" class="btn-cta secundario">Fazer Pedido</a>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <a href="../Menu/index.php">Início</a>
                <a href="index.php">Sobre</a>
                <br><br>
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