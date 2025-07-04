<?php
include_once __DIR__ . '/../config/Conexao.php';

header('Content-Type: application/json');

try {
    $conn = Conectar::getInstance();
    $sql = $conn->prepare("SELECT id, usuario_email, itens, endereco, pagamento, criado_em FROM pedidos ORDER BY criado_em DESC");
    $sql->execute();
    $pedidos = $sql->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($pedidos);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => $e->getMessage()]);
}
?>