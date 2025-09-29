<?php
session_start();
session_destroy();
header("Location: ../../frontend/Tela de login/cadastrar_motoboy.php"); // Redireciona para a página de login
exit();
?>