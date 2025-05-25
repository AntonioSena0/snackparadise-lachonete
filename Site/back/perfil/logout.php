<?php
session_start();
session_destroy();
header("Location: login.html"); // Redireciona para a página de login
exit();
?>