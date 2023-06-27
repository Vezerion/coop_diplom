const formInput = document.querySelectorAll('.settings__form__input')
const formChangeBtn = document.querySelectorAll('.settings__form__change-btn');
const cancelBtn = document.querySelector('.settings__form__cancel-btn');
const form = document.querySelector('.settings__form');
const screens_btns = document.querySelectorAll('.screen');
const phone = document.querySelector('.settigns__form__phone');
formInput.forEach(item => {
    item.readOnly = true;
    item.value = Cookies.get(item.getAttribute('data-name'));
});
let flag = true;
formChangeBtn.forEach(btn => {
    btn.addEventListener('click', (e)=> {
        flag = false;
        console.log(e.target);
        console.log(e.target.previousElementSibling);
        e.target.previousElementSibling.readOnly = false;
        e.target.classList.remove('fa-pen');
        e.target.classList.add('fa-lock-open');
    });
});

cancelBtn.addEventListener('click', ()=>{
    formInput.forEach(item => {
        item.readOnly = true;
        item.value = Cookies.get(item.getAttribute('data-name'));
    });
    formChangeBtn.forEach(btn => {
        btn.classList.add('fa-pen');
        btn.classList.remove('fa-lock-open');
    })
});

form.addEventListener('submit', (e)=>{
    e.preventDefault();
});
    
screens_btns.forEach(item => {
    item.addEventListener('click', ()=>{
        if(flag == false) {
            cancelBtn.click();
        }
    });
})

phone.addEventListener('keypress', (e)=>{
    if(!/\d/.test(e.key)){
        e.preventDefault();
    }
});


function newUserCredentialsFormPostData(form, url){
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
            if(data.status == 230) {
<<<<<<< HEAD
                setNewUserDataToCookies(dataJson);
                formInput.forEach(item => {
                    item.readOnly = true;
                });
                formChangeBtn.forEach(btn => {
                    btn.classList.add('fa-pen');
                    btn.classList.remove('fa-lock-open');
                })
=======
                setNewUserDataToCookies(data);
>>>>>>> 175298dd95f327cce32fd8e3e291017ae7af3b9d
                formInput.forEach(item => {
                    item.readOnly = true;
                    item.value = Cookies.get(item.getAttribute('data-name'));
                });
            } else {
                throw new Error();
            }
        }).catch(()=>{
            showError(form);
        });
    });
}
newUserCredentialsFormPostData(form, '../api/change_users_data.php');
newUserCredentialsFormPostData(form, '../api/change_users_data.php');

function setNewUserDataToCookies(data) {
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

function showError(form) {
    if(document.querySelector('.error')){
        const err = document.createElement('div');
        err.classList.add('error');
        err.innerHTML = "Логин и/или пароль не верны";
        form.insertAdjacentElement('beforeend', err);
        setTimeout(()=>{
            err.remove();
        }, 5000);
    }
}