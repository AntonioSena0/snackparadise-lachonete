<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../Tela de login/index.php');
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

if (in_array($pedido['status'], ['em_entrega', 'entregue', 'cancelado'])) {
    header('Location: index.php?error=Não é possível alterar este pedido');
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Meu Pedido #<?php echo htmlspecialchars($pedido['id']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Editar Pedido #<?php echo htmlspecialchars($pedido['id']); ?></h1>
        <form method="POST" action="../../backend/controllers/user_edit_pedido_form.php">
            <input type="hidden" name="pedido_id" value="<?php echo htmlspecialchars($pedido['id']); ?>">
            <div>
                <label>Endereço</label>
                <input type="text" name="endereco" value="<?php echo htmlspecialchars($pedido['endereco']); ?>" required>
            </div>
            <div>
                <label>Pagamento</label>
                <input type="text" name="pagamento" value="<?php echo htmlspecialchars($pedido['pagamento']); ?>" required>
            </div>
            <div style="margin-top:12px;">
                <button type="submit">Salvar</button>
                <a href="index.php">Cancelar</a>
            </div>
        </form>
    </main>
</body>
</html>
