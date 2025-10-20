<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar se é motoboy
if (!isset($_SESSION['motoboy'])) {
    header('Location: ../Tela de Login/cadastrar_motoboy.php');
    exit();
}

// Incluir as classes
include_once '../../backend/config/Conexao.php';
include_once '../../backend/config/DatabaseManager.php';

try {
    $db = new DatabaseManager();
    $motoboyId = $_SESSION['motoboy']['id'];
    $motoboyData = $db->getMotoboyById($motoboyId);
    
    if (!$motoboyData) {
        throw new Exception("Motoboy não encontrado no banco de dados");
    }
    
    $stats = $db->getMotoboyStats($motoboyId);
    $recentDeliveries = $db->getRecentDeliveries($motoboyId, 3);
    $pedidosMotoboy = $db->getPedidosByMotoboy($motoboyId);
    
} catch (Exception $e) {
    die("Erro ao carregar dados: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Motoboy - Snack Paradise</title>
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
            <a href="#" class="menu-item">Promoções</a>
            <a href="../Quem somos/index.php" class="menu-item">Sobre Nós</a>
        </div>

        <a href="../../backend/controllers/logout.php" class="btn-conta">Sair</a>
    </header>

    <!-- Menu Lateral -->
    <nav class="menu-lateral" id="menuLateral">
        <a href="../Cardápio/index.php" class="menu-lateral-item">Início</a>
        <a href="../PerfilMotoboy/index.php" class="menu-lateral-item active">Perfil</a>
        <a href="../Acumular Pontos/pontos.html" class="menu-lateral-item">Pontos</a>
        <a href="../SejaParceiro/index.php" class="menu-lateral-item">Seja Parceiro</a>
        <a href="../Feedback/index.php" class="menu-lateral-item">Avaliações</a>
        <a href="../Quem somos/index.php" class="menu-lateral-item">Sobre nós</a>
        <a href="../Auxílio Preferencial/auxilio.php" class="menu-lateral-item">Auxílio Preferencial</a>
    </nav>

    <main>
        <div class="main-container">
            <div class="profile-box">
                <div class="profile-header">
                    <div class="logo2">
                        <img src="../imgs/Logo.png" alt="SnackParadiseLogo">
                        <h4>SnackParadise Delivery</h4>
                    </div>
                    <h1 class="profile-title">Perfil do Motoboy</h1>
                </div>

                <div class="profile-content">
                    <div class="profile-avatar">
                        <div class="avatar-circle">
                            <?php if (!empty($motoboyData['profile_picture'])): ?>
                                <img src="../../backend/uploads/profiles/<?php echo htmlspecialchars($motoboyData['profile_picture']); ?>?t=<?php echo time(); ?>" 
                                    alt="Foto do perfil" 
                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            <?php else: ?>
                                <i class='bx bxs-user'></i>
                            <?php endif; ?>
                        </div>
                        <button class="btn-change-photo" onclick="changePhoto()">
                            <i class='bx bx-camera'></i>
                            Alterar Foto
                        </button>
                        <div class="rider-status <?php echo $motoboyData['status'] ?? 'offline'; ?>" id="riderStatus">
                            <i class='bx bx-circle'></i>
                            <span><?php echo ucfirst($motoboyData['status'] ?? 'offline'); ?></span>
                        </div>
                        <div class="rating-display">
                            <div class="stars">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bx-star'></i>
                            </div>
                            <span class="rating-number">4.2</span>
                        </div>
                    </div>

                    <div class="profile-forms">
                        <!-- Informações Pessoais -->
                        <div class="profile-section">
                            <h3 class="section-title">
                                <i class='bx bx-user-circle'></i>
                                Informações Pessoais
                            </h3>
                            
                            <form class="profile-form" id="personal-form" method="POST" action="../../backend/controllers/AccountController.php">
                                <input type="hidden" name="action" value="update_personal_info">
                                <div class="form-row">
                                    <div class="input-wrap">
                                        <input type="text" class="input-field" id="name" name="name" 
                                               value="<?php echo htmlspecialchars($motoboyData['name']); ?>" readonly />
                                        <label>Nome Completo</label>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="email" class="input-field" id="email" name="email" 
                                               value="<?php echo htmlspecialchars($motoboyData['email']); ?>" readonly />
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

                        <!-- Informações do Veículo -->
                        <div class="profile-section">
                            <h3 class="section-title">
                                <i class='bx bxs-truck'></i>
                                Informações do Veículo
                            </h3>
                            
                            <form class="profile-form" id="vehicle-form" method="POST" action="../../backend/controllers/AccountController.php">
                                <input type="hidden" name="action" value="update_vehicle_info">
                                <div class="form-row">
                                    <div class="input-wrap">
                                        <select class="input-field" id="vehicle_type" name="vehicle_type" disabled>
                                            <option value="motocicleta" <?php echo ($motoboyData['vehicle_type'] ?? 'motocicleta') === 'motocicleta' ? 'selected' : ''; ?>>Motocicleta</option>
                                            <option value="bicicleta" <?php echo ($motoboyData['vehicle_type'] ?? '') === 'bicicleta' ? 'selected' : ''; ?>>Bicicleta</option>
                                            <option value="carro" <?php echo ($motoboyData['vehicle_type'] ?? '') === 'carro' ? 'selected' : ''; ?>>Carro</option>
                                        </select>
                                        <label>Tipo de Veículo</label>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="text" class="input-field" id="license_plate" name="license_plate" 
                                               value="<?php echo htmlspecialchars($motoboyData['license_plate'] ?? ''); ?>" readonly />
                                        <label>Placa do Veículo</label>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="button" class="btn-edit" id="edit-vehicle" onclick="toggleEdit('vehicle')">
                                        <i class='bx bx-edit'></i>
                                        Editar
                                    </button>
                                    <button type="submit" class="btn-save hidden" id="save-vehicle">
                                        <i class='bx bx-check'></i>
                                        Salvar
                                    </button>
                                    <button type="button" class="btn-cancel hidden" id="cancel-vehicle" onclick="cancelEdit('vehicle')">
                                        <i class='bx bx-x'></i>
                                        Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Estatísticas REAIS -->
                        <div class="profile-section">
                            <h3 class="section-title">
                                <i class='bx bx-bar-chart-alt-2'></i>
                                Estatísticas
                            </h3>
                            
                            <div class="stats-grid">
                                <div class="stat-item">
                                    <div class="stat-number"><?php echo $stats['total_entregas'] ?? '0'; ?></div>
                                    <div class="stat-label">Entregas Realizadas</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">4.2</div>
                                    <div class="stat-label">Avaliação Média</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number"><?php echo $stats['taxa_sucesso'] ?? '0'; ?>%</div>
                                    <div class="stat-label">Taxa de Sucesso</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">R$ <?php echo number_format($stats['ganhos_totais'] ?? 0, 2, ',', '.'); ?></div>
                                    <div class="stat-label">Ganhos Totais</div>
                                </div>
                            </div>
                        </div>

                        <!-- Histórico de Entregas REAIS -->
                        <div class="profile-section">
                            <h3 class="section-title">
                                <i class='bx bx-history'></i>
                                Últimas Entregas
                            </h3>
                            
                            <div class="deliveries-container" id="deliveries-container">
                                <?php if (!empty($recentDeliveries)): ?>
                                    <?php foreach ($recentDeliveries as $delivery): ?>
                                        <div class="delivery-item">
                                            <div class="delivery-header">
                                                <span class="delivery-number">#DEL-<?php echo str_pad($delivery['id'], 3, '0', STR_PAD_LEFT); ?></span>
                                                <span class="delivery-date"><?php echo date('d/m/Y H:i', strtotime($delivery['criado_em'])); ?></span>
                                                <span class="delivery-status <?php echo $delivery['confirmar'] ? 'status-completed' : 'status-pending'; ?>">
                                                    <?php echo $delivery['confirmar'] ? 'Entregue' : 'Pendente'; ?>
                                                </span>
                                            </div>
                                            <div class="delivery-info">
                                                <p><strong>Itens:</strong> <?php echo htmlspecialchars(substr($delivery['itens'], 0, 50)) . '...'; ?></p>
                                                <p><strong>Endereço:</strong> <?php echo htmlspecialchars($delivery['endereco']); ?></p>
                                            </div>
                                            <div class="delivery-earnings">
                                                <strong>Status: <?php echo $delivery['pagamento']; ?></strong>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="delivery-item">
                                        <div class="delivery-info">
                                            <p>Nenhuma entrega realizada ainda.</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($recentDeliveries)): ?>
                                <button class="btn-load-more" onclick="loadMoreDeliveries()">
                                    <i class='bx bx-plus'></i>
                                    Ver Mais Entregas
                                </button>
                            <?php endif; ?>
                        </div>

                        <!-- Meus Pedidos Atribuídos -->
                        <div class="profile-section">
                            <h3 class="section-title">
                                <i class='bx bx-list-ul'></i>
                                Meus Pedidos Atribuídos
                            </h3>
                            <div class="orders-container" id="orders-motoboy">
                                <?php if (empty($pedidosMotoboy)): ?>
                                    <div class="no-orders">
                                        <p>Nenhum pedido atribuído.</p>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($pedidosMotoboy as $order): ?>
                                        <div class="order-item">
                                            <h4>Pedido #<?php echo htmlspecialchars($order['id']); ?></h4>
                                            <p><strong>Cliente:</strong> <?php echo htmlspecialchars($order['cliente_nome'] ?? '—'); ?></p>
                                            <p><strong>Itens:</strong> <?php echo htmlspecialchars($order['itens_descricao'] ?? $order['itens']); ?></p>
                                            <p><strong>Total:</strong> R$ <?php echo number_format($order['total'] ?? 0, 2, ',', '.'); ?></p>
                                            <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
                                            <p><strong>Pagamento:</strong> <?php echo htmlspecialchars($order['pagamento']); ?></p>
                                            <p><strong>Endereço:</strong> <?php echo htmlspecialchars($order['endereco']); ?></p>
                                            <p><strong>Data:</strong> <?php echo htmlspecialchars($order['criado_em']); ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Alterar Senha -->
                        <div class="profile-section">
                            <h3 class="section-title">
                                <i class='bx bx-lock'></i>
                                Segurança
                            </h3>
                            
                            <form class="profile-form" id="password-form" method="POST" action="../../backend/controllers/AccountController.php">
                                <input type="hidden" name="action" value="change_password">
                                <div class="form-row">
                                    <div class="input-wrap">
                                        <input type="password" class="input-field" id="current_password" name="current_password" required />
                                        <label>Senha Atual</label>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="input-wrap">
                                        <input type="password" class="input-field" id="new_password" name="new_password" required />
                                        <label>Nova Senha</label>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="password" class="input-field" id="confirm_password" name="confirm_password" required />
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
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <a href="../Cardápio/index.php">Início</a>
                <a href="../Quem somos/index.php">Sobre</a>
                <a href="#">Suporte</a>
                <a href="#">Contato</a>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 SnackParadise Delivery. Todos os direitos reservados.</p>
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
    
    <script src="script.js"></script>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>
</body>
</html>