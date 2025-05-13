window.addEventListener("scroll", MudarOHeader);
function MudarOHeader() {
    let header = document.querySelector('header');
    let barralateral = document.getElementById('barralateral');
    let conta = document.getElementById('btn-conta');
    const btn = document.getElementById('btn-ativação');
    if (scrollY > 0) {
        header.classList.add('scroll');
        barralateral.classList.add('scroll');
        conta.classList.add('scroll');
        btn.classList.add('scroll');
    }
    else {
        header.classList.remove('scroll');
        barralateral.classList.remove('scroll');
        conta.classList.remove('scroll');
        btn.classList.remove('scroll');
    }
};

window.addEventListener("load", function() {
    document.body.classList.add("loaded");
});

document.querySelectorAll("a").forEach(link => {
    link.addEventListener("click", function(event) {
        event.preventDefault();
        document.body.classList.remove("loaded");
        setTimeout(() => {
            window.location.href = this.href;
        }, 500);
    });
});

let lanches = [];
let acompanhamentos = [];
let bebidas = [];
carregarDados();

function carregarDados() {
    fetch('main.json')
        .then(response => response.json())
        .then(data => {
            lanches = data.lanches;
            acompanhamentos = data.acompanhamentos;
            bebidas = data.bebidas;

            adicionarItens();
        })
        .catch(error => console.error('Erro ao carregar os dados:', error));
}

function adicionarItens() {
    adicionarLanches();
    adicionarAcompanhamentos();
    adicionarBebidas();
}

function adicionarLanches() {
    lanches.forEach((item) => {
        let lancheItem = document.querySelector('.modelos .lanche-item').cloneNode(true);
        document.querySelector('.area-lanches').append(lancheItem);
        lancheItem.querySelector('.lanche-item--img img').src = item.img;
        lancheItem.querySelector('.lanche-item--preco').innerHTML = `R$ ${item.preco.toFixed(2)}`;
        lancheItem.querySelector('.lanche-item--nome').innerHTML = item.nome;
        lancheItem.querySelector('.lanche-item--desc').innerHTML = item.descricao;
    });
}

function adicionarAcompanhamentos() {
    acompanhamentos.forEach((item) => {
        let lancheItem = document.querySelector('.modelos .lanche-item').cloneNode(true);
        document.querySelector('.area-acompanhamentos').append(lancheItem);
        lancheItem.querySelector('.lanche-item--img img').src = item.img;
        lancheItem.querySelector('.lanche-item--preco').innerHTML = `R$ ${item.preco.toFixed(2)}`;
        lancheItem.querySelector('.lanche-item--nome').innerHTML = item.nome;
    });
}

function adicionarBebidas() {
    bebidas.forEach((item) => {
        let lancheItem = document.querySelector('.modelos .lanche-item').cloneNode(true);
        document.querySelector('.area-bebidas').append(lancheItem);
        lancheItem.querySelector('.lanche-item--img img').src = item.img;
        lancheItem.querySelector('.lanche-item--preco').innerHTML = `R$ ${item.preco.toFixed(2)}`;
        lancheItem.querySelector('.lanche-item--nome').innerHTML = item.nome;
    });
}

const Button = document.getElementById('btn-ativação');
const sidebar = document.getElementById('barralateral');

Button.addEventListener('click', clicar);
function clicar(){
    if (sidebar.style.left === '0px') {
        sidebar.style.left = '-200px';
        Button.innerText = '☰';
    }
    else {
        sidebar.style.left = '0px';
        Button.innerText = '✖';
    }
    Button.classList.toggle('active');
};

const btn = document.getElementById('btn-cardapio');
const menu = document.getElementById('submenu');

btn.addEventListener('click', clicar2);
function clicar2(event) {
    event.stopPropagation();
    menu.classList.toggle('active');
    menu.style.display = menu.classList.contains('active') ? 'flex' : 'none';
    
    if (menu.classList.contains('active')) {
        menu.style.opacity = '1';
        menu.style.visibility = 'visible';
    }
    else {
        setTimeout(() => {
            menu.style.visibility = 'hidden';
        }, 0);
        menu.style.opacity = '0';
    }
}

document.addEventListener('click', (event) => {
    if (menu.classList.contains('active')) {
        menu.classList.remove('active');
        setTimeout(() => {
            menu.style.display = 'none';
            menu.style.visibility = 'hidden';
        }, 500);
        menu.style.opacity = '0';
    }
});

menu.addEventListener('click', (event) => {
    event.stopPropagation();
});

let carrinho = [];
let total = 0;

// Função para adicionar itens ao carrinho
function adicionarAoCarrinho(nome, preco) {
    // Recupera o carrinho do localStorage ou inicializa um novo array
    let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];

    // Verifica se o item já existe no carrinho
    const itemExistente = carrinho.find(item => item.nome === nome);
    if (itemExistente) {
        // Incrementa a quantidade se o item já existir
        itemExistente.quantidade += 1;
    } else {
        // Adiciona um novo item ao carrinho
        carrinho.push({ nome, preco, quantidade: 1 });
    }

    // Salva o carrinho atualizado no localStorage
    localStorage.setItem('carrinho', JSON.stringify(carrinho));

    // Exibe uma mensagem de confirmação
    alert(`${nome} foi adicionado ao carrinho!`);
    atualizarCarrinho();
}

// Função para atualizar o carrinho na interface
function atualizarCarrinho() {
    const itensCarrinho = document.getElementById('itensCarrinho');
    const totalCarrinho = document.getElementById('totalCarrinho');

    // Recupera o carrinho do localStorage
    const carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];

    // Limpa o carrinho antes de atualizar
    itensCarrinho.innerHTML = '';
    let total = 0;

    // Adiciona os itens ao carrinho na interface
    carrinho.forEach((item, index) => {
        const li = document.createElement('li');
        li.textContent = `${item.nome} (x${item.quantidade}) - R$ ${(item.preco * item.quantidade).toFixed(2)}`;
        const btnRemover = document.createElement('button');
        btnRemover.textContent = 'Remover';
        btnRemover.onclick = () => removerDoCarrinho(index);
        li.appendChild(btnRemover);
        itensCarrinho.appendChild(li);
        total += item.preco * item.quantidade;
    });

    // Atualiza o total
    totalCarrinho.textContent = total.toFixed(2);
}

// Função para remover itens do carrinho
function removerDoCarrinho(index) {
    // Recupera o carrinho do localStorage
    let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];

    // Remove o item do carrinho
    carrinho.splice(index, 1);

    // Salva o carrinho atualizado no localStorage
    localStorage.setItem('carrinho', JSON.stringify(carrinho));

    // Atualiza o carrinho na interface
    atualizarCarrinho();
}

// Atualiza o carrinho ao carregar a página
document.addEventListener('DOMContentLoaded', atualizarCarrinho);

// Redirecionar para o checkout
document.getElementById('finalizarCompra').addEventListener('click', () => {
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    localStorage.setItem('total', total.toFixed(2));
    window.location.href = '../checkout/index.html';
});