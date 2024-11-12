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

let lanches = [
    {id: 1, nome: 'Sunset Burguer', img: 'Assets/Encomendar e Retirar (Tradicional)/Hamburguer 2 1.png', preco: 28.00, descricao: 'Bacon, cheddar, Hamburguer grelhado, Molho Barbecue, Pão com gergelim'},
    {id: 2, nome: 'Hamburguer Praiano', img: 'Assets/Encomendar e Retirar (Tradicional)/Hamburguer 1 1.png', preco: 27.00, descricao: 'Alface, cebola, hamburguer grelhado, pão com gergelim, picles, tomate'},
    {id: 3, nome: 'Snack Praia do Sol', img: 'Assets/Encomendar e Retirar (Tradicional)/Hamburguer 3 1.png', preco: 26.00, descricao: 'Alface, bacon, cebola roxa, cheddar, hamburguer grelhado, pão com gergilim, tomate'},
    {id: 4, nome: 'Palmeira Burguer', img: 'Assets/Encomendar e Retirar (Vegano)/Hamburguer 1 1.png', preco: 28.00, descricao: 'Alface, cebola, coentro, molho bechamel vegano, pão com gergilim, seitan (hamburguer vegano), tomate'},
    {id: 5, nome: 'Hamburguer Tropical', img: 'Assets/Encomendar e Retirar (Vegano)/Hamburguer 2 1.png', preco: 26.00, descricao: 'Bacon, cheddar, Hamburguer grelhado, Molho Barbecue, Pão com gergelim'},
    {id: 6, nome: 'Férias Saudaveis', img: 'Assets/Encomendar e Retirar (Vegano)/Hamburguer3 1.png', preco: 26.50, descricao: 'Alface, cebola, hamburguer grelhado, pão com gergelim, picles, tomate'}
];

let acompanhamentos = [
    {id: 7, nome: 'Batata tam.P', img: 'Assets/Acompanhamentos/Batata P.jpeg', preco: 7.75},
    {id: 8, nome: 'Batata tam.M', img: 'Assets/Acompanhamentos/Batata M.jpeg', preco: 8.25},
    {id: 9, nome: 'Batata tam.G', img: 'Assets/Acompanhamentos/Batata G.jpeg', preco: 8.99},
];

let bebidas = [
    {id: 10, nome: 'Coca-cola', img: 'Assets/Bebidas/file (12).png', preco: 5.50},
    {id: 11, nome: 'Pepsi', img: 'Assets/Bebidas/file (11).png', preco: 5.50},
    {id: 12, nome: 'Guarana', img: 'Assets/Bebidas/file (13).png', preco: 4.50},
    {id: 13, nome: 'Fanta Laranja', img: 'Assets/Bebidas/file (14).png', preco: 4.20},
    {id: 14, nome: 'Fanta Uva', img: 'Assets/Bebidas/file (15).png', preco: 4.00},
];

let carrinho = [];

lanches.map((item) => {
    let lancheItem = document.querySelector('.modelos .lanche-item').cloneNode(true);

    document.querySelector('.area-lanches').append(lancheItem);

    lancheItem.querySelector('.lanche-item--img img').src = item.img;
    lancheItem.querySelector('.lanche-item--preco').innerHTML = `R$ ${item.preco.toFixed(2)}`;
    lancheItem.querySelector('.lanche-item--nome').innerHTML = item.nome;
    lancheItem.querySelector('.lanche-item--desc').innerHTML = item.descricao;

    lancheItem.querySelector('.lanche-item--add').addEventListener('click', () => {
        adicionarAoCarrinho(item);
    });
});

acompanhamentos.map((item) => {
    let lancheItem = document.querySelector('.modelos .lanche-item').cloneNode(true);

    document.querySelector('.area-acompanhamentos').append(lancheItem);

    lancheItem.querySelector('.lanche-item--img img').src = item.img;
    lancheItem.querySelector('.lanche-item--preco').innerHTML = `R$ ${item.preco.toFixed(2)}`;
    lancheItem.querySelector('.lanche-item--nome').innerHTML = item.nome;

    lancheItem.querySelector('.lanche-item--add').addEventListener('click', () => {
        adicionarAoCarrinho(item);
    });
});

bebidas.map((item) => {
    let lancheItem = document.querySelector('.modelos .lanche-item').cloneNode(true);

    document.querySelector('.area-bebidas').append(lancheItem);

    lancheItem.querySelector('.lanche-item--img img').src = item.img;
    lancheItem.querySelector('.lanche-item--preco').innerHTML = `R$ ${item.preco.toFixed(2)}`;
    lancheItem.querySelector('.lanche-item--nome').innerHTML = item.nome;

    lancheItem.querySelector('.lanche-item--add').addEventListener('click', () => {
        adicionarAoCarrinho(item);
    });
});

function adicionarAoCarrinho(item) {
    let itemCarrinho = carrinho.find(i => i.id === item.id);
    if (itemCarrinho) {
        itemCarrinho.qt++;
    } else {
        carrinho.push({
            id: item.id,
            nome: item.nome,
            preco: item.preco,
            qt: 1
        });
    }
    atualizarCarrinho();
}

function atualizarCarrinho() {
    let areaCarrinho = document.querySelector('.carrinho');
    areaCarrinho.innerHTML = '';

    let total = 0;

    carrinho.forEach((item) => {
        total += item.preco * item.qt;

        let itemCarrinho = document.createElement('div');
        itemCarrinho.classList.add('carrinho--item');
        itemCarrinho.innerHTML = `
            <div>${item.nome} (x${item.qt})</div>
            <div>R$ ${(item.preco * item.qt).toFixed(2)}</div>
            <button class="remove-btn" data-id="${item.id}">Remover</button>
        `;
        
        areaCarrinho.append(itemCarrinho);
    });

    document.querySelector('.total-carrinho.total span:last-child').innerHTML = `R$ ${total.toFixed(2)}`;
    document.querySelector('.menu-aberto span').innerHTML = carrinho.length;

    document.querySelector('.area-carrinho').style.display = 'block';

    
document.querySelectorAll('.remove-btn').forEach(button => {
    button.addEventListener('click', function() {
        let itemId = parseInt(this.getAttribute('data-id'));
        removerDoCarrinho(itemId);
    });
});

function removerDoCarrinho(id) {
    let itemCarrinho = carrinho.find(item => item.id === id);
    if (itemCarrinho) {
        itemCarrinho.qt--;
        if (itemCarrinho.qt <= 0) {
            carrinho = carrinho.filter(item => item.id !== id);
        }
    }
    atualizarCarrinho();
}

}

document.querySelector('.menu-aberto').addEventListener('click', () => {
    document.querySelector('.area-carrinho').style.display = 'block';
});

document.querySelector('.menu-fechar').addEventListener('click', () => {
    document.querySelector('.area-carrinho').style.display = 'none';
});