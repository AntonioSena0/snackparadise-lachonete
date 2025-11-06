<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seja Parceiro</title>
    <link rel="stylesheet" href="style.css">
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
            <a href="../Quem Somos/index.php" class="menu-item">Sobre Nós</a>
        </div>

        <a href="../PerfilUser/index.php" class="btn-conta">Conta</a>
    </header>

    <!-- Menu Lateral -->
    <nav class="menu-lateral" id="menuLateral">
        <a href="../Cardápio/index.php" class="menu-lateral-item">Início</a>
        <a href="../PerfilUser/index.php" class="menu-lateral-item">Perfil</a>
        <a href="../Acumular Pontos/pontos.html" class="menu-lateral-item active">Pontos</a>
        <a href="index.php" class="menu-lateral-item">Seja Parceiro</a>
    <a href="../Feedback/index.php" class="menu-lateral-item">Avaliações</a>
    <a href="../Quem Somos/index.php" class="menu-lateral-item">Sobre nós</a>
    <a href="../Duvidas/index.php" class="menu-lateral-item">Dúvidas</a>
    <a href="../Auxílio Preferencial/auxilio.php" class="menu-lateral-item">Auxílio Preferencial</a>
    </nav>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Main Content -->
    <main class="main-container">
        <div class="content-wrapper">
            <!-- Left Side - Decorative Elements -->
            <div class="left-decoration">
                <div class="floating-shape shape-1"></div>
                <div class="floating-shape shape-2"></div>
            </div>

            <!-- Center Content -->
            <div class="form-container">
                <div class="header-section">
                    <h2 class="subtitle">Torne-se um parceiro</h2>
                    <h1 class="main-title">Leve a inclusão a outro nível</h1>
                    <p class="description">
                        Na SnackParadise, acreditamos que inclusão e sabor andam de mãos dadas.
                        Ao se tornar nosso parceiro, você não apenas terá acesso a uma infinidade de benefícios,    
                        mas também agregará ainda mais valor aos seus clientes, oferecendo experiências únicas e acolhedoras.

                    </p>
                </div>

                <form class="partner-form" id="partnerForm">
                    <div class="form-section">
                        <h3>Contato</h3>
                        
                        <div class="form-group">
                            <input type="email" id="email" name="email" placeholder="Email da empresa" required>
                        </div>

                        <div class="form-group">
                            <input type="text" id="nomeEmpresa" name="nomeEmpresa" placeholder="Nome da empresa" required>
                        </div>

                        <div class="form-group">
                            <input type="text" id="nomeResponsavel" name="nomeResponsavel" placeholder="Nome completo do responsável" required>
                        </div>

                        <div class="form-group">
                            <div class="phone-input">
                                <div class="country-code">
                                    <img src="https://img.icons8.com/?size=100&id=9659&format=png&color=000000" alt="BR">
                                </div>
                                <input type="tel" id="telefone" name="telefone" placeholder="Telefone para contato" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Sobre a empresa</h3>
                        
                        <div class="form-group">
                            <input type="url" id="socialLink" name="socialLink" placeholder="Link do Instagram ou LinkedIn" required>
                        </div>

                        <div class="form-group">
                            <input type="url" id="website" name="website" placeholder="Site (opcional)">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <select id="pais" name="pais" required>
                                    <option value="">País</option>
                                    <option value="BR">Brasil</option>
                                    <option value="US">Estados Unidos</option>
                                    <option value="AR">Argentina</option>
                                    <option value="PT">Portugal</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="text" id="cidade" name="cidade" placeholder="Cidade" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">Torne-se um parceiro</button>
                </form>
            </div>

            <!-- Right Side - Decorative Elements -->
            <div class="right-decoration">
                <div class="floating-shape shape-3"></div>
                <div class="chat-bubble"></div>
            </div>
        </div>
    </main>

    <script src="script.js"></script>

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
</body>
</html>