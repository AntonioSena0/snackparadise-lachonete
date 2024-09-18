window.addEventListener("scroll", function() {
    let header = document.querySelector('header');
    if (header) {
        header.classList.toggle('scroll', window.scrollY > 50);
    }
    
    let conta = document.querySelector('.conta');
    if (conta) {
        conta.classList.toggle('scroll', window.scrollY > 45);
    }
});

const modals = document.querySelectorAll('.modal');
const btns = document.querySelectorAll('.myBtn');
const closes = document.querySelectorAll('.close');

btns.forEach(btn => {
    btn.onclick = function() {
        const modalId = this.getAttribute('data-modal');
        document.getElementById(modalId).style.display = 'flex';
    }
});

closes.forEach(closeBtn => {
    closeBtn.onclick = function() {
        this.closest('.modal').style.display = 'none';
    }
});

window.onclick = function(event) {
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
}

const modal = document.querySelectorAll(".modal");
const btn = document.getElementById("myBtn");
const span = document.getElementsByClassName("close")[0];
const modalContent = document.querySelector('.modal-content');

btn.onclick = function() {
    modal.style.display = "flex";
    setTimeout(() => {
        modalContent.classList.add('show');
    }, 10);
}

span.onclick = function() {
    modalContent.classList.remove('show');
    setTimeout(() => {
        modal.style.display = "none";
    }, 500);
}

window.onclick = function(event) {
    if (event.target == modal) {
        modalContent.classList.remove('show');
        setTimeout(() => {
            modal.style.display = "none";
        }, 500);
    }
}

function showSection(sectionId) {
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => {
        section.classList.remove('active');
    });
    document.getElementById(sectionId).classList.add('active');
}

showSection('Tradicionais');