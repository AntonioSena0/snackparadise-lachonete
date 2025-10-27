<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../frontend/Tela de login/index.php");
    exit();
}

include_once '../../backend/config/DatabaseManager.php';

$db = new DatabaseManager();
$user = $_SESSION['user'];

// Buscar dados atualizados do usuário
$userData = $db->getUserById($user['id']);
if ($userData) {
    $user = array_merge($user, $userData);
    $_SESSION['user'] = $user;
}

// Buscar pedidos do usuário
$orders = $db->getUserOrders($user['id']);

// Buscar histórico de entregas
$deliveries = $db->getDeliveryHistory($user['id']);

// Buscar avaliações
$reviews = $db->getUserReviews($user['id']);

// Verificar se há mensagens de sucesso/erro
$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';


// Buscar todos os pedidos para exibição
$allPedidos = $db->getAllPedidos();

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
            <a href="../Quem somos/index.php" class="menu-item">Sobre Nós</a>
        </div>

        <a href="../Tela de Login/index.php" class="btn-conta">Sair</a>
    </header>

    <!-- Menu Lateral -->
    <nav class="menu-lateral" id="menuLateral">
        <a href="../Cardápio/index.php" class="menu-lateral-item">Início</a>
        <a href="../PerfilUser/index.php" class="menu-lateral-item">Perfil</a>
        <a href="../Acumular Pontos/pontos.html" class="menu-lateral-item active">Pontos</a>
        <a href="../SejaParceiro/index.php" class="menu-lateral-item">Seja Parceiro</a>
        <a href="../Feedback/index.php" class="menu-lateral-item">Avaliações</a>
        <a href="../Quem somos/index.php" class="menu-lateral-item">Sobre nós</a>
        <a href="../Auxílio Preferencial/auxilio.php" class="menu-lateral-item">Auxílio Preferencial</a>
    </nav>

    <main>
        <div class="main-container">
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
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
                            <?php if (!empty($user['profile_picture'])): ?>
                                <img src="../../backend/uploads/profiles/<?php echo htmlspecialchars($user['profile_picture']); ?>?t=<?php echo time(); ?>" 
                                    alt="Foto de perfil" 
                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            <?php else: ?>
                                <i class='bx bxs-user'></i>
                            <?php endif; ?>
                        </div>
                        <button class="btn-change-photo" onclick="document.getElementById('profilePicture').click();">
                            <i class='bx bx-camera'></i>
                            Alterar Foto
                        </button>
                        <input type="file" id="profilePicture" name="profilePicture" accept="image/png, image/jpeg" style="display: none;" onchange="uploadProfilePicture(event)">
                    </div>


                    <div class="profile-forms">
                        <!-- Informações Pessoais -->
                        <div class="profile-section">
                            <h3 class="section-title">
                                <i class='bx bx-user-circle'></i>
                                Informações Pessoais
                            </h3>
                            
                            <form class="profile-form" id="personal-form" method="POST" action="../../backend/controllers/ProfileController.php">
                                <input type="hidden" name="action" value="update_personal_info">
                                <div class="form-row">
                                    <div class="input-wrap">
                                        <input type="text" class="input-field" id="username" name="username" 
                                            value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" readonly />
                                        <label>Username</label>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="email" class="input-field" id="email" name="email" 
                                            value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" readonly />
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
                            
                            <form class="profile-form" id="address-form" method="POST" action="../../backend/controllers/ProfileController.php">
                                <input type="hidden" name="action" value="update_address">
                                <div class="form-row">
                                    <div class="input-wrap">
                                        <input type="text" class="input-field" id="cep" name="cep" 
                                            value="<?php echo htmlspecialchars($user['cep'] ?? ''); ?>" readonly />
                                        <label>CEP</label>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="text" class="input-field" id="endereco" name="endereco" 
                                            value="<?php echo htmlspecialchars($user['endereco'] ?? ''); ?>" readonly />
                                        <label>Endereço</label>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="input-wrap">
                                        <input type="text" class="input-field" id="bairro" name="bairro" value="<?php echo htmlspecialchars($user['bairro'] ?? ''); ?>" readonly />
                                        <label>Bairro</label>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="text" class="input-field" id="cidade" name="cidade" value="<?php echo htmlspecialchars($user['cidade'] ?? ''); ?>"" readonly />
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
                            
                            <form class="profile-form" id="password-form" method="POST" action="../../backend/controllers/ProfileController.php">
                            <input type="hidden" name="action" value="change_password">
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
                                <?php if (empty($orders)): ?>
                                    <p>Nenhum pedido registrado.</p>
                                <?php else: ?>
                                    <?php foreach ($orders as $order): ?>
                                        <div class="order-card">
                                            <h3>Pedido #<?php echo htmlspecialchars($order['id']); ?></h3>
                                            <p><strong>Cliente:</strong> <?php echo htmlspecialchars($order['cliente_nome'] ?? '—'); ?></p>
                                            <div><strong>Itens:</strong>
                                                <ul style="margin: 6px 0 0 0; padding-left: 18px;">
                                                    <?php foreach ($order['itens_array'] as $item): ?>
                                                        <?php if (is_array($item)): ?>
                                                            <li>
                                                                <?php echo htmlspecialchars(($item['quantidade'] ?? 1) . 'x ' . ($item['nome'] ?? $item['produto'] ?? 'Item') . (isset($item['preco']) ? ' - R$ ' . number_format($item['preco'], 2, ',', '.') : '')); ?>
                                                            </li>
                                                        <?php else: ?>
                                                            <li><?php echo htmlspecialchars($item); ?></li>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <p><strong>Total:</strong> R$ <?php echo isset($order['total']) ? number_format($order['total'], 2, ',', '.') : '—'; ?></p>
                                            <p><strong>Endereço:</strong> <?php echo htmlspecialchars($order['endereco']); ?></p>
                                            <p><strong>Pagamento:</strong> <?php echo htmlspecialchars($order['pagamento']); ?></p>
                                            <p><strong>Status:</strong> <span class="order-status status-<?php echo htmlspecialchars($order['status']); ?>"><?php echo htmlspecialchars($order['status']); ?></span></p>
                                            <p><strong>Data:</strong> <?php echo htmlspecialchars($order['criado_em']); ?></p>

                                            <?php if (!in_array($order['status'], ['cancelado', 'entregue', 'em_entrega'])): ?>
                                                <div style="display:flex; gap:8px; align-items:center;">
                                                    <a href="editar_pedido.php?id=<?php echo htmlspecialchars($order['id']); ?>" class="btn-edit-order">Editar Pedido</a>
                                                    <form method="POST" action="../../backend/controllers/cancelar_pedido_form.php" onsubmit="return confirm('Deseja realmente cancelar o pedido #'+<?php echo json_encode($order['id']); ?>+'?');" style="margin:0;">
                                                        <input type="hidden" name="pedido_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                                                        <button type="submit" class="cancelpedido">Cancelar Pedido</button>
                                                    </form>
                                                </div>
                                            <?php else: ?>
                                                <button class="cancelpedido" >Cancelar</button>
                                            <?php endif; ?>

                                            <hr>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                        <div class="profile-section">
                            <h3 class="section-title">
                                <i class='bx bx-map-pin'></i>
                                Acompanhar Entrega
                            </h3>
                            
                            <div id="tracking-container">
                                <?php
                                // Buscar entrega ativa do usuário
                                $activeDelivery = $db->getUserActiveDelivery($user['id']);
                                if ($activeDelivery && $activeDelivery['status'] == 'em_entrega'):
                                ?>
                                    <div class="tracking-card">
                                        <h4>Seu pedido está a caminho! 🛵</h4>
                                        <p><strong>Motoboy:</strong> <?php echo htmlspecialchars($activeDelivery['motoboy_name']); ?></p>
                                        <p><strong>Status:</strong> Em entrega</p>
                                        <p><strong>Previsão:</strong> 15-25 minutos</p>
                                        <div class="tracking-progress">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 70%"></div>
                                            </div>
                                            <div class="progress-labels">
                                                <span>Preparando</span>
                                                <span>Saiu para entrega</span>
                                                <span>Entregue</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <p>Nenhuma entrega em andamento no momento.</p>
                                <?php endif; ?>
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