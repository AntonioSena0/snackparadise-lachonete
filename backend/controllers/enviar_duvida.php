<?php
// backend/controllers/enviar_duvida.php
// Recebe POST de dúvidas do usuário e salva em um arquivo CSV em backend/duvidas/

if (session_status() === PHP_SESSION_NONE) session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../frontend/Duvidas/index.php?error=Metodo+invalido');
    exit();
}

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

if ($nome === '' || $email === '' || $mensagem === '') {
    header('Location: ../../frontend/Duvidas/index.php?error=Preencha+todos+os+campos');
    exit();
}

// Sanitizar campos básicos
$nomeSafe = filter_var($nome, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$emailSafe = filter_var($email, FILTER_SANITIZE_EMAIL);
$mensagemSafe = trim($mensagem);

// Tentar inserir no banco de dados; caso falhe, escrever no CSV como fallback
try {
    require_once __DIR__ . '/../config/Conexao.php';
    $pdo = Conectar::getInstance();

    $sql = "INSERT INTO duvidas (usuario_id, nome, email, mensagem) VALUES (:usuario_id, :nome, :email, :mensagem)";
    $stmt = $pdo->prepare($sql);

    $usuarioId = $_SESSION['user']['id'] ?? null;
    if ($usuarioId === null) {
        $stmt->bindValue(':usuario_id', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindValue(':usuario_id', (int)$usuarioId, PDO::PARAM_INT);
    }
    $stmt->bindValue(':nome', $nomeSafe, PDO::PARAM_STR);
    $stmt->bindValue(':email', $emailSafe, PDO::PARAM_STR);
    $stmt->bindValue(':mensagem', $mensagemSafe, PDO::PARAM_STR);

    $stmt->execute();

    header('Location: ../../frontend/Duvidas/index.php?success=1');
    exit();

} catch (Exception $e) {
    // Log do erro e fallback para CSV
    error_log('Erro ao inserir dúvida no DB: ' . $e->getMessage());

    $dir = __DIR__ . '/../duvidas';
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    $file = $dir . '/submissions.csv';

    $fp = fopen($file, 'a');
    if ($fp) {
        $record = [date('Y-m-d H:i:s'), $usuarioId ?? '', $nomeSafe, $emailSafe, str_replace(["\r", "\n"], [' ', ' '], $mensagemSafe)];
        fputcsv($fp, $record);
        fclose($fp);
        header('Location: ../../frontend/Duvidas/index.php?success=1');
        exit();
    }

    header('Location: ../../frontend/Duvidas/index.php?error=Falha+ao+salvar+a+duvida');
    exit();
}
