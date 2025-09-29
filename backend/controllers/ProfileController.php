<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../config/DatabaseManager.php';

class ProfileController {
    private $db;
    
    public function __construct() {
        $this->db = new DatabaseManager();
    }
    
    public function handleRequest() {
        if (!isset($_SESSION['user'])) {
            $this->redirectWithError('Usuário não autenticado');
        }
        
        $userId = $_SESSION['user']['id'];
        $action = $_POST['action'] ?? '';
        
        switch ($action) {
            case 'update_personal_info':
                $this->updatePersonalInfo($userId);
                break;
                
            case 'update_address':
                $this->updateAddress($userId);
                break;
                
            case 'change_password':
                $this->changePasswordUser($userId);
                break;
                
            case 'upload_photo':
                $this->uploadPhotoUser($userId);
                break;
                
            default:
                $this->redirectWithError('Ação inválida');
        }
    }
    
    private function updatePersonalInfo($userId) {
        $data = [
            'username' => trim($_POST['username'] ?? ''),
            'email' => trim($_POST['email'] ?? '')
        ];
        
        if (empty($data['username']) || empty($data['email'])) {
            $this->redirectWithError('Todos os campos são obrigatórios');
        }
        
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->redirectWithError('E-mail inválido');
        }
        
        if ($this->db->updateUserPersonalInfo($userId, $data)) {
            $_SESSION['user']['username'] = $data['username'];
            $_SESSION['user']['email'] = $data['email'];
            $this->redirectWithSuccess('Dados pessoais atualizados com sucesso!');
        } else {
            $this->redirectWithError('Erro ao atualizar dados pessoais');
        }
    }
    
    private function updateAddress($userId) {
        $data = [
            'cep' => preg_replace('/[^0-9]/', '', $_POST['cep'] ?? ''),
            'endereco' => trim($_POST['endereco'] ?? ''),
            'bairro' => trim($_POST['bairro'] ?? ''),
            'cidade' => trim($_POST['cidade'] ?? '')
        ];
        
        if (empty($data['cep']) || empty($data['endereco']) || empty($data['bairro']) || empty($data['cidade'])) {
            $this->redirectWithError('Todos os campos de endereço são obrigatórios');
        }
        
        if (strlen($data['cep']) !== 8) {
            $this->redirectWithError('CEP inválido');
        }
        
        if ($this->db->updateUserAddress($userId, $data)) {
            $_SESSION['user'] = array_merge($_SESSION['user'], $data);
            $this->redirectWithSuccess('Endereço atualizado com sucesso!');
        } else {
            $this->redirectWithError('Erro ao atualizar endereço');
        }
    }
    
    private function changePasswordUser($userId) {
        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        
        if (empty($current) || empty($new) || empty($confirm)) {
            $this->redirectWithError('Todos os campos de senha são obrigatórios');
        }
        
        if ($new !== $confirm) {
            $this->redirectWithError('As senhas não coincidem');
        }
        
        if (strlen($new) < 6) {
            $this->redirectWithError('A senha deve ter pelo menos 6 caracteres');
        }
        
        if ($this->db->changePasswordUser($userId, $current, $new)) {
            $this->redirectWithSuccess('Senha alterada com sucesso!');
        } else {
            $this->redirectWithError('Erro ao alterar senha. Verifique a senha atual.');
        }
    }
    
    private function uploadPhotoUser($userId) {
        if (!isset($_FILES['profilePicture']) || $_FILES['profilePicture']['error'] !== UPLOAD_ERR_OK) {
            $this->redirectWithError('Erro no upload da imagem');
        }
        
        $file = $_FILES['profilePicture'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!in_array($file['type'], $allowedTypes)) {
            $this->redirectWithError('Apenas imagens JPEG, PNG e GIF são permitidas');
        }
        
        if ($file['size'] > $maxSize) {
            $this->redirectWithError('A imagem deve ter no máximo 5MB');
        }
        
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = "user_{$userId}_" . time() . ".{$ext}";
        $uploadDir = "../uploads/profiles/";
        $filepath = $uploadDir . $filename;
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            if ($this->db->updateProfilePictureUser($userId, $filename)) {
                $_SESSION['user']['profile_picture'] = $filename;
                $this->redirectWithSuccess('Foto de perfil atualizada com sucesso!');
            } else {
                unlink($filepath); // Remove o arquivo se falhar no banco
                $this->redirectWithError('Erro ao salvar foto no banco de dados');
            }
        } else {
            $this->redirectWithError('Erro ao fazer upload da imagem');
        }
    }
    
    private function redirectWithSuccess($message) {
        header('Location: ../../frontend/PerfilUser/index.php?success=' . urlencode($message));
        exit();
    }
    
    private function redirectWithError($message) {
        header('Location: ../../frontend/PerfilUser/index.php?error=' . urlencode($message));
        exit();
    }
}

// Executar o controlador
$controller = new ProfileController();
$controller->handleRequest();
?>