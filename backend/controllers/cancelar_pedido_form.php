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

// Permitir cancelar apenas se o status for 'pendente' ou 'preparando'
if (!in_array($pedido['status'], ['pendente', 'preparando'])) {
    header('Location: ../../frontend/PerfilUser/index.php?error=Não é possível cancelar este pedido');
    exit();
}

// Remove o pedido do banco
$ok = $db->deletePedido(intval($pedido_id));

if ($ok) {
    header('Location: ../../frontend/Cardápio/menu.php?deleted=1');
} else {
    header('Location: ../../frontend/PerfilUser/index.php?error=Falha ao remover pedido');
}
exit();

?>
