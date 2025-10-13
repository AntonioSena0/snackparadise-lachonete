<?php
include_once __DIR__ . '/../config/Conexao.php';
session_start();

if (!isset($_SESSION['motoboy'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Motoboy não autenticado']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$pedidoId = $data['pedido_id'] ?? null;

if (!$pedidoId) {
    http_response_code(400);
    echo json_encode(['error' => 'ID do pedido não informado']);
    exit();
}

try {
    $conn = Conectar::getInstance();
    $sql = $conn->prepare("UPDATE pedidos SET motoboy_id = NULL, status = 'pendente' WHERE id = ? AND motoboy_id = ?");
    $sql->execute([$pedidoId, $_SESSION['motoboy']['id']]);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>