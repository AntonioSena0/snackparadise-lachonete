<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../Tela de login/index.html");
    exit();
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Conta do Usuário</title>
    <link rel="stylesheet" href="Conta.css">
</head>
<body>
    <div class="container">
        <img src="<?php echo isset($user['profile_picture']) ? $user['profile_picture'] : 'default-profile.png'; ?>" alt="Foto de Perfil" class="profile-picture">
        <h1>Bem-vindo, <?php echo htmlspecialchars($user['username']); ?>!</h1>
        <p><strong>E-mail:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p class="status"><strong>Status:</strong> <?php echo isset($user['partner']) && $user['partner'] ? 'Parceiro' : 'Não é parceiro'; ?></p>
        <a href="logout.php" class="btn-voltar">Sair</a>
        <div class="upload-section">
            <form method="POST" action="upload.php" enctype="multipart/form-data">
                <input type="file" id="profilePicture" name="profilePicture">
                <label for="profilePicture">Alterar Foto</label>
                <button type="submit" class="btn-voltar">Salvar</button>
            </form>
        </div>
    </div>
</body>
</html>