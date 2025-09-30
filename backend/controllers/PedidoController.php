<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../config/DatabaseManager.php';

class PedidoController {
    private $db;
    
    public function __construct() {
        $this->db = new DatabaseManager();
    }
    
    public function handleRequest() {
        $input = json_decode(file_get_contents('php://input'), true);
        $action = $input['action'] ?? '';

        switch ($action) {
            case 'criar_pedido':
                $this->criarPedido($input['data'] ?? []);
                break;
            case 'get_pedidos_usuario':
                $this->getPedidosUsuario();
                break;
            case 'get_endereco_usuario':
                $this->getEnderecoUsuario();
                break;
            default:
                $this->jsonResponse(['error' => 'Ação inválida'], 400);
        }
    }

    private function criarPedido($data) {
        try {
            // Verificar se usuário está logado
            if (!isset($_SESSION['user'])) {
                $this->jsonResponse(['error' => 'Usuário não autenticado'], 401);
                return;
            }
            
            $userId = $_SESSION['user']['id'];
            $itens = $data['itens'] ?? [];
            $endereco = $data['endereco'] ?? '';
            $pagamento = $data['pagamento'] ?? '';
            
            // Validações
            if (empty($itens)) {
                $this->jsonResponse(['error' => 'Carrinho vazio'], 400);
                return;
            }
            
            if (empty($endereco)) {
                $this->jsonResponse(['error' => 'Endereço é obrigatório'], 400);
                return;
            }
            
            if (empty($pagamento)) {
                $this->jsonResponse(['error' => 'Forma de pagamento é obrigatória'], 400);
                return;
            }
            
            // Criar pedido no banco
            $pedidoId = $this->db->createPedido($userId, $endereco, $pagamento, $itens);
            
            if ($pedidoId) {
                // Atualizar endereço do usuário se necessário
                $this->atualizarEnderecoUsuario($userId, $endereco);
                
                $this->jsonResponse([
                    'success' => true,
                    'pedido_id' => $pedidoId,
                    'message' => 'Pedido criado com sucesso'
                ]);
            } else {
                $this->jsonResponse(['error' => 'Erro ao criar pedido no banco de dados'], 500);
            }
            
        } catch (Exception $e) {
            error_log("Erro criarPedido: " . $e->getMessage());
            $this->jsonResponse(['error' => 'Erro interno do servidor'], 500);
        }
    }
    
    private function atualizarEnderecoUsuario($userId, $endereco) {
        try {
            // Extrair informações do endereço (simplificado)
            // Em um sistema real, você usaria uma API de CEP para normalizar o endereço
            $dadosEndereco = [
                'endereco' => $endereco,
                'cep' => '',
                'bairro' => '',
                'cidade' => 'São Paulo' // Default
            ];
            
            $this->db->updateUserAddress($userId, $dadosEndereco);
            
        } catch (Exception $e) {
            // Não falha o pedido se der erro no endereço
            error_log("Erro atualizarEnderecoUsuario: " . $e->getMessage());
        }
    }
    
    private function getPedidosUsuario() {
        try {
            if (!isset($_SESSION['user'])) {
                $this->jsonResponse(['error' => 'Usuário não autenticado'], 401);
                return;
            }
            
            $userId = $_SESSION['user']['id'];
            $pedidos = $this->db->getUserOrders($userId);
            
            $this->jsonResponse([
                'success' => true,
                'pedidos' => $pedidos
            ]);
            
        } catch (Exception $e) {
            error_log("Erro getPedidosUsuario: " . $e->getMessage());
            $this->jsonResponse(['error' => 'Erro ao buscar pedidos'], 500);
        }
    }

    private function getEnderecoUsuario() {
        if (!isset($_SESSION['user'])) {
            $this->jsonResponse(['error' => 'Usuário não autenticado'], 401);
            return;
        }
        $userId = $_SESSION['user']['id'];
        $endereco = $this->db->getUserAddress($userId); // Implemente este método no DatabaseManager
        $this->jsonResponse([
            'success' => true,
            'endereco' => $endereco
        ]);
    }
    
    private function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}

// Executar o controlador
$controller = new PedidoController();
$controller->handleRequest();
?>