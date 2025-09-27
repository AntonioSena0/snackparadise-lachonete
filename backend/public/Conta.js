window.addEventListener("scroll", MudarOHeader);
function MudarOHeader() {
    let header = document.querySelector('header');
    let barralateral = document.getElementById('barralateral');
    let btnconta = document.getElementById('btn-conta');
    const btn = document.getElementById('btn-ativação');
    if (scrollY > 0) {
        header.classList.add('scroll');
        barralateral.classList.add('scroll');
        btnconta.classList.add('scroll');
        btn.classList.add('scroll');
    }
    else {
        header.classList.remove('scroll');
        barralateral.classList.remove('scroll');
        btnconta.classList.remove('scroll');
        btn.classList.remove('scroll');
    }
};

window.addEventListener("load", loaded);
function loaded() {
    document.body.classList.add("loaded");
};

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
    menu.style.display = menu.classList.btncontains('active') ? 'flex' : 'none';
    
    if (menu.classList.btncontains('active')) {
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
    if (menu.classList.btncontains('active')) {
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