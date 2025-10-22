<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Área Restrita - Snack Paradise</title>
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
            <a href="#" class="menu-item">Promoções</a>
            <a href="index.php" class="menu-item">Sobre Nós</a>
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
        <a href="../Auxílio Preferencial/auxilio.php" class="menu-lateral-item">Auxílio Preferencial</a>
    </nav>

  <!-- Conteúdo principal -->
  <?php
session_start();
include_once '../../backend/config/DatabaseManager.php';
$db = new DatabaseManager();
// Fallback para testes: se não houver sessão, usa id=1
$motoboyId = isset($_SESSION['motoboy']['id']) ? $_SESSION['motoboy']['id'] : 1;
$pedidosMotoboy = $motoboyId ? $db->getPedidosByMotoboy($motoboyId) : [];
$allPedidos = $db->getAllPedidos();

?>

<div class="fundo">
  <main role="main">
    <div class="motomsg"><?php
      // Mensagem de depuração
      if (!$motoboyId) {
        echo '<div style="color:red">Motoboy não logado. Usando fallback id=1.</div>';
      }
      if (empty($pedidosMotoboy)) {
        echo '<div style="color:orange">Nenhum pedido atribuído ao motoboy (id=' . htmlspecialchars($motoboyId) . ').</div>';
      }
    ?>
    </div>
    <section class="area-restrita-section" aria-labelledby="titulo-area-restrita">
      <h1 id="titulo-area-restrita" style="display:none;">Área restrita - Gerenciamento de Pedidos</h1>

      <!-- Todos os Pedidos -->
      <div id="all-orders">
        <h2 class="tit">Todos os Pedidos</h2>
        <div class="orders-grid">
          <?php if (empty($allPedidos)): ?>
            <p>Nenhum pedido encontrado.</p>
          <?php else: ?>
            <?php foreach ($allPedidos as $order): ?>
              <div class="order-card">
                <h3>Pedido #<?php echo htmlspecialchars($order['id']); ?></h3>
                <p><strong>Cliente:</strong> <?php echo htmlspecialchars($order['cliente_nome'] ?? '—'); ?></p>
                <div><strong>Itens:</strong>
                  <ul style="margin: 6px 0 0 0; padding-left: 18px;">
                    <?php if (!empty($order['itens'])): ?>
                      <?php $itens = json_decode($order['itens'], true); ?>
                      <?php if (is_array($itens)): ?>
                        <?php foreach ($itens as $item): ?>
                          <li><?php echo htmlspecialchars(($item['quantidade'] ?? 1) . 'x ' . ($item['nome'] ?? $item['produto'] ?? 'Item') . (isset($item['preco']) ? ' - R$ ' . number_format($item['preco'], 2, ',', '.') : '')); ?></li>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <li><?php echo htmlspecialchars($order['itens']); ?></li>
                      <?php endif; ?>
                    <?php endif; ?>
                  </ul>
                </div>
                <p><strong>Total:</strong> R$ <?php echo isset($order['total']) ? number_format($order['total'], 2, ',', '.') : '—'; ?></p>
                <p><strong>Endereço:</strong> <?php echo htmlspecialchars($order['endereco']); ?></p>
                <p><strong>Pagamento:</strong> <?php echo htmlspecialchars($order['pagamento']); ?></p>
                <p><strong>Status:</strong> <span class="order-status status-<?php echo htmlspecialchars($order['status']); ?>"><?php echo htmlspecialchars($order['status']); ?></span></p>
                <p><strong>Data:</strong> <?php echo htmlspecialchars($order['criado_em']); ?></p> 
                
                <!-- Botões de ação -->
                <div class="order-actions">
                  <button class="btn-aceitar" onclick="iniciarEntrega(<?php echo htmlspecialchars($order['status']); ?>)">
                    Iniciar Entrega
                  </button>
                  <button class="btn-recusar" onclick="recusarPedidoMotoboy(<?php echo htmlspecialchars($order['status']); ?>)">
                    Recusar Pedido
                  </button>
                </div>
              </div>
              
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </section>
  </main>
</div>
  <!-- Rodapé -->
  <footer role="contentinfo">
    <div class="footer-container">
      <div class="footer-links">
        <a href="../../Menu/index.html">Início</a>
        <a href="../Quem somos/index.html">Sobre</a>
        <a href="../Auxílio Preferencial/auxilio.html">Serviços</a>
        <a href="https://www.instagram.com/_snackparadise_/profilecard/?igsh=OHh2eWpsOXBuOWRp" target="_blank" rel="noopener">Contato</a>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2024 Snack Paradise. Todos os direitos reservados.</p>
      </div>
    </div>
  </footer>

  <!-- Plugin de acessibilidade VLibras -->
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

  <!-- Scripts -->
  <script src="menu.js"></script>
  
</html>