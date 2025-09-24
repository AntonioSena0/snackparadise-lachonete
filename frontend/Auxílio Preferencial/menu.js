window.addEventListener("load", function () {
  document.body.classList.add("loaded");
});

document.querySelectorAll("a").forEach(link => {
  link.addEventListener("click", function (event) {
    event.preventDefault();
    document.body.classList.remove("loaded");
    setTimeout(() => {
      window.location.href = this.href;
    }, 500);
  });
});

const Button = document.getElementById('btn-ativação');
const sidebar = document.getElementById('barralateral');

// Alterna barra lateral
Button.addEventListener('click', () => {
  if (sidebar.style.left === '0px') {
    sidebar.style.left = '-200px';
    Button.innerText = '☰';
  } else {
    sidebar.style.left = '0px';
    Button.innerText = '✖';
  }
  Button.classList.toggle('active');
});

// Fecha a barra lateral ao clicar fora
document.addEventListener('click', (event) => {
  if (!sidebar.contains(event.target) && !Button.contains(event.target)) {
    sidebar.style.left = '-200px';
    Button.innerText = '☰';
    Button.classList.remove('active');
  }
});

// Dropdown do cardápio
const btn = document.getElementById('btn-cardapio');
const menu = document.getElementById('submenu');

btn.addEventListener('click', function (event) {
  event.stopPropagation();
  menu.classList.toggle('active');
  menu.style.display = menu.classList.contains('active') ? 'flex' : 'none';
  menu.style.opacity = menu.classList.contains('active') ? '1' : '0';
  menu.style.visibility = menu.classList.contains('active') ? 'visible' : 'hidden';
});

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
