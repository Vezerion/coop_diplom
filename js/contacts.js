window.addEventListener('DOMContentLoaded', ()=>{
    const form = document.querySelector('.contacts__feedback__form');
    const subheader = document.querySelector('.contacts__feedback__subheader');
    const send = function(e){
        e.preventDefault();
        sendFormData();
    }
    form.addEventListener('submit', send);

    async function sendFormData() {
        try {
            const formData = new FormData(form);
            const jsonData = JSON.stringify(Object.fromEntries(formData.entries()));
            const response = await fetch('', {
                method: "POST",
                headers: {
                    'Content-type': 'application/json'
                },
                body: jsonData
            });
            if(response.status == 230){
                subheader.innerHTML = "Ваше сообщение успешно отправленно";
                setTimeout(()=>{
                    subheader.innerHTML = "Оставьте свою заявку и мы свяжемся с вами";
                    form.reset();
                }, 2000);
            } else {
                throw new Error();
            }
        } catch {
            subheader.innerHTML = "Что то пошло не так, попробуйте снова";
            form.removeEventListener('submit', send);
            setTimeout(()=>{
                subheader.innerHTML = "Оставьте свою заявку и мы свяжемся с вами";
                form.addEventListener('submit', send);
            }, 2000);
        }
    }
});