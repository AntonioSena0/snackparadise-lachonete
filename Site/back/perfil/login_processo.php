<?php
include_once 'Conexao.php';

session_start(); // iniciar sessão no começo do arquivo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $conn = Conectar::getInstance();
        $sql = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $sql->bindParam(':email', $email);
        $sql->execute();
        $user = $sql->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['senha'])) {
            $_SESSION['user'] = $user; // Armazena os dados do usuário na sessão
            header("Location: Conta.php"); // Redireciona para a página Conta.php
            exit();
        } else {
            echo "E-mail ou senha inválidos.";
        }
    } catch (PDOException $e) {
        echo "Erro ao autenticar: " . $e->getMessage();
    }
}
?>
