<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../Tela de login/index.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profilePicture'])) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = uniqid() . "_" . basename($_FILES['profilePicture']['name']); // Prevent overwriting files
    $targetFile = $targetDir . $fileName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Tenta fazer o upload do arquivo
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetFile)) {
            $_SESSION['user']['profile_picture'] = $targetFile;
            header("Location: Conta.php");
            exit();
        } else {
            echo "Erro ao fazer upload do arquivo.";
        }
    }
}
?>