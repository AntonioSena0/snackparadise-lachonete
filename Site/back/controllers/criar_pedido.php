<?php
include_once __DIR__ . '/../config/Conexao.php';
session_start();

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400);
    echo "Dados inválidos.";
    exit();
}

$email = $data['email'] ?? 'visitante';
$itens = json_encode($data['pedidos'] ?? []);
$endereco = $data['endereco'] ?? '';
$pagamento = $data['pagamento'] ?? '';

try {
    $conn = Conectar::getInstance();
    $sql = $conn->prepare("INSERT INTO pedidos (usuario_email, itens, endereco, pagamento) VALUES (:email, :itens, :endereco, :pagamento)");
    $sql->bindParam(':email', $email);
    $sql->bindParam(':itens', $itens);
    $sql->bindParam(':endereco', $endereco);
    $sql->bindParam(':pagamento', $pagamento);
    $sql->execute();

    echo "Pedido registrado!";
} catch (PDOException $e) {
    http_response_code(500);
    echo "Erro ao registrar pedido: " . $e->getMessage();
}
?>