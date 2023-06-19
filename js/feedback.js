const techBtn = document.querySelector('.feedback__buttons__tech');
const reviewBtn = document.querySelector('.feedback__buttons__review');
const techForm = document.querySelector('.feedback__tech');
const reviewFrom = document.querySelector('.feedback__review');
const formTech = document.querySelector('.feedback__tech__form');
const formReview = document.querySelector('.feedback__review__form');

techBtn.addEventListener('click', ()=>{
    reviewFrom.classList.remove('form_active');
    techForm.classList.add('form_active');
});
reviewBtn.addEventListener('click', ()=>{
    reviewFrom.classList.add('form_active');
    techForm.classList.remove('form_active');
});


function feedbackFormPostData(form, url){
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
                form.reset();
            } else {
                throw new Error();
            }
            
        }).catch(()=>{
            showError(form);
        }).finally(()=>{

        });
    });
}
feedbackFormPostData(formTech, '../api/');
feedbackFormPostData(formReview, '../api/');

function showError(form) {
    if(!document.querySelector('.error')){
        const err = document.createElement('div');
        err.classList.add('error');
        err.innerHTML = "Что то пошло не так, попробуйте еще раз";
        form.insertAdjacentElement('beforeend', err);
        setTimeout(()=>{
            err.remove();
        }, 5000);
    }
    
}