<?php
include_once __DIR__ . '/../config/Conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['senha'])) {
        // User registration
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        try {
            $conn = Conectar::getInstance();
            $sql = $conn->prepare("INSERT INTO users (username, email, senha) VALUES (:username, :email, :senha)");
            $sql->bindParam(':username', $username);
            $sql->bindParam(':email', $email);
            $sql->bindParam(':senha', $password);
            $sql->execute();

            session_start();
            $_SESSION['user'] = ['username' => $username, 'email' => $email];
            header("Location: ../views/Conta.php");
            exit();
        } catch (PDOException $e) {
            echo "Erro ao cadastrar: " . $e->getMessage();
        }
    } elseif (isset($_POST['motoboy_name']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['vehicle_type']) && isset($_POST['license_plate'])) {
        // Motoboy registration
        $motoboyName = $_POST['motoboy_name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $vehicleType = $_POST['vehicle_type'];
        $licensePlate = $_POST['license_plate'];

        try {
            $conn = Conectar::getInstance();
            $sql = $conn->prepare("INSERT INTO motoboys (name, email, senha, vehicle_type, license_plate) VALUES (:name, :email, :senha, :vehicle_type, :license_plate)");
            $sql->bindParam(':name', $motoboyName);
            $sql->bindParam(':email', $email);
            $sql->bindParam(':senha', $password);
            $sql->bindParam(':vehicle_type', $vehicleType);
            $sql->bindParam(':license_plate', $licensePlate);
            $sql->execute();

            echo "Motoboy cadastrado com sucesso!";
            header("Location: ../views/Conta.php");
            exit();
        } catch (PDOException $e) {
            echo "Erro ao cadastrar motoboy: " . $e->getMessage();
        }
    } else {
        echo "Dados inválidos.";
        exit();
    }
}
?>