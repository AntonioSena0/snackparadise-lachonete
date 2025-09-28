<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Área Restrita - Snack Paradise</title>
  <link rel="stylesheet" href="style.css">
  <link rel="shortcut icon" href="../imgs/Logo.png" type="image/x-icon">
</head>
<body>
  <!-- Header -->
  <header id="header" role="banner">
    <div class="container flex">
    <a href="../Menu/index.html" class="logo">
                    <img src="../imgs/Logo.png" class="logo" alt="Snack Paradise Logo">
                </a>
      </a>
      <nav role="navigation" aria-label="Menu principal">
        <ul>
          <li><a href="../Menu/index.php">Menu</a></li>
          <li><a href="../Cardápio/index.php">Cardápio</a></li>
          <li><a href="#">Promoções</a></li>
          <li><a href="../Auxílio Preferencial/auxilio.php">Outros</a></li>
        </ul>
      </nav>
      <div class="btn-conta">
        <a href="../Tela de login/index.html">
          <button class="conta" aria-label="Acessar conta">Conta</button>
        </a>
      </div>
    </div>
  </header>

  <!-- Conteúdo principal -->
   <div class="fundo">
  <main role="main">
    <section class="area-restrita-section" aria-labelledby="titulo-area-restrita">
      <h1 id="titulo-area-restrita" style="display:none;">Área restrita - Gerenciamento de Pedidos</h1>
      <div class="tabela">
        <div class="tabela-container1">
          <!-- Coluna pedidos -->
          <div class="coluna1" role="region" aria-labelledby="pedidos-title">
            <h2 id="pedidos-title">Pedidos</h2>
            <div class="pedido tabela-card1" id="checkout-pedidos" aria-live="polite">
              <!-- Itens carregados dinamicamente -->
            </div>
          </div>
          <!-- Coluna endereço -->
          <div class="coluna2" role="region" aria-labelledby="endereco-title">
            <h2 id="endereco-title">Endereço</h2>
            <div class="tabela-card2" id="checkout-endereco" aria-live="polite"></div>
          </div>
          <!-- Coluna pagamento -->
          <div class="coluna3" role="region" aria-labelledby="pagamento-title">
            <h2 id="pagamento-title">Forma de Pagamento</h2>
            <div class="tabela-card3" id="checkout-pagamento" aria-live="polite"></div>
          </div>
        </div>

        <!-- Botão de ação -->
        <div class="tabela-container2" id="acoes-pedido">
          <!-- Botão ACEITAR PEDIDO será inserido via JS -->
        </div>
      </div>
    </section>
  </main>
</div>
  <!-- Rodapé -->
  <footer role="contentinfo">
    <div class="footer-container">
      <div class="footer-links">
        <a href="../../Menu/index.html">Início</a>
        <a href="../Quem somos/index.html">Sobre</a>
        <a href="../Auxílio Preferencial/auxilio.html">Serviços</a>
        <a href="https://www.instagram.com/_snackparadise_/profilecard/?igsh=OHh2eWpsOXBuOWRp" target="_blank" rel="noopener">Contato</a>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2024 Snack Paradise. Todos os direitos reservados.</p>
      </div>
    </div>
  </footer>

  <!-- Plugin de acessibilidade VLibras -->
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

  <!-- Scripts -->
  <script src="menu.js"></script>
  <script>
    // Busca e exibe o pedido mais recente
    async function carregarPedido() {
      const pedidosDiv = document.getElementById('checkout-pedidos');
      const enderecoDiv = document.getElementById('checkout-endereco');
      const pagamentoDiv = document.getElementById('checkout-pagamento');
      const acoesDiv = document.getElementById('acoes-pedido');

      pedidosDiv.innerHTML = 'Carregando...';
      enderecoDiv.innerHTML = '';
      pagamentoDiv.innerHTML = '';
      acoesDiv.innerHTML = '';

      try {
        const resp = await fetch('../back/controllers/listar_pedidos.php');
        const pedidos = await resp.json();

        if (!pedidos.length) {
          pedidosDiv.innerHTML = 'Sem pedidos novos por enquanto...';
          return;
        }

        const pedido = pedidos[0];
        const itens = JSON.parse(pedido.itens);

        pedidosDiv.innerHTML = itens.map(item => 
          `<div>${item.nome} (x${item.quantidade}) - R$ ${(item.preco * item.quantidade).toFixed(2)}</div>`
        ).join('');

        enderecoDiv.innerHTML = pedido.endereco;
        pagamentoDiv.innerHTML = pedido.pagamento;

        acoesDiv.innerHTML = `<button class="btn" onclick="aceitarPedido(${pedido.id})" aria-label="Aceitar pedido número ${pedido.id}">ACEITAR PEDIDO</button>`;
      } catch (e) {
        pedidosDiv.innerHTML = 'Erro ao carregar pedidos!';
      }
    }

    carregarPedido();
  </script>
</body>
</html>
    <script>
        // Função para aceitar o pedido
        async function aceitarPedido(pedidoId) {
        if (!confirm('Você tem certeza que deseja aceitar este pedido?')) return;
    
        try {
            const resp = await fetch('../back/controllers/aceitar_pedido.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: pedidoId })
            });
            const result = await resp.json();
    
            if (result.success) {
            alert('Pedido aceito com sucesso!');
            carregarPedido(); // Recarrega para mostrar o próximo pedido
            } else {
            alert('Erro ao aceitar o pedido. Tente novamente.');
            }
        } catch (e) {
            alert('Erro ao processar a solicitação.');
        }
        }
    </script>   