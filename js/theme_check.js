window.addEventListener('DOMContentLoaded', () => {
    const body = document.querySelector('body');
    if(Cookies.get('theme')) {
        const theme = Cookies.get('theme');
        body.classList.add(theme);
    }
});
