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

    // Inicializar campos ativos
    initializeActiveFields();

    // Event listeners para formulários
    setupFormEventListeners();

    // Simulação de status online/offline
    setupStatusToggle();

    // Inicializar delivery counter
    setupDeliveryCounter();
});

// Inicializar campos com valor como ativos
function initializeActiveFields() {
    const inputFields = document.querySelectorAll('.input-field');
    inputFields.forEach(field => {
        if ((field.value && field.value.trim() !== '') || field.selectedIndex > 0) {
            field.classList.add('active');
            const label = field.nextElementSibling;
            if (label && label.tagName === 'LABEL') {
                label.style.fontSize = '0.75rem';
                label.style.top = '-10px';
                label.style.background = '#fff';
                label.style.color = '#a20908';
            }
        }
        
        field.addEventListener('focus', function() {
            this.classList.add('active');
        });
        
        field.addEventListener('blur', function() {
            if ((!this.value || this.value.trim() === '') && this.selectedIndex === 0) {
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

    // Formulário de veículo
    const vehicleForm = document.getElementById('vehicle-form');
    if (vehicleForm) {
        vehicleForm.addEventListener('submit', function(event) {
            event.preventDefault();
            saveVehicleInfo();
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
}

// Configurar toggle de status online/offline
function setupStatusToggle() {
    const statusElement = document.querySelector('.rider-status');
    if (statusElement) {
        statusElement.addEventListener('click', function() {
            if (this.classList.contains('online')) {
                this.classList.remove('online');
                this.classList.add('offline');
                this.innerHTML = '<i class="bx bx-circle"></i><span>Offline</span>';
                showNotification('Status alterado para Offline', 'warning');
            } else {
                this.classList.remove('offline');
                this.classList.add('online');
                this.innerHTML = '<i class="bx bx-circle"></i><span>Online</span>';
                showNotification('Status alterado para Online', 'success');
            }
        });
        statusElement.style.cursor = 'pointer';
    }
}

// Configurar contador de entregas em tempo real
function setupDeliveryCounter() {
    // Simular atualização de estatísticas a cada 30 segundos
    setInterval(() => {
        updateLiveStats();
    }, 30000);
}

// Atualizar estatísticas em tempo real
function updateLiveStats() {
    const statusElement = document.querySelector('.rider-status.online');
    if (statusElement) {
        // Simular possível nova entrega
        if (Math.random() > 0.7) {
            const deliveriesElement = document.querySelector('.stat-item .stat-number');
            if (deliveriesElement) {
                const currentDeliveries = parseInt(deliveriesElement.textContent);
                deliveriesElement.textContent = currentDeliveries + 1;
                
                // Animate the stat update
                deliveriesElement.style.transform = 'scale(1.2)';
                deliveriesElement.style.color = '#28a745';
                setTimeout(() => {
                    deliveriesElement.style.transform = 'scale(1)';
                    deliveriesElement.style.color = 'inherit';
                }, 500);
                
                showNotification('Nova entrega completada!', 'success');
            }
        }
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
            acc[field.name] = field.tagName === 'SELECT' ? field.selectedIndex : field.value;
            return acc;
        }, {})
    );

    // Habilitar campos
    fields.forEach(field => {
        if (field.tagName === 'SELECT') {
            field.removeAttribute('disabled');
        } else {
            field.removeAttribute('readonly');
        }
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
            if (field.tagName === 'SELECT') {
                field.selectedIndex = originalValues[field.name];
            } else {
                field.value = originalValues[field.name];
            }
        }
        
        if (field.tagName === 'SELECT') {
            field.setAttribute('disabled', 'disabled');
        } else {
            field.setAttribute('readonly', 'readonly');
        }
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
        await simulateAPICall('/api/rider/personal', data);
        
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

// Salvar informações do veículo
async function saveVehicleInfo() {
    const form = document.getElementById('vehicle-form');
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);

    try {
        // Validar placa do veículo
        if (!validatePlate(data.placa)) {
            showNotification('Formato de placa inválido. Use formato ABC-1234.', 'error');
            return;
        }

        // Simular chamada para API
        await simulateAPICall('/api/rider/vehicle', data);
        
        // Desabilitar campos novamente
        const fields = form.querySelectorAll('.input-field');
        fields.forEach(field => {
            if (field.tagName === 'SELECT') {
                field.setAttribute('disabled', 'disabled');
            } else {
                field.setAttribute('readonly', 'readonly');
            }
            field.style.background = '#f8f9fa';
            field.style.cursor = 'not-allowed';
        });

        // Alternar botões
        document.getElementById('edit-vehicle').classList.remove('hidden');
        document.getElementById('save-vehicle').classList.add('hidden');
        document.getElementById('cancel-vehicle').classList.add('hidden');

        showNotification('Informações do veículo atualizadas com sucesso!', 'success');
    } catch (error) {
        showNotification('Erro ao salvar informações do veículo.', 'error');
        console.error('Erro:', error);
    }
}

// Validar formato da placa
function validatePlate(plate) {
    const plateRegex = /^[A-Z]{3}-\d{4}$/;
    return plateRegex.test(plate.toUpperCase());
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
        await simulateAPICall('/api/rider/change-password', {
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
        await simulateAPICall('/api/rider/upload-photo', { photo: file });
        showNotification('Foto do perfil atualizada com sucesso!', 'success');
    } catch (error) {
        showNotification('Erro ao fazer upload da foto.', 'error');
        console.error('Erro:', error);
    }
}

// Atualizar documento
function updateDocument(docType) {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*,.pdf';
    
    input.onchange = async function(event) {
        const file = event.target.files[0];
        if (file) {
            try {
                await simulateAPICall(`/api/rider/update-document/${docType}`, { document: file });
                
                // Atualizar status do documento na interface
                const documentItem = event.target.closest('.document-item') || 
                    document.querySelector(`[onclick="updateDocument('${docType}')"]`).closest('.document-item');
                
                if (documentItem) {
                    const statusElement = documentItem.querySelector('.status-expired, .status-valid');
                    if (statusElement) {
                        statusElement.className = 'status-valid';
                        statusElement.textContent = '✓ Válido';
                    }
                    
                    const urgentBtn = documentItem.querySelector('.btn-update-doc.urgent');
                    if (urgentBtn) {
                        urgentBtn.classList.remove('urgent');
                        urgentBtn.innerHTML = '<i class="bx bx-upload"></i>Atualizar';
                    }
                }
                
                showNotification(`Documento ${docType.toUpperCase()} atualizado com sucesso!`, 'success');
            } catch (error) {
                showNotification(`Erro ao atualizar documento ${docType.toUpperCase()}.`, 'error');
                console.error('Erro:', error);
            }
        }
    };
    
    input.click();
}

// Carregar mais entregas
async function loadMoreDeliveries() {
    try {
        const deliveriesContainer = document.getElementById('deliveries-container');
        const loadMoreBtn = document.querySelector('.btn-load-more');
        
        // Simular carregamento
        loadMoreBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i>Carregando...';
        loadMoreBtn.disabled = true;
        
        await simulateAPICall('/api/rider/deliveries?page=2');
        
        // Simular adição de novas entregas
        const newDeliveries = [
            {
                number: '#DEL-004',
                date: '27/09/2025 19:20',
                status: 'Entregue',
                from: 'SnackParadise Itaim',
                to: 'Rua Oscar Freire, 789 - Jardins',
                distance: '5.2 km',
                earnings: 'R$ 14,70'
            },
            {
                number: '#DEL-005',
                date: '27/09/2025 17:45',
                status: 'Entregue',
                from: 'SnackParadise Brooklin',
                to: 'Av. Berrini, 1500 - Brooklin',
                distance: '1.8 km',
                earnings: 'R$ 6,90'
            },
            {
                number: '#DEL-006',
                date: '27/09/2025 16:30',
                status: 'Entregue',
                from: 'SnackParadise Vila Olímpia',
                to: 'Rua Funchal, 250 - Vila Olímpia',
                distance: '2.9 km',
                earnings: 'R$ 9,50'
            }
        ];
        
        // Adicionar as novas entregas ao container
        newDeliveries.forEach(delivery => {
            const deliveryElement = createDeliveryElement(delivery);
            deliveriesContainer.appendChild(deliveryElement);
        });
        
        // Restaurar botão
        loadMoreBtn.innerHTML = '<i class="bx bx-plus"></i>Ver Mais Entregas';
        loadMoreBtn.disabled = false;
        
        showNotification('Mais entregas carregadas!', 'info');
        
    } catch (error) {
        showNotification('Erro ao carregar mais entregas.', 'error');
        console.error('Erro:', error);
        
        // Restaurar botão em caso de erro
        const loadMoreBtn = document.querySelector('.btn-load-more');
        loadMoreBtn.innerHTML = '<i class="bx bx-plus"></i>Ver Mais Entregas';
        loadMoreBtn.disabled = false;
    }
}

// Criar elemento de entrega
function createDeliveryElement(delivery) {
    const deliveryItem = document.createElement('div');
    deliveryItem.className = 'delivery-item';
    
    deliveryItem.innerHTML = `
        <div class="delivery-header">
            <span class="delivery-number">${delivery.number}</span>
            <span class="delivery-date">${delivery.date}</span>
            <span class="delivery-status status-completed">${delivery.status}</span>
        </div>
        <div class="delivery-info">
            <p><strong>De:</strong> ${delivery.from}</p>
            <p><strong>Para:</strong> ${delivery.to}</p>
            <p><strong>Distância:</strong> ${delivery.distance}</p>
        </div>
        <div class="delivery-earnings">
            <strong>Ganho: ${delivery.earnings}</strong>
        </div>
    `;
    
    // Adicionar animação de entrada
    deliveryItem.style.opacity = '0';
    deliveryItem.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
        deliveryItem.style.transition = 'all 0.5s ease';
        deliveryItem.style.opacity = '1';
        deliveryItem.style.transform = 'translateY(0)';
    }, 100);
    
    return deliveryItem;
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

// Funcionalidades específicas do motoboy

// Simulação de pedidos em tempo real
function simulateRealTimeOrders() {
    const statusElement = document.querySelector('.rider-status.online');
    if (!statusElement) return;

    // Simular notificação de novo pedido a cada 2-5 minutos para demonstração
    const interval = (2 + Math.random() * 3) * 60 * 1000; // 2-5 minutos
    
    setTimeout(() => {
        if (document.querySelector('.rider-status.online')) {
            showNewOrderNotification();
            simulateRealTimeOrders(); // Continuar simulação
        }
    }, interval);
}

// Mostrar notificação de novo pedido
function showNewOrderNotification() {
    const orderNotification = document.createElement('div');
    orderNotification.className = 'order-notification';
    orderNotification.innerHTML = `
        <div class="order-header">
            <i class='bx bx-bell'></i>
            <strong>Novo Pedido Disponível!</strong>
        </div>
        <div class="order-details">
            <p><strong>De:</strong> SnackParadise Centro</p>
            <p><strong>Para:</strong> Rua Augusta, ${Math.floor(Math.random() * 2000 + 100)}</p>
            <p><strong>Valor:</strong> R$ ${(Math.random() * 15 + 5).toFixed(2)}</p>
            <p><strong>Distância:</strong> ${(Math.random() * 5 + 1).toFixed(1)} km</p>
        </div>
        <div class="order-actions">
            <button class="btn-accept" onclick="acceptOrder(this)">
                <i class='bx bx-check'></i>
                Aceitar
            </button>
            <button class="btn-decline" onclick="declineOrder(this)">
                <i class='bx bx-x'></i>
                Recusar
            </button>
        </div>
    `;

    // Estilos da notificação de pedido
    orderNotification.style.cssText = `
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        z-index: 2000;
        min-width: 350px;
        animation: bounceIn 0.5s ease-out;
    `;

    // Adicionar overlay
    const overlay = document.createElement('div');
    overlay.className = 'order-overlay';
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 1999;
    `;

    document.body.appendChild(overlay);
    document.body.appendChild(orderNotification);

    // Auto-rejeitar após 30 segundos
    setTimeout(() => {
        if (orderNotification.parentElement) {
            declineOrder(orderNotification.querySelector('.btn-decline'));
        }
    }, 30000);
}

// Aceitar pedido
function acceptOrder(button) {
    const notification = button.closest('.order-notification');
    const overlay = document.querySelector('.order-overlay');
    
    notification.remove();
    overlay.remove();
    
    showNotification('Pedido aceito! Dirija-se ao restaurante.', 'success');
    
    // Atualizar estatísticas
    setTimeout(() => {
        updateDeliveryStats();
    }, 2000);
}

// Recusar pedido
function declineOrder(button) {
    const notification = button.closest('.order-notification');
    const overlay = document.querySelector('.order-overlay');
    
    notification.remove();
    overlay.remove();
    
    showNotification('Pedido recusado.', 'info');
}

// Atualizar estatísticas após entrega
function updateDeliveryStats() {
    const deliveriesElement = document.querySelector('.stat-item:first-child .stat-number');
    const earningsElement = document.querySelector('.stat-item:last-child .stat-number');
    
    if (deliveriesElement) {
        const currentDeliveries = parseInt(deliveriesElement.textContent);
        deliveriesElement.textContent = currentDeliveries + 1;
        
        // Animação
        deliveriesElement.style.transform = 'scale(1.2)';
        deliveriesElement.style.color = '#28a745';
        setTimeout(() => {
            deliveriesElement.style.transform = 'scale(1)';
            deliveriesElement.style.color = 'inherit';
        }, 500);
    }
    
    if (earningsElement) {
        const currentEarnings = parseFloat(earningsElement.textContent.replace('R$ ', '').replace('.', '').replace(',', '.'));
        const newEarnings = currentEarnings + (Math.random() * 15 + 5);
        earningsElement.textContent = `R$ ${newEarnings.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
        
        // Animação
        earningsElement.style.transform = 'scale(1.2)';
        earningsElement.style.color = '#28a745';
        setTimeout(() => {
            earningsElement.style.transform = 'scale(1)';
            earningsElement.style.color = 'inherit';
        }, 500);
    }
}

// Iniciar simulação quando estiver online
document.addEventListener('DOMContentLoaded', function() {
    // Aguardar um pouco antes de iniciar a simulação
    setTimeout(() => {
        simulateRealTimeOrders();
    }, 10000); // Começar após 10 segundos
});

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
    
    @keyframes bounceIn {
        0% {
            transform: translate(-50%, -50%) scale(0.5);
            opacity: 0;
        }
        50% {
            transform: translate(-50%, -50%) scale(1.05);
        }
        100% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }
    }
    
    .order-notification .order-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
        color: #a20908;
    }
    
    .order-notification .order-header i {
        font-size: 1.5rem;
        color: #ffc107;
        animation: pulse 1s infinite;
    }
    
    .order-notification .order-details p {
        margin: 0.5rem 0;
        color: #495057;
    }
    
    .order-notification .order-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
    }
    
    .order-notification .btn-accept,
    .order-notification .btn-decline {
        flex: 1;
        padding: 0.8rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .order-notification .btn-accept {
        background: #28a745;
        color: white;
    }
    
    .order-notification .btn-accept:hover {
        background: #218838;
        transform: translateY(-2px);
    }
    
    .order-notification .btn-decline {
        background: #6c757d;
        color: white;
    }
    
    .order-notification .btn-decline:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }
`;
document.head.appendChild(style);