var usrInput = document.getElementById("usr");
var pwdInput = document.getElementById("pwd");
usrInput.addEventListener("focus",()=>{limpiarCampo("usrError")})
usrInput.addEventListener("blur",()=>{validarCampo("usr","usrError")})

pwdInput.addEventListener("focus",()=>{limpiarCampo("pwdError")})
pwdInput.addEventListener("blur",()=>{validarCampo("pwd","pwdError")})

var form = document.getElementById("login");
// form.addEventListener("submit",()=>{validateLogin});
function limpiarCampo(id){
    document.getElementById(id).innerText="";
}
function validateLogin(){
    var validar = true;
    if(usrInput.value ==""){
        document.getElementById("usrError").innerText = "Usuario es un campo obligatorio";
        validar = false;
    }
    if(pwdInput.value==""){
        document.getElementById("pwdError").innerText = "La contraseña es obligatoria";
        validar = false;
    }
    if(!validar){
        document.getElementById("error").innerText = "revisa tus credenciales de inicio de sesión";
        validar = false;
    }
    console.log(validar)
    return validar;
}
function validarCampo(input,error){

    if(document.getElementById(input).value == ""){
        document.getElementById(error).innerText = "El campo es obligatorio"
    }
}