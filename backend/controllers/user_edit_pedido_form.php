<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../../frontend/Tela de login/index.php');
    exit();
}

include_once __DIR__ . '/../config/DatabaseManager.php';
$db = new DatabaseManager();

$pedido_id = $_POST['pedido_id'] ?? null;
$endereco = $_POST['endereco'] ?? '';
$pagamento = $_POST['pagamento'] ?? '';

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
    header('Location: ../../frontend/PerfilUser/index.php?error=Não é possível alterar este pedido');
    exit();
}

$ok = $db->updatePedidoBasic(intval($pedido_id), ['endereco' => $endereco, 'pagamento' => $pagamento, 'status' => $pedido['status']]);

if ($ok) {
    header('Location: ../../frontend/PerfilUser/index.php?success=Pedido atualizado');
} else {
    header('Location: ../../frontend/PerfilUser/index.php?error=Falha ao atualizar pedido');
}
exit();

?>
