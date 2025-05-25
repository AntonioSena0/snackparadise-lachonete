<?php
include_once 'Conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Criptografa a senha

    try {
        $conn = Conectar::getInstance();
        $sql = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $sql->bindParam(':username', $username);
        $sql->bindParam(':email', $email);
        $sql->bindParam(':password', $password);
        $sql->execute();

        session_start();
        $_SESSION['user'] = ['username' => $username, 'email' => $email]; // Armazena os dados na sessão
        header("Location: Conta.php"); // Redireciona para a página Conta.php
        exit();
    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
}
?>