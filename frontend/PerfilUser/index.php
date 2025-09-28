<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../Tela de login/index.html");
    exit();
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário - Snack Paradise</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
                                <a href="../Menu/index.php" target="_self">Início</a>
                                <a href="../PerfilUser/index.php" target="_self">Perfil</a>
                                <a href="#" target="_self">Pontos</a>
                                <a href="#" target="_self">Seja Parceiro</a>
                                <a href="#" target="_self">Avaliações</a>
                                <a href="../Quem somos/index.php" target="_self">Sobre nós</a>
                                <a href="../Auxílio Preferencial/auxilio.php" target="_self">Auxílio Preferencial</a>
                            </div>
                        </li>
                        <li class="list-menu1">
                            <button id="btn-cardapio">&darr;Cardápio</button>
                            <div class="submenu" id="submenu">
                                <a href="../Cardápio/index.php" target="_self"><button>Hamburgueres</button></a>
                                <hr>
                                <a href="#" target="_self"><button>Acompanhamentos</button></a>
                                <hr>
                                <a href="#" target="_self"><button>Bebidas</button></a>
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
                    <a href="../Tela de login/index.php"><button id="btn-conta" class="conta">Sair</button></a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="main-container">
            <div class="profile-box">
                <div class="profile-header">
                    <div class="logo2">
                        <img src="../imgs/Logo.png" alt="SnackParadiseLogo">
                        <h4>SnackParadise</h4>
                    </div>
                    <h1 class="profile-title">Meu Perfil</h1>
                </div>

                <div class="profile-content">
                    <div class="profile-avatar">
                        <div class="avatar-circle">
                            <img src="<?php echo isset($user['profile_picture']) && file_exists($user['profile_picture']) ? $user['profile_picture'] : '../../backend/views/uploads/Default_pfp.png'; ?>" alt="Foto de Perfil" class="bx bx-user" width="150">
                        </div>
                        <button class="btn-change-photo">Alterar Foto</button>
                        <form method="POST" action="../../backend/views/upload2.php" enctype="multipart/form-data">
                            <input type="file" id="profilePicture" name="profilePicture" accept="image/png, image/jpeg" alt="Alterar Foto">
                            <button type="submit" class="btn-voltar">Salvar</button>
                        </form>
                        <i class='bx bx-camera'></i>
                        </button>
                    </div>

                    <div class="profile-forms">
                        <!-- Informações Pessoais -->
                        <div class="profile-section">
                            <h3 class="section-title">
                                <i class='bx bx-user-circle'></i>
                                Informações Pessoais
                            </h3>
                            
                            <form class="profile-form" id="personal-form">
                                <div class="form-row">
                                    <div class="input-wrap">
                                        <input type="text" class="input-field" id="nome" name="nome" value="<?php echo htmlspecialchars($user['username']); ?>" readonly />
                                        <label>Username</label>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="email" class="input-field" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly />
                                        <label>E-mail</label>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="button" class="btn-edit" id="edit-personal" onclick="toggleEdit('personal')">
                                        <i class='bx bx-edit'></i>
                                        Editar
                                    </button>
                                    <button type="submit" class="btn-save hidden" id="save-personal">
                                        <i class='bx bx-check'></i>
                                        Salvar
                                    </button>
                                    <button type="button" class="btn-cancel hidden" id="cancel-personal" onclick="cancelEdit('personal')">
                                        <i class='bx bx-x'></i>
                                        Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Endereço -->
                        <div class="profile-section">
                            <h3 class="section-title">
                                <i class='bx bx-map'></i>
                                Endereço de Entrega
                            </h3>
                            
                            <form class="profile-form" id="address-form">
                                <div class="form-row">
                                    <div class="input-wrap">
                                        <input type="text" class="input-field" id="cep" name="cep" value="01234-567" readonly />
                                        <label>CEP</label>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="text" class="input-field" id="endereco" name="endereco" value="Rua das Flores, 123" readonly />
                                        <label>Endereço</label>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="input-wrap">
                                        <input type="text" class="input-field" id="bairro" name="bairro" value="Centro" readonly />
                                        <label>Bairro</label>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="text" class="input-field" id="cidade" name="cidade" value="São Paulo" readonly />
                                        <label>Cidade</label>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="button" class="btn-edit" id="edit-address" onclick="toggleEdit('address')">
                                        <i class='bx bx-edit'></i>
                                        Editar
                                    </button>
                                    <button type="submit" class="btn-save hidden" id="save-address">
                                        <i class='bx bx-check'></i>
                                        Salvar
                                    </button>
                                    <button type="button" class="btn-cancel hidden" id="cancel-address" onclick="cancelEdit('address')">
                                        <i class='bx bx-x'></i>
                                        Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Alterar Senha -->
                        <div class="profile-section">
                            <h3 class="section-title">
                                <i class='bx bx-lock'></i>
                                Segurança
                            </h3>
                            
                            <form class="profile-form" id="password-form">
                                <div class="form-row">
                                    <div class="input-wrap">
                                        <input type="password" class="input-field" id="senha-atual" name="senha-atual" />
                                        <label>Senha Atual</label>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="input-wrap">
                                        <input type="password" class="input-field" id="nova-senha" name="nova-senha" />
                                        <label>Nova Senha</label>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="password" class="input-field" id="confirmar-senha" name="confirmar-senha" />
                                        <label>Confirmar Nova Senha</label>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn-change-password">
                                        <i class='bx bx-key'></i>
                                        Alterar Senha
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Histórico de Pedidos -->
                        <div class="profile-section">
                            <h3 class="section-title">
                                <i class='bx bx-history'></i>
                                Meus Pedidos
                            </h3>
                            
                            <div class="orders-container" id="orders-container">
                                <div class="order-item">
                                    <div class="order-header">
                                        <span class="order-number">#001</span>
                                        <span class="order-date">15/12/2024</span>
                                        <span class="order-status status-entregue">Entregue</span>
                                    </div>
                                    <div class="order-items">
                                        <p>X-Burger Tradicional x1, Batata Frita x1</p>
                                    </div>
                                    <div class="order-total">
                                        <strong>Total: R$ 25,90</strong>
                                    </div>
                                </div>

                                <div class="order-item">
                                    <div class="order-header">
                                        <span class="order-number">#002</span>
                                        <span class="order-date">10/12/2024</span>
                                        <span class="order-status status-preparando">Em preparo</span>
                                    </div>
                                    <div class="order-items">
                                        <p>X-Salada x2, Coca-Cola x2</p>
                                    </div>
                                    <div class="order-total">
                                        <strong>Total: R$ 42,80</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <a href="../Menu/index.php">Início</a>
                <a href="../Quem somos/index.php">Sobre</a>
                <a href="../Auxílio Preferencial/auxilio.php">Serviços</a>
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

    <script src="script.js"></script>
</body>
</html>