<?php
include 'db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['username'], $data['email'], $data['password'])) {
    echo json_encode(['message' => 'Dados incompletos!']);
    exit;
}

$username = trim($data['username']);
$email = filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL);
$password = trim($data['password']);

if (!$email) {
    echo json_encode(['message' => 'E-mail inválido!']);
    exit;
}

$passwordHash = password_hash($password, PASSWORD_BCRYPT);

$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $username, $email, $passwordHash);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Usuário cadastrado com sucesso!']);
} else {
    echo json_encode(['message' => 'Erro ao cadastrar usuário: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>