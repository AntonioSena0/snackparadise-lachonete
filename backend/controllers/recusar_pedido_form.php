<?php
session_start();
if (!isset($_SESSION['motoboy'])) {
    header('Location: ../../frontend/Tela de login/index.php');
    exit();
}

include_once __DIR__ . '/../config/Conexao.php';
include_once __DIR__ . '/../config/DatabaseManager.php';

$pedido_id = $_POST['pedido_id'] ?? null;

if (!$pedido_id) {
    header('Location: ../../frontend/PerfilMotoboy/index.php?error=ID inválido');
    exit();
}

try {
    $conn = Conectar::getInstance();
    $conn->beginTransaction();

    $sql = $conn->prepare("SELECT motoboy_id FROM pedidos WHERE id = ?");
    $sql->execute([$pedido_id]);
    $pedido = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$pedido || $pedido['motoboy_id'] != $_SESSION['motoboy']['id']) {
        throw new Exception('Pedido não pertence a este motoboy');
    }

    $sql = $conn->prepare("UPDATE pedidos SET motoboy_id = NULL, status = 'pronto' WHERE id = ?");
    $sql->execute([$pedido_id]);

    $sql = $conn->prepare("UPDATE motoboys SET status = 'disponivel' WHERE id = ?");
    $sql->execute([$_SESSION['motoboy']['id']]);

    try {
        $sql = $conn->prepare("INSERT INTO pedido_assignments (pedido_id, motoboy_id, status, observacao) VALUES (?, ?, 'recusado', 'Recusado via formulário')");
        $sql->execute([$pedido_id, $_SESSION['motoboy']['id']]);
    } catch (Exception $e) {
        error_log('pedido_assignments insert failed: ' . $e->getMessage());
    }

    $conn->commit();
    header('Location: ../../frontend/PerfilMotoboy/index.php?success=Pedido recusado');
    exit();
} catch (Exception $e) {
    if (isset($conn)) $conn->rollBack();
    header('Location: ../../frontend/PerfilMotoboy/index.php?error=' . urlencode($e->getMessage()));
    exit();
}

?>
