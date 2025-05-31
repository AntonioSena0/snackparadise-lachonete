<?php
session_start();
session_destroy();
header("Location: ../../Tela de login"); // Redireciona para a página de login
exit();
?>