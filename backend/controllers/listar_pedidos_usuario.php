
<?php
include_once __DIR__ . '/../config/Conexao.php';
session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Usuário não autenticado']);
    exit();
}

$userId = $_SESSION['user']['id'];

try {
    $conn = Conectar::getInstance();
    $sql = $conn->prepare("SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY criado_em DESC");
    $sql->execute([$userId]);
    $pedidos = $sql->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'pedidos' => $pedidos]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>