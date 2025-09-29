document.addEventListener('DOMContentLoaded', function() {
    // Menu Lateral
    const btnMenuLateral = document.getElementById('btnMenuLateral');
    const menuLateral = document.getElementById('menuLateral');

    btnMenuLateral.addEventListener('click', function(event) {
        event.stopPropagation();
        
        if (menuLateral.classList.contains('ativo')) {
            menuLateral.classList.remove('ativo');
            btnMenuLateral.classList.remove('active');
            btnMenuLateral.innerHTML = '☰';
        } else {
            menuLateral.classList.add('ativo');
            btnMenuLateral.classList.add('active');
            btnMenuLateral.innerHTML = '✖';
        }
    });

    // Submenu Cardápio
    const cardapioBtn = document.getElementById('cardapioBtn');
    const submenu = document.getElementById('submenu');

    if (cardapioBtn && submenu) {
        cardapioBtn.addEventListener('click', function(event) {
            event.stopPropagation();
            
            if (submenu.classList.contains('ativo')) {
                submenu.classList.remove('ativo');
                cardapioBtn.classList.remove('active');
            } else {
                submenu.classList.add('ativo');
                cardapioBtn.classList.add('active');
            }
        });

        // Evitar que cliques no submenu o fechem
        submenu.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    }

    // Fechar menus ao clicar fora
    document.addEventListener('click', function(event) {
        if (!menuLateral.contains(event.target) && 
            !btnMenuLateral.contains(event.target)) {
            menuLateral.classList.remove('ativo');
            btnMenuLateral.classList.remove('active');
            btnMenuLateral.innerHTML = '☰';
        }

        if (submenu && !submenu.contains(event.target) && 
            !cardapioBtn.contains(event.target)) {
            submenu.classList.remove('ativo');
            cardapioBtn.classList.remove('active');
        }
    });
});