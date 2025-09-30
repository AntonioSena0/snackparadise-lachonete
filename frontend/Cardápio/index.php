<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snack Paradise - Homepage</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Hero Section -->
        <section class="hero-section" id="home">
            <div class="hero-content">
                <h1 class="hero-title">Bem-vindo ao Snack Paradise</h1>
                <p class="hero-subtitle">
                    O seu paraíso dos lanches está aqui! Sabores únicos, ingredientes frescos e muito amor em cada mordida.
                </p>
                <div class="section-divider"></div>
                <div class="hero-buttons">
                    <a href="menu.php" class="hero-btn primary">
                        <i class="fas fa-utensils"></i>
                        Ver Menu Completo
                    </a>
                    <a href="menu.php" class="hero-btn secondary">
                        <i class="fas fa-motorcycle"></i>
                        Fazer Pedido
                    </a>
                </div>
            </div>
        </section>

        <!-- Services Container -->
        <div class="services-container">
            <!-- Delivery Section -->
            <section class="service-card delivery-card" id="delivery">
                <div class="card-content">
                    <div class="service-icon">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <h2 class="service-title">Delivery Rápido</h2>
                    <p class="service-description">
                        Receba seus lanches favoritos no conforto da sua casa! Entrega rápida, segura e sempre quentinha. 
                        Nossos entregadores são treinados para levar o melhor até você.
                    </p>
                    
                    <div class="service-features">
                        <div class="feature-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <strong>30-45 min</strong>
                                <span>Tempo médio</span>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-shield-alt"></i>
                            <div>
                                <strong>100% Seguro</strong>
                                <span>Entrega protegida</span>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-thermometer-half"></i>
                            <div>
                                <strong>Sempre Quente</strong>
                                <span>Embalagem térmica</span>
                            </div>
                        </div>
                    </div>
                    
                    <a href="menu.php" class="service-btn">
                        <i class="fas fa-shopping-cart"></i>
                        Pedir Delivery
                    </a>
                </div>
            </section>

            <!-- Pickup Section -->
            <section class="service-card pickup-card" id="pickup">
                <div class="card-content">
                    <div class="card-grid">
                        <div class="pickup-text">
                            <div class="service-icon">
                                <i class="fas fa-store"></i>
                            </div>
                            <h2 class="service-title">Peça & Retire</h2>
                            <p class="service-description">
                                Faça seu pedido online e retire na nossa loja sem filas ou esperas. 
                                Rápido, prático e sem taxa de entrega!
                            </p>
                            
                            <div class="pickup-benefits">
                                <div class="benefit-item">
                                    <i class="fas fa-clock"></i>
                                    <span>Sem tempo de espera</span>
                                </div>
                                <div class="benefit-item">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <span>Economia na taxa</span>
                                </div>
                                <div class="benefit-item">
                                    <i class="fas fa-hand-holding-heart"></i>
                                    <span>Atendimento personalizado</span>
                                </div>
                            </div>
                            
                            <a href="menu.php" class="service-btn">
                                <i class="fas fa-hand-holding"></i>
                                Pedir para Retirar
                            </a>
                        </div>
                        
                        <div class="pickup-visual">
                            <div class="pickup-image">
                                <div class="floating-icons">
                                    <i class="fas fa-hamburger"></i>
                                    <i class="fas fa-french-fries"></i>
                                    <i class="fas fa-glass-cheers"></i>
                                </div>
                                <div class="logo-background">SP</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- About Section -->
            <section class="service-card about-card" id="about">
                <div class="card-content">
                    <div class="service-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h2 class="service-title">Nossa História</h2>
                    <p class="service-description">
                        Fundado em 2020, o Snack Paradise nasceu do sonho de criar o melhor hambúrguer da cidade. 
                        Nossos ingredientes são selecionados diariamente e nossas receitas são desenvolvidas com muito carinho.
                    </p>
                    
                    <div class="about-highlights">
                        <div class="highlight-item">
                            <div class="highlight-number">100%</div>
                            <span>Ingredientes Frescos</span>
                        </div>
                        <div class="highlight-item">
                            <div class="highlight-number">5000+</div>
                            <span>Clientes Satisfeitos</span>
                        </div>
                        <div class="highlight-item">
                            <div class="highlight-number">24h</div>
                            <span>Preparo Artesanal</span>
                        </div>
                    </div>
                    
                    <div class="video-container">
                        <div class="video-placeholder" onclick="playVideo()">
                            <div class="video-play-content">
                                <i class="fas fa-play-circle"></i>
                                <span>Conheça Nossa Cozinha</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Popular Items Preview -->
        <section class="popular-section">
            <div class="popular-content">
                <h2 class="section-title">Nossos Sucessos</h2>
                <p class="section-subtitle">Os lanches mais pedidos pelos nossos clientes</p>
                
                <div class="popular-grid">
                    <div class="popular-item">
                        <div class="item-image">
                            <i class="fas fa-hamburger"></i>
                            <div class="item-badge">Mais Pedido</div>
                        </div>
                        <h3>Paradise Burger</h3>
                        <p>Hambúrguer artesanal 180g com molho especial</p>
                        <span class="item-price">R$ 24,90</span>
                    </div>
                    
                    <div class="popular-item">
                        <div class="item-image">
                            <i class="fas fa-fire"></i>
                            <div class="item-badge">Picante</div>
                        </div>
                        <h3>Spicy Fire</h3>
                        <p>Para quem gosta de uma emoção a mais</p>
                        <span class="item-price">R$ 28,90</span>
                    </div>
                    
                    <div class="popular-item">
                        <div class="item-image">
                            <i class="fas fa-leaf"></i>
                            <div class="item-badge">Vegano</div>
                        </div>
                        <h3>Veggie Paradise</h3>
                        <p>Opção deliciosa e saudável</p>
                        <span class="item-price">R$ 22,90</span>
                    </div>
                </div>
                
                <a href="menu.php" class="hero-btn primary">
                        <i class="fas fa-utensils"></i>
                        Ver Menu Completo
                    </a>
            </div>
        </section>
    </main>

    <!-- <script src="menu.js"></script> script antigo, vê o que ele faz e vê se ele serve pra página-->>
     <script src="carrinho.js"></script>
   <!--<script src="newmenu.js"></script>-->
</body>
</html>