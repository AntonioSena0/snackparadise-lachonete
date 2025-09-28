// Sistema de Feedback SnackParadise
console.log('🍔 Iniciando sistema de feedback SnackParadise...');

// Aguardar o DOM estar carregado
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ DOM carregado, iniciando funcionalidades...');
    
    inicializarPagina();
    inicializarMenuLateral();
    inicializarSubmenu();
    inicializarFormularioFeedback();
    carregarAvaliacoesRecentes();
    configurarAcessibilidade();
    
    console.log('🚀 Sistema de feedback inicializado com sucesso!');
});

// ============= INICIALIZAÇÃO DA PÁGINA =============
function inicializarPagina() {
    console.log('⚙️ Inicializando página...');
    
    setTimeout(() => {
        document.body.classList.add('loaded');
    }, 100);
    
    configurarAnimacoesOnScroll();
}

// ============= MENU LATERAL =============
function inicializarMenuLateral() {
    const btnMenuLateral = document.getElementById('btnMenuLateral');
    const menuLateral = document.getElementById('menuLateral');
    const overlay = document.getElementById('overlay');
    
    if (!btnMenuLateral || !menuLateral || !overlay) {
        console.warn('⚠️ Elementos do menu lateral não encontrados');
        return;
    }
    
    btnMenuLateral.addEventListener('click', function(e) {
        e.preventDefault();
        const isAtivo = menuLateral.classList.contains('ativo');
        
        if (isAtivo) {
            fecharMenuLateral();
        } else {
            abrirMenuLateral();
        }
    });
    
    overlay.addEventListener('click', fecharMenuLateral);
    
    function abrirMenuLateral() {
        menuLateral.classList.add('ativo');
        overlay.classList.add('ativo');
        btnMenuLateral.classList.add('active');
        btnMenuLateral.innerHTML = '✕';
        document.body.style.overflow = 'hidden';
        btnMenuLateral.setAttribute('aria-expanded', 'true');
    }
    
    function fecharMenuLateral() {
        menuLateral.classList.remove('ativo');
        overlay.classList.remove('ativo');
        btnMenuLateral.classList.remove('active');
        btnMenuLateral.innerHTML = '☰';
        document.body.style.overflow = 'auto';
        btnMenuLateral.setAttribute('aria-expanded', 'false');
    }
    
    window.fecharMenuLateral = fecharMenuLateral;
}

// ============= SUBMENU =============
function inicializarSubmenu() {
    const cardapioBtn = document.getElementById('cardapioBtn');
    const submenu = document.getElementById('submenu');

    if (!cardapioBtn || !submenu) {
        console.warn('⚠️ Elementos do submenu não encontrados');
        return;
    }

    document.addEventListener('click', function(e) {
        if (!cardapioBtn.contains(e.target) && !submenu.contains(e.target)) {
            fecharSubmenu();
        }
    });

    if (window.innerWidth > 768) {
        cardapioBtn.addEventListener('mouseenter', abrirSubmenu);
        cardapioBtn.addEventListener('mouseleave', fecharSubmenu);
        submenu.addEventListener('mouseenter', abrirSubmenu);
        submenu.addEventListener('mouseleave', fecharSubmenu);
    }

    function abrirSubmenu() {
        submenu.classList.add('ativo');
        cardapioBtn.classList.add('active');
        cardapioBtn.setAttribute('aria-expanded', 'true');
    }

    function fecharSubmenu() {
        submenu.classList.remove('ativo');
        cardapioBtn.classList.remove('active');
        cardapioBtn.setAttribute('aria-expanded', 'false');
    }

    window.abrirSubmenu = abrirSubmenu;
    window.fecharSubmenu = fecharSubmenu;
}

// ============= FORMULÁRIO DE FEEDBACK =============
function inicializarFormularioFeedback() {
    console.log('📝 Inicializando formulário de feedback...');
    
    inicializarSistemaEstrelas();
    inicializarSelecaoCategoria();
    inicializarValidacaoCampos();
    inicializarContadorCaracteres();
    inicializarEnvioFormulario();
}

// Sistema de Avaliação por Estrelas
function inicializarSistemaEstrelas() {
    const estrelas = document.querySelectorAll('.estrela');
    const ratingInput = document.getElementById('rating');
    const ratingText = document.getElementById('ratingText');
    
    const textos = {
        1: 'Muito Insatisfeito 😔',
        2: 'Insatisfeito 😕',
        3: 'Regular 😐',
        4: 'Satisfeito 😊',
        5: 'Muito Satisfeito 🤩'
    };
    
    estrelas.forEach((estrela, index) => {
        // Evento de hover
        estrela.addEventListener('mouseenter', function() {
            destacarEstrelas(index + 1);
            ratingText.textContent = textos[index + 1];
        });
        
        // Evento de clique
        estrela.addEventListener('click', function() {
            const rating = index + 1;
            ratingInput.value = rating;
            marcarEstrelas(rating);
            ratingText.textContent = textos[rating];
            
            // Adicionar animação
            estrela.style.animation = 'pulse 0.6s ease';
            setTimeout(() => {
                estrela.style.animation = '';
            }, 600);
        });
    });
    
    // Reset ao sair do container
    const container = document.getElementById('estrelasContainer');
    container.addEventListener('mouseleave', function() {
        const valorAtual = ratingInput.value;
        if (valorAtual) {
            marcarEstrelas(parseInt(valorAtual));
            ratingText.textContent = textos[valorAtual];
        } else {
            resetarEstrelas();
            ratingText.textContent = 'Selecione uma avaliação';
        }
    });
    
    function destacarEstrelas(rating) {
        estrelas.forEach((estrela, index) => {
            if (index < rating) {
                estrela.classList.add('active');
            } else {
                estrela.classList.remove('active');
            }
        });
    }
    
    function marcarEstrelas(rating) {
        estrelas.forEach((estrela, index) => {
            if (index < rating) {
                estrela.classList.add('active');
            } else {
                estrela.classList.remove('active');
            }
        });
    }
    
    function resetarEstrelas() {
        estrelas.forEach(estrela => {
            estrela.classList.remove('active');
        });
    }
}

// Seleção de Categoria
function inicializarSelecaoCategoria() {
    const botoesCategorias = document.querySelectorAll('.categoria-btn');
    const categoriaInput = document.getElementById('categoria');
    
    botoesCategorias.forEach(botao => {
        botao.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remover seleção anterior
            botoesCategorias.forEach(btn => btn.classList.remove('active'));
            
            // Adicionar seleção atual
            this.classList.add('active');
            categoriaInput.value = this.dataset.categoria;
            
            // Animação
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });
}

// Validação de Campos
function inicializarValidacaoCampos() {
    const campos = document.querySelectorAll('.input-field');
    
    campos.forEach(campo => {
        // Adicionar/remover classe has-value
        campo.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.add('has-value');
            } else {
                this.classList.remove('has-value');
            }
            
            // Remover estado de erro ao começar a digitar
            this.classList.remove('error');
            const errorMsg = this.parentNode.querySelector('.error-message');
            if (errorMsg) {
                errorMsg.classList.remove('show');
            }
        });
        
        // Validação on blur
        campo.addEventListener('blur', function() {
            validarCampo(this);
        });
        
        // Estado inicial
        if (campo.value.trim()) {
            campo.classList.add('has-value');
        }
    });
}

// Contador de Caracteres
function inicializarContadorCaracteres() {
    const comentario = document.getElementById('comentario');
    const contadorAtual = document.getElementById('contadorAtual');
    const contadorMax = document.getElementById('contadorMax');
    const maxCaracteres = 500;
    
    if (comentario && contadorAtual) {
        comentario.addEventListener('input', function() {
            const atual = this.value.length;
            contadorAtual.textContent = atual;
            
            // Mudar cor quando próximo do limite
            if (atual > maxCaracteres * 0.9) {
                contadorAtual.style.color = '#f44336';
            } else if (atual > maxCaracteres * 0.7) {
                contadorAtual.style.color = '#ff9800';
            } else {
                contadorAtual.style.color = '#6c757d';
            }
            
            // Limitar caracteres
            if (atual > maxCaracteres) {
                this.value = this.value.substring(0, maxCaracteres);
                contadorAtual.textContent = maxCaracteres;
            }
        });
        
        contadorMax.textContent = maxCaracteres;
    }
}

// Envio do Formulário
function inicializarEnvioFormulario() {
    const form = document.getElementById('feedbackForm');
    const btnEnviar = document.getElementById('btnEnviar');
    const btnTexto = btnEnviar.querySelector('.btn-texto');
    const btnLoading = btnEnviar.querySelector('.btn-loading');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Validar formulário
        if (!validarFormulario()) {
            mostrarNotificacao('Por favor, preencha todos os campos obrigatórios.', 'error');
            return;
        }
        
        // Estado de loading
        btnEnviar.disabled = true;
        btnTexto.classList.add('hidden');
        btnLoading.classList.remove('hidden');
        
        try {
            // Coletar dados do formulário
            const dados = coletarDadosFormulario();
            
            // Simular envio
            await simularEnvioFeedback(dados);
            
            // Sucesso
            mostrarNotificacao('Avaliação enviada com sucesso! Obrigado pelo seu feedback.', 'success');
            form.reset();
            resetarFormulario();
            
            // Atualizar estatísticas
            atualizarEstatisticas();
            
        } catch (error) {
            console.error('Erro ao enviar feedback:', error);
            mostrarNotificacao('Erro ao enviar avaliação. Tente novamente.', 'error');
        } finally {
            // Restaurar botão
            btnEnviar.disabled = false;
            btnTexto.classList.remove('hidden');
            btnLoading.classList.add('hidden');
        }
    });
}

// Validação do Formulário
function validarFormulario() {
    let valido = true;
    
    // Validar rating
    const rating = document.getElementById('rating');
    if (!rating.value) {
        mostrarErroCustomizado('Selecione uma avaliação com as estrelas');
        valido = false;
    }
    
    // Validar categoria
    const categoria = document.getElementById('categoria');
    if (!categoria.value) {
        mostrarErroCustomizado('Selecione uma categoria');
        valido = false;
    }
    
    // Validar campos obrigatórios
    const campos = document.querySelectorAll('.input-field[required]');
    campos.forEach(campo => {
        if (!validarCampo(campo)) {
            valido = false;
        }
    });
    
    // Validar recomendação
    const recomendacao = document.querySelector('input[name="recomendacao"]:checked');
    if (!recomendacao) {
        mostrarErroCustomizado('Selecione se recomendaria o SnackParadise');
        valido = false;
    }
    
    return valido;
}

// Validar Campo Individual
function validarCampo(campo) {
    const valor = campo.value.trim();
    let valido = true;
    let mensagem = '';
    
    // Remover mensagens de erro anteriores
    const errorMsg = campo.parentNode.querySelector('.error-message');
    if (errorMsg) errorMsg.remove();
    
    // Validação por tipo
    if (campo.hasAttribute('required') && !valor) {
        mensagem = 'Este campo é obrigatório';
        valido = false;
    } else if (campo.type === 'email' && valor) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(valor)) {
            mensagem = 'Digite um e-mail válido';
            valido = false;
        }
    } else if (campo.name === 'nome' && valor.length < 2) {
        mensagem = 'Nome deve ter pelo menos 2 caracteres';
        valido = false;
    } else if (campo.name === 'comentario' && valor.length < 10) {
        mensagem = 'Comentário deve ter pelo menos 10 caracteres';
        valido = false;
    }
    
    // Aplicar estilo e mensagem
    if (valido) {
        campo.classList.remove('error');
        campo.classList.add('success');
    } else {
        campo.classList.remove('success');
        campo.classList.add('error');
        mostrarErroNoCampo(campo, mensagem);
    }
    
    return valido;
}

// Mostrar Erro no Campo
function mostrarErroNoCampo(campo, mensagem) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message show';
    errorDiv.textContent = mensagem;
    campo.parentNode.appendChild(errorDiv);
}

// Mostrar Erro Customizado
function mostrarErroCustomizado(mensagem) {
    const container = document.querySelector('.formulario-container');
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message show';
    errorDiv.style.textAlign = 'center';
    errorDiv.style.marginBottom = '20px';
    errorDiv.style.padding = '10px';
    errorDiv.style.backgroundColor = '#fee';
    errorDiv.style.borderRadius = '8px';
    errorDiv.textContent = mensagem;
    
    // Remover erro anterior
    const errorAnterior = container.querySelector('.error-message');
    if (errorAnterior) errorAnterior.remove();
    
    container.insertBefore(errorDiv, container.firstChild);
    
    // Scroll para o topo
    container.scrollIntoView({ behavior: 'smooth', block: 'start' });
    
    // Remover após 5 segundos
    setTimeout(() => {
        if (errorDiv.parentNode) {
            errorDiv.remove();
        }
    }, 5000);
}

// Coletar Dados do Formulário
function coletarDadosFormulario() {
    const recomendacao = document.querySelector('input[name="recomendacao"]:checked');
    
    return {
        rating: document.getElementById('rating').value,
        categoria: document.getElementById('categoria').value,
        nome: document.getElementById('nome').value.trim(),
        email: document.getElementById('email').value.trim(),
        comentario: document.getElementById('comentario').value.trim(),
        recomendacao: recomendacao ? recomendacao.value : null,
        data: new Date().toISOString()
    };
}

// Resetar Formulário
function resetarFormulario() {
    // Resetar estrelas
    document.querySelectorAll('.estrela').forEach(estrela => {
        estrela.classList.remove('active');
    });
    document.getElementById('ratingText').textContent = 'Selecione uma avaliação';
    
    // Resetar categorias
    document.querySelectorAll('.categoria-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Resetar campos
    document.querySelectorAll('.input-field').forEach(campo => {
        campo.classList.remove('has-value', 'error', 'success');
    });
    
    // Resetar contador
    const contadorAtual = document.getElementById('contadorAtual');
    if (contadorAtual) {
        contadorAtual.textContent = '0';
        contadorAtual.style.color = '#6c757d';
    }
    
    // Remover mensagens de erro
    document.querySelectorAll('.error-message').forEach(msg => msg.remove());
}

// Simular Envio de Feedback
async function simularEnvioFeedback(dados) {
    console.log('📤 Enviando feedback:', dados);
    
    // Simular delay da API
    await new Promise(resolve => setTimeout(resolve, 1500 + Math.random() * 1000));
    
    // Simular sucesso
    console.log('📤 Feedback enviado com sucesso!');
}