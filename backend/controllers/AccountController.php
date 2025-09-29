<?php
// backend/controllers/AccountController.php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../config/Conexao.php';
include_once '../config/DatabaseManager.php';

try {
    $db = new DatabaseManager();
    
    if (!isset($_SESSION['motoboy'])) {
        header('Location: ../../frontend/PerfilMotoboy/index.php?error=Usuário não autenticado');
        exit();
    }
    
    $motoboyId = $_SESSION['motoboy']['id'];
    $action = $_POST['action'] ?? '';

    // Variável para mensagens de sucesso
    $successMessage = '';

    switch ($action) {
        case 'update_personal_info':
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? ''
            ];
            
            if (empty($data['name']) || empty($data['email'])) {
                header('Location: ../../frontend/PerfilMotoboy/index.php?error=Nome e email são obrigatórios');
                exit();
            }
            
            $success = $db->updateMotoboyPersonalInfo($motoboyId, $data);
            
            if ($success) {
                $_SESSION['motoboy']['name'] = $data['name'];
                $_SESSION['motoboy']['email'] = $data['email'];
                $successMessage = 'Informações pessoais atualizadas com sucesso!';
            } else {
                header('Location: ../../frontend/PerfilMotoboy/index.php?error=Erro ao atualizar informações pessoais');
                exit();
            }
            break;

        case 'update_vehicle_info':
            $data = [
                'vehicle_type' => $_POST['vehicle_type'] ?? '',
                'license_plate' => $_POST['license_plate'] ?? ''
            ];
            
            $success = $db->updateMotoboyVehicleInfo($motoboyId, $data);

            if ($success) {
                $_SESSION['motoboy']['vehicle_type'] = $data['vehicle_type'];
                $_SESSION['motoboy']['license_plate'] = $data['license_plate'];
                header('Location: ../../frontend/PerfilMotoboy/index.php?success=Informações do veículo atualizadas com sucesso!');
                exit();
            } else {
                header('Location: ../../frontend/PerfilMotoboy/index.php?error=Erro ao atualizar informações do veículo');
                exit();
            }
            break;



        case 'update_status':
        $status = $_POST['status'] ?? '';
        
        if (!in_array($status, ['online', 'offline'])) {
            echo json_encode(['error' => 'Status inválido']);
            exit();
        }
        
        $success = $db->updateMotoboyStatus($motoboyId, $status);
        
        if ($success) {
            $_SESSION['motoboy']['status'] = $status;
            echo json_encode([
                'success' => 'Status alterado com sucesso!',
                'status'  => $status
            ]);
        } else {
            echo json_encode(['error' => 'Erro ao alterar status']);
        }
        exit();


        case 'change_password':
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                header('Location: ../../frontend/PerfilMotoboy/index.php?error=Todos os campos de senha são obrigatórios');
                exit();
            }
            
            if ($newPassword !== $confirmPassword) {
                header('Location: ../../frontend/PerfilMotoboy/index.php?error=A nova senha e a confirmação não coincidem');
                exit();
            }
            
            if (strlen($newPassword) < 6) {
                header('Location: ../../frontend/PerfilMotoboy/index.php?error=A nova senha deve ter pelo menos 6 caracteres');
                exit();
            }
            
            $success = $db->changePassword($motoboyId, $currentPassword, $newPassword, true);
            
            if ($success) {
                $successMessage = 'Senha alterada com sucesso!';
            } else {
                header('Location: ../../frontend/PerfilMotoboy/index.php?error=Erro ao alterar senha');
                exit();
            }
            break;

            case 'upload_photo':
                if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
                    echo json_encode(['error' => 'Erro no upload do arquivo']);
                    exit();
                }

                $file = $_FILES['photo'];

                // Validar tipo de arquivo
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileType = mime_content_type($file['tmp_name']);

                if (!in_array($fileType, $allowedTypes)) {
                    echo json_encode(['error' => 'Tipo de arquivo não permitido. Use JPEG, PNG ou GIF.']);
                    exit();
                }

                // Validar tamanho
                if ($file['size'] > 5 * 1024 * 1024) {
                    echo json_encode(['error' => 'A imagem deve ter no máximo 5MB']);
                    exit();
                }

                // Gerar nome único
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = 'profile_' . $motoboyId . '_' . time() . '.' . $extension;
                $uploadPath = '../uploads/profiles/' . $filename;

                // Criar diretório se não existir
                if (!is_dir('../uploads/profiles/')) {
                    mkdir('../uploads/profiles/', 0777, true);
                }

                if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    $success = $db->updateProfilePicture($motoboyId, $filename, true);

                    if ($success) {
                        $_SESSION['motoboy']['profile_picture'] = $filename;
                        echo json_encode([
                            'success'  => 'Foto do perfil atualizada com sucesso!',
                            'filename' => $filename
                        ]);
                    } else {
                        echo json_encode(['error' => 'Erro ao salvar informações da foto']);
                    }
                } else {
                    echo json_encode(['error' => 'Erro ao fazer upload da imagem']);
                }
                exit();

    }
    
    // Redirecionar para a mesma página com mensagem de sucesso
    if (!empty($successMessage)) {
        header('Location: ../../frontend/PerfilMotoboy/index.php?success=' . urlencode($successMessage));
        exit();
    }
    
} catch (Exception $e) {
    header('Location: ../../frontend/PerfilMotoboy/index.php?error=' . urlencode($e->getMessage()));
    exit();
}
?>