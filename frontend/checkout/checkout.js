document.addEventListener("DOMContentLoaded", () => {
    const itensCheckout = document.getElementById("itensCheckout");
    const totalCheckout = document.getElementById("totalCheckout");

    let carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
    itensCheckout.innerHTML = "";
    let total = 0;

    carrinho.forEach(item => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
        <td>${item.nome}</td>
        <td>${item.quantidade}</td>
        <td>R$ ${item.preco.toFixed(2)}</td>
        <td>R$ ${(item.preco * item.quantidade).toFixed(2)}</td>
    `;
    itensCheckout.appendChild(tr);
    total += item.preco * item.quantidade;
});


    totalCheckout.textContent = total.toFixed(2);
});
