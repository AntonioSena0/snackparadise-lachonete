
<?php
include_once __DIR__ . '/../config/Conexao.php';

$data = json_decode(file_get_contents('php://input'), true);

$cliente_id = $data['cliente_id'] ?? null;
$motoboy_id = $data['motoboy_id'] ?? null; // Pode ser null inicialmente
$itens = json_encode($data['itens'] ?? []);
$endereco = $data['endereco'] ?? '';
$pagamento = $data['pagamento'] ?? '';

if (!$cliente_id || !$itens || !$endereco || !$pagamento) {
    http_response_code(400);
    echo "Dados incompletos.";
    exit();
}

try {
    $conn = Conectar::getInstance();
    $sql = $conn->prepare("INSERT INTO registro (cliente_id, motoboy_id, itens, endereco, pagamento) VALUES (:cliente_id, :motoboy_id, :itens, :endereco, :pagamento)");
    $sql->bindParam(':cliente_id', $cliente_id);
    $sql->bindParam(':motoboy_id', $motoboy_id);
    $sql->bindParam(':itens', $itens);
    $sql->bindParam(':endereco', $endereco);
    $sql->bindParam(':pagamento', $pagamento);
    $sql->execute();

    echo "Registro criado!";
} catch (PDOException $e) {
    http_response_code(500);
    echo "Erro: " . $e->getMessage();
}
?>