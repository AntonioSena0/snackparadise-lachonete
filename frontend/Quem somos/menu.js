window.addEventListener("scroll", MudarOHeader);
function MudarOHeader() {
    let header = document.querySelector('header');
    let barralateral = document.getElementById('barralateral');
    let conta = document.getElementById('btn-conta');
    const btn = document.getElementById('btn-ativação');
    if (scrollY > 50) {
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
    menu.style.display = menu.classList.contains('active') ? 'block' : 'none';
    
    if (menu.classList.contains('active')) {
        menu.style.opacity = '1';
        menu.style.visibility = 'visible';
    }
    else {
        setTimeout(() => {
            menu.style.visibility = 'hidden';
        }, 500);
        menu.style.opacity = '0';
    }
}

document.addEventListener('click', (event) => {
    if (menu.classList.contains('active')) {
        menu.classList.remove('active');
        setTimeout(() => {
            menu.style.visibility = 'hidden';
        }, 500);
        menu.style.opacity = '0';
    }
});

menu.addEventListener('click', (event) => {
    event.stopPropagation();
});