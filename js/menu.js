window.addEventListener('DOMContentLoaded', () => {
    const menu = document.querySelector('.menu'),
          menu_button = document.querySelector('.menu__button'),
          items = document.querySelector('.menu__items'),
          item = document.querySelectorAll('.menu__items__item'),
          item_files = document.querySelector('.menu__items__item__files'),
          item_contacts = document.querySelector('.menu__items__item__contacts'),
          item_settings = document.querySelector('.menu__items__item__settings'),
          item_logout = document.querySelector('.menu__items__item__logout'),
          theme_button = document.querySelector('.menu__items__item__theme__icon'),
          theme_name = document.querySelector('.menu__items__item__theme__header'),
          body = document.querySelector('body');

        menu_button.addEventListener('click', ()=>{
            menu.classList.toggle('active');
            menu_button.classList.toggle('active');
            items.classList.toggle('align-baseline');
            if (!menu.classList.contains('active')){
                item.forEach((item)=>{
                    item.classList.add('short');
                });
            } else {
                item.forEach((item)=>{
                    item.classList.remove('short');
                });
            }
        });
        function cookie_set(){
            if(Cookies.get('theme')){
                const theme_value = Cookies.get('theme');
                if(!body.classList.contains(theme_value)){
                    body.classList.add(theme_value);
                    theme_button.classList.add(theme_value);
                    Cookies.set('theme', theme_value, { expires: 7 });
                }
            } else {
                Cookies.set('theme', 'light', { expires: 7 });
            }
        }
        cookie_set();
        function theme_get(){
            const current_theme = Cookies.get('theme');
            if(current_theme == 'dark'){
                theme_name.innerText = "";
                theme_name.innerText = "Темная тема";
                theme_button.classList.add('fa-moon');
                theme_button.classList.remove('fa-sun');
            } else {
                theme_name.innerText = "";
                theme_name.innerText = "Светлая тема";
                theme_button.classList.remove('fa-moon');
                theme_button.classList.add('fa-sun');
            }
        }

        theme_get();
        theme_button.addEventListener('click', ()=>{
            theme_button.classList.toggle('light');
            theme_button.classList.toggle('dark');
            body.classList.toggle('light');
            body.classList.toggle('dark');
            if(theme_button.classList.contains('light')){
                Cookies.remove('theme');
                Cookies.set('theme', 'light', { expires: 7 });
                cookie_set();
                theme_get();
            } else {
                Cookies.remove('theme');
                Cookies.set('theme', 'dark', { expires: 7 });
                cookie_set();
                theme_get();
            }
        });
});