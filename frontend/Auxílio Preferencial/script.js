// Script completo e funcional para SnackParadise
console.log('🍔 Iniciando SnackParadise...');

// Aguardar o DOM estar completamente carregado
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ DOM carregado, iniciando funcionalidades...');
    
    // Inicializar todas as funcionalidades
    inicializarPagina();
    inicializarMenuLateral();
    inicializarSubmenu();
    configurarAcessibilidade();
    configurarPerformance();
    
    console.log('🚀 SnackParadise inicializado com sucesso!');
});

// ============= INICIALIZAÇÃO DA PÁGINA =============
function inicializarPagina() {
    console.log('⚙️ Inicializando página...');
    
    // Mostrar o body gradualmente
    setTimeout(() => {
        document.body.classList.add('loaded');
        document.body.style.opacity = '1';
    }, 100);
    
    // Configurar funcionalidades extras
    configurarLazyLoading();
    configurarSmoothScroll();
    configurarTooltips();
}

// ============= MENU LATERAL =============
function inicializarMenuLateral() {
    console.log('📱 Configurando menu lateral...');
    
    const btnMenuLateral = document.getElementById('btnMenuLateral');
    const menuLateral = document.getElementById('menuLateral');
    const overlay = document.getElementById('overlay');
    
    if (!btnMenuLateral || !menuLateral || !overlay) {
        console.warn('⚠️ Elementos do menu lateral não encontrados');
        return;
    }
    
    // Evento principal do botão
    btnMenuLateral.addEventListener('click', function(e) {
        e.preventDefault();
        console.log('🖱️ Clique no botão do menu lateral');
        
        const isAtivo = menuLateral.classList.contains('ativo');
        
        if (isAtivo) {
            fecharMenuLateral();
        } else {
            abrirMenuLateral();
        }
    });
    
    // Fechar ao clicar no overlay
    overlay.addEventListener('click', function() {
        fecharMenuLateral();
    });
    
    // Funções internas do menu lateral
    function abrirMenuLateral() {
        console.log('📂 Abrindo menu lateral');
        menuLateral.classList.add('ativo');
        overlay.classList.add('ativo');
        btnMenuLateral.classList.add('active');
        btnMenuLateral.innerHTML = '✕';
        document.body.style.overflow = 'hidden';
        
        // Acessibilidade
        btnMenuLateral.setAttribute('aria-expanded', 'true');
    }
    
    function fecharMenuLateral() {
        console.log('📁 Fechando menu lateral');
        menuLateral.classList.remove('ativo');
        overlay.classList.remove('ativo');
        btnMenuLateral.classList.remove('active');
        btnMenuLateral.innerHTML = '☰';
        document.body.style.overflow = 'auto';
        
        // Acessibilidade
        btnMenuLateral.setAttribute('aria-expanded', 'false');
    }
    
    // Expor função globalmente
    window.fecharMenuLateral = fecharMenuLateral;
}

// ============= SUBMENU DO CARDÁPIO =============
function inicializarSubmenu() {
    console.log('🍽️ Configurando submenu do cardápio...');
    
    const cardapioBtn = document.getElementById('cardapioBtn');
    const submenu = document.getElementById('submenu');
    
    if (!cardapioBtn || !submenu) {
        console.warn('⚠️ Elementos do submenu não encontrados');
        console.warn('cardapioBtn:', !!cardapioBtn, 'submenu:', !!submenu);
        return;
    }
    
    console.log('✅ Submenu encontrado e configurado');
    
    let timeoutSubmenu = null;
    
    // Evento de clique principal
    cardapioBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        console.log('🖱️ Clique no cardápio detectado');
        
        const isAtivo = submenu.classList.contains('ativo');
        
        if (isAtivo) {
            fecharSubmenu();
        } else {
            abrirSubmenu();
        }
    });
    
    // Hover para desktop (largura > 768px)
    if (window.innerWidth > 768) {
        console.log('🖥️ Configurando hover para desktop');
        
        cardapioBtn.addEventListener('mouseenter', function() {
            clearTimeout(timeoutSubmenu);
            abrirSubmenu();
        });
        
        cardapioBtn.addEventListener('mouseleave', function() {
            timeoutSubmenu = setTimeout(() => {
                if (!submenu.matches(':hover')) {
                    fecharSubmenu();
                }
            }, 300);
        });
        
        submenu.addEventListener('mouseenter', function() {
            clearTimeout(timeoutSubmenu);
        });
        
        submenu.addEventListener('mouseleave', function() {
            timeoutSubmenu = setTimeout(() => {
                fecharSubmenu();
            }, 300);
        });
    }
    
    // Fechar ao clicar fora
    document.addEventListener('click', function(e) {
        if (!cardapioBtn.contains(e.target)) {
            fecharSubmenu();
        }
    });
    
    // Funções internas do submenu
    function abrirSubmenu() {
        console.log('📋 Abrindo submenu');
        
        // Fechar outros submenus se existirem
        document.querySelectorAll('.submenu.ativo').forEach(sub => {
            if (sub !== submenu) {
                sub.classList.remove('ativo');
            }
        });
        
        submenu.classList.add('ativo');
        cardapioBtn.classList.add('active');
        
        // Acessibilidade
        cardapioBtn.setAttribute('aria-expanded', 'true');
        
        console.log('✅ Submenu aberto, classes:', submenu.className);
    }
    
    function fecharSubmenu() {
        console.log('❌ Fechando submenu');
        
        submenu.classList.remove('ativo');
        cardapioBtn.classList.remove('active');
        
        // Acessibilidade
        cardapioBtn.setAttribute('aria-expanded', 'false');
        
        console.log('✅ Submenu fechado, classes:', submenu.className);
    }
    
    // Expor funções globalmente
    window.abrirSubmenu = abrirSubmenu;
    window.fecharSubmenu = fecharSubmenu;
}

// ============= ACESSIBILIDADE =============
function configurarAcessibilidade() {
    console.log('♿ Configurando acessibilidade...');
    
    // Navegação por teclado
    document.addEventListener('keydown', function(event) {
        // Tab para navegação
        if (event.key === 'Tab') {
            document.body.classList.add('usando-teclado');
        }
        
        // ESC para fechar menus
        if (event.key === 'Escape') {
            console.log('⌨️ ESC pressionado - fechando menus');
            
            // Fechar menu lateral
            if (window.fecharMenuLateral) {
                window.fecharMenuLateral();
            }
            
            // Fechar submenu
            if (window.fecharSubmenu) {
                window.fecharSubmenu();
            }
        }
        
        // Enter/Space para ativar elementos
        if (event.key === 'Enter' || event.key === ' ') {
            const elemento = document.activeElement;
            if (elemento && (
                elemento.classList.contains('menu-item') ||
                elemento.classList.contains('btn-menu-lateral') ||
                elemento.classList.contains('cardapio-btn') ||
                elemento.classList.contains('clickable')
            )) {
                event.preventDefault();
                elemento.click();
            }
        }
    });
    
    // Remover classe de teclado quando usar mouse
    document.addEventListener('mousedown', function() {
        document.body.classList.remove('usando-teclado');
    });
    
    // Configurar atributos ARIA
    configurarAtributosAria();
}

function configurarAtributosAria() {
    // Botão do menu lateral
    const btnMenuLateral = document.getElementById('btnMenuLateral');
    if (btnMenuLateral && !btnMenuLateral.getAttribute('aria-label')) {
        btnMenuLateral.setAttribute('aria-label', 'Abrir menu de navegação lateral');
        btnMenuLateral.setAttribute('aria-expanded', 'false');
        btnMenuLateral.setAttribute('aria-controls', 'menuLateral');
    }
    
    // Menu lateral
    const menuLateral = document.getElementById('menuLateral');
    if (menuLateral && !menuLateral.getAttribute('role')) {
        menuLateral.setAttribute('role', 'navigation');
        menuLateral.setAttribute('aria-label', 'Menu de navegação lateral');
    }
    
    // Botão do cardápio
    const cardapioBtn = document.getElementById('cardapioBtn');
    if (cardapioBtn && !cardapioBtn.getAttribute('aria-label')) {
        cardapioBtn.setAttribute('aria-label', 'Abrir menu do cardápio');
        cardapioBtn.setAttribute('aria-expanded', 'false');
        cardapioBtn.setAttribute('aria-controls', 'submenu');
        cardapioBtn.setAttribute('aria-haspopup', 'true');
    }
    
    // Submenu
    const submenu = document.getElementById('submenu');
    if (submenu && !submenu.getAttribute('role')) {
        submenu.setAttribute('role', 'menu');
        submenu.setAttribute('aria-label', 'Menu do cardápio');
    }
    
    // Itens do submenu
    document.querySelectorAll('.submenu-item').forEach((item, index) => {
        if (!item.getAttribute('role')) {
            item.setAttribute('role', 'menuitem');
            item.setAttribute('tabindex', '-1');
        }
    });
}

// ============= TOOLTIPS =============
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
    
    // Remover tooltip existente
    esconderTooltip();
    
    // Criar novo tooltip
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip-ativo';
    tooltip.textContent = textoTooltip;
    
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
        whiteSpace: 'nowrap',
        maxWidth: '200px'
    });
    
    document.body.appendChild(tooltip);
    
    // Posicionamento inteligente
    const rect = elemento.getBoundingClientRect();
    const tooltipRect = tooltip.getBoundingClientRect();
    
    let left = rect.left + rect.width / 2 - tooltipRect.width / 2;
    let top = rect.top - tooltipRect.height - 8;
    
    // Ajustar se sair da tela
    if (left < 0) left = 8;
    if (left + tooltipRect.width > window.innerWidth) {
        left = window.innerWidth - tooltipRect.width - 8;
    }
    if (top < 0) top = rect.bottom + 8;
    
    tooltip.style.left = left + 'px';
    tooltip.style.top = top + 'px';
    
    // Animar entrada
    setTimeout(() => {
        tooltip.style.opacity = '1';
    }, 10);
}

function esconderTooltip() {
    const tooltip = document.querySelector('.tooltip-ativo');
    if (tooltip) {
        tooltip.style.opacity = '0';
        setTimeout(() => {
            if (tooltip.parentNode) {
                tooltip.parentNode.removeChild(tooltip);
            }
        }, 200);
    }
}

// ============= LAZY LOADING DE IMAGENS =============
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
        }, {
            rootMargin: '50px'
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
}

// ============= SMOOTH SCROLL =============
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
                
                // Atualizar URL
                if (history.pushState) {
                    history.pushState(null, null, `#${targetId}`);
                }
            }
        });
    });
}

// ============= PERFORMANCE =============
function configurarPerformance() {
    // Throttle para scroll
    let scrollTimer;
    window.addEventListener('scroll', function() {
        if (scrollTimer) clearTimeout(scrollTimer);
        scrollTimer = setTimeout(() => {
            handleScroll();
        }, 16); // ~60fps
    }, { passive: true });
    
    // Throttle para resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        if (resizeTimer) clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            handleResize();
        }, 100);
    });
}

function handleScroll() {
    const scrollY = window.scrollY;
    
    // Header com efeito scroll
    const header = document.querySelector('header');
    if (header) {
        if (scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    }
    
    // Animações on scroll
    const elementos = document.querySelectorAll('.animar-on-scroll:not(.animado)');
    elementos.forEach(elemento => {
        const rect = elemento.getBoundingClientRect();
        if (rect.top < window.innerHeight * 0.8) {
            elemento.classList.add('animado');
        }
    });
}

function handleResize() {
    const largura = window.innerWidth;
    
    // Atualizar classes responsivas
    document.body.classList.toggle('mobile', largura <= 480);
    document.body.classList.toggle('tablet', largura > 480 && largura <= 768);
    document.body.classList.toggle('desktop', largura > 768);
    
    // Reconfigurar submenu se necessário
    if (largura <= 768) {
        // Remover eventos de hover em mobile
        const cardapioBtn = document.getElementById('cardapioBtn');
        if (cardapioBtn) {
            cardapioBtn.replaceWith(cardapioBtn.cloneNode(true));
            // Reconfigurar apenas o clique
            inicializarSubmenu();
        }
    }
}

// ============= SISTEMA DE NOTIFICAÇÕES =============
const Notificacoes = {
    mostrar: function(mensagem, tipo = 'info', duracao = 4000) {
        const notificacao = document.createElement('div');
        notificacao.className = `notificacao-global ${tipo}`;
        notificacao.innerHTML = `
            <span class="notificacao-texto">${mensagem}</span>
            <button class="notificacao-fechar" onclick="this.parentElement.remove()" aria-label="Fechar notificação">×</button>
        `;
        
        const cores = {
            sucesso: '#4caf50',
            erro: '#f44336',
            aviso: '#ff9800',
            info: '#2196f3'
        };
        
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
            maxWidth: '400px',
            background: cores[tipo] || cores.info,
            transform: 'translateX(400px)',
            transition: 'transform 0.3s ease, opacity 0.3s ease',
            boxShadow: '0 4px 12px rgba(0,0,0,0.15)'
        });
        
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

// ============= UTILITÁRIOS =============
const Utils = {
    isMobile: function() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    },
    
    isTouch: function() {
        return 'ontouchstart' in window || navigator.maxTouchPoints > 0;
    },
    
    formatarMoeda: function(valor) {
        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(valor);
    },
    
    validarEmail: function(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    },
    
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
    
    throttle: function(func, limit) {
        let inThrottle;
        return function(...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }
};

// ============= FUNÇÃO DE DEBUG =============
window.debugSnackParadise = function() {
    console.log('🔍 === DEBUG SNACK PARADISE ===');
    console.log('Menu lateral:', document.getElementById('menuLateral'));
    console.log('Botão menu lateral:', document.getElementById('btnMenuLateral'));
    console.log('Cardápio btn:', document.getElementById('cardapioBtn'));
    console.log('Submenu:', document.getElementById('submenu'));
    console.log('Overlay:', document.getElementById('overlay'));
    
    const cardapioBtn = document.getElementById('cardapioBtn');
    const submenu = document.getElementById('submenu');
    
    if (cardapioBtn && submenu) {
        console.log('Classes do cardápio:', cardapioBtn.className);
        console.log('Classes do submenu:', submenu.className);
        console.log('Estilos computados do submenu:', window.getComputedStyle(submenu));
    }
    
    console.log('Utils disponíveis:', Object.keys(Utils));
    console.log('Notificações disponíveis:', Object.keys(Notificacoes));
};

// ============= EXPOSIÇÃO GLOBAL =============
window.Utils = Utils;
window.Notificacoes = Notificacoes;

// ============= INICIALIZAÇÃO FINAL =============
console.log('📋 Script SnackParadise carregado completamente!');
console.log('🛠️ Para debug, use: debugSnackParadise()');

// Notificar que está tudo pronto
setTimeout(() => {
    if (document.body.classList.contains('loaded')) {
        console.log('🎉 SnackParadise totalmente funcional!');
    }
}, 500);