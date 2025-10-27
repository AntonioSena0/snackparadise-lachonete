<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

include_once '../../backend/config/DatabaseManager.php';
$db = new DatabaseManager();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: pedidos.php?error=ID inválido');
    exit();
}

$pedido = $db->getPedidoById(intval($id));
if (!$pedido) {
    header('Location: pedidos.php?error=Pedido não encontrado');
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Pedido #<?php echo htmlspecialchars($pedido['id']); ?></title>
    <link rel="stylesheet" href="pedidos.css">
</head>
<body>
    <main>
        <h1>Editar Pedido #<?php echo htmlspecialchars($pedido['id']); ?></h1>
        <form method="POST" action="../../backend/controllers/admin_edit_pedido_form.php">
            <input type="hidden" name="pedido_id" value="<?php echo htmlspecialchars($pedido['id']); ?>">
            <div>
                <label>Endereço</label>
                <input type="text" name="endereco" value="<?php echo htmlspecialchars($pedido['endereco']); ?>" required>
            </div>
            <div>
                <label>Pagamento</label>
                <input type="text" name="pagamento" value="<?php echo htmlspecialchars($pedido['pagamento']); ?>" required>
            </div>
            <div>
                <label>Status</label>
                <select name="status">
                    <option value="pendente" <?php echo $pedido['status']=='pendente' ? 'selected' : ''; ?>>pendente</option>
                    <option value="preparando" <?php echo $pedido['status']=='preparando' ? 'selected' : ''; ?>>preparando</option>
                    <option value="pronto" <?php echo $pedido['status']=='pronto' ? 'selected' : ''; ?>>pronto</option>
                    <option value="em_entrega" <?php echo $pedido['status']=='em_entrega' ? 'selected' : ''; ?>>em_entrega</option>
                    <option value="entregue" <?php echo $pedido['status']=='entregue' ? 'selected' : ''; ?>>entregue</option>
                    <option value="cancelado" <?php echo $pedido['status']=='cancelado' ? 'selected' : ''; ?>>cancelado</option>
                    <option value="oculto" <?php echo $pedido['status']=='oculto' ? 'selected' : ''; ?>>oculto</option>
                </select>
            </div>
            <div style="margin-top:12px;">
                <button type="submit">Salvar</button>
                <a href="pedidos.php">Cancelar</a>
            </div>
        </form>
    </main>
</body>
</html>
