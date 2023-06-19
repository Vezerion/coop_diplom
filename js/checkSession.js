window.addEventListener('DOMContentLoaded', ()=>{
    if(Cookies.get('PHPSESSID') == undefined){
        window.location.href = "home.html";
    }
    // async function checkSession(){
    //     await fetch('', {
            
    //     })
    // }
});