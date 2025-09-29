<?php
include_once 'DatabaseManager.php';

class DeliveriesAPI
{
    private $db;

    public function __construct()
    {
        session_start();
        $this->db = new DatabaseManager();
        $this->checkMotoboyAuthentication();
    }

    private function checkMotoboyAuthentication()
    {
        if (!isset($_SESSION['motoboy'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Não autorizado']);
            exit();
        }
    }

    public function handleRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $action = $_GET['action'] ?? '';

        try {
            switch ($method) {
                case 'GET':
                    $this->handleGetRequest($action);
                    break;
                case 'POST':
                    $this->handlePostRequest($action);
                    break;
                default:
                    $this->jsonResponse(['error' => 'Método não permitido'], 405);
            }
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    private function handleGetRequest($action)
    {
        $motoboyId = $_SESSION['motoboy']['id'];

        switch ($action) {
            case 'stats':
                $stats = $this->db->getMotoboyStats($motoboyId);
                $this->jsonResponse($stats);
                break;
            case 'deliveries':
                $page = $_GET['page'] ?? 1;
                $limit = $_GET['limit'] ?? 10;
                $offset = ($page - 1) * $limit;
                
                $deliveries = $this->db->getRecentDeliveries($motoboyId, $limit, $offset);
                $this->jsonResponse($deliveries);
                break;
            case 'pending_orders':
                $orders = $this->getPendingOrders();
                $this->jsonResponse($orders);
                break;
            default:
                $this->jsonResponse(['error' => 'Ação não reconhecida'], 400);
        }
    }

    private function handlePostRequest($action)
    {
        $motoboyId = $_SESSION['motoboy']['id'];
        $input = json_decode(file_get_contents('php://input'), true);

        switch ($action) {
            case 'accept_order':
                $this->acceptOrder($motoboyId, $input['order_id'] ?? 0);
                break;
            case 'decline_order':
                $this->declineOrder($motoboyId, $input['order_id'] ?? 0);
                break;
            case 'complete_delivery':
                $this->completeDelivery($motoboyId, $input['delivery_id'] ?? 0);
                break;
            default:
                $this->jsonResponse(['error' => 'Ação não reconhecida'], 400);
        }
    }

    private function getPendingOrders()
    {
        // Simular pedidos pendentes - na implementação real, você buscaria da tabela de pedidos
        return [
            [
                'id' => 1,
                'from' => 'SnackParadise Centro',
                'to' => 'Rua Augusta, ' . rand(100, 2000),
                'value' => number_format(rand(500, 2000) / 100, 2, ',', '.'),
                'distance' => number_format(rand(10, 50) / 10, 1, ',', '.') . ' km',
                'created_at' => date('d/m/Y H:i')
            ]
        ];
    }

    private function acceptOrder($motoboyId, $orderId)
    {
        // Na implementação real, você atualizaria o pedido com o motoboy_id
        $sql = "UPDATE pedidos SET motoboy_id = :motoboy_id, status = 'aceito' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':motoboy_id', $motoboyId, PDO::PARAM_INT);
        $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $this->jsonResponse(['success' => 'Pedido aceito com sucesso!']);
        } else {
            throw new Exception('Erro ao aceitar pedido.');
        }
    }

    private function declineOrder($motoboyId, $orderId)
    {
        // Simular recusa de pedido
        $this->jsonResponse(['success' => 'Pedido recusado.']);
    }

    private function completeDelivery($motoboyId, $deliveryId)
    {
        // Marcar entrega como concluída
        $sql = "UPDATE registro SET confirmar = 1 WHERE id = :id AND motoboy_id = :motoboy_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $deliveryId, PDO::PARAM_INT);
        $stmt->bindParam(':motoboy_id', $motoboyId, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $this->jsonResponse(['success' => 'Entrega marcada como concluída!']);
        } else {
            throw new Exception('Erro ao completar entrega.');
        }
    }

    private function jsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}

// Executar a API
$api = new DeliveriesAPI();
$api->handleRequest();
?>