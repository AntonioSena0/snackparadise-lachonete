
<?php
include_once __DIR__ . '/../config/Conexao.php';
session_start();

$data = json_decode(file_get_contents('php://input'), true);

$pedido_id = $data['pedido_id'] ?? null;
$motoboy_id = $_SESSION['motoboy']['id'] ?? null;

if (!$pedido_id || !$motoboy_id) {
    http_response_code(400);
    echo "Dados incompletos.";
    exit();
}

try {
    $conn = Conectar::getInstance();

    // Busca dados do pedido
    $sqlPedido = $conn->prepare("SELECT * FROM pedidos WHERE id = :id");
    $sqlPedido->bindParam(':id', $pedido_id);
    $sqlPedido->execute();
    $pedido = $sqlPedido->fetch(PDO::FETCH_ASSOC);

    if (!$pedido) {
        http_response_code(404);
        echo "Pedido não encontrado.";
        exit();
    }

    // Busca id do cliente pelo email
    $sqlCliente = $conn->prepare("SELECT id FROM users WHERE email = :email");
    $sqlCliente->bindParam(':email', $pedido['usuario_email']);
    $sqlCliente->execute();
    $cliente = $sqlCliente->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) {
        http_response_code(404);
        echo "Cliente não encontrado.";
        exit();
    }

    // Insere na tabela registro
    $sqlRegistro = $conn->prepare("INSERT INTO registro (pedido_id, cliente_id, motoboy_id, itens, endereco, pagamento, confirmar) VALUES (:pedido_id, :cliente_id, :motoboy_id, :itens, :endereco, :pagamento, 1)");
    $sqlRegistro->bindParam(':pedido_id', $pedido_id);
    $sqlRegistro->bindParam(':cliente_id', $cliente['id']);
    $sqlRegistro->bindParam(':motoboy_id', $motoboy_id);
    $sqlRegistro->bindParam(':itens', $pedido['itens']);
    $sqlRegistro->bindParam(':endereco', $pedido['endereco']);
    $sqlRegistro->bindParam(':pagamento', $pedido['pagamento']);
    $sqlRegistro->execute();

    echo "Registro criado!";
} catch (PDOException $e) {
    http_response_code(500);
    echo "Erro: " . $e->getMessage();
}
?>