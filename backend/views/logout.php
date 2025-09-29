<?php
session_start();
session_destroy();
header("Location: ../../frontend/Tela de login/index.php");
exit();
?>