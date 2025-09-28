// Sistema de Pontos SnackParadise
class SistemaPontos {
    constructor() {
        this.pontos = parseInt(localStorage.getItem('pontos_snackparadise') || '0');
        this.historico = JSON.parse(localStorage.getItem('historico_pontos') || '[]');
        this.inicializar();
    }

    inicializar() {
        this.atualizarInterface();
        this.carregarHistorico();
        this.verificarBotoesRecompensas();
        
        // Se for primeira vez, adicionar entrada de boas-vindas
        if (this.historico.length === 0) {
            this.adicionarHistorico('Bem-vindo ao programa!', 0, 'sistema');
        }
    }

    // Definir níveis e benefícios
    obterNivel() {
        if (this.pontos < 250) return { nome: 'Bronze', icone: '🥉', progresso: this.pontos, proximo: 250 };
        if (this.pontos < 500) return { nome: 'Prata', icone: '🥈', progresso: this.pontos - 250, proximo: 500 };
        if (this.pontos < 1000) return { nome: 'Ouro', icone: '🥇', progresso: this.pontos - 500, proximo: 1000 };
        return { nome: 'Diamante', icone: '💎', progresso: this.pontos - 1000, proximo: null };
    }

    // Atualizar interface do usuário
    atualizarInterface() {
        const pontosElement = document.getElementById('pontosAtuais');
        const nivelElement = document.getElementById('nivelAtual');
        const barraProgresso = document.getElementById('barraProgresso');
        const proximoNivelElement = document.getElementById('proximoNivel');

        // Atualizar pontos
        this.animarContador(pontosElement, this.pontos);

        // Atualizar nível
        const nivel = this.obterNivel();
        nivelElement.textContent = nivel.nome;

        // Atualizar barra de progresso
        let porcentagem = 0;
        let textoProximo = '';

        if (nivel.proximo) {
            const pontosNecessarios = nivel.proximo - (this.pontos - nivel.progresso);
            const progressoAtual = nivel.progresso;
            const progressoTotal = nivel.proximo === 250 ? 250 : 
                                   nivel.proximo === 500 ? 250 : 
                                   nivel.proximo === 1000 ? 500 : 0;
            
            porcentagem = (progressoAtual / progressoTotal) * 100;
            textoProximo = `${this.obterProximoNivel()} em ${pontosNecessarios} pontos`;
        } else {
            porcentagem = 100;
            textoProximo = 'Nível máximo atingido!';
        }

        barraProgresso.style.width = `${porcentagem}%`;
        proximoNivelElement.textContent = textoProximo;

        // Salvar no localStorage
        localStorage.setItem('pontos_snackparadise', this.pontos.toString());
        localStorage.setItem('historico_pontos', JSON.stringify(this.historico));
    }

    obterProximoNivel() {
        const nivel = this.obterNivel();
        if (nivel.nome === 'Bronze') return 'Prata';
        if (nivel.nome === 'Prata') return 'Ouro';
        if (nivel.nome === 'Ouro') return 'Diamante';
        return 'Máximo';
    }

    // Animar contador de pontos
    animarContador(element, valorFinal) {
        const valorInicial = parseInt(element.textContent) || 0;
        const diferenca = valorFinal - valorInicial;
        const duracao = 1000; // 1 segundo
        const incremento = diferenca / (duracao / 16); // 60 FPS

        let valorAtual = valorInicial;
        const intervalo = setInterval(() => {
            valorAtual += incremento;
            
            if ((incremento > 0 && valorAtual >= valorFinal) || 
                (incremento < 0 && valorAtual <= valorFinal)) {
                valorAtual = valorFinal;
                clearInterval(intervalo);
            }
            
            element.textContent = Math.floor(valorAtual).toLocaleString('pt-BR');
        }, 16);
    }

    // Adicionar pontos
    adicionarPontos(quantidade, descricao, tipo = 'ganho') {
        const pontosAnteriores = this.pontos;
        this.pontos += quantidade;
        
        this.adicionarHistorico(descricao, quantidade, tipo);
        this.atualizarInterface();
        this.verificarBotoesRecompensas();
        
        // Verificar se subiu de nível
        this.verificarSubidaNivel(pontosAnteriores, this.pontos);
        
        this.mostrarNotificacao(`+${quantidade} pontos adicionados!`, 'sucesso');
    }

    // Remover pontos (para trocas)
    removerPontos(quantidade, descricao) {
        if (this.pontos >= quantidade) {
            this.pontos -= quantidade;
            this.adicionarHistorico(descricao, -quantidade, 'troca');
            this.atualizarInterface();
            this.verificarBotoesRecompensas();
            return true;
        }
        return false;
    }

    // Verificar mudança de nível
    verificarSubidaNivel(pontosAnteriores, pontosAtuais) {
        const nivelAnterior = this.obterNivelPorPontos(pontosAnteriores);
        const nivelAtual = this.obterNivelPorPontos(pontosAtuais);
        
        if (nivelAnterior !== nivelAtual) {
            this.mostrarNotificacaoNivel(nivelAtual);
        }
    }

    obterNivelPorPontos(pontos) {
        if (pontos < 250) return 'Bronze';
        if (pontos < 500) return 'Prata';
        if (pontos < 1000) return 'Ouro';
        return 'Diamante';
    }

    // Mostrar notificação de novo nível
    mostrarNotificacaoNivel(novoNivel) {
        const icons = {
            'Bronze': '🥉',
            'Prata': '🥈',
            'Ouro': '🥇',
            'Diamante': '💎'
        };

        this.mostrarNotificacao(
            `Parabéns! Você alcançou o nível ${icons[novoNivel]} ${novoNivel}!`, 
            'nivel'
        );
    }

    // Sistema de notificações
    mostrarNotificacao(mensagem, tipo = 'info') {
        const notificacao = document.createElement('div');
        notificacao.className = `notificacao ${tipo}`;
        notificacao.textContent = mensagem;
        
        // Estilos da notificação
        Object.assign(notificacao.style, {
            position: 'fixed',
            top: '100px',
            right: '20px',
            padding: '15px 25px',
            borderRadius: '10px',
            color: 'white',
            fontWeight: '600',
            zIndex: '10000',
            transform: 'translateX(400px)',
            transition: 'transform 0.3s ease',
            boxShadow: '0 5px 15px rgba(0,0,0,0.3)'
        });

        // Cores por tipo
        const cores = {
            sucesso: '#4caf50',
            erro: '#f44336',
            nivel: '#ff9800',
            info: '#2196f3'
        };

        notificacao.style.background = cores[tipo] || cores.info;
        
        document.body.appendChild(notificacao);
        
        // Animação de entrada
        setTimeout(() => {
            notificacao.style.transform = 'translateX(0)';
        }, 100);
        
        // Remover após 4 segundos
        setTimeout(() => {
            notificacao.style.transform = 'translateX(400px)';
            setTimeout(() => {
                if (notificacao.parentNode) {
                    notificacao.parentNode.removeChild(notificacao);
                }
            }, 300);
        }, 4000);
    }

    // Adicionar entrada no histórico
    adicionarHistorico(descricao, pontos, tipo) {
        const entrada = {
            data: new Date().toLocaleDateString('pt-BR'),
            hora: new Date().toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' }),
            descricao,
            pontos,
            saldo: this.pontos,
            tipo
        };
        
        this.historico.unshift(entrada); // Adicionar no início
        
        // Limitar histórico a 50 entradas
        if (this.historico.length > 50) {
            this.historico = this.historico.slice(0, 50);
        }
    }

    // Carregar histórico na interface
    carregarHistorico() {
        const lista = document.getElementById('historicoLista');
        lista.innerHTML = '';
        
        this.historico.forEach(entrada => {
            const item = document.createElement('div');
            item.className = 'historico-item';
            
            const pontosClass = entrada.pontos >= 0 ? 'pontos-positivo' : 'pontos-negativo';
            const pontosTexto = entrada.pontos >= 0 ? `+${entrada.pontos}` : entrada.pontos;
            
            item.innerHTML = `
                <span>${entrada.data}</span>
                <span>${entrada.descricao}</span>
                <span class="${pontosClass}">${pontosTexto}</span>
                <span>${entrada.saldo}</span>
            `;
            
            lista.appendChild(item);
        });
    }

    // Verificar disponibilidade dos botões de recompensa
    verificarBotoesRecompensas() {
        const botoes = document.querySelectorAll('.btn-trocar');
        botoes.forEach(botao => {
            const custo = parseInt(botao.getAttribute('data-custo') || '0');
            botao.disabled = this.pontos < custo;
        });
    }
}

// Instanciar sistema
const sistemaPontos = new SistemaPontos();

// Função para simular gastos
function simularGastos() {
    const valores = [15, 25, 35, 50, 75, 100];
    const descricoes = [
        'Hambúrguer Clássico',
        'Combo Duplo',
        'Pizza Individual',
        'Combo Família',
        'Pedido Especial',
        'Grande Pedido'
    ];
    
    const indice = Math.floor(Math.random() * valores.length);
    const valor = valores[indice];
    const descricao = `Compra: ${descricoes[indice]} - R$${valor.toFixed(2)}`;
    
    sistemaPontos.adicionarPontos(valor, descricao, 'compra');
}

// Função para trocar recompensas
function trocarRecompensa(nome, custo) {
    if (sistemaPontos.pontos >= custo) {
        if (confirm(`Deseja trocar ${custo} pontos por: ${nome}?`)) {
            const sucesso = sistemaPontos.removerPontos(custo, `Troca: ${nome}`);
            if (sucesso) {
                sistemaPontos.mostrarNotificacao(`${nome} resgatado com sucesso!`, 'sucesso');
            }
        }
    } else {
        const faltam = custo - sistemaPontos.pontos;
        sistemaPontos.mostrarNotificacao(
            `Você precisa de mais ${faltam} pontos para esta recompensa.`, 
            'erro'
        );
    }
}

// Controle do menu lateral e submenu (reutilizando do arquivo anterior)
document.addEventListener('DOMContentLoaded', function() {
    // Menu Lateral
    const btnMenuLateral = document.getElementById('btnMenuLateral');
    const menuLateral = document.getElementById('menuLateral');
    const overlay = document.getElementById('overlay');

    btnMenuLateral.addEventListener('click', function(event) {
        event.stopPropagation();
        
        if (menuLateral.classList.contains('ativo')) {
            menuLateral.classList.remove('ativo');
            overlay.classList.remove('ativo');
            btnMenuLateral.classList.remove('active');
            btnMenuLateral.innerHTML = '☰';
        } else {
            menuLateral.classList.add('ativo');
            overlay.classList.add('ativo');
            btnMenuLateral.classList.add('active');
            btnMenuLateral.innerHTML = '✖';
        }
    });

    // Fechar menu lateral ao clicar no overlay
    overlay.addEventListener('click', function() {
        menuLateral.classList.remove('ativo');
        overlay.classList.remove('ativo');
        btnMenuLateral.classList.remove('active');
        btnMenuLateral.innerHTML = '☰';
    });

    // Submenu Cardápio
    const cardapioBtn = document.getElementById('cardapioBtn');
    const submenu = document.getElementById('submenu');

    if (cardapioBtn && submenu) {
        cardapioBtn.addEventListener('click', function(event) {
            event.stopPropagation();
            
            if (submenu.classList.contains('ativo')) {
                submenu.classList.remove('ativo');
                cardapioBtn.classList.remove('active');
            } else {
                submenu.classList.add('ativo');
                cardapioBtn.classList.add('active');
            }
        });

        // Evitar que cliques no submenu o fechem
        submenu.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    }

    // Fechar menus ao clicar fora
    document.addEventListener('click', function(event) {
        if (!menuLateral.contains(event.target) && 
            !btnMenuLateral.contains(event.target)) {
            menuLateral.classList.remove('ativo');
            overlay.classList.remove('ativo');
            btnMenuLateral.classList.remove('active');
            btnMenuLateral.innerHTML = '☰';
        }

        if (submenu && !submenu.contains(event.target) && 
            !cardapioBtn.contains(event.target)) {
            submenu.classList.remove('ativo');
            cardapioBtn.classList.remove('active');
        }
    });

    // Adicionar custos aos botões (data-attribute)
    const recompensas = [
        { selector: '.btn-trocar', custos: [150, 80, 60, 200, 120, 500] }
    ];

    const botoesTrocar = document.querySelectorAll('.btn-trocar');
    const custos = [150, 80, 60, 200, 120, 500];
    
    botoesTrocar.forEach((botao, index) => {
        if (custos[index]) {
            botao.setAttribute('data-custo', custos[index]);
        }
    });

    // Inicializar verificação dos botões
    sistemaPontos.verificarBotoesRecompensas();
});

// Atalhos de teclado
document.addEventListener('keydown', function(event) {
    // Alt + S para simular gastos
    if (event.altKey && event.key === 's') {
        event.preventDefault();
        simularGastos();
    }
    
    // Alt + M para abrir/fechar menu lateral
    if (event.altKey && event.key === 'm') {
        event.preventDefault();
        document.getElementById('btnMenuLateral').click();
    }
});

// Função para resetar pontos (apenas para desenvolvimento)
function resetarPontos() {
    if (confirm('Tem certeza que deseja resetar todos os pontos? Esta ação não pode ser desfeita.')) {
        localStorage.removeItem('pontos_snackparadise');
        localStorage.removeItem('historico_pontos');
        location.reload();
    }
}

// Adicionar função global para debug (remover em produção)
window.debug = {
    adicionarPontos: (quantidade) => sistemaPontos.adicionarPontos(quantidade, `Debug: +${quantidade} pontos`),
    resetar: resetarPontos,
    pontos: () => sistemaPontos.pontos,
    nivel: () => sistemaPontos.obterNivel()
};