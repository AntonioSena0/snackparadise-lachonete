<?php
session_start();
include_once __DIR__ . '/../config/Conexao.php';
include_once __DIR__ . '/../config/DatabaseManager.php';

if (!isset($_SESSION['motoboy']) || !isset($_SESSION['motoboy']['id'])) {
    header('Location: ../../frontend/Tela de Login/cadastrar_motoboy.php');
    exit();
}

$motoboyId = $_SESSION['motoboy']['id'];
try {
    $db = new DatabaseManager();
    $current = $db->getMotoboyById($motoboyId);
    if (!$current) {
        $msg = urlencode('Motoboy não encontrado');
        header('Location: ../../frontend/PerfilMotoboy/index.php?error=' . $msg);
        exit();
    }

    $newStatus = ($current['status'] === 'disponivel') ? 'offline' : 'disponivel';
    $ok = $db->updateMotoboyStatus($motoboyId, $newStatus);
    if ($ok) {
        $msg = urlencode('Status atualizado para ' . $newStatus);
        header('Location: ../../frontend/PerfilMotoboy/index.php?success=' . $msg);
        exit();
    } else {
        $msg = urlencode('Falha ao atualizar status');
        header('Location: ../../frontend/PerfilMotoboy/index.php?error=' . $msg);
        exit();
    }
} catch (Exception $e) {
    $msg = urlencode('Erro: ' . $e->getMessage());
    header('Location: ../../frontend/PerfilMotoboy/index.php?error=' . $msg);
    exit();
}

?>
