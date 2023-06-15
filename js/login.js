const signin = document.querySelector('.signin__promo__button');
const signup = document.querySelector('.signup__promo__button');
const container = document.querySelector('.login');

signin.addEventListener('click', ()=>{
    container.classList.remove('signup-mode');
});
signup.addEventListener('click', ()=>{
    container.classList.add('signup-mode');
});
