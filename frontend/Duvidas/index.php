<?php
session_start();
$userDuvidas = [];
if (!empty($_SESSION['user'])) {
  // Carregar dúvidas do usuário
  require_once __DIR__ . '/../../backend/config/DatabaseManager.php';
  $db = new DatabaseManager();
  $userId = $_SESSION['user']['id'] ?? null;
  if ($userId) {
    $userDuvidas = $db->getDuvidasByUser($userId);
  }
}

$lookupDuvidas = [];
if (!empty($_GET['lookup_email'])) {
  $email = filter_var(trim($_GET['lookup_email']), FILTER_SANITIZE_EMAIL);
  if ($email !== '') {
    if (!isset($db)) {
      require_once __DIR__ . '/../../backend/config/DatabaseManager.php';
      $db = new DatabaseManager();
    }
    $lookupDuvidas = $db->getDuvidasByEmail($email);
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dúvidas - Snack Paradise</title>
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
    <a href="../Duvidas/index.php" class="menu-lateral-item">Dúvidas</a>
    <a href="../Auxílio Preferencial/auxilio.php" class="menu-lateral-item">Auxílio Preferencial</a>
    </nav>

  <main>
    <div class="left-decoration" aria-hidden="true">
      <div class="floating-shape shape-1"></div>
      <div class="floating-shape shape-2"></div>
    </div>

    <div class="main-container" style="max-width:900px; margin:28px auto;">
      <h1>Dúvidas e Suporte</h1>
      <?php if (!empty($_GET['success'])): ?>
        <div class="alert alert-success">Sua dúvida foi enviada. Responderemos em breve.</div>
      <?php endif; ?>
      <?php if (!empty($_GET['error'])): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($_GET['error']); ?></div>
      <?php endif; ?>

      <p>Use este formulário para enviar dúvidas, sugestões ou problemas relacionados ao pedido.</p>

      <form method="POST" action="../../backend/controllers/enviar_duvida.php">
        <div class="form-row">
          <label for="nome">Nome</label>
          <input type="text" id="nome" name="nome" required>
        </div>
        <div class="form-row">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-row">
          <label for="mensagem">Mensagem</label>
          <textarea id="mensagem" name="mensagem" rows="6" required></textarea>
        </div>
        <div class="form-row">
          <button type="submit" class="botao-login">Enviar Dúvida</button>
        </div>
      </form>

      <div style="margin-top:18px;padding:12px;border:1px solid #eee;border-radius:8px;background:#fff">
        <h3 style="margin:0 0 8px">Consultar por e-mail</h3>
        <form method="GET" action="index.php">
          <div style="display:flex;gap:8px;align-items:center">
            <input type="email" name="lookup_email" placeholder="Seu e-mail" required style="padding:8px;border:1px solid #e7e7e7;border-radius:6px;flex:1">
            <button type="submit" style="background:#a20908;color:#fff;padding:8px 12px;border:0;border-radius:6px;cursor:pointer">Buscar</button>
          </div>
        </form>
      </div>

      <?php if (!empty($userDuvidas)): ?>
        <section style="margin-top:24px">
          <h2>Suas dúvidas e respostas</h2>
          <?php foreach ($userDuvidas as $ud): ?>
            <div class="card" style="margin-bottom:12px;padding:12px">
              <div style="font-size:14px;color:#666;margin-bottom:6px">Enviada em: <?php echo htmlspecialchars($ud['criado_em']); ?></div>
              <div style="white-space:pre-wrap;margin-bottom:8px"><?php echo nl2br(htmlspecialchars($ud['mensagem'])); ?></div>
              <?php if (!empty($ud['resposta'])): ?>
                <div style="background:#f6f9ff;padding:10px;border-radius:6px;border:1px solid #e6eefc">
                  <strong>Resposta:</strong>
                  <div style="white-space:pre-wrap;margin-top:6px"><?php echo nl2br(htmlspecialchars($ud['resposta'])); ?></div>
                  <div style="font-size:12px;color:#666;margin-top:6px">Respondido em: <?php echo htmlspecialchars($ud['resposta_em'] ?? '-'); ?></div>
                </div>
              <?php else: ?>
                <div style="font-size:13px;color:#999">Ainda sem resposta.</div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </section>
      <?php endif; ?>
      
      <?php if (!empty($lookupDuvidas)): ?>
        <section style="margin-top:24px">
          <h2>Resultados da busca por e-mail</h2>
          <?php foreach ($lookupDuvidas as $ud): ?>
            <div class="card" style="margin-bottom:12px;padding:12px">
              <div style="font-size:14px;color:#666;margin-bottom:6px">Enviada em: <?php echo htmlspecialchars($ud['criado_em']); ?></div>
              <div style="white-space:pre-wrap;margin-bottom:8px"><?php echo nl2br(htmlspecialchars($ud['mensagem'])); ?></div>
              <?php if (!empty($ud['resposta'])): ?>
                <div style="background:#f6f9ff;padding:10px;border-radius:6px;border:1px solid #e6eefc">
                  <strong>Resposta:</strong>
                  <div style="white-space:pre-wrap;margin-top:6px"><?php echo nl2br(htmlspecialchars($ud['resposta'])); ?></div>
                  <div style="font-size:12px;color:#666;margin-top:6px">Respondido em: <?php echo htmlspecialchars($ud['resposta_em'] ?? '-'); ?></div>
                </div>
              <?php else: ?>
                <div style="font-size:13px;color:#999">Ainda sem resposta.</div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </section>
      <?php elseif (isset($_GET['lookup_email'])): ?>
        <div style="margin-top:16px;color:#666">Nenhuma dúvida encontrada para esse e-mail.</div>
      <?php endif; ?>
    </div>
  </main>

  <div class="right-decoration" aria-hidden="true">
    <div class="floating-shape shape-3"></div>
    <div class="chat-bubble"></div>
  </div>

  <script src="../PerfilUser/script.js"></script>

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
