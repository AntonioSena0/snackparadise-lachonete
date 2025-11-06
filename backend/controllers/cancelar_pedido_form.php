<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../../frontend/Tela de login/index.php');
    exit();
}

include_once __DIR__ . '/../config/DatabaseManager.php';
$db = new DatabaseManager();

$pedido_id = $_POST['pedido_id'] ?? null;

if (!$pedido_id) {
    header('Location: ../../frontend/PerfilUser/index.php?error=ID inválido');
    exit();
}

$pedido = $db->getPedidoById(intval($pedido_id));
if (!$pedido || $pedido['usuario_id'] != $_SESSION['user']['id']) {
    header('Location: ../../frontend/PerfilUser/index.php?error=Pedido não encontrado ou sem permissão');
    exit();
}

if (in_array($pedido['status'], ['em_entrega', 'entregue', 'cancelado'])) {
    header('Location: ../../frontend/PerfilUser/index.php?error=Não é possível cancelar este pedido');
    exit();
}

$ok = $db->updateOrderStatus(intval($pedido_id), 'cancelado');

if ($ok) {
    header('Location: ../../frontend/PerfilUser/index.php?success=Pedido cancelado');
} else {
    header('Location: ../../frontend/PerfilUser/index.php?error=Falha ao cancelar pedido');
}
exit();

?>
