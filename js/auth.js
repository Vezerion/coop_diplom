const signInForm = document.querySelector('.signin__form');


function signIn(form, url){
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
            if(data.status == 230) {
                checkUserDataInCookies(dataJson);
                form.reset();
            } else {
                throw new Error();
            }
            
        }).catch(()=>{
            showErrorMessage();
        }).finally(()=>{

        });
    });
}
signIn(signInForm, '../api/auth.php');


function checkUserDataInCookies(userData){
    const cookieNamesArray = ['login', 'name', 'email', 'surname', 'date_of_birth', 'city', 'country', 'phone', 'username'];
    let iterator = 0;
    cookieNamesArray.forEach((item) => {
        const res = Cookies.get(item);
        if(res == undefined){
            iterator++;
        } 
    });
    if(iterator != 0) {
        getUserDataFromServer(userData);
    } else {
        window.location.href = 'account.html';
    }
}

async function getUserDataFromServer(data){
    await fetch('../api/get_user_data.php', {
        method: "POST",
        headers: {
            'Content-type': 'application/json'
        },
        body: data
    })
    .then(data=> data.json())
    .then((res)=>{
        const dataArray = Object.entries(res);
        console.log(dataArray);
        dataArray.forEach(item => {
            setUserDataInCookies(item);
            
        });
    })
    .then(()=>{
        window.location.href = 'account.html';
    })
    .catch();
    
}

function setUserDataInCookies(cookie) {
    Cookies.set(cookie[0], cookie[1], { expires: 7 });
    
}

function showErrorMessage() {
    if(document.querySelector('.error')){
        const err = document.createElement('div');
        err.classList.add('error');
        err.innerHTML = "Логин и/или пароль не верны";
        signInForm.insertAdjacentElement('beforeend', err);
        setTimeout(()=>{
            err.remove();
        }, 5000);
    }
    
}