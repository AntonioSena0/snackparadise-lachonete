
<?php
include_once __DIR__ . '/../config/Conexao.php';
session_start();

if (!isset($_SESSION['motoboy'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Motoboy não autenticado']);
    exit();
}

try {
    $conn = Conectar::getInstance();
    $sql = $conn->prepare("SELECT * FROM pedidos WHERE status = 'pendente' OR (motoboy_id = ? AND status = 'em_entrega')");
    $sql->execute([$_SESSION['motoboy']['id']]);
    $pedidos = $sql->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'pedidos' => $pedidos]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>