<?php
include_once __DIR__ . '/../../backend/config/Conexao.php';
include_once __DIR__ . '/../../backend/config/DatabaseManager.php';


session_start();



if (!isset($_SESSION['motoboy'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Motoboy não autenticado']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$pedidoId = $data['pedido_id'] ?? null;

if (!$pedidoId) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'ID do pedido não informado']);
    exit();
}

try {
    $conn = Conectar::getInstance();
    
    // Iniciar transação
    $conn->beginTransaction();
    
    // 1. Verificar se o pedido pertence ao motoboy
    $sql = $conn->prepare("SELECT motoboy_id FROM pedidos WHERE id = ?");
    $sql->execute([$pedidoId]);
    $pedido = $sql->fetch(PDO::FETCH_ASSOC);
    
    if (!$pedido || $pedido['motoboy_id'] != $_SESSION['motoboy']['id']) {
        throw new Exception('Pedido não encontrado ou não pertence a este motoboy');
    }
    
    // 2. Remover motoboy_id do pedido e voltar status para "pronto"
    $sql = $conn->prepare("UPDATE pedidos SET motoboy_id = NULL, status = 'pronto' WHERE id = ?");
    $sql->execute([$pedidoId]);
    
    // 3. Atualizar status do motoboy para disponível
    $sql = $conn->prepare("UPDATE motoboys SET status = 'disponivel' WHERE id = ?");
    $sql->execute([$_SESSION['motoboy']['id']]);
    
    // 4. Registrar a recusa na tabela de assignments (se existir)
    try {
        $sql = $conn->prepare("INSERT INTO pedido_assignments (pedido_id, motoboy_id, status, observacao) VALUES (?, ?, 'recusado', 'Pedido recusado pelo motoboy')");
        $sql->execute([$pedidoId, $_SESSION['motoboy']['id']]);
    } catch (Exception $e) {
        // Tabela pode não existir, apenas registra o erro
        error_log("Erro ao inserir em pedido_assignments: " . $e->getMessage());
    }
    
    $conn->commit();
    
    echo json_encode(['success' => true, 'message' => 'Pedido recusado com sucesso']);
    
} catch (Exception $e) {
    if (isset($conn)) {
        $conn->rollBack();
    }
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>