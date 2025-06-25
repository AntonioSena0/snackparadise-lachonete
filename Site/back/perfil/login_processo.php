<?php
include_once __DIR__ . '/../config/Conexao.php';

session_start(); // iniciar sessão no começo do arquivo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    try {
        $conn = Conectar::getInstance();
        if (!$conn) {
            throw new Exception("Falha ao conectar ao banco de dados.");
        }

        $sql = $conn->prepare("SELECT id, username, email, senha, profile_picture, partner FROM users WHERE email = :email");
        $sql->bindParam(':email', $email);
        $sql->execute();
        $user = $sql->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['senha'])) {
            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'profile_picture' => $user['profile_picture'] ?? null,
                'partner' => $user['partner'] ?? false
            ]; // Store only necessary user data in the session

            header("Location: ../views/Conta.php");
            exit();
        } else {
            $_SESSION['login_error'] = "E-mail ou senha inválidos.";
            header("Location: ../views/Conta.php");
            exit();
        }
    } catch (Exception $e) {
        error_log("Erro ao conectar ou autenticar: " . $e->getMessage()); // Log the error
        $_SESSION['login_error'] = "Não foi possível processar sua solicitação no momento. Tente novamente mais tarde.";
        header("Location: ../views/Conta.php");
        exit();
    }
}
?>
