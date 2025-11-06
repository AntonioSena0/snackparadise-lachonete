<?php
// backend/controllers/admin_reply_duvida.php
if (session_status() === PHP_SESSION_NONE) session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../frontend/Admin/duvidas.php?error=Metodo+invalido');
    exit();
}

if (empty($_SESSION['admin'])) {
    header('Location: ../../frontend/CadAdmin/index.php');
    exit();
}

$duvidaId = intval($_POST['duvida_id'] ?? 0);
$resposta = trim($_POST['resposta'] ?? '');

if ($duvidaId <= 0 || $resposta === '') {
    header('Location: ../../frontend/Admin/duvidas.php?error=Dados+inválidos');
    exit();
}

require_once __DIR__ . '/../config/DatabaseManager.php';
$db = new DatabaseManager();

// Recuperar dúvida para obter email (se houver)
$duvida = $db->getDuvidaById($duvidaId);
if (!$duvida) {
    header('Location: ../../frontend/Admin/duvidas.php?error=Dúvida+não+encontrada');
    exit();
}

$ok = $db->replyDuvida($duvidaId, $resposta);

if ($ok) {
    // Tentar notificar por e-mail (se configurado) — não falhar se mail() não estiver configurado
    if (!empty($duvida['email'])) {
        $to = $duvida['email'];
        $subject = "Resposta à sua dúvida - Snack Paradise";
        $message = "Olá " . ($duvida['nome'] ?? '') . ",\n\n";
        $message .= "Recebemos sua dúvida:\n" . strip_tags($duvida['mensagem']) . "\n\n";
        $message .= "Resposta do suporte:\n" . strip_tags($resposta) . "\n\n";
        $message .= "Se preferir, acesse sua conta para ver as respostas em: http://localhost/site/frontend/Duvidas/index.php\n\n";
        $headers = 'From: no-reply@localhost' . "\r\n" . 'Reply-To: no-reply@localhost' . "\r\n";
        @mail($to, $subject, $message, $headers);
    }

    header('Location: ../../frontend/Admin/duvidas.php?success=Resposta+enviada');
    exit();
} else {
    header('Location: ../../frontend/Admin/duvidas.php?error=Falha+ao+salvar+resposta');
    exit();
}
