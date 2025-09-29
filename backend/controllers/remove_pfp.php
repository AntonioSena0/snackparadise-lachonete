<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../frontend/Tela de login/index.php");
    exit();
}

include_once '../config/Conexao.php';

$userId = $_SESSION['user']['id'];

try {
    $conn = Conectar::getInstance();

    $defaultPfp = '../views/uploads/Default_pfp.png';

    // atualiza no banco
    $sql = $conn->prepare("UPDATE users SET profile_picture = :pfp WHERE id = :id");
    $sql->bindParam(':pfp', $defaultPfp);
    $sql->bindParam(':id', $userId);
    $sql->execute();

    // atualiza na sessão
    $_SESSION['user']['profile_picture'] = $defaultPfp;

    header("Location: ../views/Conta.php");
    exit();
} catch (Exception $e) {
    error_log("Erro ao remover foto: " . $e->getMessage());
    $_SESSION['error'] = "Não foi possível remover a foto.";
    header("Location: Conta.php");
    exit();
}
?>
