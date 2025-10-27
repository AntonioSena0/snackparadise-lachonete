<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../../frontend/CadAdmin/index.php');
    exit();
}

include_once __DIR__ . '/../config/DatabaseManager.php';

$pedido_id = $_POST['pedido_id'] ?? null;
$endereco = $_POST['endereco'] ?? '';
$pagamento = $_POST['pagamento'] ?? '';
$status = $_POST['status'] ?? 'pendente';

if (!$pedido_id) {
    header('Location: ../../frontend/Admin/pedidos.php?error=ID inválido');
    exit();
}

$db = new DatabaseManager();
$ok = $db->updatePedidoBasic(intval($pedido_id), ['endereco' => $endereco, 'pagamento' => $pagamento, 'status' => $status]);

if ($ok) {
    header('Location: ../../frontend/Admin/pedidos.php?success=Pedido atualizado');
} else {
    header('Location: ../../frontend/Admin/pedidos.php?error=Falha ao atualizar pedido');
}
exit();

?>
