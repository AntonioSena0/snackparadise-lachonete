<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../CadAdmin/index.php');
    exit();
}

include_once '../../backend/config/DatabaseManager.php';
$db = new DatabaseManager();
$duvidas = $db->getAllDuvidas();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dúvidas - Admin</title>
    <link rel="stylesheet" href="pedidos.css">
    <style>
        /* Estilos específicos para a listagem de dúvidas no admin */
        .duvidas-container{max-width:1100px;margin:24px auto;padding:18px}
        .duvidas-table{width:100%;border-collapse:collapse;background:#fff;border-radius:8px;overflow:hidden}
        .duvidas-table thead th{background:#fafafa;padding:12px 10px;border-bottom:1px solid #eee;text-align:left}
        .duvidas-table tbody td{padding:10px;border-bottom:1px solid #f3f3f3;vertical-align:top}
        .small{font-size:13px;color:#666}
        .btn-action{display:inline-block;padding:8px 10px;border-radius:6px;border:0;cursor:pointer}
        .btn-delete{background:#a20908;color:#fff}
        .btn-reply{background:#1a73e8;color:#fff}
        .msg-preview{max-width:420px;white-space:pre-wrap;word-break:break-word}
        .expandable{display:none;padding:8px;border:1px solid #eee;background:#fbfbfb;border-radius:6px;margin-top:8px}
        textarea.reply-box{width:100%;min-height:80px;padding:8px;border-radius:6px;border:1px solid #e7e7e7}
        @media(max-width:900px){
            .duvidas-table thead{display:none}
            .duvidas-table tbody td{display:block;width:100%}
            .duvidas-table tbody tr{margin-bottom:12px;border:1px solid #eee;padding:10px;border-radius:8px}
        }
    </style>
</head>
<body>
    <header>
        <div class="header-left">
            <button class="btn-menu-lateral" id="btnMenuLateral">☰</button>
            <div class="logo-container">
                <a href="dashboard.php" class="logo"><img src="../imgs/Logo.png" alt="Logo" style="height:36px"></a>
            </div>
        </div>
        <div class="header-center">
            <a href="pedidos.php" class="menu-item">Pedidos</a>
            <a href="clientes.php" class="menu-item">Clientes</a>
            <a href="produtos.php" class="menu-item">Produtos</a>
        </div>
        <a href="logout.php" class="btn-conta">Sair</a>
    </header>

    <nav class="menu-lateral" id="menuLateral">
        <a href="dashboard.php" class="menu-lateral-item">🏠 Dashboard</a>
        <a href="pedidos.php" class="menu-lateral-item">📦 Pedidos</a>
        <a href="clientes.php" class="menu-lateral-item">👥 Clientes</a>
        <a href="produtos.php" class="menu-lateral-item">🍔 Produtos</a>
        <a href="duvidas.php" class="menu-lateral-item active">✉️ Dúvidas</a>
        <a href="config.php" class="menu-lateral-item">⚙️ Configurações</a>
    </nav>

    <main>
        <div class="duvidas-container">
            <h1>Dúvidas Recebidas</h1>
            <?php if (empty($duvidas)): ?>
                <p class="small">Nenhuma dúvida registrada.</p>
            <?php else: ?>
                <table class="duvidas-table">
                    <thead>
                        <tr>
                            <th style="width:60px">ID</th>
                            <th style="width:130px">Usuário</th>
                            <th>Mensagem / Resposta</th>
                            <th style="width:160px">Recebido em</th>
                            <th style="width:160px">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($duvidas as $d): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($d['id']); ?></td>
                                <td>
                                    <div><?php echo htmlspecialchars($d['usuario_nome'] ?? '-'); ?></div>
                                    <div class="small"><?php echo htmlspecialchars($d['nome']); ?></div>
                                    <div class="small"><?php echo htmlspecialchars($d['email']); ?></div>
                                </td>
                                <td>
                                    <div class="msg-preview"><?php echo nl2br(htmlspecialchars(strlen($d['mensagem'])>300?substr($d['mensagem'],0,300).'...':$d['mensagem'])); ?></div>
                                    <button class="btn-action" data-toggle-id="msg-<?php echo htmlspecialchars($d['id']); ?>">Ver mensagem</button>
                                    <div id="msg-<?php echo htmlspecialchars($d['id']); ?>" class="expandable"><?php echo nl2br(htmlspecialchars($d['mensagem'])); ?></div>

                                    <?php if (!empty($d['resposta'])): ?>
                                        <div style="margin-top:10px">
                                            <strong>Resposta:</strong>
                                            <div class="msg-preview"><?php echo nl2br(htmlspecialchars(strlen($d['resposta'])>300?substr($d['resposta'],0,300).'...':$d['resposta'])); ?></div>
                                            <button class="btn-action" data-toggle-id="rep-<?php echo htmlspecialchars($d['id']); ?>">Ver resposta</button>
                                            <div id="rep-<?php echo htmlspecialchars($d['id']); ?>" class="expandable"><?php echo nl2br(htmlspecialchars($d['resposta'])); ?></div>
                                        </div>
                                    <?php else: ?>
                                        <div style="margin-top:10px">
                                            <form method="POST" action="../../backend/controllers/admin_reply_duvida.php">
                                                <input type="hidden" name="duvida_id" value="<?php echo htmlspecialchars($d['id']); ?>">
                                                <textarea name="resposta" class="reply-box" placeholder="Escreva a resposta para o usuário..."></textarea>
                                                <div style="margin-top:8px">
                                                    <button type="submit" class="btn-action btn-reply">Responder</button>
                                                </div>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($d['criado_em']); ?></td>
                                <td>
                                    <form method="POST" action="../../backend/controllers/admin_delete_duvida.php" onsubmit="return confirm('Excluir dúvida #'+<?php echo json_encode($d['id']); ?>+'?');" style="display:inline-block">
                                        <input type="hidden" name="duvida_id" value="<?php echo htmlspecialchars($d['id']); ?>">
                                        <button type="submit" class="btn-action btn-delete">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>

 
</html>
<script>
    // Toggle para mostrar/ocultar mensagens e respostas
    document.addEventListener('click', function(e){
        var btn = e.target.closest('[data-toggle-id]');
        if(!btn) return;
        var id = btn.getAttribute('data-toggle-id');
        var el = document.getElementById(id);
        if(!el) return;
        el.style.display = (el.style.display === 'block') ? 'none' : 'block';
        btn.textContent = (el.style.display === 'block') ? 'Ocultar' : 'Ver mensagem';
    });
</script>
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
