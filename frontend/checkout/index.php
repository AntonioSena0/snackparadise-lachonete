<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>
<body>
    <header id="header">
        <div class="container">
            <div class="flex">
                <a href="../Menu/index.html" class="logo">
                    <img src="../imgs/Logo.png" class="logo" alt="Snack Paradise Logo">
                </a>
                <nav>
                    <ul>
                        <li class="list-menu1"><a href="../Menu/index.html">Menu</a></li>
                        <li class="list-menu1"><a href="../Cardápio/index.html">Cardápio</a></li>
                        <li class="list-menu1"><a href="#">Promoções</a></li>
                        <li class="list-menu1"><a href="../Auxílio Preferencial/auxilio.html">Outros</a></li>
                    </ul>
                </nav>
                <div class="btn-conta">
                    <a href="../Tela de login/index.html"><button class="conta">Conta</button></a>
                </div>
            </div>
        </div>
    </header>
    <main class="main">
        <div class="janelas">
            <div class="itens-2">
                <h1>Itens Selecionados</h1>
                <ul id="itensCheckout"></ul>
                <p>Total: R$ <span id="totalCheckout">0.00</span></p>
            </div>
            <div class="pagamento">
                <h1>Pagamento</h1>
                <form id="payment-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" name="nome" required>
                        </div>

                        <div class="form-group">
                            <label for="rua">Endereço</label>
                            <input type="text" id="rua" name="rua" required>
                        </div>

                        <div class="form-group">
                            <label for="numero">Número</label>
                            <input type="text" id="numero" name="numero" required>
                        </div>

                        <div class="form-group">
                            <label for="complemento">Complemento</label>
                            <input type="text" id="complemento" name="complemento">
                        </div>

                        <div class="form-group">
                            <label for="preferencial">Atendimento Preferencial</label>
                            <select id="preferencial" name="preferencial">
                                <option value="Sim">Sim</option>
                                <option value="Não">Não</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="forma">Forma de Pagamento</label>
                            <select id="forma" name="forma" class="forma">
                                <option value="debito">Débito</option>
                                <option value="credito">Crédito</option>
                                <option value="cedula">Cédula</option>
                                <option value="pix">Pix</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn" name="btnsubm">Confirmar Pedido</button>
                </form>
            </div>
        </div>
    </main>
    <div class="modal" id="modal-loading">
        <div class="card">
            <div class="loading">
                <div class="spinner"></div>
                <p>Carregando...</p>
            </div>
            <div class="confirmation" style="display: none;">
                <i class="bi bi-check-circle" style="font-size: 40px; color: green;"></i>
                <p>Pedido confirmado!</p>
                <div class="close-btn">Fechar</div>
            </div>
        </div>
    </div>
    <div class="modal" id="modal-qrcode">
        <div class="card">
            <div id="qrcode" class="qrcode"></div>
            <button class="confirm-pix">Confirmar pagamento por Pix</button>
            <div class="close-btn">Fechar</div>
        </div>
    </div>    

    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <a href="../Menu/index.html">Início</a>
                <a href="../Quem somos/index.html">Sobre</a>
                <a href="../Auxílio Preferencial/auxilio.html">Serviços</a>
                <a href="https://www.instagram.com/_snackparadise_/profilecard/?igsh=OHh2eWpsOXBuOWRp">Contato</a>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 SnackParadise. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
<script>
(function () {
  // Roda após DOM pronto
  document.addEventListener('DOMContentLoaded', () => {
    safePopulateCheckout();
  });

  function safePopulateCheckout() {
    const ul = document.getElementById('itensCheckout');
    const totalSpan = document.getElementById('totalCheckout');

    if (!ul) {
      console.error('Elemento #itensCheckout NÃO encontrado no DOM.');
      return;
    }
    if (!totalSpan) {
      console.error('Elemento #totalCheckout NÃO encontrado no DOM.');
      return;
    }

    // Tenta obter o carrinho de forma robusta
    const cart = findCartInLocalStorage();
    console.log('DEBUG: cart encontrado =', cart);

    if (!cart || !Array.isArray(cart) || cart.length === 0) {
      ul.innerHTML = '<li>Seu carrinho está vazio.</li>';
      totalSpan.textContent = '0.00';
      return;
    }

    // Preenche a lista e calcula total
    ul.innerHTML = '';
    let total = 0;
    cart.forEach(item => {
      // normalize keys (pt/en)
      const nome = item.nome ?? item.name ?? 'Sem nome';
      const quantidade = item.quantidade ?? item.qty ?? item.qtd ?? 1;
      const preco = Number(item.preco ?? item.price ?? 0) || 0;

      const li = document.createElement('li');
      li.textContent = `${nome} (x${quantidade}) - R$ ${(preco * quantidade).toFixed(2)}`;
      ul.appendChild(li);

      total += preco * quantidade;
    });

    totalSpan.textContent = total.toFixed(2);
  }

  // Procura possíveis chaves de carrinho no localStorage e retorna o array (ou null)
  function findCartInLocalStorage() {
    const triedKeys = [];
    // 1) tenta chaves óbvias
    const possibleKeys = ['carrinho', 'cart', 'carrinhoUsuario', 'shoppingCart', 'cartItems', 'itensCarrinho'];

    for (const k of possibleKeys) {
      triedKeys.push(k);
      const raw = localStorage.getItem(k);
      if (!raw) continue;
      try {
        const parsed = JSON.parse(raw);
        if (Array.isArray(parsed)) return parsed;
        // se for objeto com array interno
        if (parsed && typeof parsed === 'object') {
          // procura um campo que seja array de itens
          for (const f of Object.keys(parsed)) {
            if (Array.isArray(parsed[f]) && parsed[f].length && isCartArrayLike(parsed[f])) {
              return parsed[f];
            }
          }
        }
      } catch (e) {
        // não JSON -> ignora
      }
    }

    // 2) varre todo o localStorage e tenta achar um array de objetos parecido com carrinho
    for (let i = 0; i < localStorage.length; i++) {
      const key = localStorage.key(i);
      if (possibleKeys.includes(key)) continue; // já tentado
      triedKeys.push(key);
      const raw = localStorage.getItem(key);
      try {
        const parsed = JSON.parse(raw);
        if (Array.isArray(parsed) && parsed.length && isCartArrayLike(parsed)) {
          console.warn('Detectei carrinho na key localStorage:', key);
          return parsed;
        }
        // se for objeto com campo array
        if (parsed && typeof parsed === 'object') {
          for (const f of Object.keys(parsed)) {
            if (Array.isArray(parsed[f]) && parsed[f].length && isCartArrayLike(parsed[f])) {
              console.warn('Detectei carrinho dentro do objeto na key:', key, 'campo:', f);
              return parsed[f];
            }
          }
        }
      } catch (e) { /* ignore parse errors */ }
    }

    console.log('Tentei keys:', triedKeys);
    return null;
  }

  // Heurística: checa se um array parece ser um carrinho (itens com nome/preco)
  function isCartArrayLike(arr) {
    if (!Array.isArray(arr) || arr.length === 0) return false;
    // aceita se pelo menos metade dos itens tiverem "nome" ou "name" e "preco" ou "price"
    let match = 0;
    arr.slice(0, 10).forEach(it => {
      if (!it || typeof it !== 'object') return;
      const hasName = ('nome' in it) || ('name' in it);
      const hasPrice = ('preco' in it) || ('price' in it);
      if (hasName && hasPrice) match++;
    });
    return match >= Math.max(1, Math.floor(arr.length / 2));
  }

})();
</script>

    <script src="menu.js"></script>
</body>
</html>