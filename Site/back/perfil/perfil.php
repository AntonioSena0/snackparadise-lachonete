<?php
include 'db.php';

header('Content-Type: application/json');

$headers = getallheaders();
$token = $headers['Authorization'] ?? '';

if (!$token) {
    echo json_encode(['message' => 'Token não fornecido!']);
    exit;
}

$decoded = json_decode(base64_decode($token), true);

if (!isset($decoded['id'], $decoded['exp']) || $decoded['exp'] < time()) {
    echo json_encode(['message' => 'Token inválido ou expirado!']);
    exit;
}

$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $decoded['id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(['message' => 'Usuário não encontrado!']);
}

$stmt->close();
$conn->close();
?>