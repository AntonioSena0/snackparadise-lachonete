<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../../frontend/Tela de login/index.php');
    exit();
}

include_once '../../backend/config/DatabaseManager.php';
$db = new DatabaseManager();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php?error=ID inválido');
    exit();
}

$pedido = $db->getPedidoById(intval($id));

if (!$pedido || $pedido['usuario_id'] != $_SESSION['user']['id']) {
    header('Location: index.php?error=Pedido não encontrado ou sem permissão');
    exit();
}

// Permitir edição apenas se o status for 'pendente' ou 'preparando'
if (!in_array($pedido['status'], ['pendente', 'preparando'])) {
    header('Location: index.php?error=Não é possível editar este pedido');
    exit();
}

// Gera token CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Pedido #<?php echo htmlspecialchars($pedido['id']); ?></title>
    <link rel="stylesheet" href="../Admin/pedidos.css">
</head>
<body>
    <main>
        <div class="editar-pedido-container">
            <h1>Editar Pedido #<?php echo htmlspecialchars($pedido['id']); ?></h1>
            <form method="POST" action="../../backend/controllers/user_edit_pedido_form.php">
                <input type="hidden" name="pedido_id" value="<?php echo htmlspecialchars($pedido['id']); ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div>
                    <label for="endereco">Endereço</label>
                    <input type="text" name="endereco" value="<?php echo htmlspecialchars($pedido['endereco']); ?>" required>
                </div>
                <div>
                    <label for="pagamento">Pagamento</label>
                    <input type="text" name="pagamento" value="<?php echo htmlspecialchars($pedido['pagamento']); ?>" required>
                </div>
                <div style="margin-top:12px; display:flex; gap:12px;">
                    <button type="submit">Salvar</button>
                    <a href="index.php">Cancelar</a>
                </div>
            </form>
        </div>
    </main>
    <script>
    // Redireciona para o cardápio após exclusão
    <?php if (isset($_GET['deleted']) && $_GET['deleted'] === '1'): ?>
        window.location.href = '../Cardápio/menu.php';
    <?php endif; ?>
    </script>
</body>
</html>
