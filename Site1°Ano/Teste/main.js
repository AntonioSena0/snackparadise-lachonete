let lanches = [
    {id: 1, nome: 'Sunset-Burguer', img: 'Assets/Hamburguer1.png', preco: 25.00, descricao: 'Bacon, cheddar, Hamburguer grelhado, Molho Barbecue, Pão com gergelim'},
    {id: 2, nome: 'Hamburguer-Praiano', img: 'Assets/Hamburguer2.png', preco: 27.00, descricao: 'Alface, cebola, hamburguer grelhado, pão com gergelim, picles, tomate'},
    {id: 3, nome: 'Snack Praia do Sol', img: 'Assets/Hamburguer1.png', preco: 25.00, descricao: 'Alface, bacon, cebola roxa, cheddar, hamburguer grelhado, pão com gergilim, tomate'},
    {id: 4, nome: 'Palmeira Burguer', img: 'Assets/Hamburguer2.png', preco: 27.00, descricao: 'Alface, cebola, coentro, molho bechamel vegano, pão com gergilim, seitan (hamburguer vegano), tomate'},
    {id: 5, nome: 'Hamburguer Tropical', img: 'Assets/Hamburguer1.png', preco: 25.00, descricao: 'Bacon, cheddar, Hamburguer grelhado, Molho Barbecue, Pão com gergelim'},
    {id: 6, nome: 'Férias Saudaveis', img: 'Assets/Hamburguer2.png', preco: 27.00, descricao: 'Alface, cebola, hamburguer grelhado, pão com gergelim, picles, tomate'}
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
        `;

        areaCarrinho.append(itemCarrinho);
    });

    document.querySelector('.total-carrinho.total span:last-child').innerHTML = `R$ ${total.toFixed(2)}`;
    document.querySelector('.menu-aberto span').innerHTML = carrinho.length;

    document.querySelector('.finalizar-compra').addEventListener('click', () => {
        alert('Indo para o checkout!');
    });

    document.querySelector('.area-carrinho').style.display = 'block';
}

document.querySelector('.menu-aberto').addEventListener('click', () => {
    document.querySelector('.area-carrinho').style.display = 'block';
});

document.querySelector('.menu-fechar').addEventListener('click', () => {
    document.querySelector('.area-carrinho').style.display = 'none';
});