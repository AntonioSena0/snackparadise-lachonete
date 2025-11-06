<?php
// backend/controllers/admin_delete_duvida.php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../../frontend/CadAdmin/index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../frontend/Admin/duvidas.php?error=Metodo+invalido');
    exit();
}

$duvidaId = intval($_POST['duvida_id'] ?? 0);
if ($duvidaId <= 0) {
    header('Location: ../../frontend/Admin/duvidas.php?error=ID+inválido');
    exit();
}

include_once __DIR__ . '/../config/DatabaseManager.php';
$db = new DatabaseManager();
$success = $db->deleteDuvida($duvidaId);

if ($success) {
    header('Location: ../../frontend/Admin/duvidas.php?success=1');
} else {
    header('Location: ../../frontend/Admin/duvidas.php?error=Falha+ao+excluir');
}
exit();
