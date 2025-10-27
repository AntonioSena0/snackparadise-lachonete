<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../CadAdmin/index.php");
    exit();
}

include_once '../../backend/config/DatabaseManager.php';
$db = new DatabaseManager();

// Buscar todos os pedidos para exibição
$allPedidos = $db->getAllPedidos();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Pedidos - Snack Paradise</title>
    <link rel="stylesheet" href="pedidos.css">
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
    <h1>Gerenciar Pedidos - Atribuir Motoboys</h1>
    
    <div id="all-orders">
        <h2>Todos os Pedidos (visão rápida)</h2>
        <div class="orders-grid">
            <?php if (empty($allPedidos)): ?>
                <p>Nenhum pedido registrado.</p>
            <?php else: ?>
                <?php foreach ($allPedidos as $order): ?>
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
                        <div style="display:flex; gap:8px; margin-top:8px;">
                            <button class="excpedido" type="button" onclick="location.href='editar_pedido.php?id=<?php echo htmlspecialchars($order['id']); ?>'">Editar</button>
                            <form method="POST" action="../../backend/controllers/admin_hide_pedido.php" style="margin:0;">
                                <input type="hidden" name="pedido_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                                <button type="submit" class="excpedido">Ocultar</button>
                            </form>
                            <form method="POST" action="../../backend/controllers/admin_delete_pedido.php" style="margin:0;" onsubmit="return confirm('Deseja excluir o pedido #'+<?php echo json_encode($order['id']); ?>+'? Isso removerá permanentemente o pedido.');">
                                <input type="hidden" name="pedido_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                                <button type="submit" class="excpedido">Excluir</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
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
    <script src="script.js"></script>
    <script>
        async function loadPendingOrders() {
            try {
                const response = await fetch('../../backend/controllers/DeliveryController.php?action=get_pending_orders');
                const data = await response.json();
                
                if (data.success) {
                    displayOrders(data.orders);
                }
            } catch (error) {
                console.error('Erro ao carregar pedidos:', error);
            }
        }
        
        function displayOrders(orders) {
            const container = document.getElementById('orders-container');
            
            if (orders.length === 0) {
                container.innerHTML = '<p>Nenhum pedido pendente no momento.</p>';
                return;
            }
            
            container.innerHTML = orders.map(order => `
                <div class="order-card">
                    <h3>Pedido #${order.id}</h3>
                    <p><strong>Cliente:</strong> ${order.cliente_nome}</p>
                    <p><strong>Itens:</strong> ${order.itens_descricao}</p>
                    <p><strong>Total:</strong> R$ ${parseFloat(order.total).toFixed(2)}</p>
                    <p><strong>Endereço:</strong> ${order.endereco}, ${order.bairro}, ${order.cidade}</p>
                    <p><strong>Status:</strong> <span class="order-status status-${order.status}">${order.status}</span></p>
                    <button class="btn-assign" onclick="assignMotoboy(${order.id})">
                        Atribuir Motoboy
                    </button>
                </div>
            `).join('');
        }
        
        async function assignMotoboy(pedidoId) {
            try {
                // Carregar motoboys disponíveis
                const response = await fetch('../../backend/controllers/DeliveryController.php?action=get_available_motoboys');
                const data = await response.json();
                
                if (!data.success || data.motoboys.length === 0) {
                    alert('Nenhum motoboy disponível no momento.');
                    return;
                }
                
                const motoboyName = prompt(`Escolha um motoboy:\n${data.motoboys.map(m => `${m.id} - ${m.name}`).join('\n')}`);
                if (!motoboyName) return;
                
                const motoboyId = parseInt(motoboyName.split(' - ')[0]);
                
                const formData = new FormData();
                formData.append('action', 'assign_order');
                formData.append('pedido_id', pedidoId);
                formData.append('motoboy_id', motoboyId);
                
                const assignResponse = await fetch('../../backend/controllers/DeliveryController.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await assignResponse.json();
                
                if (result.success) {
                    alert('Pedido atribuído com sucesso!');
                    loadPendingOrders();
                } else {
                    alert('Erro ao atribuir pedido: ' + result.error);
                }
                
            } catch (error) {
                console.error('Erro ao atribuir motoboy:', error);
                alert('Erro ao atribuir motoboy');
            }
        }
        
        loadPendingOrders();
        setInterval(loadPendingOrders, 30000);
    </script>
    
</body>
</html>