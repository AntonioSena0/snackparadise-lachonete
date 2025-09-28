document.addEventListener('DOMContentLoaded', () => {
window.addEventListener("load", function() {
    document.body.classList.add("loaded");
});

// Previne o comportamento padrão de links e gerencia a transição
document.querySelectorAll("a").forEach(link => {
    link.addEventListener("click", function(event) {
        event.preventDefault();
        document.body.classList.remove("loaded");
        setTimeout(() => {
            window.location.href = this.href;
        }, 500);
    });
});

// Formulário de pagamento
document.getElementById('payment-form').addEventListener('submit', async function(event) {
    event.preventDefault();

    // Captura os dados do formulário
    const nome = document.getElementById('nome').value;
    const rua = document.getElementById('rua').value;
    const numero = document.getElementById('numero').value;
    const complemento = document.getElementById('complemento').value;
    const preferencial = document.getElementById('preferencial').value;
    const formaPagamento = document.getElementById('forma').value;

    // Captura os itens do carrinho
    const carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];

    // Cria um objeto com os dados do checkout
    const checkoutData = {
        endereco: `Nome: ${nome}<br>Rua: ${rua}<br>Número: ${numero}<br>Complemento: ${complemento}<br>Atendimento Preferencial: ${preferencial}`,
        pagamento: formaPagamento,
        pedidos: carrinho
    };

    // Salva no localStorage para a tela do motoboy
    localStorage.setItem('checkoutData', JSON.stringify(checkoutData));

    // Envia para o backend (AJAX)
    try {
        await fetch('../back/controllers/criar_pedido.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                email: localStorage.getItem('userEmail') || nome, // ou outro identificador
                pedidos: carrinho,
                endereco: checkoutData.endereco,
                pagamento: formaPagamento
            })
        });
    } catch (e) {
        alert('Erro ao registrar pedido no servidor!');
    }
});

// Formato do CEP
document.getElementById('CEP').addEventListener('input', function(event) {
    const input = event.target.value.replace(/\D/g, '');
    if (input.length <= 5) {
        event.target.value = input;
    } else {
        event.target.value = input.slice(0, 5) + '-' + input.slice(5, 8);
    }
});

// Gera QR Code ao selecionar a forma de pagamento
document.getElementById('forma').addEventListener('change', function() {
    const qrcodeContainer = document.getElementById('qrcode');
    qrcodeContainer.innerHTML = '';

    if (this.value === 'pix') {
        const qrContent = "Pix: R$30,00";
        const qrcode = new QRCode(qrcodeContainer, {
            text: qrContent,
            width: 128,
            height: 128,
        });
        qrcodeContainer.style.display = 'block';

        // Exibe o modal QR Code após gerar o QR
        const modalQRCode = document.getElementById('modal-qrcode');
        modalQRCode.style.display = 'flex';
    } else {
        qrcodeContainer.style.display = 'none';
    }
});

// Abre o modal de confirmação
document.querySelector('.confirmar').addEventListener('click', function() {
    document.querySelector('.form2').style.display = 'none';
    const modal = document.querySelector('.modal');
    modal.style.display = 'flex';
    setTimeout(() => {
        document.querySelector('.loading').style.display = 'none';
        document.querySelector('.confirmation').style.display = 'block';
    }, 3000);
});

// Função para fechar modal e recarregar a página
function fechaModal(modal) {
    modal.style.display = 'none';
    location.reload();
}

// Fecha os modais ao clicar no botão de fechar
document.querySelectorAll('.close-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const modal = document.querySelector('.modal');
        fechaModal(modal);
    });
});

// Fechamento ao clicar fora do modal
document.querySelector('.modal').addEventListener('click', function(event) {
    if (event.target === this) {
        fechaModal(this);
    }
});

// Gerenciamento dos modais de QR Code e confirmação
const modalConfirmacao = document.getElementById('modal-confirmacao');
const modalQRCode = document.getElementById('modal-qrcode');

// Confirmar pagamento com Pix
document.querySelector('.confirm-pix').addEventListener('click', function() {
    modalQRCode.style.display = 'none';
    modalConfirmacao.style.display = 'flex';

    // Recarrega a página após um pequeno atraso
    setTimeout(() => {
        location.reload();
    }, 1000); // 1 segundo de atraso antes de recarregar
});

// Fechar modais ao clicar fora deles
modalConfirmacao.addEventListener('click', function(event) {
    if (event.target === this) {
        fechaModal(this);
    }
});

modalQRCode.addEventListener('click', function(event) {
    if (event.target === this) {
        this.style.display = 'none';
    }
});

// Função para carregar os itens do carrinho no checkout
function carregarCarrinhoNoCheckout() {
    const carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
    const itensCheckout = document.getElementById('itensCheckout');
    const totalCheckout = document.getElementById('totalCheckout');

    // Limpa os itens do checkout antes de atualizar
    itensCheckout.innerHTML = '';
    let total = 0;

    // Adiciona os itens ao checkout
    carrinho.forEach((item) => {
        const li = document.createElement('li');
        li.textContent = `${item.nome} (x${item.quantidade}) - R$ ${(item.preco * item.quantidade).toFixed(2)}`;
        itensCheckout.appendChild(li);
        total += item.preco * item.quantidade;
    });

    // Atualiza o total no checkout
    totalCheckout.textContent = total.toFixed(2);
}

// Chama a função ao carregar a página de checkout
document.addEventListener('DOMContentLoaded', () => {
    if (window.location.pathname.includes('checkout')) {
        carregarCarrinhoNoCheckout();
    }
});
});