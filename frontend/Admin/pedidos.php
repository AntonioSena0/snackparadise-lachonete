<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../Tela de login/index.php");
    exit();
}

include_once '../../backend/config/DatabaseManager.php';
$db = new DatabaseManager();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Pedidos - Snack Paradise</title>
    <style>
        .orders-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .order-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background: white;
        }
        .order-status {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-pendente { background: #fff3cd; color: #856404; }
        .status-preparando { background: #d1ecf1; color: #0c5460; }
        .status-pronto { background: #d4edda; color: #155724; }
        .btn-assign {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Gerenciar Pedidos - Atribuir Motoboys</h1>
    
    <div id="pending-orders">
        <h2>Pedidos Pendentes de Entrega</h2>
        <div class="orders-grid" id="orders-container">
        </div>
    </div>

    <script>
        async function loadPendingOrders() {
            try {
                const response = await fetch('../../backend/controllers/DeliveryController.php?action=get_pending_orders');
                const data = await response.json();
                
                if (data.success) {
                    displayOrders(data.orders);
                }
            } catch (error) {
                console.error('Erro ao carregar pedidos:', error);
            }
        }
        
        function displayOrders(orders) {
            const container = document.getElementById('orders-container');
            
            if (orders.length === 0) {
                container.innerHTML = '<p>Nenhum pedido pendente no momento.</p>';
                return;
            }
            
            container.innerHTML = orders.map(order => `
                <div class="order-card">
                    <h3>Pedido #${order.id}</h3>
                    <p><strong>Cliente:</strong> ${order.cliente_nome}</p>
                    <p><strong>Itens:</strong> ${order.itens_descricao}</p>
                    <p><strong>Total:</strong> R$ ${parseFloat(order.total).toFixed(2)}</p>
                    <p><strong>Endereço:</strong> ${order.endereco}, ${order.bairro}, ${order.cidade}</p>
                    <p><strong>Status:</strong> <span class="order-status status-${order.status}">${order.status}</span></p>
                    <button class="btn-assign" onclick="assignMotoboy(${order.id})">
                        Atribuir Motoboy
                    </button>
                </div>
            `).join('');
        }
        
        async function assignMotoboy(pedidoId) {
            try {
                // Carregar motoboys disponíveis
                const response = await fetch('../../backend/controllers/DeliveryController.php?action=get_available_motoboys');
                const data = await response.json();
                
                if (!data.success || data.motoboys.length === 0) {
                    alert('Nenhum motoboy disponível no momento.');
                    return;
                }
                
                const motoboyName = prompt(`Escolha um motoboy:\n${data.motoboys.map(m => `${m.id} - ${m.name}`).join('\n')}`);
                if (!motoboyName) return;
                
                const motoboyId = parseInt(motoboyName.split(' - ')[0]);
                
                const formData = new FormData();
                formData.append('action', 'assign_order');
                formData.append('pedido_id', pedidoId);
                formData.append('motoboy_id', motoboyId);
                
                const assignResponse = await fetch('../../backend/controllers/DeliveryController.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await assignResponse.json();
                
                if (result.success) {
                    alert('Pedido atribuído com sucesso!');
                    loadPendingOrders();
                } else {
                    alert('Erro ao atribuir pedido: ' + result.error);
                }
                
            } catch (error) {
                console.error('Erro ao atribuir motoboy:', error);
                alert('Erro ao atribuir motoboy');
            }
        }
        
        loadPendingOrders();
        setInterval(loadPendingOrders, 30000);
    </script>
</body>
</html>