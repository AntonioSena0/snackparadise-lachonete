<?php
session_start();

if (isset($_SESSION['user'])) {
    $logged = true;
    $user = $_SESSION['user'];
} elseif (isset($_SESSION['motoboy'])) {
    $logged = true;
    $user = $_SESSION['motoboy'];
} else {
    $logged = false;
    $user = null;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../style.css"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    
</head>
<body>
 <header>
        <div class="header-left">
            <button class="btn-menu-lateral" id="btnMenuLateral">☰</button>
            <div class="logo-container">
            <a href="../Cardápio/index.php" class="logo">
                    <img src="../imgs/Logo.png" class="logo" alt="Snack Paradise Logo">
                </a>           
             </div>
        </div>

        <div class="header-center">
            <a href="../Cardápio/index.php" class="menu-item">Menu</a>
            <div class="menu-item cardapio-btn" id="cardapioBtn">
                Cardápio
                <div class="submenu" id="submenu">
                    <a href="../Cardápio/menu.php#subheader2" class="submenu-item">Hambúrgueres</a>
                    <a href="../Cardápio/menu.php#acompanhamentos" class="submenu-item">Acompanhamentos</a>
                    <a href="../Cardápio/menu.php#bebidas" class="submenu-item">Bebidas</a>
                </div>
            </div>
            <a href="../Acumular Pontos/pontos.html" class="menu-item">Promoções</a>
            <a href="../Quem somos/index.php" class="menu-item">Sobre Nós</a>
        </div>

        <a href="../Tela de Login/index.php" class="btn-conta">Sair</a>
    </header>

    <!-- Menu Lateral -->
    <nav class="menu-lateral" id="menuLateral">
        <a href="../Cardápio/index.php" class="menu-lateral-item">Início</a>
        <a href="../PerfilUser/index.php" class="menu-lateral-item">Perfil</a>
        <a href="../Acumular Pontos/pontos.html" class="menu-lateral-item active">Pontos</a>
        <a href="../SejaParceiro/index.php" class="menu-lateral-item">Seja Parceiro</a>
        <a href="../Feedback/index.php" class="menu-lateral-item">Avaliações</a>
        <a href="../Quem somos/index.php" class="menu-lateral-item">Sobre nós</a>
        <a href="../Auxílio Preferencial/auxilio.php" class="menu-lateral-item">Auxílio Preferencial</a>
    </nav>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    
    <main class="main">
        <div class="janelas">
            <div class="itens-2">
                <h1>Itens Selecionados</h1>
                <ul id="itensCheckout"></ul>
                <p><ul id="itensCheckout"></ul><span id="totalCheckout">0.00</span></p>
            </div>
            <div class="pagamento">
                <h1>Pagamento</h1>
                <form id="payment-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" name="nome" required>
                        </div>

                        <div class="form-group">
                            <label for="rua">Endereço</label>
                            <input type="text" id="rua" name="rua" required>
                        </div>

                        <div class="form-group">
                            <label for="numero">Número</label>
                            <input type="text" id="numero" name="numero" required>
                        </div>

                        <div class="form-group">
                            <label for="complemento">Complemento</label>
                            <input type="text" id="complemento" name="complemento">
                        </div>

                        <div class="form-group">
                            <label for="preferencial">Atendimento Preferencial</label>
                            <select id="preferencial" name="preferencial">
                                <option value="Sim">Sim</option>
                                <option value="Não">Não</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="forma">Forma de Pagamento</label>
                            <select id="forma" name="forma" class="forma">
                                <option value="debito">Débito</option>
                                <option value="credito">Crédito</option>
                                <option value="cedula">Cédula</option>
                                <option value="pix">Pix</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn" name="btnsubm">Confirmar Pedido</button>
                </form>
            </div>
        </div>
    </main> 
    <div class="modal" tabindex="-1" id="modal-qrcode">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pagamento via Pix</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="qrcode" class="qrcode"></div>
      </div>
      <div class="modal-footer">
     <!--   <a class="btn btn-primary" class="btn">Confirmar pagamento por Pix</a> -->
        <a href="../checkout/index.php" id="finalizarCompra" class="btn btn-primary" class="btn">Confirmar pagamento por Pix</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <a href="../Menu/index.php">Início</a>
                <a href="../Quem somos/index.php">Sobre</a>
                <a href="../Auxílio Preferencial/auxilio.php">Serviços</a>
                <a href="https://www.instagram.com/_snackparadise_/profilecard/?igsh=OHh2eWpsOXBuOWRp">Contato</a>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 SnackParadise. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
<script>
document.addEventListener("DOMContentLoaded", function() {
    carregarCarrinhoNoCheckout();
    setupFormSubmit();
});

function carregarCarrinhoNoCheckout() {
    const carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
    const ul = document.getElementById('itensCheckout');
    const totalSpan = document.getElementById('totalCheckout');

    ul.innerHTML = '';
    let total = 0;

    if (carrinho.length === 0) {
        ul.innerHTML = '<li>Carrinho vazio.</li>';
        totalSpan.textContent = '0.00';
        return;
    }

    carrinho.forEach(item => {
        const li = document.createElement('li');
        li.textContent = `${item.nome} (x${item.quantidade}) - R$ ${(item.preco * item.quantidade).toFixed(2)}`;
        ul.appendChild(li);
        total += item.preco * item.quantidade;
    });

    totalSpan.textContent = total.toFixed(2);
}

function setupFormSubmit() {
    const form = document.getElementById('payment-form');
    
    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        
        await finalizarPedido();
    });
}

async function finalizarPedido() {
    // Verificar se o usuário está logado
    <?php if (!$logged): ?>
        alert('Você precisa estar logado para finalizar o pedido!');
        window.location.href = '../Tela de Login/index.php';
        return;
    <?php endif; ?>

    const carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
    
    if (carrinho.length === 0) {
        alert('Seu carrinho está vazio!');
        return;
    }

    // Coletar dados do formulário
    const formData = new FormData(document.getElementById('payment-form'));
    const enderecoCompleto = `${formData.get('rua')}, ${formData.get('numero')}${formData.get('complemento') ? ' - ' + formData.get('complemento') : ''}`;
    const formaPagamento = formData.get('forma');

    // Verificar se é Pix e mostrar QR Code
    if (formaPagamento === 'pix') {
        mostrarQRCodePix();
        return; // O pedido será finalizado após confirmação do Pix
    }

    // Para outras formas de pagamento, finalizar diretamente
    await criarPedidoNoBanco(carrinho, enderecoCompleto, formaPagamento);
}

function mostrarQRCodePix() {
    const total = document.getElementById('totalCheckout').textContent;
    
    // Gerar QR Code Pix (exemplo com dados fictícios)
    const qrCodeData = `00020126580014br.gov.bcb.pix0136123e4567-e12b-12d1-a456-4266141740005204000053039865406${total}5802BR5909SnackParadise6008Sao Paulo62070503***6304`;
    
    // Limpar QR Code anterior
    document.getElementById('qrcode').innerHTML = '';
    
    // Gerar novo QR Code
    new QRCode(document.getElementById('qrcode'), {
        text: qrCodeData,
        width: 200,
        height: 200
    });
    
    // Mostrar modal
    const modal = new bootstrap.Modal(document.getElementById('modal-qrcode'));
    modal.show();
    
    // Configurar botão de confirmação do Pix
    document.querySelector('#modal-qrcode .btn-primary').onclick = async function() {
        const carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
        const formData = new FormData(document.getElementById('payment-form'));
        const enderecoCompleto = `${formData.get('rua')}, ${formData.get('numero')}${formData.get('complemento') ? ' - ' + formData.get('complemento') : ''}`;
        
        await criarPedidoNoBanco(carrinho, enderecoCompleto, 'pix');
        modal.hide();
    };
}

async function criarPedidoNoBanco(carrinho, endereco, pagamento) {
    try {
        // Preparar dados para enviar
        const pedidoData = {
            itens: carrinho,
            endereco: endereco,
            pagamento: pagamento,
            total: document.getElementById('totalCheckout').textContent
        };

        const response = await fetch('../../backend/controllers/criar_pedido.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                itens: carrinho, // array de itens
                endereco: endereco, // use o parâmetro recebido
                pagamento: pagamento // use o parâmetro recebido
            })
        });

        const result = await response.json();

        if (result.success) {
            // Limpar carrinho
            localStorage.removeItem('carrinho');
            
            // Mostrar mensagem de sucesso
            showNotification('Pedido realizado com sucesso! Nº ' + result.pedido_id, 'success');
            
            // Redirecionar para página de confirmação
            setTimeout(() => {
                window.location.href = `../ConfirmacaoPedido/index.php?pedido_id=${result.pedido_id}`;
            }, 2000);
            
        } else {
            throw new Error(result.error || 'Erro ao criar pedido');
        }
        
    } catch (error) {
        console.error('Erro:', error);
        showNotification('Erro ao finalizar pedido: ' + error.message, 'error');
    }
}

// Função para mostrar notificação
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <span>${message}</span>
        <button onclick="this.parentElement.remove()">&times;</button>
    `;

    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 0.8rem;
        color: white;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        min-width: 300px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        animation: slideIn 0.3s ease-out;
    `;

    const colors = {
        success: '#28a745',
        error: '#dc3545',
        warning: '#ffc107',
        info: '#17a2b8'
    };

    notification.style.background = colors[type] || colors.info;

    const closeBtn = notification.querySelector('button');
    closeBtn.style.cssText = `
        background: none;
        border: none;
        color: white;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        if (notification.parentElement) {
            notification.style.animation = 'slideOut 0.3s ease-in forwards';
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="menu.js"></script>
    </body>
</html>