window.addEventListener('DOMContentLoaded', () => {
    const menu = document.querySelector('.menu'),
          menu_button = document.querySelector('.menu__button'),
          items = document.querySelector('.menu__items'),
          item = document.querySelectorAll('.menu__items__item'),
          screens_btns = document.querySelectorAll('.screen'),
          screens = document.querySelectorAll('.section'),
          theme_button = document.querySelector('.menu__items__item__theme__icon'),
          theme_name = document.querySelector('.menu__items__item__theme__header'),
          userName = document.querySelector('.menu__items__item__user__info-name'),
          userLogin = document.querySelector('.menu__items__item__user__info-user'),
          body = document.querySelector('body');


    userName.innerText = Cookies.get('username');
    userLogin.innerText = Cookies.get('login');
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
    screens_btns.forEach(item => {
        item.addEventListener('click', (e)=>{
            const screenName = item.getAttribute("data-screen");
            console.log(screenName);
            screens.forEach(screen => {
            screen.classList.remove('screen_active');
                if(screen.classList.contains(screenName)){
                    screen.classList.add('screen_active');
                }
            })
        });
    })
});