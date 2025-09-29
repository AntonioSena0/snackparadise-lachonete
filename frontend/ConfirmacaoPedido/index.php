<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../Tela de Login/index.php");
    exit();
}

$pedidoId = $_GET['pedido_id'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado - Snack Paradise</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../imgs/Logo.png" type="image/x-icon">
    <style>
        .confirmacao-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 40px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .icone-sucesso {
            font-size: 80px;
            color: #28a745;
            margin-bottom: 20px;
        }
        
        .numero-pedido {
            background: #f8f9fa;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 24px;
            font-weight: bold;
            color: #495057;
            margin: 20px 0;
        }
        
        .info-pedido {
            text-align: left;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .btn-voltar {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <!-- Header igual às outras páginas -->
    </header>

    <main>
        <div class="confirmacao-container">
            <div class="icone-sucesso">✅</div>
            <h1>Pedido Confirmado!</h1>
            <p>Seu pedido foi recebido e está sendo preparado.</p>
            
            <div class="numero-pedido">
                Nº do Pedido: <?php echo htmlspecialchars($pedidoId ?? '---'); ?>
            </div>
            
            <div class="info-pedido">
                <h3>Informações do Pedido:</h3>
                <p><strong>Status:</strong> Em preparação</p>
                <p><strong>Previsão de entrega:</strong> 30-45 minutos</p>
                <p><strong>Acompanhe:</strong> Acesse "Meus Pedidos" no seu perfil</p>
            </div>
            
            <p>Você receberá atualizações sobre o status do seu pedido.</p>
            
            <a href="../Menu/index.php" class="btn-voltar">Voltar ao Menu</a>
            <a href="../PerfilUser/index.php" class="btn-voltar" style="background: #28a745; margin-left: 10px;">Ver Meus Pedidos</a>
        </div>
    </main>

    <footer>
        <!-- Footer igual às outras páginas -->
    </footer>
</body>
</html>