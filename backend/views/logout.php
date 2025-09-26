<?php
session_start();
session_destroy();
header("Location: ../../frontend/Tela de login"); // Redireciona para a página de login
exit();
?>