// Efeito de carregamento da página
window.addEventListener("load", function() {
    document.body.classList.add("loaded");
});

// Navegação suave
document.querySelectorAll("a").forEach(link => {
    link.addEventListener("click", function(event) {
        if (this.href && this.href !== "#" && !this.href.includes("instagram.com")) {
            event.preventDefault();
            document.body.classList.remove("loaded");
            setTimeout(() => {
                window.location.href = this.href;
            }, 500);
        }
    });
});

// Menu lateral
document.addEventListener('DOMContentLoaded', function() {
    const btnAtivacao = document.getElementById('btn-ativação');
    const barraLateral = document.getElementById('barralateral');
    const btnCardapio = document.getElementById('btn-cardapio');
    const submenu = document.getElementById('submenu');

    // Menu lateral
    if (btnAtivacao && barraLateral) {
        btnAtivacao.addEventListener('click', function(event) {
            event.stopPropagation();
            
            if (barraLateral.style.left === '0px') {
                barraLateral.style.left = '-200px';
                btnAtivacao.classList.remove('active');
            } else {
                barraLateral.style.left = '0px';
                btnAtivacao.classList.add('active');
            }
        });

        // Fechar menu ao clicar fora
        document.addEventListener('click', function(event) {
            if (!barraLateral.contains(event.target) && !btnAtivacao.contains(event.target)) {
                barraLateral.style.left = '-200px';
                btnAtivacao.classList.remove('active');
            }
        });
    }

    // Submenu cardápio
    if (btnCardapio && submenu) {
        btnCardapio.addEventListener('click', function(event) {
            event.stopPropagation();
            
            if (submenu.style.display === 'flex') {
                submenu.style.display = 'none';
                submenu.style.opacity = '0';
                submenu.style.visibility = 'hidden';
            } else {
                submenu.style.display = 'flex';
                submenu.style.opacity = '1';
                submenu.style.visibility = 'visible';
            }
        });

        // Fechar submenu ao clicar fora
        document.addEventListener('click', function(event) {
            if (!submenu.contains(event.target) && !btnCardapio.contains(event.target)) {
                submenu.style.display = 'none';
                submenu.style.opacity = '0';
                submenu.style.visibility = 'hidden';
            }
        });
    }

    // Inicializar campos ativos
    initializeActiveFields();

    // Event listeners para formulários
    setupFormEventListeners();
});

// Inicializar campos com valor como ativos
function initializeActiveFields() {
    const inputFields = document.querySelectorAll('.input-field');
    inputFields.forEach(field => {
        if (field.value && field.value.trim() !== '') {
            field.classList.add('active');
        }
        
        field.addEventListener('focus', function() {
            this.classList.add('active');
        });
        
        field.addEventListener('blur', function() {
            if (!this.value || this.value.trim() === '') {
                this.classList.remove('active');
            }
        });
    });
}

// Configurar event listeners dos formulários
function setupFormEventListeners() {
    // Formulário de informações pessoais
    const personalForm = document.getElementById('personal-form');
    if (personalForm) {
        personalForm.addEventListener('submit', function(event) {
            event.preventDefault();
            savePersonalInfo();
        });
    }

    // Formulário de endereço
    const addressForm = document.getElementById('address-form');
    if (addressForm) {
        addressForm.addEventListener('submit', function(event) {
            event.preventDefault();
            saveAddressInfo();
        });
    }

    // Formulário de senha
    const passwordForm = document.getElementById('password-form');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(event) {
            event.preventDefault();
            changePassword();
        });
    }

    // CEP lookup
    const cepField = document.getElementById('cep');
    if (cepField) {
        cepField.addEventListener('blur', function() {
            const cep = this.value.replace(/\D/g, '');
            if (cep.length === 8) {
                lookupCEP(cep);
            }
        });
    }
}

// Alternar modo de edição
function toggleEdit(section) {
    const form = document.getElementById(`${section}-form`);
    const fields = form.querySelectorAll('.input-field');
    const editBtn = document.getElementById(`edit-${section}`);
    const saveBtn = document.getElementById(`save-${section}`);
    const cancelBtn = document.getElementById(`cancel-${section}`);

    // Salvar valores originais
    form.dataset.originalValues = JSON.stringify(
        Array.from(fields).reduce((acc, field) => {
            acc[field.name] = field.value;
            return acc;
        }, {})
    );

    // Habilitar campos
    fields.forEach(field => {
        field.removeAttribute('readonly');
        field.style.background = '#fff';
        field.style.cursor = 'text';
    });

    // Alternar botões
    editBtn.classList.add('hidden');
    saveBtn.classList.remove('hidden');
    cancelBtn.classList.remove('hidden');

    // Focar no primeiro campo
    fields[0]?.focus();
}

// Cancelar edição
function cancelEdit(section) {
    const form = document.getElementById(`${section}-form`);
    const fields = form.querySelectorAll('.input-field');
    const editBtn = document.getElementById(`edit-${section}`);
    const saveBtn = document.getElementById(`save-${section}`);
    const cancelBtn = document.getElementById(`cancel-${section}`);

    // Restaurar valores originais
    const originalValues = JSON.parse(form.dataset.originalValues || '{}');
    fields.forEach(field => {
        if (originalValues[field.name] !== undefined) {
            field.value = originalValues[field.name];
        }
        field.setAttribute('readonly', 'readonly');
        field.style.background = '#f8f9fa';
        field.style.cursor = 'not-allowed';
    });

    // Alternar botões
    editBtn.classList.remove('hidden');
    saveBtn.classList.add('hidden');
    cancelBtn.classList.add('hidden');
}

// Salvar informações pessoais
async function savePersonalInfo() {
    const form = document.getElementById('personal-form');
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);

    try {
        // Simular chamada para API
        await simulateAPICall('/api/user/personal', data);
        
        // Desabilitar campos novamente
        const fields = form.querySelectorAll('.input-field');
        fields.forEach(field => {
            field.setAttribute('readonly', 'readonly');
            field.style.background = '#f8f9fa';
            field.style.cursor = 'not-allowed';
        });

        // Alternar botões
        document.getElementById('edit-personal').classList.remove('hidden');
        document.getElementById('save-personal').classList.add('hidden');
        document.getElementById('cancel-personal').classList.add('hidden');

        showNotification('Informações pessoais atualizadas com sucesso!', 'success');
    } catch (error) {
        showNotification('Erro ao salvar informações pessoais.', 'error');
        console.error('Erro:', error);
    }
}

// Salvar informações de endereço
async function saveAddressInfo() {
    const form = document.getElementById('address-form');
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);

    try {
        // Simular chamada para API
        await simulateAPICall('/api/user/address', data);
        
        // Desabilitar campos novamente
        const fields = form.querySelectorAll('.input-field');
        fields.forEach(field => {
            field.setAttribute('readonly', 'readonly');
            field.style.background = '#f8f9fa';
            field.style.cursor = 'not-allowed';
        });

        // Alternar botões
        document.getElementById('edit-address').classList.remove('hidden');
        document.getElementById('save-address').classList.add('hidden');
        document.getElementById('cancel-address').classList.add('hidden');

        showNotification('Endereço atualizado com sucesso!', 'success');
    } catch (error) {
        showNotification('Erro ao salvar endereço.', 'error');
        console.error('Erro:', error);
    }
}

// Alterar senha
async function changePassword() {
    const senhaAtual = document.getElementById('senha-atual').value;
    const novaSenha = document.getElementById('nova-senha').value;
    const confirmarSenha = document.getElementById('confirmar-senha').value;

    // Validações
    if (!senhaAtual || !novaSenha || !confirmarSenha) {
        showNotification('Todos os campos de senha são obrigatórios.', 'error');
        return;
    }

    if (novaSenha !== confirmarSenha) {
        showNotification('A nova senha e a confirmação não coincidem.', 'error');
        return;
    }

    if (novaSenha.length < 6) {
        showNotification('A nova senha deve ter pelo menos 6 caracteres.', 'error');
        return;
    }

    try {
        // Simular chamada para API
        await simulateAPICall('/api/user/change-password', {
            current_password: senhaAtual,
            new_password: novaSenha
        });

        // Limpar campos
        document.getElementById('senha-atual').value = '';
        document.getElementById('nova-senha').value = '';
        document.getElementById('confirmar-senha').value = '';

        showNotification('Senha alterada com sucesso!', 'success');
    } catch (error) {
        showNotification('Erro ao alterar senha. Verifique a senha atual.', 'error');
        console.error('Erro:', error);
    }
}

// Alterar foto do perfil
function changePhoto() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    
    input.onchange = function(event) {
        const file = event.target.files[0];
        if (file) {
            // Validar tipo e tamanho do arquivo
            if (!file.type.startsWith('image/')) {
                showNotification('Por favor, selecione apenas arquivos de imagem.', 'error');
                return;
            }
            
            if (file.size > 5 * 1024 * 1024) { // 5MB
                showNotification('A imagem deve ter no máximo 5MB.', 'error');
                return;
            }

            // Preview da imagem
            const reader = new FileReader();
            reader.onload = function(e) {
                const avatarCircle = document.querySelector('.avatar-circle');
                avatarCircle.innerHTML = `<img src="${e.target.result}" alt="Foto do perfil" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">`;
            };
            reader.readAsDataURL(file);

            // Simular upload
            uploadPhoto(file);
        }
    };
    
    input.click();
}

// Upload da foto
async function uploadPhoto(file) {
    try {
        // Simular upload
        await simulateAPICall('/api/user/upload-photo', { photo: file });
        showNotification('Foto do perfil atualizada com sucesso!', 'success');
    } catch (error) {
        showNotification('Erro ao fazer upload da foto.', 'error');
        console.error('Erro:', error);
    }
}

// Buscar CEP
async function lookupCEP(cep) {
    try {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const data = await response.json();

        if (data.erro) {
            showNotification('CEP não encontrado.', 'error');
            return;
        }

        // Preencher campos
        document.getElementById('endereco').value = data.logradouro;
        document.getElementById('bairro').value = data.bairro;
        document.getElementById('cidade').value = data.localidade;

        // Ativar campos preenchidos
        document.getElementById('endereco').classList.add('active');
        document.getElementById('bairro').classList.add('active');
        document.getElementById('cidade').classList.add('active');

    } catch (error) {
        console.error('Erro ao buscar CEP:', error);
    }
}

// Simular chamada de API
function simulateAPICall(endpoint, data) {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            // Simular sucesso na maioria dos casos
            if (Math.random() > 0.1) {
                resolve({ success: true, data });
            } else {
                reject(new Error('Erro simulado na API'));
            }
        }, 1000 + Math.random() * 1000);
    });
}

// Mostrar notificação
function showNotification(message, type = 'info') {
    // Remover notificação existente
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    // Criar nova notificação
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <span>${message}</span>
        <button onclick="this.parentElement.remove()">&times;</button>
    `;

    // Estilos da notificação
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

    // Cores por tipo
    const colors = {
        success: '#28a745',
        error: '#dc3545',
        warning: '#ffc107',
        info: '#17a2b8'
    };

    notification.style.background = colors[type] || colors.info;

    // Estilo do botão fechar
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

    // Remover automaticamente após 5 segundos
    setTimeout(() => {
        if (notification.parentElement) {
            notification.style.animation = 'slideOut 0.3s ease-in forwards';
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}

// Adicionar animações CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);