// Efeito de carregamento da página
window.addEventListener("load", function() {
    document.body.classList.add("loaded");
});

// Navegação suave
document.querySelectorAll("a").forEach(link => {
    link.addEventListener("click", function(event) {
        if (this.href && this.href !== "#" && !this.href.includes("instagram.com") && !this.href.includes('logout.php')) {
            event.preventDefault();
            document.body.classList.remove("loaded");
            setTimeout(() => {
                window.location.href = this.href;
            }, 500);
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Menu Lateral
    const btnMenuLateral = document.getElementById('btnMenuLateral');
    const menuLateral = document.getElementById('menuLateral');

    if (btnMenuLateral && menuLateral) {
        btnMenuLateral.addEventListener('click', function(event) {
            event.stopPropagation();
            
            if (menuLateral.classList.contains('ativo')) {
                menuLateral.classList.remove('ativo');
                btnMenuLateral.classList.remove('active');
                btnMenuLateral.innerHTML = '☰';
            } else {
                menuLateral.classList.add('ativo');
                btnMenuLateral.classList.add('active');
                btnMenuLateral.innerHTML = '✖';
            }
        });
    }

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
        if (menuLateral && !menuLateral.contains(event.target) && 
            btnMenuLateral && !btnMenuLateral.contains(event.target)) {
            menuLateral.classList.remove('ativo');
            btnMenuLateral.classList.remove('active');
            btnMenuLateral.innerHTML = '☰';
        }

        if (submenu && !submenu.contains(event.target) && 
            cardapioBtn && !cardapioBtn.contains(event.target)) {
            submenu.classList.remove('ativo');
            cardapioBtn.classList.remove('active');
        }
    });

    // Inicializar funcionalidades específicas do perfil
    initializeActiveFields();
    setupStatusToggle();
    setupFormSubmissions();
    setupFieldInteractions();
    setupVehicleForm();
});

function setupFieldInteractions() {
    // Adicionar interações para campos de formulário
    const inputFields = document.querySelectorAll('.input-field');
    
    inputFields.forEach(field => {
        field.addEventListener('focus', function() {
            this.classList.add('active');
            const label = this.nextElementSibling;
            if (label && label.tagName === 'LABEL') {
                updateLabelPosition(label, true);
            }
        });
        
        field.addEventListener('blur', function() {
            if ((!this.value || this.value.trim() === '') && this.selectedIndex === 0) {
                this.classList.remove('active');
                const label = this.nextElementSibling;
                if (label && label.tagName === 'LABEL') {
                    updateLabelPosition(label, false);
                }
            }
        });

        // Atualizar dinamicamente enquanto digita
        field.addEventListener('input', function() {
            if (this.value && this.value.trim() !== '') {
                this.classList.add('active');
                const label = this.nextElementSibling;
                if (label && label.tagName === 'LABEL') {
                    updateLabelPosition(label, true);
                }
            }
        });
    });
}

function updateLabelPosition(label, isActive) {
    if (isActive) {
        label.style.fontSize = '0.75rem';
        label.style.top = '-10px';
        label.style.background = '#fff';
        label.style.color = '#a20908';
        label.style.padding = '0 4px';
    } else {
        label.style.fontSize = '';
        label.style.top = '';
        label.style.background = '';
        label.style.color = '';
        label.style.padding = '';
    }
}

function initializeActiveFields() {
    const inputFields = document.querySelectorAll('.input-field');
    inputFields.forEach(field => {
        if (field.value && field.value.trim() !== '') {
            field.classList.add('active');
            const label = field.nextElementSibling;
            if (label && label.tagName === 'LABEL') {
                updateLabelPosition(label, true);
            }
        }
    });
}

function setupVehicleForm() {
    const form = document.getElementById('vehicle-form');
    if (!form) return;

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(form);

        fetch('../../backend/controllers/AccountController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                showNotification(result.success, 'success');

                // Atualizar valores na interface
                document.getElementById('vehicle_type').value = result.vehicle_type;
                document.getElementById('license_plate').value = result.license_plate;

                // Travar campos novamente
                cancelEdit('vehicle');
            } else {
                showNotification(result.error, 'error');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            showNotification('Erro ao atualizar veículo', 'error');
        });
    });
}


function setupStatusToggle() {
    const statusElement = document.getElementById('riderStatus');
    if (statusElement) {
        statusElement.addEventListener('click', function() {
            const currentStatus = this.classList.contains('online') ? 'online' : 'offline';
            const newStatus = currentStatus === 'online' ? 'offline' : 'online';
            
            const originalHTML = this.innerHTML;
            this.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i><span>Alterando...</span>';
            
            fetch('../../backend/controllers/AccountController.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=update_status&status=${newStatus}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.className = `rider-status ${data.status}`;
                    this.innerHTML = `<i class='bx bx-circle'></i><span>${data.status.charAt(0).toUpperCase() + data.status.slice(1)}</span>`;
                    showNotification(data.success, 'success');
                } else {
                    this.innerHTML = originalHTML;
                    showNotification(data.error, 'error');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                this.innerHTML = originalHTML;
                showNotification('Erro ao alterar status', 'error');
            });
        });
        statusElement.style.cursor = 'pointer';
    }
}


function toggleEdit(section) {
    const form = document.getElementById(`${section}-form`);
    const fields = form.querySelectorAll('.input-field, select');
    const editBtn = document.getElementById(`edit-${section}`);
    const saveBtn = document.getElementById(`save-${section}`);
    const cancelBtn = document.getElementById(`cancel-${section}`);

    console.log('🔍 Iniciando edição:', section);
    
    // Salvar valores originais
    const originalValues = {};
    fields.forEach(field => {
        originalValues[field.name] = field.value;
        
        // Remover readonly/disabled
        if (field.hasAttribute('readonly')) {
            field.removeAttribute('readonly');
        }
        if (field.disabled) {
            field.disabled = false;
        }
        
        // Adicionar estilo visual de edição
        field.classList.add('editing');
        field.style.background = '#fff';
        field.style.cursor = 'text';
        field.style.borderColor = '#a20908';
    });

    form.dataset.originalValues = JSON.stringify(originalValues);

    // Alternar botões
    editBtn.classList.add('hidden');
    saveBtn.classList.remove('hidden');
    cancelBtn.classList.remove('hidden');
}

function cancelEdit(section) {
    const form = document.getElementById(`${section}-form`);
    const fields = form.querySelectorAll('.input-field, select');
    const editBtn = document.getElementById(`edit-${section}`);
    const saveBtn = document.getElementById(`save-${section}`);
    const cancelBtn = document.getElementById(`cancel-${section}`);

    // Restaurar valores originais
    const originalValues = JSON.parse(form.dataset.originalValues || '{}');
    
    fields.forEach(field => {
        if (originalValues[field.name] !== undefined) {
            field.value = originalValues[field.name];
        }
        
        // Restaurar atributos
        if (field.tagName === 'SELECT') {
            field.disabled = true;
        } else {
            field.setAttribute('readonly', 'readonly');
        }
        
        // Remover estilo de edição
        field.classList.remove('editing');
        field.style.background = '#f8f9fa';
        field.style.cursor = 'not-allowed';
        field.style.borderColor = '';
    });

    // Alternar botões
    editBtn.classList.remove('hidden');
    saveBtn.classList.add('hidden');
    cancelBtn.classList.add('hidden');
}
function changePhoto() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    
    input.onchange = function(event) {
        const file = event.target.files[0];
        if (file) {
            if (!file.type.startsWith('image/')) {
                showNotification('Por favor, selecione apenas imagens (JPEG, PNG, GIF).', 'error');
                return;
            }
            if (file.size > 5 * 1024 * 1024) {
                showNotification('A imagem deve ter no máximo 5MB.', 'error');
                return;
            }

            // Preview temporário
            const reader = new FileReader();
            reader.onload = function(e) {
                const avatarCircle = document.querySelector('.avatar-circle');
                avatarCircle.innerHTML = `<img src="${e.target.result}" alt="Foto do perfil" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">`;
            };
            reader.readAsDataURL(file);

            const formData = new FormData();
            formData.append('action', 'upload_photo');
            formData.append('photo', file);

            fetch('../../backend/controllers/AccountController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    const avatarImg = document.querySelector('.avatar-circle img');
                    if (avatarImg && result.filename) {
                        avatarImg.src = `../../backend/uploads/profiles/${result.filename}?t=${new Date().getTime()}`;
                    }
                    showNotification(result.success, 'success');
                } else {
                    showNotification(result.error, 'error');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                showNotification('Erro ao fazer upload da foto.', 'error');
            });
        }
    };
    
    input.click();
}


function updateDocument(docType) {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*,.pdf';
    
    input.onchange = function(event) {
        const file = event.target.files[0];
        if (file) {
            showNotification(`Enviando ${docType.toUpperCase()}...`, 'info');
            
            // Simular upload (implementar conforme necessidade)
            setTimeout(() => {
                showNotification(`Documento ${docType.toUpperCase()} atualizado com sucesso!`, 'success');
                
                // Atualizar interface
                const documentItem = event.target.closest('.document-item');
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
            }, 2000);
        }
    };
    
    input.click();
}

function loadMoreDeliveries() {
    const loadMoreBtn = document.querySelector('.btn-load-more');
    const originalHTML = loadMoreBtn.innerHTML;
    
    loadMoreBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i>Carregando...';
    loadMoreBtn.disabled = true;

    // Simular carregamento de mais entregas
    setTimeout(() => {
        // Aqui você pode implementar carregamento real via AJAX
        showNotification('Mais entregas carregadas com sucesso!', 'success');
        loadMoreBtn.innerHTML = originalHTML;
        loadMoreBtn.disabled = false;
        
        // Adicionar entregas simuladas
        const deliveriesContainer = document.getElementById('deliveries-container');
        const newDelivery = document.createElement('div');
        newDelivery.className = 'delivery-item';
        newDelivery.innerHTML = `
            <div class="delivery-header">
                <span class="delivery-number">#DEL-999</span>
                <span class="delivery-date">${new Date().toLocaleDateString('pt-BR')} ${new Date().toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'})}</span>
                <span class="delivery-status status-completed">Entregue</span>
            </div>
            <div class="delivery-info">
                <p><strong>De:</strong> SnackParadise Centro</p>
                <p><strong>Para:</strong> Rua das Flores, 123</p>
                <p><strong>Distância:</strong> 3.2 km</p>
            </div>
            <div class="delivery-earnings">
                <strong>Ganho: R$ 9,50</strong>
            </div>
        `;
        deliveriesContainer.appendChild(newDelivery);
    }, 1500);
}

function showNotification(message, type = 'info') {
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <span>${message}</span>
        <button onclick="this.parentElement.remove()">&times;</button>
    `;

    // Estilos da notificação
    Object.assign(notification.style, {
        position: 'fixed',
        top: '20px',
        right: '20px',
        padding: '1rem 1.5rem',
        borderRadius: '0.8rem',
        color: 'white',
        zIndex: '10000',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'space-between',
        gap: '1rem',
        minWidth: '300px',
        boxShadow: '0 5px 15px rgba(0,0,0,0.2)',
        animation: 'slideIn 0.3s ease-out'
    });

    const colors = {
        success: '#28a745',
        error: '#dc3545',
        warning: '#ffc107',
        info: '#17a2b8'
    };

    notification.style.background = colors[type] || colors.info;

    const closeBtn = notification.querySelector('button');
    Object.assign(closeBtn.style, {
        background: 'none',
        border: 'none',
        color: 'white',
        fontSize: '1.2rem',
        cursor: 'pointer',
        padding: '0',
        width: '20px',
        height: '20px',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center'
    });

    document.body.appendChild(notification);

    // Remover automaticamente após 5 segundos
    setTimeout(() => {
        if (notification.parentElement) {
            notification.style.animation = 'slideOut 0.3s ease-in forwards';
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 300);
        }
    }, 5000);
}

// Adicionar estilos CSS para as animações
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
    
    .input-field.editing {
        border-color: #a20908;
        box-shadow: 0 0 0 2px rgba(162, 9, 8, 0.1);
    }
    
    .hidden {
        display: none !important;
    }
`;
document.head.appendChild(style);