// Script geral para funcionalidades comuns do SnackParadise

// Inicialização da página
document.addEventListener('DOMContentLoaded', function() {
    inicializarPagina();
    configurarTransicoesPagina();
    configurarAcessibilidade();
    configurarPerformance();
});

// Função principal de inicialização
function inicializarPagina() {
    // Adicionar classe loaded para animações
    setTimeout(() => {
        document.body.classList.add('loaded');
    }, 100);
    
    // Configurar tooltips
    configurarTooltips();
    
    // Configurar lazy loading para imagens
    configurarLazyLoading();
    
    // Configurar smooth scroll
    configurarSmoothScroll();
}

// Configurar transições entre páginas
function configurarTransicoesPagina() {
    // Selecionar todos os links que não são âncoras
    document.querySelectorAll('a[href]:not([href^="#"])').forEach(link => {
        link.addEventListener('click', function(event) {
            // Verificar se é um link externo
            if (this.hostname && this.hostname !== window.location.hostname) {
                return; // Permitir comportamento padrão para links externos
            }
            
            // Verificar se não é um link com target="_blank"
            if (this.target === '_blank') {
                return;
            }
            
            event.preventDefault();
            
            const destino = this.href;
            
            // Animação de saída
            document.body.style.transition = 'opacity 0.3s ease-in-out';
            document.body.style.opacity = '0';
            
            setTimeout(() => {
                window.location.href = destino;
            }, 300);
        });
    });
}

// Configurar acessibilidade
function configurarAcessibilidade() {
    // Navegação por teclado
    document.addEventListener('keydown', function(event) {
        // Tab para navegação
        if (event.key === 'Tab') {
            document.body.classList.add('usando-teclado');
        }
        
        // Esc para fechar modais/menus
        if (event.key === 'Escape') {
            fecharTodosModais();
        }
        
        // Enter e Space para ativar elementos clicáveis
        if (event.key === 'Enter' || event.key === ' ') {
            const elemento = document.activeElement;
            if (elemento && elemento.classList.contains('clickable')) {
                event.preventDefault();
                elemento.click();
            }
        }
    });
    
    // Remover classe quando usar mouse
    document.addEventListener('mousedown', function() {
        document.body.classList.remove('usando-teclado');
    });
    
    // Configurar ARIA labels dinâmicos
    configurarAriaLabels();
}

// Configurar tooltips
function configurarTooltips() {
    const elementos = document.querySelectorAll('[data-tooltip]');
    
    elementos.forEach(elemento => {
        elemento.addEventListener('mouseenter', mostrarTooltip);
        elemento.addEventListener('mouseleave', esconderTooltip);
        elemento.addEventListener('focus', mostrarTooltip);
        elemento.addEventListener('blur', esconderTooltip);
    });
}

function mostrarTooltip(event) {
    const elemento = event.target;
    const textoTooltip = elemento.getAttribute('data-tooltip');
    
    if (!textoTooltip) return;
    
    // Criar tooltip
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip';
    tooltip.textContent = textoTooltip;
    tooltip.id = 'tooltip-ativo';
    
    // Estilos do tooltip
    Object.assign(tooltip.style, {
        position: 'absolute',
        background: '#333',
        color: 'white',
        padding: '8px 12px',
        borderRadius: '4px',
        fontSize: '0.9rem',
        zIndex: '10000',
        pointerEvents: 'none',
        opacity: '0',
        transition: 'opacity 0.2s ease',
        whiteSpace: 'nowrap'
    });
    
    document.body.appendChild(tooltip);
    
    // Posicionar tooltip
    const rect = elemento.getBoundingClientRect();
    const tooltipRect = tooltip.getBoundingClientRect();
    
    tooltip.style.left = (rect.left + rect.width / 2 - tooltipRect.width / 2) + 'px';
    tooltip.style.top = (rect.top - tooltipRect.height - 8) + 'px';
    
    // Animar entrada
    setTimeout(() => {
        tooltip.style.opacity = '1';
    }, 10);
}

function esconderTooltip() {
    const tooltip = document.getElementById('tooltip-ativo');
    if (tooltip) {
        tooltip.style.opacity = '0';
        setTimeout(() => {
            if (tooltip.parentNode) {
                tooltip.parentNode.removeChild(tooltip);
            }
        }, 200);
    }
}

// Configurar lazy loading para imagens
function configurarLazyLoading() {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
}

// Configurar smooth scroll
function configurarSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Atualizar URL sem recarregar
                history.pushState(null, null, `#${targetId}`);
            }
        });
    });
}

// Configurar ARIA labels dinâmicos
function configurarAriaLabels() {
    // Botões com ícones
    document.querySelectorAll('button[aria-label=""]').forEach(botao => {
        if (botao.textContent.trim() === '') {
            const icone = botao.querySelector('i, svg');
            if (icone) {
                botao.setAttribute('aria-label', 'Botão de ação');
            }
        }
    });
    
    // Links sem texto
    document.querySelectorAll('a:not([aria-label])').forEach(link => {
        if (link.textContent.trim() === '') {
            const img = link.querySelector('img');
            if (img && img.alt) {
                link.setAttribute('aria-label', img.alt);
            } else {
                link.setAttribute('aria-label', 'Link');
            }
        }
    });
}

// Fechar todos os modais/menus
function fecharTodosModais() {
    // Fechar menu lateral
    const menuLateral = document.getElementById('menuLateral');
    const btnMenuLateral = document.getElementById('btnMenuLateral');
    const overlay = document.getElementById('overlay');
    
    if (menuLateral && menuLateral.classList.contains('ativo')) {
        menuLateral.classList.remove('ativo');
        overlay.classList.remove('ativo');
        btnMenuLateral.classList.remove('active');
        btnMenuLateral.innerHTML = '☰';
    }
    
    // Fechar submenu
    const submenu = document.getElementById('submenu');
    const cardapioBtn = document.getElementById('cardapioBtn');
    
    if (submenu && submenu.classList.contains('ativo')) {
        submenu.classList.remove('ativo');
        cardapioBtn.classList.remove('active');
    }
    
    // Fechar outros modais
    document.querySelectorAll('.modal.ativo, .popup.ativo').forEach(modal => {
        modal.classList.remove('ativo');
    });
}

// Configurar performance
function configurarPerformance() {
    // Throttle para eventos de scroll e resize
    let scrollTimer, resizeTimer;
    
    window.addEventListener('scroll', function() {
        if (scrollTimer) clearTimeout(scrollTimer);
        scrollTimer = setTimeout(() => {
            handleScroll();
        }, 16); // ~60fps
    }, { passive: true });
    
    window.addEventListener('resize', function() {
        if (resizeTimer) clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            handleResize();
        }, 100);
    });
    
    // Precarregar recursos importantes
    precarregarRecursos();
}

// Manipular eventos de scroll
function handleScroll() {
    const scrollY = window.scrollY;
    
    // Header fixo com efeito
    const header = document.querySelector('header');
    if (header) {
        if (scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    }
    
    // Botão voltar ao topo
    const botaoTopo = document.getElementById('voltarTopo');
    if (botaoTopo) {
        if (scrollY > 500) {
            botaoTopo.classList.add('visivel');
        } else {
            botaoTopo.classList.remove('visivel');
        }
    }
    
    // Animações on scroll
    animarElementosOnScroll();
}

// Manipular eventos de resize
function handleResize() {
    // Ajustar elementos responsivos
    ajustarElementosResponsivos();
    
    // Recalcular posições
    recalcularPosicoes();
}

// Animar elementos quando entram na tela
function animarElementosOnScroll() {
    const elementos = document.querySelectorAll('.animar-on-scroll');
    
    elementos.forEach(elemento => {
        const rect = elemento.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        
        if (rect.top < windowHeight * 0.8) {
            elemento.classList.add('animado');
        }
    });
}

// Precarregar recursos importantes
function precarregarRecursos() {
    // Precarregar fontes críticas
    const fontLinks = [
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap'
    ];
    
    fontLinks.forEach(font => {
        const link = document.createElement('link');
        link.rel = 'preload';
        link.href = font;
        link.as = 'style';
        link.onload = function() { this.rel = 'stylesheet'; };
        document.head.appendChild(link);
    });
    
    // Precarregar imagens importantes
    const imagensImportantes = [
        'data:image/svg+xml,<svg>...</svg>' // Logo, por exemplo
    ];
    
    imagensImportantes.forEach(src => {
        const img = new Image();
        img.src = src;
    });
}

// Utilitários
const Utils = {
    // Debounce
    debounce: function(func, wait, immediate) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                timeout = null;
                if (!immediate) func(...args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func(...args);
        };
    },
    
    // Throttle
    throttle: function(func, limit) {
        let inThrottle;
        return function(...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    },
    
    // Detectar dispositivo mobile
    isMobile: function() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    },
    
    // Detectar se suporta touch
    isTouch: function() {
        return 'ontouchstart' in window || navigator.maxTouchPoints > 0;
    },
    
    // Formatar números
    formatarNumero: function(num) {
        return num.toLocaleString('pt-BR');
    },
    
    // Formatar moeda
    formatarMoeda: function(valor) {
        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(valor);
    },
    
    // Validar email
    validarEmail: function(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    },
    
    // Sanitizar HTML
    sanitizarHTML: function(str) {
        const temp = document.createElement('div');
        temp.textContent = str;
        return temp.innerHTML;
    }
};

// Configurações globais
const Config = {
    animacaoRapida: 200,
    animacaoMedia: 400,
    animacaoLenta: 600,
    breakpoints: {
        mobile: 480,
        tablet: 768,
        desktop: 1024,
        large: 1400
    },
    cores: {
        primaria: '#a20908',
        secundaria: '#f40919',
        amarelo: '#fccc16',
        dourado: '#fabb18'
    }
};

// Ajustar elementos responsivos
function ajustarElementosResponsivos() {
    const largura = window.innerWidth;
    
    // Ajustes específicos por breakpoint
    if (largura <= Config.breakpoints.mobile) {
        document.body.classList.add('mobile');
        document.body.classList.remove('tablet', 'desktop');
    } else if (largura <= Config.breakpoints.tablet) {
        document.body.classList.add('tablet');
        document.body.classList.remove('mobile', 'desktop');
    } else {
        document.body.classList.add('desktop');
        document.body.classList.remove('mobile', 'tablet');
    }
}

// Recalcular posições
function recalcularPosicoes() {
    // Reposicionar elementos fixos se necessário
    const elementosFixos = document.querySelectorAll('.posicao-fixa');
    elementosFixos.forEach(elemento => {
        // Lógica para reposicionar se necessário
    });
}

// Sistema de notificações globais
const Notificacoes = {
    mostrar: function(mensagem, tipo = 'info', duracao = 4000) {
        const notificacao = document.createElement('div');
        notificacao.className = `notificacao-global ${tipo}`;
        notificacao.innerHTML = `
            <span class="notificacao-texto">${mensagem}</span>
            <button class="notificacao-fechar" onclick="this.parentElement.remove()">×</button>
        `;
        
        // Estilos
        Object.assign(notificacao.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            padding: '15px 20px',
            borderRadius: '8px',
            color: 'white',
            fontWeight: '500',
            zIndex: '10001',
            minWidth: '300px',
            transform: 'translateX(400px)',
            transition: 'transform 0.3s ease, opacity 0.3s ease',
            boxShadow: '0 4px 12px rgba(0,0,0,0.15)'
        });
        
        // Cores por tipo
        const cores = {
            sucesso: '#4caf50',
            erro: '#f44336',
            aviso: '#ff9800',
            info: '#2196f3'
        };
        
        notificacao.style.background = cores[tipo] || cores.info;
        
        document.body.appendChild(notificacao);
        
        // Animação de entrada
        setTimeout(() => {
            notificacao.style.transform = 'translateX(0)';
        }, 100);
        
        // Auto remover
        if (duracao > 0) {
            setTimeout(() => {
                notificacao.style.transform = 'translateX(400px)';
                setTimeout(() => {
                    if (notificacao.parentNode) {
                        notificacao.parentNode.removeChild(notificacao);
                    }
                }, 300);
            }, duracao);
        }
    }
};

// Exposar utilitários globalmente
window.Utils = Utils;
window.Config = Config;
window.Notificacoes = Notificacoes;

// Log de inicialização
console.log('SnackParadise - Sistema carregado com sucesso!');

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
});
