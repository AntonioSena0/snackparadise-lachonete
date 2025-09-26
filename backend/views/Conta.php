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
        <li class="list-menu1">
            <button id="btn-cardapio">&darr;Cardápio</button>
            <div class="submenu" id="submenu">
                <a href="../Cardápio/index.html" target="_self"><button>Hamburgueres</button></a>
                <hr>
                <a href="#" target="_self"><button>Acompanhamentos</button></a>
                <hr>
                <a href="#" target="_self"><button>Bebidas</button></a>
            </div>
        </li>
                <li class="list-menu1"><a href="#">Promoções</a></li>
                <li class="list-menu1"><a href="#">Pedidos</a></li>
                <li class="list-menu1"><a href="#">App SP</a></li>
        </ul>
        </nav>

        <div class="btn-conta">
          <a href="Conta.php">
            <button id="btn-conta" class="conta">Conta</button>
          </a>
        </div>
                </div><!--btn-conta-->

            </div><!--Flex-->

        </div><!--container-->

</header><!--header-->
    <div class="container">
        <img src="<?php echo isset($user['profile_picture']) && file_exists($user['profile_picture']) ? $user['profile_picture'] : 'default-profile.png'; ?>" alt="Foto de Perfil" class="profile-picture">
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
        </div>
    </div>
</body>
</html>