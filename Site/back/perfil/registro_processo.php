<?php
include_once 'Conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['senha'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografa a senha
    
        try {
            $conn = Conectar::getInstance();
            $sql = $conn->prepare("INSERT INTO users (username, email, senha) VALUES (:username, :email, :senha)");
            $sql->bindParam(':username', $username);
            $sql->bindParam(':email', $email);
            $sql->bindParam(':senha', $password);
            $sql->execute();
    
            session_start();
            $_SESSION['user'] = ['username' => $username, 'email' => $email]; // Armazena os dados na sessão
            header("Location: Conta.php"); // Redireciona para a página Conta.php
            exit();
        } catch (PDOException $e) {
            echo "Erro ao cadastrar: " . $e->getMessage();
        }
    } else {
        echo "Dados inválidos.";
        exit();
    }

}
?>