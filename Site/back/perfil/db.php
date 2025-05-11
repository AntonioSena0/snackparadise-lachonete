<?php
$host = 'localhost';
$user = 'root';
$password = ''; // Insira sua senha do MariaDB
$database = 'snack_paradise';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
}

$conn->set_charset('utf8mb4');
?>