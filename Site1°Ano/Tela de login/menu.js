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

const inputs = document.querySelectorAll(".input-field");
const toggle_btn = document.querySelectorAll(".toggle");
const main = document.querySelector("main")
const bullets = document.querySelectorAll(".bullets span");
const imagens = document.querySelectorAll(".imagem")

inputs.forEach(inp => {
    inp.addEventListener("focus", () => {
        inp.classList.add("active");
    });
    inp.addEventListener("blur", () =>{
        if(inp.value != "") return;
        inp.classList.remove("active");
    })
});

toggle_btn.forEach((btn) => {
    btn.addEventListener("click", () => {
        main.classList.toggle("Modo-Cadastrar-se");
    });
});

function moverCarrossel() {
    let index = this.dataset.value;
    
    let imagematual = document.querySelector(`.img-${index}`);
    imagens.forEach(img => img.classList.remove("mostrar"));
    imagematual.classList.add("mostrar");

    bullets.forEach((bull) => bull.classList.remove("active"));
    this.classList.add("active");
}

bullets.forEach(bullet =>{
    bullet.addEventListener("click", moverCarrossel)
});