<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../Tela de login/index.html"); // agora ta redirecionando certo, antes tava procurando a pasta 'Tela de login' dentro da pasta 'back', que dava um erro
    exit();
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Conta do Usuário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Bem-vindo, <?php echo htmlspecialchars($user['username']); ?>!</h1>
        <p><strong>E-mail:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <a href="logout.php" class="btn-voltar">Sair</a>
    </div>
</body>
</html>