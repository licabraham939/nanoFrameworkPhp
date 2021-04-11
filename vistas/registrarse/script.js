let form = document.getElementById("registerForm");
form.addEventListener("keyup",(e)=>{
    if(form.pass1.value == form.pass2.value ){
        console.log("no coincide");
        form.querySelector('button').removeAttribute('disabled')
    }
    else {
        form.querySelector('button').setAttribute("disabled", "");
    }
})
