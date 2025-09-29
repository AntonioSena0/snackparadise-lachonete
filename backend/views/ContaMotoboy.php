<?php
session_start();

if (!isset($_SESSION['motoboy'])) {
    header("Location: ../../frontend/Tela de login/cadastrar_motoboy.php");
    exit();
}

$motoboy = $_SESSION['motoboy'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Conta do Motoboy</title>
    <link rel="stylesheet" href="../public/Conta.css">
</head>
<body>
    <div class="container">
        <img src="<?php echo isset($motoboy['profile_picture']) && file_exists($motoboy['profile_picture']) ? $motoboy['profile_picture'] : 'default-profile.png'; ?>" alt="Foto de Perfil" class="profile-picture">
        <h1>Bem-vindo, <?php echo htmlspecialchars($motoboy['name']); ?>!</h1>
        <p><strong>E-mail:</strong> <?php echo htmlspecialchars($motoboy['email']); ?></p>
        <p><strong>Tipo de Veículo:</strong> <?php echo htmlspecialchars($motoboy['vehicle_type']); ?></p>
        <p><strong>Placa:</strong> <?php echo htmlspecialchars($motoboy['license_plate']); ?></p>
        <a href="../controllers/logout.php" class="btn-voltar">Sair</a>
        <div class="upload-section">
            <form method="POST" action="upload.php" enctype="multipart/form-data">
                <input type="file" id="profilePicture" name="profilePicture">
                <label for="profilePicture">Alterar Foto</label>
                <button type="submit" class="btn-voltar">Salvar</button>
            </form>
        </div>
        <div class="motoboy-actions">
            <h2>Minhas Entregas</h2>
            <!-- Aqui pode ser listado as entregas do motoboy -->
            <p>Você ainda não possui entregas cadastradas.</p>
            <a href="#" class="btn-voltar">Ver histórico</a>
        </div>
    </div>
</body>
</html>
