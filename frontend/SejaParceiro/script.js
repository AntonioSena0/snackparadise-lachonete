document.addEventListener('DOMContentLoaded', function() {
    // Menu lateral functionality
    const btnMenuLateral = document.getElementById('btnMenuLateral');
    const menuLateral = document.getElementById('menuLateral');
    const overlay = document.getElementById('overlay');

    // Toggle menu lateral
    if (btnMenuLateral && menuLateral && overlay) {
        btnMenuLateral.addEventListener('click', function() {
            menuLateral.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        // Close menu when clicking overlay
        overlay.addEventListener('click', function() {
            menuLateral.classList.remove('active');
            overlay.classList.remove('active');
        });

        // Close menu when pressing ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                menuLateral.classList.remove('active');
                overlay.classList.remove('active');
            }
        });
    }

    // Cardápio dropdown functionality
    const cardapioBtn = document.getElementById('cardapioBtn');
    if (cardapioBtn) {
        const submenu = cardapioBtn.querySelector('.submenu');
        
        cardapioBtn.addEventListener('mouseenter', function() {
            if (submenu) {
                submenu.style.opacity = '1';
                submenu.style.visibility = 'visible';
                submenu.style.transform = 'translateY(0)';
            }
        });

        cardapioBtn.addEventListener('mouseleave', function() {
            if (submenu) {
                setTimeout(() => {
                    submenu.style.opacity = '0';
                    submenu.style.visibility = 'hidden';
                    submenu.style.transform = 'translateY(-10px)';
                }, 100);
            }
        });

        // Keep submenu open when hovering over it
        if (submenu) {
            submenu.addEventListener('mouseenter', function() {
                this.style.opacity = '1';
                this.style.visibility = 'visible';
                this.style.transform = 'translateY(0)';
            });

            submenu.addEventListener('mouseleave', function() {
                this.style.opacity = '0';
                this.style.visibility = 'hidden';
                this.style.transform = 'translateY(-10px)';
            });
        }
    }

    // Form validation and submission
    const form = document.getElementById('partnerForm');
    if (form) {
        const inputs = form.querySelectorAll('input, select');

        // Add error message elements to form groups
        inputs.forEach(input => {
            const formGroup = input.closest('.form-group');
            if (formGroup && !formGroup.querySelector('.error-message')) {
                const errorMsg = document.createElement('div');
                errorMsg.className = 'error-message';
                formGroup.appendChild(errorMsg);
            }
        });

        // Real-time validation
        inputs.forEach(input => {
            input.addEventListener('blur', () => validateField(input));
            input.addEventListener('input', () => clearError(input));
        });

        // Form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            let isValid = true;
            inputs.forEach(input => {
                if (!validateField(input)) {
                    isValid = false;
                }
            });

            if (isValid) {
                submitForm();
            } else {
                // Scroll to first error
                const firstError = document.querySelector('.form-group.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });

        function validateField(input) {
            const formGroup = input.closest('.form-group');
            const errorMsg = formGroup.querySelector('.error-message');
            let isValid = true;
            let message = '';

            // Clear previous error state
            formGroup.classList.remove('error');

            // Check if required field is empty
            if (input.hasAttribute('required') && !input.value.trim()) {
                isValid = false;
                message = 'Este campo é obrigatório';
            } 
            // Email validation
            else if (input.type === 'email' && input.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(input.value)) {
                    isValid = false;
                    message = 'Digite um email válido';
                }
            }
            // URL validation for social links
            else if (input.name === 'socialLink' && input.value) {
                const socialRegex = /(instagram\.com|linkedin\.com)/i;
                if (!socialRegex.test(input.value)) {
                    isValid = false;
                    message = 'Digite um link válido do Instagram ou LinkedIn';
                }
            }
            // Phone validation
            else if (input.type === 'tel' && input.value) {
                const phoneRegex = /^[\d\s\-\(\)\+]{8,}$/;
                if (!phoneRegex.test(input.value)) {
                    isValid = false;
                    message = 'Digite um telefone válido';
                }
            }
            // URL validation for website
            else if (input.type === 'url' && input.value && input.name === 'website') {
                const urlRegex = /^https?:\/\/.+/i;
                if (!urlRegex.test(input.value)) {
                    isValid = false;
                    message = 'Digite uma URL válida (ex: https://www.exemplo.com)';
                }
            }

            if (!isValid) {
                formGroup.classList.add('error');
                if (errorMsg) {
                    errorMsg.textContent = message;
                }
            }

            return isValid;
        }

        function clearError(input) {
            const formGroup = input.closest('.form-group');
            if (formGroup) {
                formGroup.classList.remove('error');
            }
        }

        function submitForm() {
            // Show loading state
            const submitBtn = document.querySelector('.submit-btn');
            if (submitBtn) {
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Enviando...';
                submitBtn.disabled = true;

                // Collect form data
                const formData = new FormData(form);
                const data = {};
                for (let [key, value] of formData.entries()) {
                    data[key] = value;
                }

                // Simulate API call
                setTimeout(() => {
                    console.log('Dados do parceiro enviados:', data);
                    
                    // Show success message
                    showSuccessMessage();
                    
                    // Reset form
                    form.reset();
                    
                    // Reset button
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                }, 2000);
            }
        }

        function showSuccessMessage() {
            // Create success overlay
            const successOverlay = document.createElement('div');
            successOverlay.className = 'success-overlay';

            const successBox = document.createElement('div');
            successBox.className = 'success-box';

            successBox.innerHTML = `
                <div style="color: #28a745; font-size: 3rem; margin-bottom: 1rem;">✅</div>
                <h3 style="color: #1a1a2e; margin-bottom: 1rem;">Sucesso!</h3>
                <p style="color: #666; margin-bottom: 2rem;">Sua solicitação de parceria foi enviada com sucesso. Entraremos em contato em breve!</p>
                <button class="success-close-btn" 
                        style="background: #a20908; color: white; border: none; padding: 0.8rem 2rem; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s ease;">
                    Fechar
                </button>
            `;

            // Add close functionality
            const closeBtn = successBox.querySelector('.success-close-btn');
            closeBtn.addEventListener('click', () => {
                successOverlay.remove();
            });

            closeBtn.addEventListener('mouseover', () => {
                closeBtn.style.background = '#8b0707';
            });

            closeBtn.addEventListener('mouseout', () => {
                closeBtn.style.background = '#a20908';
            });

            successOverlay.appendChild(successBox);
            document.body.appendChild(successOverlay);

            // Auto close after 5 seconds
            setTimeout(() => {
                if (successOverlay.parentNode) {
                    successOverlay.remove();
                }
            }, 5000);
        }

        // Auto-format phone number
        const telefoneInput = document.getElementById('telefone');
        if (telefoneInput) {
            telefoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                
                if (value.length >= 11) {
                    value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                } else if (value.length >= 7) {
                    value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
                } else if (value.length >= 3) {
                    value = value.replace(/(\d{2})(\d{0,5})/, '($1) $2');
                }
                
                e.target.value = value;
            });
        }
    }
});

// Add floating animation to decorative elements
function addFloatingAnimation() {
    const shapes = document.querySelectorAll('.floating-shape, .chat-bubble');
    
    shapes.forEach((shape, index) => {
        if (shape) {
            const delay = index * 1000;
            const duration = 3000 + (index * 500);
            
            setTimeout(() => {
                setInterval(() => {
                    const currentTransform = shape.style.transform || '';
                    if (!currentTransform.includes('translateY(-10px)')) {
                        shape.style.transform = currentTransform + ' translateY(-10px)';
                        setTimeout(() => {
                            shape.style.transform = shape.style.transform.replace(' translateY(-10px)', '');
                        }, duration / 2);
                    }
                }, duration);
            }, delay);
        }
    });
}

// Initialize floating animations when page loads
window.addEventListener('load', addFloatingAnimation);

// Add parallax effect to background elements
let ticking = false;

function updateParallax() {
    const scrolled = window.pageYOffset;
    const shapes = document.querySelectorAll('.floating-shape');
    
    shapes.forEach((shape, index) => {
        if (shape) {
            const speed = 0.1 + (index * 0.05);
            const baseTransform = shape.getAttribute('data-base-transform') || '';
            shape.style.transform = baseTransform + ` translateY(${scrolled * speed}px)`;
        }
    });
    
    ticking = false;
}

window.addEventListener('scroll', function() {
    if (!ticking) {
        requestAnimationFrame(updateParallax);
        ticking = true;
    }
});

// Initialize base transforms
document.addEventListener('DOMContentLoaded', function() {
    const shapes = document.querySelectorAll('.floating-shape');
    shapes.forEach(shape => {
        if (shape && !shape.getAttribute('data-base-transform')) {
            shape.setAttribute('data-base-transform', shape.style.transform || '');
        }
    });
});

// Smooth scroll for navigation links
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
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
});