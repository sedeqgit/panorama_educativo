//import './bootstrap';
import 'bootstrap';

document.querySelectorAll('.dropdown-submenu > a').forEach(element => {
    element.addEventListener('click', function(e){
        let nextEl = this.nextElementSibling;
        if(nextEl && nextEl.classList.contains('dropdown-menu')){
            e.preventDefault();
            e.stopPropagation();
            let isShown=nextEl.classList.contains('show');
            let parentMenu=this.closest('.dropdown-menu');
            let openMenus=parentMenu.querySelectorAll('.dropdown-menu.show');
            openMenus.forEach(menu => {
                menu.classList.remove('show');
            });
            if(!isShown) nextEl.classList.toggle('show')
        }
    });
});

document.querySelectorAll('.dropdown').forEach(dropdown => {
    dropdown.addEventListener('hidden.bs.dropdown', function(){
        let submenus=this.querySelectorAll('.dropdown-menu.show');
        submenus.forEach(submenu => {
            submenu.classList.remove('show');
        });
    });
});