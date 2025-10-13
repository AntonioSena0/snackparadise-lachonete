<?php
include_once __DIR__ . '/../config/Conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    try {
        $conn = Conectar::getInstance();
        if (!$conn) {
            throw new Exception("Falha ao conectar ao banco de dados.");
        }

        // Busca admin por username
        $sqlAdmin = $conn->prepare("SELECT id, username, email, senha FROM admins WHERE username = :username");
        $sqlAdmin->bindParam(':username', $username);
        $sqlAdmin->execute();
        $admin = $sqlAdmin->fetch(PDO::FETCH_ASSOC);

        // Se a senha estiver em texto puro, troque para: if ($admin && $password === $admin['senha'])
        if ($admin && (password_verify($password, $admin['senha']) || $password === $admin['senha'])) {
            session_regenerate_id(true);
            $_SESSION['admin'] = [
                'id' => $admin['id'],
                'username' => $admin['username'],
                'email' => $admin['email']
            ];
            header("Location: ../../frontend/Admin/pedidos.php");
            exit();
        }

        $_SESSION['login_error'] = "Usuário ou senha inválidos.";
        header("Location: ../../frontend/CadAdmin/index.php");
        exit();
    } catch (Exception $e) {
        error_log("Erro ao conectar ou autenticar: " . $e->getMessage());
        $_SESSION['login_error'] = "Não foi possível processar sua solicitação no momento. Tente novamente mais tarde.";
        header("Location: ../../frontend/CadAdmin/index.php");
        exit();
    }
}
?>