<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../Tela de login/index.html");
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

    // Verifica se o arquivo é uma imagem
    $check = getimagesize($_FILES['profilePicture']['tmp_name']);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "O arquivo não é uma imagem.";
        $uploadOk = 0;
    }


    // Permite apenas certos formatos de arquivo
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Apenas arquivos JPG, JPEG e PNG são permitidos.";
        $uploadOk = 0;
    }

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
            header("Location: Conta.php");
            exit();
        } else {
            echo "Erro ao fazer upload do arquivo.";
        }
    }
}
?>