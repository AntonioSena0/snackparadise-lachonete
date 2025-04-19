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
document.getElementById('payment-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const confirmarButton = document.querySelector('.confirmar');
    confirmarButton.disabled = true;

    // Simula um carregamento e exibe uma mensagem após 3 segundos
    setTimeout(function() {
        const modalQRCode = document.getElementById('modal-qrcode');
        modalQRCode.style.display = 'flex'; // Exibe o modal QR Code
    }, 3000);
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