<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
include_once __DIR__ . '/../config/Conexao.php';
session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Usuário não autenticado']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

$usuario_id = $_SESSION['user']['id'] ?? null;
$itens = $data['itens'] ?? null;
$endereco = $data['endereco'] ?? null;
$pagamento = $data['pagamento'] ?? null;

if (!$usuario_id || !$itens || !$endereco || !$pagamento) {
    http_response_code(400);
    echo json_encode(['error' => 'Dados obrigatórios ausentes']);
    exit();
}

try {
    $conn = Conectar::getInstance();
    $stmt = $conn->prepare("INSERT INTO pedidos (usuario_id, itens, endereco, pagamento, status, criado_em) VALUES (?, ?, ?, ?, 'pendente', NOW())");
    $stmt->execute([
        $usuario_id,
        json_encode($itens),
        $endereco,
        $pagamento
    ]);
    echo json_encode(['success' => true, 'pedido_id' => $conn->lastInsertId()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>