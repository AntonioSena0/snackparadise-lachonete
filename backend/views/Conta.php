<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../frontend/Tela de login/index.php");
    exit();
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Conta do Usuário</title>
    <link rel="stylesheet" href="../public/Conta.css">
</head>
<body>
<header id="header">
  <div class="container2">
    <div class="flex">
      <a href="../Menu/index.html">
        <div class="flex">
        </div>
      </a>

    <div class="header-right">
        <nav>
                    <ul>
                        <li class="list-menu2">
                            <button class="btn-ativação" id="btn-ativação">☰</button>
                            <div class="barralateral" id="barralateral">
                                <a href="index.html" target="_self">Início</a>
                                <a href="#" target="_self">Perfil</a>
                                <a href="#" target="_self">Pontos</a>
                                <a href="#" target="_self">Seja Parceiro</a>
                                <a href="#" target="_self">Avaliações</a>
                                <a href="../Quem somos/index.html" target="_self">Sobre nós</a>
                                <a href="../Auxílio Preferencial/auxilio.html" target="_self">Auxílio Preferencial</a>
                            </div>
                        </li>
                        <li class="list-menu1">
                            <a href="../../frontend/Cardápio/index.php" target="_self">Cardápio</a>
                        </li>
                        <li class="list-menu1">
                            <a href="#" target="_self">Promoções</a>
                        </li>
                        <li class="list-menu1">
                            <a href="#" target="_self">Pedidos</a>
                        </li>
                        <li class="list-menu1">
                            <a href="#" target="_self">App SP</a>
                        </li>
                    </ul>
                </nav>


            </div><!--Flex-->

        </div><!--container-->

</header><!--header-->
    <div class="container">
        <img src="<?php echo isset($user['profile_picture']) && file_exists($user['profile_picture']) ? $user['profile_picture'] : 'uploads/Default_pfp.png'; ?>" alt="Foto de Perfil" class="profile-picture">
        <h1>Bem-vindo, <?php echo htmlspecialchars($user['username']); ?>!</h1>
        <p><strong>E-mail:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p class="status"><strong>Status:</strong> <?php echo isset($user['partner']) && $user['partner'] ? 'Parceiro' : 'Não é parceiro'; ?></p>   
        <a href="logout.php" class="btn-voltar">Sair</a>
        <div class="upload-section">
            <form method="POST" action="upload.php" enctype="multipart/form-data">
                <input type="file" id="profilePicture" name="profilePicture" accept="image/png, image/jpeg">
                <label for="profilePicture">Alterar Foto</label>
                <button type="submit" class="btn-voltar">Salvar</button>
            </form>
                <form method="POST" action="../controllers/remove_pfp.php">
                    <button type="submit" class="btn-remover">Remover</button>
                </form>
        </div>
    </div>
    <div class="container">
        <h1>aqui ficao as coisas qo usuario interage tipo</h1><br>
        <label for="email">Email</label>
        <form method="POST" action="">
        <input type="text" name="emaildaora" value=<?php echo $user['email'] ?>></input>
        <button type="submit" name="altemail">Alterar Email</input>
        </form>
    </div>
    <script src="../public/Conta.js"></script>

    <?php
    extract($_POST, EXTR_OVERWRITE);
    if(isset($altemail)) {
    require_once 'Registro.php';
    $userObj = new Registro();
    $userObj->setId($_SESSION['user']['id']);
    $userObj->setEmail($_POST['emaildaora']);
    $userObj->editaremail();

    // atualizar a sessão
    $_SESSION['user']['email'] = $_POST['emaildaora'];

    header("Location: Conta.php");
    exit;
}
    ?>
</body>
</html>