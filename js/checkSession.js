window.addEventListener('DOMContentLoaded', ()=>{
    if(Cookies.get('PHPSESSID') == ""){
        window.location.href = "home.html";
    }
    // async function checkSession(){
    //     await fetch('', {
            
    //     })
    // }
});