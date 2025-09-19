<?php
include_once __DIR__ . '/../config/Conexao.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    try {
        $conn = Conectar::getInstance();
        if (!$conn) {
            throw new Exception("Falha ao conectar ao banco de dados.");
        }

        // Verifica se é motoboy
        $sqlMotoboy = $conn->prepare("SELECT id, name, email, senha, profile_picture, vehicle_type, license_plate FROM motoboys WHERE email = :email");
        $sqlMotoboy->bindParam(':email', $email);
        $sqlMotoboy->execute();
        $motoboy = $sqlMotoboy->fetch(PDO::FETCH_ASSOC);

        if ($motoboy && password_verify($password, $motoboy['senha'])) {
            session_regenerate_id(true);
            $_SESSION['motoboy'] = [
                'id' => $motoboy['id'],
                'name' => $motoboy['name'],
                'email' => $motoboy['email'],
                'profile_picture' => $motoboy['profile_picture'] ?? null,
                'vehicle_type' => $motoboy['vehicle_type'],
                'license_plate' => $motoboy['license_plate']
            ];
            header("Location: ../views/ContaMotoboy.php");
            exit();
        }

        // Verifica se é usuário comum
        $sqlUser = $conn->prepare("SELECT id, username, email, senha, profile_picture, partner FROM users WHERE email = :email");
        $sqlUser->bindParam(':email', $email);
        $sqlUser->execute();
        $user = $sqlUser->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['senha'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'profile_picture' => $user['profile_picture'] ?? null,
                'partner' => $user['partner'] ?? false
            ];
            header("Location: ../views/Conta.php");
            exit();
        }

        $_SESSION['login_error'] = "E-mail ou senha inválidos.";
        header("Location: ../../Tela de login/index.html");
        exit();
    } catch (Exception $e) {
        error_log("Erro ao conectar ou autenticar: " . $e->getMessage());
        $_SESSION['login_error'] = "Não foi possível processar sua solicitação no momento. Tente novamente mais tarde.";
        header("Location: ../../Tela de login/index.html");
        exit();
    }
}
?>
