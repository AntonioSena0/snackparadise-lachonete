// Smooth scrolling para os links de navegação
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Efeito avançado no header ao fazer scroll
let lastScrollTop = 0;
window.addEventListener('scroll', function() {
    const header = document.querySelector('.header');
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    if (scrollTop > 100) {
        header.style.background = 'rgba(0, 0, 0, 0.98)';
        header.style.backdropFilter = 'blur(15px)';
        header.style.borderBottom = '1px solid rgba(255, 255, 0, 0.3)';
    } else {
        header.style.background = 'rgba(0, 0, 0, 0.9)';
        header.style.backdropFilter = 'blur(5px)';
        header.style.borderBottom = 'none';
    }
    
    // Hide/show header on scroll
    if (scrollTop > lastScrollTop && scrollTop > 200) {
        header.style.transform = 'translateY(-100%)';
    } else {
        header.style.transform = 'translateY(0)';
    }
    lastScrollTop = scrollTop;
});

// Intersection Observer para animações avançadas
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-in');
            
            // Animações específicas por elemento
            if (entry.target.classList.contains('service-card')) {
                const icon = entry.target.querySelector('.service-icon');
                const features = entry.target.querySelectorAll('.feature-item, .benefit-item');
                
                // Animar ícone
                setTimeout(() => {
                    icon.style.transform = 'scale(1.2) rotate(360deg)';
                    icon.style.transition = 'all 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
                }, 200);
                
                setTimeout(() => {
                    icon.style.transform = 'scale(1) rotate(0deg)';
                }, 1000);
                
                // Animar features com delay
                features.forEach((feature, index) => {
                    setTimeout(() => {
                        feature.style.opacity = '1';
                        feature.style.transform = 'translateY(0) scale(1)';
                        feature.style.transition = 'all 0.6s ease';
                    }, 300 + (index * 100));
                });
            }
            
            if (entry.target.classList.contains('popular-item')) {
                const badge = entry.target.querySelector('.item-badge');
                if (badge) {
                    setTimeout(() => {
                        badge.style.animation = 'bounce 0.6s ease';
                    }, 500);
                }
            }
        }
    });
}, observerOptions);

// Observar elementos para animação
document.querySelectorAll('.service-card, .popular-item, .highlight-item').forEach(element => {
    // Configurar estado inicial
    element.style.opacity = '0';
    element.style.transform = 'translateY(50px)';
    element.style.transition = 'all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
    
    // Configurar features para animação
    const features = element.querySelectorAll('.feature-item, .benefit-item');
    features.forEach(feature => {
        feature.style.opacity = '0';
        feature.style.transform = 'translateY(30px) scale(0.9)';
    });
    
    observer.observe(element);
});

// Funcionalidade do vídeo com efeitos avançados
function playVideo() {
    const videoContainer = document.querySelector('.video-container');
    const placeholder = videoContainer.querySelector('.video-placeholder');
    
    // Efeito de loading
    placeholder.innerHTML = `
        <div class="video-loading">
            <div class="loading-spinner"></div>
            <p>Carregando vídeo...</p>
        </div>
    `;
    
    // Adicionar CSS do spinner
    const spinnerCSS = `
        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(255, 255, 0, 0.3);
            border-top: 4px solid #ffff00;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 1rem;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .video-loading {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: white;
        }
    `;
    
    if (!document.querySelector('#spinner-styles')) {
        const style = document.createElement('style');
        style.id = 'spinner-styles';
        style.textContent = spinnerCSS;
        document.head.appendChild(style);
    }
    
    // Simular carregamento e substituir por iframe (exemplo com YouTube)
    setTimeout(() => {
        videoContainer.innerHTML = `
            <iframe 
                src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
                frameborder="0" 
                allowfullscreen
                style="width: 100%; height: 100%;">
            </iframe>
        `;
    }, 2000);
}

// Efeitos hover avançados nos botões
document.querySelectorAll('.hero-btn, .service-btn, .view-menu-btn').forEach(btn => {
    btn.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-5px) scale(1.05)';
        this.style.filter = 'drop-shadow(0 10px 20px rgba(255, 255, 0, 0.3))';
        
        // Efeito ripple
        const ripple = document.createElement('div');
        ripple.style.cssText = `
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: ripple 0.6s linear;
            pointer-events: none;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        `;
        
        const rippleCSS = `
            @keyframes ripple {
                to {
                    transform: translate(-50%, -50%) scale(10);
                    opacity: 0;
                }
            }
        `;
        
        if (!document.querySelector('#ripple-styles')) {
            const style = document.createElement('style');
            style.id = 'ripple-styles';
            style.textContent = rippleCSS;
            document.head.appendChild(style);
        }
        
        this.style.position = 'relative';
        this.style.overflow = 'hidden';
        this.appendChild(ripple);
        
        setTimeout(() => {
            if (ripple.parentNode) {
                ripple.remove();
            }
        }, 600);
    });
    
    btn.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
        this.style.filter = 'none';
    });
});

// Parallax suave para elementos
window.addEventListener('scroll', function() {
    const scrolled = window.pageYOffset;
    
    // Hero parallax
    const heroContent = document.querySelector('.hero-content');
    if (heroContent) {
        heroContent.style.transform = `translateY(${scrolled * 0.2}px)`;
    }
    
    // Ícones flutuantes parallax
    const floatingIcons = document.querySelectorAll('.floating-icons i');
    floatingIcons.forEach((icon, index) => {
        const speed = 0.1 + (index * 0.05);
        icon.style.transform = `translateY(${scrolled * speed}px) rotate(${scrolled * 0.1}deg)`;
    });
    
    // Background parallax
    const serviceCards = document.querySelectorAll('.service-card');
    serviceCards.forEach((card, index) => {
        const rect = card.getBoundingClientRect();
        const speed = 0.05 * (index + 1);
        
        if (rect.top < window.innerHeight && rect.bottom > 0) {
            card.style.backgroundPosition = `50% ${50 + scrolled * speed}%`;
        }
    });
});

// Contador animado para highlights
function animateNumbers() {
    const numbers = document.querySelectorAll('.highlight-number');
    
    numbers.forEach(number => {
        const target = parseInt(number.textContent.replace(/\D/g, ''));
        const suffix = number.textContent.replace(/\d/g, '');
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                clearInterval(timer);
                current = target;
            }
            number.textContent = Math.floor(current) + suffix;
        }, 50);
    });
}

// Ativar contador quando a seção aparecer
const aboutCard = document.querySelector('.about-card');
if (aboutCard) {
    const aboutObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateNumbers();
                aboutObserver.disconnect();
            }
        });
    }, { threshold: 0.5 });
    
    aboutObserver.observe(aboutCard);
}

// Navegação ativa
window.addEventListener('scroll', function() {
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-menu a[href^="#"]');
    
    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop - 150;
        const sectionHeight = section.clientHeight;
        
        if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
            current = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
            link.classList.add('active');
            link.style.background = 'rgba(255, 255, 0, 0.2)';
            link.style.color = '#ffff00';
        } else {
            link.style.background = 'transparent';
            link.style.color = 'white';
        }
    });
});

// Adicionar estilos CSS para bounce animation
const bounceCSS = `
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
`;

const bounceStyle = document.createElement('style');
bounceStyle.textContent = bounceCSS;
document.head.appendChild(bounceStyle);

// Preloader para melhor experiência
window.addEventListener('load', function() {
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.5s ease';
    
    setTimeout(() => {
        document.body.style.opacity = '1';
    }, 100);
});

// Easter egg - clique triplo no logo
let logoClickCount = 0;
const logo = document.querySelector('.logo');
if (logo) {
    logo.addEventListener('click', function(e) {
        e.preventDefault();
        logoClickCount++;
        
        if (logoClickCount === 3) {
            this.style.animation = 'glow 0.5s ease, spin 1s ease';
            this.textContent = '🍔 PARADISE 🍔';
            
            setTimeout(() => {
                this.textContent = 'Snack Paradise';
                this.style.animation = '';
                logoClickCount = 0;
            }, 2000);
        }
        
        setTimeout(() => {
            logoClickCount = 0;
        }, 1000);
    });
}