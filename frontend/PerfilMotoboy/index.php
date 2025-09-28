<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Motoboy - Snack Paradise</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../imgs/Logo.png" type="image/x-icon">
</head>
<body>
    <header id="header">
        <div class="container">
            <div class="flex">
                <nav>
                    <ul>
                        <li class="list-menu2">
                            <button class="btn-ativação" id="btn-ativação">☰</button>
                            <div class="barralateral" id="barralateral">
                                <a href="../Menu/index.php" target="_self">Início</a>
                                <a href="../Perfil/index.php" target="_self">Meu Perfil</a>
                                <a href="#" target="_self">Entregas</a>
                                <a href="#" target="_self">Earnings</a>
                                <a href="#" target="_self">Avaliações</a>
                                <a href="../Quem somos/index.php" target="_self">Sobre nós</a>
                                <a href="#" target="_self">Suporte</a>
                            </div>
                        </li>
                        <li class="list-menu1">
                            <a href="#" target="_self">Painel</a>
                        </li>
                        <li class="list-menu1">
                            <a href="#" target="_self">Entregas</a>
                        </li>
                        <li class="list-menu1">
                            <a href="#" target="_self">Relatórios</a>
                        </li>
                        <li class="list-menu1">
                            <a href="#" target="_self">App Motoboy</a>
                        </li>
                    </ul>
                </nav>

                <div class="btn-conta">
                    <a href="../Tela de login/index.php"><button id="btn-conta" class="conta">Sair</button></a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="main-container">
            <div class="profile-box">
                <div class="profile-header">
                    <div class="logo2">
                        <img src="../imgs/Logo.png" alt="SnackParadiseLogo">
                        <h4>SnackParadise Delivery</h4>
                    </div>
                    <h1 class="profile-title">Perfil do Motoboy</h1>
                </div>

                <div class="profile-content">
                    <div class="profile-avatar">
                        <div class="avatar-circle">
                            <i class='bx bxs-user'></i>
                        </div>
                        <button class="btn-change-photo" onclick="changePhoto()">
                            <i class='bx bx-camera'></i>
                            Alterar Foto
                        </button>
                        <div class="rider-status online">
                            <i class='bx bx-circle'></i>
                            <span>Online</span>
                        </div>
                        <div class="rating-display">
                            <div class="stars">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bx-star'></i>
                            </div>
                            <span class="rating-number">4.2</span>
                        </div>
                    </div>

                    <div class="profile-forms">
                        <!-- Informações Pessoais -->
                        <div class="profile-section">
                            <h3 class="section-title">
                                <i class='bx bx-user-circle'></i>
                                Informações Pessoais
                            </h3>
                            
                            <form class="profile-form" id="personal-form">
                                <div class="form-row">
                                    <div class="input-wrap">
                                        <input type="text" class="input-field" id="nome" name="nome" value="Carlos Alberto Santos" readonly />
                                        <label>Nome Completo</label>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="email" class="input-field" id="email" name="email" value="carlos.motoboy@email.com" readonly />
                                        <label>E-mail</label>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="input-wrap">
                                        <input type="tel" class="input-field" id="telefone" name="telefone" value="(11) 98765-4321" readonly />
                                        <label>Telefone</label>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="date" class="input-field" id="nascimento" name="nascimento" value="1985-03-20" readonly />
                                        <label>Data de Nascimento</label>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="button" class="btn-edit" id="edit-personal" onclick="toggleEdit('personal')">
                                        <i class='bx bx-edit'></i>
                                        Editar
                                    </button>
                                    <button type="submit" class="btn-save hidden" id="save-personal">
                                        <i class='bx bx-check'></i>
                                        Salvar
                                    </button>
                                    <button type="button" class="btn-cancel hidden" id="cancel-personal" onclick="cancelEdit('personal')">
                                        <i class='bx bx-x'></i>
                                        Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Informações do Veículo -->
                        <div class="profile-section">
                            <h3 class="section-title">
                                <i class='bx bxs-truck'></i>
                                Informações do Veículo
                            </h3>
                            
                            <form class="profile-form" id="vehicle-form">
                                <div class="form-row">
                                    <div class="input-wrap">
                                        <select class="input-field" id="tipo-veiculo" name="tipo-veiculo" disabled>
                                            <option value="motocicleta" selected>Motocicleta</option>
                                            <option value="bicicleta">Bicicleta</option>
                                            <option value="carro">Carro</option>
                                        </select>
                                        <label>Tipo de Veículo</label>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="text" class="input-field" id="placa" name="placa" value="ABC-1234" readonly />
                                        <label>Placa do Veículo</label>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="input-wrap">
                                        <input type="text" class="input-field" id="modelo" name="modelo" value="Honda CG 160" readonly />
                                        <label>Modelo</label>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="text" class="input-field" id="cor" name="cor" value="Vermelha" readonly />
                                        <label>Cor</label>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="button" class="btn-edit" id="edit-vehicle" onclick="toggleEdit('vehicle')">
                                        <i class='bx bx-edit'></i>
                                        Editar
                                    </button>
                                    <button type="submit" class="btn-save hidden" id="save-vehicle">
                                        <i class='bx bx-check'></i>
                                        Salvar
                                    </button>
                                    <button type="button" class="btn-cancel hidden" id="cancel-vehicle" onclick="cancelEdit('vehicle')">
                                        <i class='bx bx-x'></i>
                                        Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Documentação -->
                        <div class="profile-section">
                            <h3 class="section-title">
                                <i class='bx bx-id-card'></i>
                                Documentação
                            </h3>
                            
                            <div class="documents-grid">
                                <div class="document-item">
                                    <div class="document-header">
                                        <i class='bx bx-user'></i>
                                        <span>CNH</span>
                                        <span class="status-valid">✓ Válida</span>
                                    </div>
                                    <p>Válida até: 15/08/2027</p>
                                    <button class="btn-update-doc" onclick="updateDocument('cnh')">
                                        <i class='bx bx-upload'></i>
                                        Atualizar
                                    </button>
                                </div>

                                <div class="document-item">
                                    <div class="document-header">
                                        <i class='bx bx-car'></i>
                                        <span>CRLV</span>
                                        <span class="status-valid">✓ Válido</span>
                                    </div>
                                    <p>Válido até: 30/12/2025</p>
                                    <button class="btn-update-doc" onclick="updateDocument('crlv')">
                                        <i class='bx bx-upload'></i>
                                        Atualizar
                                    </button>
                                </div>

                                <div class="document-item">
                                    <div class="document-header">
                                        <i class='bx bx-shield'></i>
                                        <span>Seguro</span>
                                        <span class="status-expired">⚠ Vencendo</span>
                                    </div>
                                    <p>Válido até: 05/01/2025</p>
                                    <button class="btn-update-doc urgent" onclick="updateDocument('seguro')">
                                        <i class='bx bx-upload'></i>
                                        Urgente - Atualizar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Estatísticas -->
                        <div class="profile-section">
                            <h3 class="section-title">
                                <i class='bx bx-bar-chart-alt-2'></i>
                                Estatísticas
                            </h3>
                            
                            <div class="stats-grid">
                                <div class="stat-item">
                                    <div class="stat-number">247</div>
                                    <div class="stat-label">Entregas Realizadas</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">4.2</div>
                                    <div class="stat-label">Avaliação Média</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">98%</div>
                                    <div class="stat-label">Taxa de Sucesso</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">R$ 2.847</div>
                                    <div class="stat-label">Ganhos Este Mês</div>
                                </div>
                            </div>
                        </div>

                        <!-- Histórico de Entregas -->
                        <div class="profile-section">
                            <h3 class="section-title">
                                <i class='bx bx-history'></i>
                                Últimas Entregas
                            </h3>
                            
                            <div class="deliveries-container" id="deliveries-container">
                                <div class="delivery-item">
                                    <div class="delivery-header">
                                        <span class="delivery-number">#DEL-001</span>
                                        <span class="delivery-date">28/09/2025 14:30</span>
                                        <span class="delivery-status status-completed">Entregue</span>
                                    </div>
                                    <div class="delivery-info">
                                        <p><strong>De:</strong> SnackParadise Centro</p>
                                        <p><strong>Para:</strong> Rua Augusta, 1200 - Consolação</p>
                                        <p><strong>Distância:</strong> 2.3 km</p>
                                    </div>
                                    <div class="delivery-earnings">
                                        <strong>Ganho: R$ 8,50</strong>
                                    </div>
                                </div>

                                <div class="delivery-item">
                                    <div class="delivery-header">
                                        <span class="delivery-number">#DEL-002</span>
                                        <span class="delivery-date">28/09/2025 13:15</span>
                                        <span class="delivery-status status-completed">Entregue</span>
                                    </div>
                                    <div class="delivery-info">
                                        <p><strong>De:</strong> SnackParadise Vila Madalena</p>
                                        <p><strong>Para:</strong> Av. Paulista, 900 - Bela Vista</p>
                                        <p><strong>Distância:</strong> 4.1 km</p>
                                    </div>
                                    <div class="delivery-earnings">
                                        <strong>Ganho: R$ 12,30</strong>
                                    </div>
                                </div>

                                <div class="delivery-item">
                                    <div class="delivery-header">
                                        <span class="delivery-number">#DEL-003</span>
                                        <span class="delivery-date">28/09/2025 11:45</span>
                                        <span class="delivery-status status-completed">Entregue</span>
                                    </div>
                                    <div class="delivery-info">
                                        <p><strong>De:</strong> SnackParadise Moema</p>
                                        <p><strong>Para:</strong> Rua dos Pinheiros, 456 - Pinheiros</p>
                                        <p><strong>Distância:</strong> 3.7 km</p>
                                    </div>
                                    <div class="delivery-earnings">
                                        <strong>Ganho: R$ 10,80</strong>
                                    </div>
                                </div>
                            </div>

                            <button class="btn-load-more" onclick="loadMoreDeliveries()">
                                <i class='bx bx-plus'></i>
                                Ver Mais Entregas
                            </button>
                        </div>

                        <!-- Alterar Senha -->
                        <div class="profile-section">
                            <h3 class="section-title">
                                <i class='bx bx-lock'></i>
                                Segurança
                            </h3>
                            
                            <form class="profile-form" id="password-form">
                                <div class="form-row">
                                    <div class="input-wrap">
                                        <input type="password" class="input-field" id="senha-atual" name="senha-atual" />
                                        <label>Senha Atual</label>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="input-wrap">
                                        <input type="password" class="input-field" id="nova-senha" name="nova-senha" />
                                        <label>Nova Senha</label>
                                    </div>
                                    <div class="input-wrap">
                                        <input type="password" class="input-field" id="confirmar-senha" name="confirmar-senha" />
                                        <label>Confirmar Nova Senha</label>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn-change-password">
                                        <i class='bx bx-key'></i>
                                        Alterar Senha
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <a href="../Menu/index.php">Início</a>
                <a href="../Quem somos/index.php">Sobre</a>
                <a href="#">Suporte</a>
                <a href="#">Contato</a>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 SnackParadise Delivery. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- VLibras -->
    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>

    <script src="script.js"></script>
</body>
</html>