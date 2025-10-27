<?php
session_start();
if (!isset($_SESSION['motoboy'])) {
    header('Location: ../../frontend/Tela de login/index.php');
    exit();
}

include_once __DIR__ . '/../config/DatabaseManager.php';
$db = new DatabaseManager();

$pedido_id = $_POST['pedido_id'] ?? null;
$motoboy_id = $_SESSION['motoboy']['id'];

if (!$pedido_id) {
    header('Location: ../../frontend/PerfilMotoboy/index.php?error=ID inválido');
    exit();
}

$ok = $db->assignOrderToMotoboy(intval($pedido_id), intval($motoboy_id));

if ($ok) {
    header('Location: ../../frontend/PerfilMotoboy/index.php?success=Pedido aceito');
} else {
    header('Location: ../../frontend/PerfilMotoboy/index.php?error=Falha ao aceitar pedido');
}
exit();

?>
