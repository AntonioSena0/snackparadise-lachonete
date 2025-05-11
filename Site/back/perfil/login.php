<?php
include 'db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['email'], $data['password'])) {
    echo json_encode(['message' => 'Dados incompletos!']);
    exit;
}

$email = filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL);
$password = trim($data['password']);

if (!$email) {
    echo json_encode(['message' => 'E-mail inválido!']);
    exit;
}

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $token = base64_encode(json_encode(['id' => $user['id'], 'exp' => time() + 3600]));
        echo json_encode(['token' => $token, 'user' => ['username' => $user['username'], 'email' => $user['email']]]);
    } else {
        echo json_encode(['message' => 'Senha incorreta!']);
    }
} else {
    echo json_encode(['message' => 'Usuário não encontrado!']);
}

$stmt->close();
$conn->close();
?>