<?php
require_once '../config/Conectar.php';
session_start();

if (!isset($_SESSION['user']['id'])) {
    http_response_code(401);
    echo "Usuário não autenticado.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pedido_id = $_POST['pedido_id'] ?? null;
    $motoboy_id = $_POST['motoboy_id'] ?? null;
    $nota = $_POST['nota'] ?? null;
    $comentario = $_POST['comentario'] ?? '';

    // Validação simples
    if (!$pedido_id || !$motoboy_id || !$nota || $nota < 1 || $nota > 5) {
        http_response_code(400);
        echo "Dados inválidos.";
        exit();
    }

    $usuario_id = $_SESSION['user']['id'];

    try {
        $conn = Conectar::getInstance();
        $sql = $conn->prepare("INSERT INTO reviews (pedido_id, motoboy_id, usuario_id, nota, comentario) 
                               VALUES (:pedido_id, :motoboy_id, :usuario_id, :nota, :comentario)");
        $sql->bindParam(':pedido_id', $pedido_id);
        $sql->bindParam(':motoboy_id', $motoboy_id);
        $sql->bindParam(':usuario_id', $usuario_id);
        $sql->bindParam(':nota', $nota);
        $sql->bindParam(':comentario', $comentario);
        $sql->execute();

        echo "Avaliação registrada com sucesso!";
        exit();
    } catch (PDOException $e) {
        http_response_code(500);
        echo "Erro ao registrar avaliação: " . $e->getMessage();
        exit();
    }
}
?>

<!-- Formulário HTML (exibido apenas se não for POST) -->
<form method="POST" action="criar_review.php">
    <input type="hidden" name="pedido_id" value="<?php echo htmlspecialchars($_GET['pedido_id'] ?? ''); ?>">
    <input type="hidden" name="motoboy_id" value="<?php echo htmlspecialchars($_GET['motoboy_id'] ?? ''); ?>">

    <label for="nota">Nota (1 a 5):</label>
    <select name="nota" id="nota" required>
        <option value="">Selecione</option>
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php endfor; ?>
    </select>
    <br>

    <label for="comentario">Comentário:</label>
    <textarea name="comentario" id="comentario" rows="4" cols="40"></textarea>
    <br>

    <button type="submit">Enviar Avaliação</button>
</form>
