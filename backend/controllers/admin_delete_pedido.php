<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../../frontend/CadAdmin/index.php');
    exit();
}

include_once __DIR__ . '/../config/DatabaseManager.php';

$pedido_id = $_POST['pedido_id'] ?? null;

if (!$pedido_id || !is_numeric($pedido_id)) {
    header('Location: ../../frontend/Admin/pedidos.php?error=ID inválido');
    exit();
}

$db = new DatabaseManager();

try {
    $db->beginTransaction();

    // Tentar extrair lista de tabelas a partir do arquivo SQL em backend/sql/snack.sql
    $tablesFromSql = [];
    $sqlFile = __DIR__ . '/../sql/snack.sql';
    if (file_exists($sqlFile) && is_readable($sqlFile)) {
        $content = file_get_contents($sqlFile);
        if ($content !== false) {
            if (preg_match_all('/CREATE TABLE `([^`]+)`/i', $content, $matches)) {
                $tablesFromSql = array_map('strtolower', $matches[1]);
            }
        }
    }

    // Fallback: função que checa information_schema caso o arquivo SQL não exista
    $tableExistsInfo = function($tableName) use ($db) {
        $sql = "SELECT COUNT(*) as cnt FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = :t";
        $st = $db->prepare($sql);
        $st->bindParam(':t', $tableName);
        $st->execute();
        $r = $st->fetch(PDO::FETCH_ASSOC);
        return ($r && intval($r['cnt']) > 0);
    };

    // Helper final: verifica se a tabela está listada no SQL (preferência) ou no information_schema
    $tableExists = function($tableName) use ($tablesFromSql, $tableExistsInfo) {
        $t = strtolower($tableName);
        if (!empty($tablesFromSql)) {
            return in_array($t, $tablesFromSql, true);
        }
        return $tableExistsInfo($tableName);
    };

    // Remover assignments (se existir a tabela)
    if ($tableExists('pedido_assignments')) {
        $sql = "DELETE FROM pedido_assignments WHERE pedido_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $pedido_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Remover registro (se existir)
    if ($tableExists('registro')) {
        $sql = "DELETE FROM registro WHERE pedido_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $pedido_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Remover reviews (se existir)
    if ($tableExists('reviews')) {
        $sql = "DELETE FROM reviews WHERE pedido_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $pedido_id, PDO::PARAM_INT);
        $stmt->execute();
    }
    // Remover itens do pedido (se existir)
    if ($tableExists('pedido_itens')) {
        $sql = "DELETE FROM pedido_itens WHERE pedido_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $pedido_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Por fim, remover o pedido (verifica se a tabela existe)
    if ($tableExists('pedidos')) {
        $sql = "DELETE FROM pedidos WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $pedido_id, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        throw new Exception('Tabela pedidos não encontrada no banco.');
    }

    $db->commit();
    header('Location: ../../frontend/Admin/pedidos.php?success=Pedido excluído');
    exit();
} catch (Exception $e) {
    try { $db->rollBack(); } catch (Exception $ex) {}
    error_log('Erro admin_delete_pedido: ' . $e->getMessage());
    $msg = urlencode('Falha ao excluir pedido: ' . $e->getMessage());
    header('Location: ../../frontend/Admin/pedidos.php?error=' . $msg);
    exit();
}

?>
