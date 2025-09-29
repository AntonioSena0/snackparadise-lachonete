<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../frontend/Tela de login/index.php");
    exit();
}

include_once '../config/Conexao.php';

$userId = $_SESSION['user']['id'];
$targetDir = "uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // botão remover
    if (isset($_POST['remove'])) {
        $defaultPfp = $targetDir . "Default_pfp.png";
        try {
            $conn = Conectar::getInstance();
            $sql = $conn->prepare("UPDATE users SET profile_picture = :pfp WHERE id = :id");
            $sql->bindParam(':pfp', $defaultPfp);
            $sql->bindParam(':id', $userId);
            $sql->execute();

            $_SESSION['user']['profile_picture'] = $defaultPfp;
            header("Location: Conta.php");
            exit();
        } catch (Exception $e) {
            error_log("Erro ao remover foto: " . $e->getMessage());
            exit("Erro ao remover foto");
        }
    }

    // upload de nova foto
    if (isset($_FILES['profilePicture'])) {
        $fileName = uniqid() . "_" . basename($_FILES['profilePicture']['name']);
        $targetFile = $targetDir . $fileName;
        if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetFile)) {
            try {
                $conn = Conectar::getInstance();
                $sql = $conn->prepare("UPDATE users SET profile_picture = :pfp WHERE id = :id");
                $sql->bindParam(':pfp', $targetFile);
                $sql->bindParam(':id', $userId);
                $sql->execute();

                $_SESSION['user']['profile_picture'] = $targetFile;
                header("Location: Conta.php");
                exit();
            } catch (Exception $e) {
                error_log("Erro ao atualizar foto no banco: " . $e->getMessage());
                exit("Erro ao atualizar foto no banco");
            }
        } else {
            exit("Erro ao fazer upload do arquivo");
        }
    }
}
?>
