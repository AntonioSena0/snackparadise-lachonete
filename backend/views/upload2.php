<?php
include_once "../config/Conexao.php";
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../frontend/Tela de login/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profilePicture'])) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Ensure the uploads directory exists
    }

    $fileName = uniqid() . "_" . basename($_FILES['profilePicture']['name']); // Prevent overwriting files
    $targetFile = $targetDir . $fileName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    // Tenta fazer o upload do arquivo
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetFile)) {
            // Após upload bem-sucedido
            $conn = Conectar::getInstance();
            $sql = $conn->prepare("UPDATE users SET profile_picture = :profile_picture WHERE id = :id");
            $sql->bindParam(':profile_picture', $targetFile);
            $sql->bindParam(':id', $_SESSION['user']['id']);
            $sql->execute();
            $_SESSION['user']['profile_picture'] = $targetFile;
            header("Location: ../../frontend/PerfilUser/index.php");
            exit();
        } else {
            echo "Erro ao fazer upload do arquivo.";
        }
    }
}
?>