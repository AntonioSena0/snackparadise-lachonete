<?php
session_start();
include_once '../config/DatabaseManager.php';

class ProdutoController {
    private $db;
    
    public function __construct() {
        $this->db = new DatabaseManager();
    }
    
    public function handleRequest() {
        $action = $_GET['action'] ?? '';
        
        switch ($action) {
            case 'get_produtos':
                $this->getProdutos();
                break;
            default:
                $this->jsonResponse(['error' => 'Ação inválida'], 400);
        }
    }
    
    private function getProdutos() {
        try {
            $produtos = $this->getProdutosMock();
            
            $this->jsonResponse([
                'success' => true,
                'produtos' => $produtos
            ]);
            
        } catch (Exception $e) {
            $this->jsonResponse(['error' => 'Erro ao buscar produtos'], 500);
        }
    }
    
    private function getProdutosMock() {
        return [
{
  "lanches": [
    {"id": 1, "nome": "Sunset Burguer", "img": "Assets/Encomendar e Retirar (Tradicional)/Hamburguer 2 1.png", "preco": 28.00, "descricao": "Bacon, cheddar, Hamburguer grelhado, Molho Barbecue, Pão com gergelim"},
    {"id": 2, "nome": "Hamburguer Praiano", "img": "Assets/Encomendar e Retirar (Tradicional)/Hamburguer 1 1.png", "preco": 27.00, "descricao": "Alface, cebola, hamburguer grelhado, pão com gergelim, picles, tomate"},
    {"id": 3, "nome": "Snack Praia do Sol", "img": "Assets/Encomendar e Retirar (Tradicional)/Hamburguer 3 1.png", "preco": 26.00, "descricao": "Alface, bacon, cebola roxa, cheddar, hamburguer grelhado, pão com gergilim, tomate"},
    {"id": 4, "nome": "Palmeira Burguer", "img": "Assets/Encomendar e Retirar (Vegano)/Hamburguer 1 1.png", "preco": 28.00, "descricao": "Alface, cebola, coentro, molho bechamel vegano, pão com gergilim, seitan (hamburguer vegano), tomate"},
    {"id": 5, "nome": "Hamburguer Tropical", "img": "Assets/Encomendar e Retirar (Vegano)/Hamburguer 2 1.png", "preco": 26.00, "descricao": "Bacon, cheddar, Hamburguer grelhado, Molho Barbecue, Pão com gergilim"},
    {"id": 6, "nome": "Férias Saudaveis", "img": "Assets/Encomendar e Retirar (Vegano)/Hamburguer3 1.png", "preco": 26.50, "descricao": "Alface, cebola, hamburguer grelhado, pão com gergilim, picles, tomate"}
  ],
  "acompanhamentos": [
    {"id": 7, "nome": "Batata tam.P", "img": "Assets/Acompanhamentos/Batata P.jpeg", "preco": 7.75},
    {"id": 8, "nome": "Batata tam.M", "img": "Assets/Acompanhamentos/Batata M.jpeg", "preco": 8.25},
    {"id": 9, "nome": "Batata tam.G", "img": "Assets/Acompanhamentos/Batata G.jpeg", "preco": 8.99}
  ],
  "bebidas": [
    {"id": 10, "nome": "Coca-cola", "img": "Assets/Bebidas/file (12).png", "preco": 5.50},
    {"id": 11, "nome": "Pepsi", "img": "Assets/Bebidas/file (11).png", "preco": 5.50},
    {"id": 12, "nome": "Guarana", "img": "Assets/Bebidas/file (13).png", "preco": 4.50},
    {"id": 13, "nome": "Fanta Laranja", "img": "Assets/Bebidas/file (14).png", "preco": 4.20},
    {"id": 14, "nome": "Fanta Uva", "img": "Assets/Bebidas/file (15).png", "preco": 4.00}
  ]
}
        ];
    }
    
    private function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}

$controller = new ProdutoController();
$controller->handleRequest();
?>