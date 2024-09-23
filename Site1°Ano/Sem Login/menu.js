window.addEventListener("scroll", function() {
    let header = document.querySelector('header');
    if (header) {
        header.classList.toggle('scroll', window.scrollY > 0);
    }
    let conta = document.querySelector('.conta');
    if (conta) {
        conta.classList.toggle('scroll', window.scrollY > 0);
    }
});