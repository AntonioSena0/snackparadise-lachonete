<?php
session_start();

// 🔒 Verifica se o administrador está logado
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

include_once '../../backend/config/DatabaseManager.php';
$db = new DatabaseManager();

// 🔍 Valida o ID recebido
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: pedidos.php?error=ID inválido');
    exit();
}

// 🔎 Busca o pedido no banco
$pedido = $db->getPedidoById(intval($id));
if (!$pedido) {
    header('Location: pedidos.php?error=Pedido não encontrado');
    exit();
}

// ✅ Gera token CSRF (opcional, mas recomendado)
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Pedido #<?php echo htmlspecialchars($pedido['id']); ?></title>

    <!-- CSS principal -->
    <link rel="stylesheet" href="pedidos.css">
</head>
<body>

    <!-- Header -->
    <header>
        <div class="header-left">
            <button class="btn-menu-lateral" id="btn-menu">&#9776;</button>
            <div class="logo-container">
                <img src="../assets/logo.png" alt="Logo" class="logo">
            </div>
        </div>
        <div class="header-center">
            <a href="pedidos.php" class="menu-item">Pedidos</a>
            <a href="clientes.php" class="menu-item">Clientes</a>
            <a href="produtos.php" class="menu-item">Produtos</a>
        </div>
        <a href="logout.php" class="btn-conta">Sair</a>
    </header>

    <!-- Menu lateral -->
    <nav class="menu-lateral" id="menuLateral">
        <a href="dashboard.php" class="menu-lateral-item">🏠 Dashboard</a>
        <a href="pedidos.php" class="menu-lateral-item active">📦 Pedidos</a>
        <a href="clientes.php" class="menu-lateral-item">👥 Clientes</a>
        <a href="produtos.php" class="menu-lateral-item">🍔 Produtos</a>
        <a href="config.php" class="menu-lateral-item">⚙️ Configurações</a>
    </nav>
    <div class="overlay" id="overlay"></div>

    <!-- Conteúdo principal -->
    <main>
        <div class="editar-pedido-container">
            <h1>Editar Pedido #<?php echo htmlspecialchars($pedido['id']); ?></h1>

            <form method="POST" action="../../backend/controllers/admin_edit_pedido_form.php">
                <input type="hidden" name="pedido_id" value="<?php echo htmlspecialchars($pedido['id']); ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <div>
                    <label>Endereço</label>
                    <input type="text" name="endereco" value="<?php echo htmlspecialchars($pedido['endereco']); ?>" required>
                </div>

                <div>
                    <label>Pagamento</label>
                    <input type="text" name="pagamento" value="<?php echo htmlspecialchars($pedido['pagamento']); ?>" required>
                </div>

                <div>
                    <label>Status</label>
                    <select name="status" required>
                        <?php
                        $statuses = ['pendente', 'preparando', 'pronto', 'em_entrega', 'entregue', 'cancelado', 'oculto'];
                        foreach ($statuses as $status) {
                            $selected = $pedido['status'] === $status ? 'selected' : '';
                            echo "<option value='$status' $selected>$status</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="editar-pedido-botoes">
                    <button type="submit">Salvar</button>
                    <a href="pedidos.php">Cancelar</a>
                </div>
            </form>
        </div>
    </main>

    <!-- Rodapé -->
    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <a href="#">Política de Privacidade</a>
                <a href="#">Termos de Uso</a>
                <a href="#">Suporte</a>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> - Seu Sistema de Pedidos</p>
                <p>Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Script para menu lateral -->
    <script>
        const btnMenu = document.getElementById('btn-menu');
        const menuLateral = document.getElementById('menuLateral');
        const overlay = document.getElementById('overlay');

        btnMenu.addEventListener('click', () => {
            menuLateral.classList.toggle('ativo');
            overlay.classList.toggle('active');
            btnMenu.classList.toggle('active');
        });

        overlay.addEventListener('click', () => {
            menuLateral.classList.remove('ativo');
            overlay.classList.remove('active');
            btnMenu.classList.remove('active');
        });
    </script>

</body>
</html>
