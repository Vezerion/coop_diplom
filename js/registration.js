const signUpForm = document.querySelector('.signup__form');

const usernameInput = document.querySelector('.signup__form__username');
const loginInput = document.querySelector('.signup__form__login');
const emailInput = document.querySelector('.signup__form__email');
const passwordInput = document.querySelector('.signup__form__password');
const passwordConfirm = document.querySelector('.signup__from__password-confirm');

const phoneInput = document.querySelector('.signup__form__phone');

function signUp(form, url){
    form.addEventListener('submit', async (e)=>{
        e.preventDefault();

        const formData = new FormData(form);
        const dataJson = JSON.stringify(Object.fromEntries(formData.entries()));
        await fetch(url, {
            method: "POST",
            headers: {
                'Content-type': 'application/json'
            },
            body: dataJson
        }).then((data)=>{
            console.log(data.status);
            httpRequestCodes(data.status, dataJson);
        }).catch(()=>{
            errorMessage();
        }).finally(()=>{
            
        });
    });
}
signUp(signUpForm, '../api/sign_up.php');


function httpRequestCodes(code, data) {
    switch (code) {
        case 230:
            // Регистрация успешна
            setUserDataToCookies(data);
            signUpForm.reset();
            window.location.href = 'account.html';
            break;
        case 231:
            // Не все необходимые поля были заполнены правильно
            usernameInput.classList.add('invalid');
            loginInput.classList.add('invalid');
            emailInput.classList.add('invalid');
            passwordInput.classList.add('invalid');
            passwordConfirm.classList.add('invalid');
            break;
        case 232:
            // Проблемы с валидацией пароля или почты( не проходит по шаблонам)
            emailInput.classList.add('invalid');
            passwordInput.classList.add('invalid');
            passwordConfirm.classList.add('invalid');
            break;
        case 234:
            // Не корректно введен пароль
            passwordInput.classList.add('invalid');
            passwordConfirm.classList.add('invalid');
            break;
        default:
            throw new Error();
    }
}

function setUserDataToCookies(data) {
    const userData = JSON.parse(data);
    console.log(userData);
    Cookies.set('username', userData.username, { expires: 7 });
    Cookies.set('surname', userData.surname, { expires: 7 });
    Cookies.set('phone', userData.phone, { expires: 7 });
    Cookies.set('name', userData.name, { expires: 7 });
    Cookies.set('login', userData.login, { expires: 7 });
    Cookies.set('email', userData.email, { expires: 7 });
    Cookies.set('date_of_birth', userData.date_of_birth, { expires: 7 });
    Cookies.set('country', userData.country, { expires: 7 });
    Cookies.set('city', userData.city, { expires: 7 });
}

function errorMessage() {
    const err = document.createElement('div');
    err.innerHTML = "Что то пошло не так попробуйте снова.";
    signUpForm.insertAdjacentElement('beforeend', err);
    setTimeout(()=>{
        err.remove();
    }, 5000);
}

phoneInput.addEventListener('keypress', (e)=>{
    if(!/\d/.test(e.key)){
        e.preventDefault();
    }
});

function checkIsNameTaken(input, name) {
    input.addEventListener('change', async ()=>{
        const formData = new FormData();
        formData.append(name, input.value);
        const dataJson = JSON.stringify(Object.fromEntries(formData.entries()));
        await fetch('test.php', {
            method: "POST",
            headers: {
                'Content-type': 'application/json'
            },
            body: dataJson
        }).then(data => {
            if(data.status == 230) {
                if(input.classList.contains('invalid')){
                    input.classList.remove('invalid');
                    input.classList.add('valid');
                } else {
                    input.classList.add('valid');
                }
            } else {
                if(input.classList.contains('valid')){
                    input.classList.remove('valid');
                    input.classList.add('invalid');
                } else {
                    input.classList.add('invalid');
                }
            }
        }).catch()
        .finally();
    });
}

// checkIsNameTaken(loginInput, "login");
// checkIsNameTaken(emailInput, "email");