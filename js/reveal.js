document.addEventListener('DOMContentLoaded', () => {
    const revealLeftObjects = document.querySelectorAll('.reveal-left');
    const revealTopObjects = document.querySelectorAll('.reveal-top');
    const revealRightObjects = document.querySelectorAll('.reveal-right');
    const revealBottomObjects = document.querySelectorAll('.reveal-bottom');


    const revealLeftOnload = document.querySelector('.reveal-left-onload');
    const revealTopOnload = document.querySelector('.reveal-top-onload');
    const revealRightOnload = document.querySelector('.reveal-right-onload');

    setTimeout(revealLeftOnload.classList.add('reveal-left-onload-active'), 4000);
    setTimeout(revealTopOnload.classList.add('reveal-top-onload-active'), 4000);
    setTimeout(revealRightOnload.classList.add('reveal-right-onload-active'), 4000);

    window.addEventListener('scroll', revealLeft);
    window.addEventListener('scroll', revealTop);
    window.addEventListener('scroll', revealRight);
    window.addEventListener('scroll', revealBottom);



    function revealLeft(){
        revealLeftObjects.forEach((item)=>{
            const windowHeight = window.innerHeight;
            const revealTop = item.getBoundingClientRect().top;
            const revealPoint = 150;

            if (revealTop < windowHeight - revealPoint) {
                item.classList.add('reveal-left-active');
            } else {
                item.classList.remove('reveal-left-active');
            }
        });
    }

    function revealTop(){
        revealTopObjects.forEach((item)=>{
            const windowHeight = window.innerHeight;
            const revealTop = item.getBoundingClientRect().top;
            const revealPoint = 150;

            if (revealTop < windowHeight - revealPoint) {
                item.classList.add('reveal-top-active');
            } else {
                item.classList.remove('reveal-top-active');
            }
        });
    }

    function revealRight(){
        revealRightObjects.forEach((item)=>{
            const windowHeight = window.innerHeight;
            const revealTop = item.getBoundingClientRect().top;
            const revealPoint = 150;

            if (revealTop < windowHeight - revealPoint) {
                item.classList.add('reveal-right-active');
            } else {
                item.classList.remove('reveal-right-active');
            }
        });
    }

    function revealBottom(){
        revealBottomObjects.forEach((item)=>{
            const windowHeight = window.innerHeight;
            const revealTop = item.getBoundingClientRect().top;
            const revealPoint = 150;

            if (revealTop < windowHeight - revealPoint) {
                item.classList.add('reveal-bottom-active');
            } else {
                item.classList.remove('reveal-bottom-active');
            }
        });
    }
});

