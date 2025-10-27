<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../../frontend/CadAdmin/index.php');
    exit();
}

include_once __DIR__ . '/../config/DatabaseManager.php';

$pedido_id = $_POST['pedido_id'] ?? null;

if (!$pedido_id) {
    header('Location: ../../frontend/Admin/pedidos.php?error=ID inválido');
    exit();
}

$db = new DatabaseManager();
$ok = $db->hidePedido(intval($pedido_id));

if ($ok) {
    header('Location: ../../frontend/Admin/pedidos.php?success=Pedido ocultado');
} else {
    header('Location: ../../frontend/Admin/pedidos.php?error=Falha ao ocultar pedido');
}
exit();

?>
