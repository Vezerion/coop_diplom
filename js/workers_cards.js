document.addEventListener('DOMContentLoaded', ()=>{
    const cards = document.querySelector('.workers__cards');
    const card = document.querySelectorAll('.workers__cards__card');
    // const wrapper = document.querySelectorAll('.workers__cards__card__wrapper');
    // const photo = document.querySelectorAll('.workers__cards__card__photo');
    // const card_name = document.querySelectorAll('.workers__cards__card__name');
    // const description = document.querySelectorAll('.workers__cards__card__description');
    // const info = document.querySelectorAll('.workers__cards__card__info');
    const btn = document.querySelectorAll('.workers__cards__card__button');
    // const btn_text = document.querySelectorAll('.workers__cards__card__button__text');
    const podrezov = document.querySelector(`[data-name="podrezov"]`);
    const shestakov = document.querySelector(`[data-name="shestakov"]`);

    btn.forEach((item)=>{
        item.addEventListener('click', (e)=>{
            const parent = e.currentTarget.parentNode.parentNode;
            const wrapper = parent.querySelector('.workers__cards__card__wrapper');
            const photo = parent.querySelector('.workers__cards__card__photo');
            const card_name = parent.querySelector('.workers__cards__card__name');
            const description = parent.querySelector('.workers__cards__card__description');
            const info = parent.querySelector('.workers__cards__card__info');
            const btn_text_small = parent.querySelector('.workers__cards__card__button__text__small');
            const btn_text_big = parent.querySelector('.workers__cards__card__button__text__big');

            cards.classList.toggle('more-width');
            parent.classList.toggle('bigger-card');
            wrapper.classList.toggle('wrapper-big');
            photo.classList.toggle('card-photo');
            card_name.classList.toggle('card-name');
            description.classList.toggle('card-descr');
            info.classList.toggle('card-info');
            item.classList.toggle('active-card');

            if(parent.classList.contains('bigger-card')){
                btn_text_small.classList.add('hide');
                btn_text_big.classList.remove('hide');
            } else {
                btn_text_big.classList.add('hide');
                btn_text_small.classList.remove('hide');
            }

        });
    });
});
